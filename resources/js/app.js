import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

// ── Carousel component ──────────────────────────────────────────────────────
window.carousel = function (count) {
    return {
        current: 0,
        total: count,
        next() { this.current = (this.current + 1) % this.total; },
        prev() { this.current = (this.current - 1 + this.total) % this.total; },
        autoplay: null,
        init() {
            if (this.total > 1) {
                this.autoplay = setInterval(() => this.next(), 5000);
            }
        },
        destroy() { clearInterval(this.autoplay); },
    };
};

// ── Notification bell component ─────────────────────────────────────────────
window.notificationBell = function () {
    return {
        open: false,
        unread: 0,
        notifications: [],
        toggle() { this.open = !this.open; },
        async init() {
            await this.fetchNotifications();
            if (window.Echo && window.__userId) {
                window.Echo.private(`App.Models.User.${window.__userId}`)
                    .notification((n) => {
                        this.notifications.unshift({ ...n, read_at: null, created_at: 'just now' });
                        this.unread++;
                    });
            }
        },
        async fetchNotifications() {
            try {
                const url = window.__notificationsApiUrl || '/api/notifications';
                const res = await axios.get(url);
                this.notifications = res.data.notifications;
                this.unread = res.data.unread;
            } catch (_) {}
        },
        async markAllRead() {
            const url = window.__notificationsReadAllUrl || '/notifications/read-all';
            await axios.post(url, {}, {
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content }
            });
            this.notifications.forEach(n => n.read_at = new Date().toISOString());
            this.unread = 0;
        },
        async readNotification(n) {
            if (!n.read_at) {
                const urlTemplate = window.__notificationsReadUrl || '/notifications/{id}/read';
                await axios.post(urlTemplate.replace('{id}', n.id), {}, {
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content }
                });
                n.read_at = new Date().toISOString();
                this.unread = Math.max(0, this.unread - 1);
            }
            if (n.data && n.data.url) window.location.href = n.data.url;
        },
    };
};

// ── Lightbox store ───────────────────────────────────────────────────────────
Alpine.store('lightbox', {
    open: false,
    src: '',
    type: 'image',
    show(src, type = 'image') {
        this.src  = src;
        this.type = type;
        this.open = true;
    },
    close() {
        this.open = false;
        this.src  = '';
    },
});

Alpine.start();

// ── Web Push subscription ────────────────────────────────────────────────────
if ('serviceWorker' in navigator && 'PushManager' in window && window.__vapidPublicKey) {
    navigator.serviceWorker.register('/sw.js').then(async (reg) => {
        const existing = await reg.pushManager.getSubscription();
        if (existing) return;
        try {
            const sub = await reg.pushManager.subscribe({
                userVisibleOnly: true,
                applicationServerKey: urlBase64ToUint8Array(window.__vapidPublicKey),
            });
            const json = sub.toJSON();
            await axios.post('/push-subscriptions', {
                endpoint:   sub.endpoint,
                public_key: json.keys.p256dh,
                auth_token: json.keys.auth,
            }, {
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content }
            });
        } catch (_) {}
    });
}

function urlBase64ToUint8Array(base64String) {
    const padding = '='.repeat((4 - base64String.length % 4) % 4);
    const base64 = (base64String + padding).replace(/-/g, '+').replace(/_/g, '/');
    const raw = window.atob(base64);
    return Uint8Array.from([...raw].map(c => c.charCodeAt(0)));
}
