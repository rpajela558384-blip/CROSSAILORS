<x-app-layout>
    <x-slot name="title">Ticket #{{ $ticket->id }}</x-slot>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-6">
            <a href="{{ route('tickets.index') }}" class="inline-flex items-center gap-1.5 text-brand-700 hover:text-brand-800 text-sm font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Back to Tickets
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm">{{ session('success') }}</div>
        @endif

        {{-- Ticket Header --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-4">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h1 class="text-xl font-bold text-slate-800">{{ $ticket->subject }}</h1>
                    <p class="text-slate-400 text-sm mt-1">Submitted by {{ $ticket->user->name }} · {{ $ticket->created_at->format('M j, Y \a\t g:i A') }}</p>
                </div>
                <span class="shrink-0 inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $ticket->getStatusBadgeClass() }}">
                    {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                </span>
            </div>
            <div class="mt-4 pt-4 border-t border-slate-100">
                <p class="text-slate-700 whitespace-pre-line">{{ $ticket->description }}</p>
            </div>
        </div>

        {{-- Replies --}}
        <div class="space-y-3 mb-6">
            @foreach($ticket->replies as $reply)
            <div class="flex gap-3 {{ $reply->user_id === auth()->id() ? 'flex-row-reverse' : '' }}">
                <div class="shrink-0">
                    @if($reply->user->avatar)
                        <img src="{{ Storage::url($reply->user->avatar) }}" class="w-9 h-9 rounded-full object-cover" alt="">
                    @else
                        <div class="w-9 h-9 rounded-full {{ $reply->user->isOfficer() ? 'bg-brand-700' : 'bg-slate-300' }} flex items-center justify-center text-white text-sm font-bold">
                            {{ strtoupper(substr($reply->user->name, 0, 1)) }}
                        </div>
                    @endif
                </div>
                <div class="max-w-lg">
                    <div class="flex items-center gap-2 mb-1 {{ $reply->user_id === auth()->id() ? 'flex-row-reverse' : '' }}">
                        <span class="text-sm font-semibold text-slate-700">{{ $reply->user->name }}</span>
                        @if($reply->user->isOfficer())
                            <span class="text-xs bg-brand-100 text-brand-700 px-2 py-0.5 rounded-full font-medium">Officer</span>
                        @endif
                        <span class="text-xs text-slate-400">{{ $reply->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="bg-white border border-slate-100 rounded-xl px-4 py-3 shadow-sm {{ $reply->user_id === auth()->id() ? 'bg-brand-50 border-brand-100' : '' }}">
                        <p class="text-slate-700 text-sm whitespace-pre-line">{{ $reply->message }}</p>
                    </div>
                </div>
            </div>
            @endforeach

            @if($ticket->replies->isEmpty())
            <div class="text-center py-8 text-slate-400 text-sm">No replies yet. Our officers will respond shortly.</div>
            @endif
        </div>

        {{-- Reply Form --}}
        @if($ticket->status !== 'resolved')
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <h2 class="text-sm font-semibold text-slate-700 mb-3">Add a Reply</h2>
            <form method="POST" action="{{ route('tickets.reply', $ticket) }}">
                @csrf
                <textarea name="message" rows="4"
                    class="w-full border-slate-300 focus:border-brand-500 focus:ring-brand-500 rounded-lg shadow-sm resize-none text-sm"
                    placeholder="Type your reply..."
                    required>{{ old('message') }}</textarea>
                <x-input-error :messages="$errors->get('message')" class="mt-2" />
                <div class="flex justify-end mt-3">
                    <x-primary-button class="px-5 py-2">Send Reply</x-primary-button>
                </div>
            </form>
        </div>
        @else
        <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5 text-center">
            <svg class="w-8 h-8 text-slate-400 mx-auto mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <p class="text-slate-500 text-sm font-medium">This ticket has been resolved.</p>
            <p class="text-slate-400 text-xs mt-1">No further replies can be added.</p>
        </div>
        @endif
    </div>
</x-app-layout>
