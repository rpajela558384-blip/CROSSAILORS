<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name', 'Crossailors') }} — BSMT Portal</title>
        <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'><rect width='32' height='32' rx='6' fill='%231E4D9C'/><text x='50%25' y='54%25' dominant-baseline='middle' text-anchor='middle' font-size='20' font-family='serif'>⚓</text></svg>">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @auth
        <script>
            window.__userId = {{ auth()->id() }};
            window.__vapidPublicKey = "{{ config('webpush.vapid.public_key') }}";
            @if(auth()->user()->isAdmin())
            window.__notificationsApiUrl = "{{ route('admin.notifications.api') }}";
            window.__notificationsReadAllUrl = "{{ route('admin.notifications.readAll') }}";
            window.__notificationsReadUrl = "/admin/notifications/{id}/read";
            window.__notificationsVisitUrl = "/admin/notifications/{id}/visit";
            @elseif(auth()->user()->isOfficer())
            window.__notificationsApiUrl = "{{ route('officer.notifications.api') }}";
            window.__notificationsReadAllUrl = "{{ route('officer.notifications.readAll') }}";
            window.__notificationsReadUrl = "/officer/notifications/{id}/read";
            window.__notificationsVisitUrl = "/officer/notifications/{id}/visit";
            @else
            window.__notificationsApiUrl = "{{ route('notifications.api') }}";
            window.__notificationsReadAllUrl = "{{ route('notifications.readAll') }}";
            window.__notificationsReadUrl = "/notifications/{id}/read";
            window.__notificationsVisitUrl = "/notifications/{id}/visit";
            @endif
        </script>
        @endauth
        @stack('head')
    </head>
    <style>[x-cloak]{display:none!important}</style>
    <body class="font-sans antialiased bg-slate-50 text-slate-900 flex flex-col min-h-screen"
          x-data="{
              confirm: {
                  open: false,
                  title: '',
                  message: '',
                  type: 'danger',
                  action: null,
              },
              openConfirm(payload) {
                  this.confirm.title   = payload.title   || 'Are you sure?';
                  this.confirm.message = payload.message || 'This action cannot be undone.';
                  this.confirm.type    = payload.type    || 'danger';
                  this.confirm.action  = payload.action  || null;
                  this.confirm.open    = true;
              },
              doConfirm() {
                  if (this.confirm.action) this.confirm.action();
                  this.confirm.open = false;
              }
          }"
          @confirm-action.window="openConfirm($event.detail)">

        @include('layouts.navigation')

        @isset($header)
            <header class="bg-white border-b border-slate-200">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex items-center gap-3">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main class="flex-1">
            {{ $slot }}
        </main>

        @include('layouts.footer')

        {{-- ══ Global Toast Notifications ══ --}}
        @if(session('success') || session('error'))
        <div x-data="{ show: true }" x-show="show" x-cloak
             x-init="setTimeout(() => show = false, 4000)"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 translate-y-4"
             class="fixed bottom-6 right-6 z-[1000] max-w-sm w-full">
            @if(session('success'))
            <div class="flex items-start gap-3 bg-green-600 text-white px-4 py-3 rounded-xl shadow-lg">
                <svg class="w-5 h-5 mt-0.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-sm font-medium leading-snug">{{ session('success') }}</p>
                <button @click="show = false" class="ml-auto text-white/70 hover:text-white shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            @endif
            @if(session('error'))
            <div class="flex items-start gap-3 bg-red-600 text-white px-4 py-3 rounded-xl shadow-lg {{ session('success') ? 'mt-2' : '' }}">
                <svg class="w-5 h-5 mt-0.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                <p class="text-sm font-medium leading-snug">{{ session('error') }}</p>
                <button @click="show = false" class="ml-auto text-white/70 hover:text-white shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            @endif
        </div>
        @endif

        @stack('scripts')

        {{-- ══ Global Lightbox ══ --}}
        <div x-cloak
             x-show="$store.lightbox.open"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @keydown.escape.window="$store.lightbox.open = false"
             @click.self="$store.lightbox.open = false"
             class="fixed inset-0 z-[990] flex items-center justify-center bg-black/90 p-4">
            <button @click="$store.lightbox.open = false"
                    class="absolute top-4 right-4 text-white/70 hover:text-white transition">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            <template x-if="$store.lightbox.type === 'video'">
                <video :src="$store.lightbox.src" class="max-w-full max-h-[90vh] rounded-xl shadow-2xl" controls autoplay></video>
            </template>
            <template x-if="$store.lightbox.type === 'image'">
                <img :src="$store.lightbox.src" class="max-w-full max-h-[90vh] rounded-xl shadow-2xl object-contain" alt="">
            </template>
        </div>

        {{-- ══ Global Confirmation Modal ══ --}}
        <div x-cloak
             x-show="confirm.open"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @keydown.escape.window="confirm.open = false"
             class="fixed inset-0 z-[999] flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
            <div x-show="confirm.open"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 @click.outside="confirm.open = false"
                 class="bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden">
                {{-- Icon header --}}
                <div class="px-6 pt-6 pb-4 flex flex-col items-center text-center">
                    <div :class="confirm.type === 'danger' ? 'bg-red-100' : (confirm.type === 'warning' ? 'bg-amber-100' : 'bg-brand-100')"
                         class="w-14 h-14 rounded-full flex items-center justify-center mb-4">
                        <template x-if="confirm.type === 'danger'">
                            <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                        </template>
                        <template x-if="confirm.type === 'warning'">
                            <svg class="w-7 h-7 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                        </template>
                        <template x-if="confirm.type !== 'danger' && confirm.type !== 'warning'">
                            <svg class="w-7 h-7 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </template>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-1" x-text="confirm.title"></h3>
                    <p class="text-sm text-slate-500 leading-relaxed" x-text="confirm.message"></p>
                </div>
                {{-- Actions --}}
                <div class="px-6 pb-6 flex gap-3">
                    <button type="button"
                            @click="confirm.open = false"
                            class="flex-1 px-4 py-2.5 text-sm font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-xl transition">
                        Cancel
                    </button>
                    <button type="button"
                            @click="doConfirm()"
                            :class="confirm.type === 'danger' ? 'bg-red-600 hover:bg-red-700 text-white' : (confirm.type === 'warning' ? 'bg-amber-500 hover:bg-amber-600 text-white' : 'bg-brand-700 hover:bg-brand-800 text-white')"
                            class="flex-1 px-4 py-2.5 text-sm font-semibold rounded-xl transition">
                        Confirm
                    </button>
                </div>
            </div>
        </div>
    </body>
</html>
