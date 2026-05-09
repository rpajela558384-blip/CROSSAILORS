<x-app-layout>
    <x-slot name="title">Announcements</x-slot>

    <div class="bg-brand-700 text-white pt-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold mb-6">Dashboard</h1>
            <div class="flex gap-1 overflow-x-auto">
                <a href="{{ route('officer.carousel.index') }}" class="px-5 py-2.5 text-sm font-semibold rounded-t-xl whitespace-nowrap text-brand-200 hover:bg-brand-600 hover:text-white transition">Home Page</a>
                <a href="{{ route('officer.announcements.index') }}" class="px-5 py-2.5 text-sm font-semibold rounded-t-xl whitespace-nowrap bg-white text-brand-700">Announcements</a>
                <a href="{{ route('officer.officers.index') }}" class="px-5 py-2.5 text-sm font-semibold rounded-t-xl whitespace-nowrap text-brand-200 hover:bg-brand-600 hover:text-white transition">Officers</a>
                <a href="{{ route('officer.tickets.index') }}" class="px-5 py-2.5 text-sm font-semibold rounded-t-xl whitespace-nowrap text-brand-200 hover:bg-brand-600 hover:text-white transition">Tickets</a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex items-center justify-between mb-5">
            <h2 class="text-lg font-bold text-slate-800">Announcements & Schedules</h2>
            <a href="{{ route('officer.announcements.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand-700 text-white font-semibold rounded-xl hover:bg-brand-800 transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                Add
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="text-left px-5 py-3 text-slate-500 font-semibold">Title</th>
                        <th class="text-left px-5 py-3 text-slate-500 font-semibold">Type</th>
                        <th class="text-left px-5 py-3 text-slate-500 font-semibold">Category</th>
                        <th class="text-left px-5 py-3 text-slate-500 font-semibold">Published</th>
                        <th class="text-left px-5 py-3 text-slate-500 font-semibold">Active</th>
                        <th class="text-left px-5 py-3 text-slate-500 font-semibold">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($announcements as $ann)
                    <tr class="hover:bg-slate-50">
                        <td class="px-5 py-3 font-medium text-slate-800">{{ Str::limit($ann->title, 60) }}</td>
                        <td class="px-5 py-3">
                            <span class="inline-flex px-2 py-0.5 rounded text-xs font-semibold {{ $ann->type === 'image' ? 'bg-purple-100 text-purple-700' : 'bg-slate-100 text-slate-600' }}">{{ ucfirst($ann->type) }}</span>
                        </td>
                        <td class="px-5 py-3">
                            <span class="inline-flex px-2 py-0.5 rounded text-xs font-semibold {{ $ann->category === 'announcement' ? 'bg-brand-100 text-brand-700' : 'bg-amber-100 text-amber-700' }}">{{ ucfirst($ann->category) }}</span>
                        </td>
                        <td class="px-5 py-3 text-slate-400">{{ $ann->published_at?->format('M j, Y') ?? '—' }}</td>
                        <td class="px-5 py-3">
                            <button type="button" x-data
                                @click="$dispatch('confirm-action', {
                                    title: '{{ $ann->active ? 'Hide' : 'Show' }} Announcement',
                                    message: '{{ $ann->active ? 'Hide this announcement from the home page?' : 'Make this announcement visible on the home page?' }}',
                                    type: '{{ $ann->active ? 'warning' : 'info' }}',
                                    action: () => $refs.toggleAnn{{ $ann->id }}.submit()
                                })"
                                class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $ann->active ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-500' }} hover:opacity-80">
                                {{ $ann->active ? 'Active' : 'Hidden' }}
                            </button>
                            <form x-ref="toggleAnn{{ $ann->id }}" method="POST" action="{{ route('officer.announcements.toggle', $ann) }}" class="hidden">
                                @csrf @method('PATCH')
                            </form>
                        </td>
                        <td class="px-5 py-3 space-x-3 whitespace-nowrap">
                            <a href="{{ route('officer.announcements.edit', $ann) }}" class="text-brand-700 hover:text-brand-800 text-xs font-medium">Edit</a>
                            <button type="button" x-data
                                @click="$dispatch('confirm-action', {
                                    title: 'Delete Announcement',
                                    message: 'Are you sure you want to delete this announcement? This cannot be undone.',
                                    type: 'danger',
                                    action: () => $refs.deleteAnn{{ $ann->id }}.submit()
                                })"
                                class="text-red-500 hover:text-red-700 text-xs font-medium">Delete</button>
                            <form x-ref="deleteAnn{{ $ann->id }}" method="POST" action="{{ route('officer.announcements.destroy', $ann) }}" class="hidden">
                                @csrf @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-5 py-10 text-center text-slate-400">No announcements yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $announcements->links() }}
    </div>
</x-app-layout>
