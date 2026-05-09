<x-app-layout>
    <x-slot name="title">My Tickets</x-slot>

    <div class="bg-brand-700 text-white py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold">My Tickets</h1>
                <p class="text-brand-200 mt-1">Track your submitted concerns</p>
            </div>
            <a href="{{ route('tickets.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-brand-700 font-semibold rounded-xl hover:bg-brand-50 transition shadow">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                New Ticket
            </a>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        @if($tickets->count())
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="text-left px-5 py-3 text-slate-500 font-semibold">#</th>
                        <th class="text-left px-5 py-3 text-slate-500 font-semibold">Subject</th>
                        <th class="text-left px-5 py-3 text-slate-500 font-semibold">Status</th>
                        <th class="text-left px-5 py-3 text-slate-500 font-semibold">Submitted</th>
                        <th class="px-5 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($tickets as $ticket)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-5 py-4 text-slate-400">#{{ $ticket->id }}</td>
                        <td class="px-5 py-4 font-medium text-slate-800">{{ $ticket->subject }}</td>
                        <td class="px-5 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $ticket->getStatusBadgeClass() }}">
                                {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-slate-400">{{ $ticket->created_at->format('M j, Y') }}</td>
                        <td class="px-5 py-4 text-right">
                            <a href="{{ route('tickets.show', $ticket) }}" class="text-brand-700 hover:text-brand-800 font-medium text-xs">View →</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $tickets->links() }}
        @else
        <div class="text-center py-24 bg-white rounded-2xl border border-slate-100">
            <svg class="w-14 h-14 text-brand-200 mx-auto mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            <h3 class="text-lg font-bold text-slate-600 mb-2">No Tickets Yet</h3>
            <p class="text-slate-400 mb-6">Submit a ticket if you have a concern or inquiry.</p>
            <a href="{{ route('tickets.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand-700 text-white font-semibold rounded-xl hover:bg-brand-800 transition">
                Submit your first ticket
            </a>
        </div>
        @endif
    </div>
</x-app-layout>
