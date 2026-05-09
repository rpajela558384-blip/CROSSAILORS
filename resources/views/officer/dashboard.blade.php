<x-app-layout>
    <x-slot name="title">Officer Dashboard</x-slot>

    <div class="bg-brand-700 text-white pt-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold mb-6">Dashboard</h1>
            {{-- Sub-nav tabs --}}
            <div class="flex gap-1 overflow-x-auto pb-0">
                <a href="{{ route('officer.carousel.index') }}"
                   class="px-5 py-2.5 text-sm font-semibold rounded-t-xl whitespace-nowrap transition
                       {{ request()->routeIs('officer.carousel.*') ? 'bg-white text-brand-700' : 'text-brand-200 hover:bg-brand-600 hover:text-white' }}">
                    Home Page
                </a>
                <a href="{{ route('officer.announcements.index') }}"
                   class="px-5 py-2.5 text-sm font-semibold rounded-t-xl whitespace-nowrap transition
                       {{ request()->routeIs('officer.announcements.*') ? 'bg-white text-brand-700' : 'text-brand-200 hover:bg-brand-600 hover:text-white' }}">
                    Announcements
                </a>
                <a href="{{ route('officer.officers.index') }}"
                   class="px-5 py-2.5 text-sm font-semibold rounded-t-xl whitespace-nowrap transition
                       {{ request()->routeIs('officer.officers.*') ? 'bg-white text-brand-700' : 'text-brand-200 hover:bg-brand-600 hover:text-white' }}">
                    Officers
                </a>
                <a href="{{ route('officer.tickets.index') }}"
                   class="px-5 py-2.5 text-sm font-semibold rounded-t-xl whitespace-nowrap transition
                       {{ request()->routeIs('officer.tickets.*') ? 'bg-white text-brand-700' : 'text-brand-200 hover:bg-brand-600 hover:text-white' }}">
                    Tickets
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- Recent Tickets --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h2 class="font-semibold text-slate-800">Recent Tickets</h2>
                <a href="{{ route('officer.tickets.index') }}" class="text-xs text-brand-700 hover:underline">View all →</a>
            </div>
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="text-left px-5 py-3 text-slate-500 font-semibold">Student</th>
                        <th class="text-left px-5 py-3 text-slate-500 font-semibold">Subject</th>
                        <th class="text-left px-5 py-3 text-slate-500 font-semibold">Status</th>
                        <th class="text-left px-5 py-3 text-slate-500 font-semibold">Submitted</th>
                        <th class="px-5 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($recentTickets as $ticket)
                    <tr class="hover:bg-slate-50">
                        <td class="px-5 py-3 font-medium text-slate-700">{{ $ticket->user->name }}</td>
                        <td class="px-5 py-3 text-slate-600">{{ Str::limit($ticket->subject, 50) }}</td>
                        <td class="px-5 py-3">
                            <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $ticket->getStatusBadgeClass() }}">
                                {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                            </span>
                        </td>
                        <td class="px-5 py-3 text-slate-400">{{ $ticket->created_at->diffForHumans() }}</td>
                        <td class="px-5 py-3 text-right">
                            <a href="{{ route('officer.tickets.show', $ticket) }}" class="text-brand-700 hover:text-brand-800 text-xs font-medium">Open →</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-5 py-8 text-center text-slate-400">No tickets yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
