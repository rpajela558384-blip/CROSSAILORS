<x-app-layout>
    <x-slot name="title">Manage Officers</x-slot>

    <div class="bg-brand-700 text-white pt-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold mb-6">Dashboard</h1>
            <div class="flex gap-1 overflow-x-auto">
                <a href="{{ route('officer.carousel.index') }}" class="px-5 py-2.5 text-sm font-semibold rounded-t-xl whitespace-nowrap text-brand-200 hover:bg-brand-600 hover:text-white transition">Home Page</a>
                <a href="{{ route('officer.announcements.index') }}" class="px-5 py-2.5 text-sm font-semibold rounded-t-xl whitespace-nowrap text-brand-200 hover:bg-brand-600 hover:text-white transition">Announcements</a>
                <a href="{{ route('officer.officers.index') }}" class="px-5 py-2.5 text-sm font-semibold rounded-t-xl whitespace-nowrap bg-white text-brand-700">Officers</a>
                <a href="{{ route('officer.tickets.index') }}" class="px-5 py-2.5 text-sm font-semibold rounded-t-xl whitespace-nowrap text-brand-200 hover:bg-brand-600 hover:text-white transition">Tickets</a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm">{{ session('success') }}</div>
        @endif
        <div class="flex items-center justify-between mb-5">
            <h2 class="text-lg font-bold text-slate-800">Officer Profiles</h2>
            <a href="{{ route('officer.officers.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand-700 text-white font-semibold rounded-xl hover:bg-brand-800 transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                Add
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
            @forelse($officers as $officer)
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 text-center hover:shadow-md transition">
@php $boardPhoto = $officer->photo ? Storage::url($officer->photo) : ($officer->user->avatar ? Storage::url($officer->user->avatar) : null); @endphp
                @if($boardPhoto)
                    <img src="{{ $boardPhoto }}" class="w-16 h-16 rounded-full object-cover mx-auto mb-3 ring-4 ring-brand-100" alt="">
                @else
                    <div class="w-16 h-16 rounded-full bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center mx-auto mb-3">
                        <span class="text-white font-bold text-xl">{{ strtoupper(substr($officer->user->name, 0, 1)) }}</span>
                    </div>
                @endif
                <h3 class="font-bold text-slate-800">{{ $officer->user->name }}</h3>
                <p class="text-brand-600 text-xs font-medium mt-0.5">{{ $officer->position ?? 'No position set' }}</p>
                <span class="inline-block mt-1 px-2 py-0.5 text-xs rounded-full bg-brand-100 text-brand-700">{{ ucfirst($officer->user->role) }}</span>
                <div class="flex justify-center gap-3 mt-4">
                    <a href="{{ route('officer.officers.edit', $officer) }}" class="text-xs text-brand-700 hover:text-brand-800 font-medium border border-brand-200 px-3 py-1 rounded-lg hover:bg-brand-50 transition">Edit</a>
                    <button type="button" x-data
                        @click="$dispatch('confirm-action', {
                            title: 'Remove from Board',
                            message: 'Remove {{ addslashes($officer->user->name) }} from the officer board?',
                            type: 'danger',
                            action: () => $refs.removeOfficer{{ $officer->id }}.submit()
                        })"
                        class="text-xs text-red-500 hover:text-red-700 font-medium border border-red-200 px-3 py-1 rounded-lg hover:bg-red-50 transition">Remove</button>
                    <form x-ref="removeOfficer{{ $officer->id }}" method="POST" action="{{ route('officer.officers.destroy', $officer) }}" class="hidden">
                        @csrf @method('DELETE')
                    </form>
                </div>
            </div>
            @empty
            <div class="col-span-4 text-center py-16 text-slate-400">
                <p>No officers yet. Add one to get started.</p>
            </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
