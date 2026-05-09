<x-app-layout>
    <x-slot name="title">Home Page</x-slot>

    <div class="bg-brand-700 text-white pt-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold mb-6">Dashboard</h1>
            <div class="flex gap-1 overflow-x-auto">
                <a href="{{ route('officer.carousel.index') }}" class="px-5 py-2.5 text-sm font-semibold rounded-t-xl whitespace-nowrap bg-white text-brand-700">Home Page</a>
                <a href="{{ route('officer.announcements.index') }}" class="px-5 py-2.5 text-sm font-semibold rounded-t-xl whitespace-nowrap text-brand-200 hover:bg-brand-600 hover:text-white transition">Announcements</a>
                <a href="{{ route('officer.officers.index') }}" class="px-5 py-2.5 text-sm font-semibold rounded-t-xl whitespace-nowrap text-brand-200 hover:bg-brand-600 hover:text-white transition">Officers</a>
                <a href="{{ route('officer.tickets.index') }}" class="px-5 py-2.5 text-sm font-semibold rounded-t-xl whitespace-nowrap text-brand-200 hover:bg-brand-600 hover:text-white transition">Tickets</a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex items-center justify-between mb-5">
            <h2 class="text-lg font-bold text-slate-800">Home Page Slides</h2>
            <a href="{{ route('officer.carousel.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand-700 text-white font-semibold rounded-xl hover:bg-brand-800 transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                Add
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="text-left px-5 py-3 text-slate-500 font-semibold">Preview</th>
                        <th class="text-left px-5 py-3 text-slate-500 font-semibold">Title</th>
                        <th class="text-left px-5 py-3 text-slate-500 font-semibold">Caption</th>
                        <th class="text-left px-5 py-3 text-slate-500 font-semibold">Order</th>
                        <th class="text-left px-5 py-3 text-slate-500 font-semibold">Status</th>
                        <th class="text-left px-5 py-3 text-slate-500 font-semibold">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($items as $item)
                    <tr class="hover:bg-slate-50">
                        <td class="px-5 py-3">
                            @if($item->image_path)
                                @php $ext = strtolower(pathinfo($item->image_path, PATHINFO_EXTENSION)); @endphp
                                @if(in_array($ext, ['mp4','mov','avi','webm']))
                                    <video src="{{ Storage::url($item->image_path) }}" class="w-20 h-12 object-cover rounded-lg" muted></video>
                                @else
                                    <img src="{{ Storage::url($item->image_path) }}" class="w-20 h-12 object-cover rounded-lg" alt="">
                                @endif
                            @else
                                <div class="w-20 h-12 bg-brand-50 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-brand-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            @endif
                        </td>
                        <td class="px-5 py-3 font-medium text-slate-700">{{ $item->title ?? '—' }}</td>
                        <td class="px-5 py-3 text-slate-500 max-w-xs truncate">{{ $item->caption ?? '—' }}</td>
                        <td class="px-5 py-3 text-slate-500">{{ $item->order }}</td>
                        <td class="px-5 py-3">
                            <button type="button" x-data
                                @click="$dispatch('confirm-action', {
                                    title: '{{ $item->active ? 'Hide Slide' : 'Show Slide' }}',
                                    message: '{{ $item->active ? 'Hide this slide from the home page?' : 'Make this slide visible on the home page?' }}',
                                    type: '{{ $item->active ? 'warning' : 'info' }}',
                                    action: () => $refs.toggleSlide{{ $item->id }}.submit()
                                })"
                                class="px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $item->active ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-500' }} hover:opacity-75 transition">
                                {{ $item->active ? 'Visible' : 'Hidden' }}
                            </button>
                            <form x-ref="toggleSlide{{ $item->id }}" method="POST" action="{{ route('officer.carousel.toggle', $item) }}" class="hidden">
                                @csrf @method('PATCH')
                            </form>
                        </td>
                        <td class="px-5 py-3 whitespace-nowrap space-x-3">
                            <a href="{{ route('officer.carousel.edit', $item) }}" class="text-brand-700 hover:text-brand-800 text-xs font-medium">Edit</a>
                            <button type="button"
                                x-data
                                @click="$dispatch('confirm-action', {
                                    title: 'Delete Slide',
                                    message: 'Are you sure you want to delete this slide? This cannot be undone.',
                                    type: 'danger',
                                    action: () => $refs.deleteForm{{ $item->id }}.submit()
                                })"
                                class="text-red-500 hover:text-red-700 text-xs font-medium">Delete</button>
                            <form x-ref="deleteForm{{ $item->id }}" method="POST" action="{{ route('officer.carousel.destroy', $item) }}" class="hidden">
                                @csrf @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-5 py-10 text-center text-slate-400">No slides yet. Click Add to get started.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $items->links() }}
    </div>
</x-app-layout>
