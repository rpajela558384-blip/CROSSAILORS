<x-app-layout>
    <x-slot name="title">Notifications</x-slot>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-slate-800">Notifications</h1>
            <form method="POST" action="{{ route('notifications.readAll') }}">
                @csrf
                <button type="submit" class="text-sm text-brand-700 hover:text-brand-800 font-medium hover:underline">Mark all as read</button>
            </form>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 divide-y divide-slate-100 overflow-hidden">
            @forelse($notifications as $notification)
            @php
                $type   = $notification->data['type'] ?? '';
                $isRead = !is_null($notification->read_at);
                $iconBg = str_starts_with($type, 'ticket') ? 'bg-brand-100 text-brand-700' : 'bg-green-100 text-green-700';
            @endphp
            <a href="{{ route('notifications.visit', $notification->id) }}"
               class="flex items-start gap-4 px-6 py-4 hover:bg-slate-50 transition {{ $isRead ? '' : 'bg-brand-50' }}">
                <div class="shrink-0 mt-0.5">
                    <div class="w-9 h-9 rounded-full {{ $iconBg }} flex items-center justify-center">
                        @if(str_starts_with($type, 'ticket'))
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                        @else
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                        @endif
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm text-slate-800 {{ $isRead ? '' : 'font-semibold' }} leading-snug">
                        {{ $notification->data['message'] ?? 'Notification' }}
                    </p>
                    <p class="text-xs text-slate-400 mt-0.5">{{ $notification->created_at->diffForHumans() }}</p>
                    @if(!$isRead)
                    <span class="inline-block mt-1 text-xs text-brand-700 font-medium">Tap to view →</span>
                    @endif
                </div>
                @if(!$isRead)
                    <div class="shrink-0 w-2.5 h-2.5 bg-brand-500 rounded-full mt-1.5"></div>
                @endif
            </a>
            @empty
            <div class="px-6 py-16 text-center">
                <svg class="w-12 h-12 text-brand-200 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                <p class="text-slate-500 font-medium">No notifications yet</p>
                <p class="text-slate-400 text-sm mt-1">You'll see ticket updates and announcements here.</p>
            </div>
            @endforelse
        </div>
        <div class="mt-4">{{ $notifications->links() }}</div>
    </div>
</x-app-layout>
