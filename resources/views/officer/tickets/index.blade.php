<x-app-layout>
    <x-slot name="title">Manage Tickets</x-slot>

    <div class="bg-brand-700 text-white pt-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold mb-6">Dashboard</h1>
            <div class="flex gap-1 overflow-x-auto">
                <a href="{{ route('officer.carousel.index') }}" class="px-5 py-2.5 text-sm font-semibold rounded-t-xl whitespace-nowrap text-brand-200 hover:bg-brand-600 hover:text-white transition">Home Page</a>
                <a href="{{ route('officer.announcements.index') }}" class="px-5 py-2.5 text-sm font-semibold rounded-t-xl whitespace-nowrap text-brand-200 hover:bg-brand-600 hover:text-white transition">Announcements</a>
                <a href="{{ route('officer.officers.index') }}" class="px-5 py-2.5 text-sm font-semibold rounded-t-xl whitespace-nowrap text-brand-200 hover:bg-brand-600 hover:text-white transition">Officers</a>
                <a href="{{ route('officer.tickets.index') }}" class="px-5 py-2.5 text-sm font-semibold rounded-t-xl whitespace-nowrap bg-white text-brand-700">Tickets</a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h2 class="text-lg font-bold text-slate-800 mb-5">Student Tickets</h2>

        {{-- Filter --}}
        <form method="GET" class="flex flex-wrap items-center gap-3 mb-6">
            <select name="status" onchange="this.form.submit()" class="border-slate-300 focus:border-brand-500 focus:ring-brand-500 rounded-lg shadow-sm text-sm py-2">
                <option value="">All Statuses</option>
                <option value="open"        {{ request('status') === 'open'        ? 'selected' : '' }}>Open</option>
                <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="resolved"    {{ request('status') === 'resolved'    ? 'selected' : '' }}>Resolved</option>
            </select>
        </form>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="text-left px-5 py-3 text-slate-500 font-semibold">#</th>
                        <th class="text-left px-5 py-3 text-slate-500 font-semibold">Student</th>
                        <th class="text-left px-5 py-3 text-slate-500 font-semibold">Subject</th>
                        <th class="text-left px-5 py-3 text-slate-500 font-semibold">Status</th>
                        <th class="text-left px-5 py-3 text-slate-500 font-semibold">Submitted</th>
                        <th class="text-left px-5 py-3 text-slate-500 font-semibold">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($tickets as $ticket)
                    <tr class="hover:bg-slate-50">
                        <td class="px-5 py-3 text-slate-400">#{{ $ticket->id }}</td>
                        <td class="px-5 py-3 font-medium text-slate-700">{{ $ticket->user->name }}</td>
                        <td class="px-5 py-3 text-slate-600">{{ Str::limit($ticket->subject, 55) }}</td>
                        <td class="px-5 py-3">
                            <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $ticket->getStatusBadgeClass() }}">
                                {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                            </span>
                        </td>
                        <td class="px-5 py-3 text-slate-400">{{ $ticket->created_at->format('M j, Y') }}</td>
                        <td class="px-5 py-3">
                            <a href="{{ route('officer.tickets.show', $ticket) }}" class="text-brand-700 hover:text-brand-800 text-xs font-medium">Open →</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-5 py-10 text-center text-slate-400">No tickets found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $tickets->links() }}
    </div>
</x-app-layout>
