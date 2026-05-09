self.addEventListener('push', function (event) {
    if (!event.data) return;
    const data = event.data.json();
    event.waitUntil(
        self.registration.showNotification(data.title || 'Crossailors', {
            body: data.body || '',
            icon: '/favicon.ico',
            data: { url: data.action_url || '/' },
        })
    );
});

self.addEventListener('notificationclick', function (event) {
    event.notification.close();
    event.waitUntil(
        clients.openWindow(event.notification.data.url || '/')
    );
});
