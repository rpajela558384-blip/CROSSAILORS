<x-app-layout>
    <x-slot name="title">Officers</x-slot>

    <div class="bg-brand-700 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-bold mb-2">Meet Our Officers</h1>
            <p class="text-brand-200">The dedicated leaders of the BSMT Department</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        @if($officers->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($officers as $officer)
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-md transition text-center p-6 group">
@php $boardPhoto = $officer->photo ? Storage::url($officer->photo) : ($officer->user->avatar ? Storage::url($officer->user->avatar) : null); @endphp
                @if($boardPhoto)
                    <img src="{{ $boardPhoto }}" alt="{{ $officer->user->name }}" class="w-20 h-20 rounded-full object-cover mx-auto mb-4 ring-4 ring-brand-100 group-hover:ring-brand-300 transition">
                @else
                    <div class="w-20 h-20 rounded-full bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center mx-auto mb-4 ring-4 ring-brand-100">
                        <span class="text-white font-bold text-2xl">{{ strtoupper(substr($officer->user->name, 0, 1)) }}</span>
                    </div>
                @endif
                <h3 class="font-bold text-slate-800 text-lg">{{ $officer->user->name }}</h3>
                @if($officer->position)
                    <p class="text-brand-600 text-sm font-medium mt-0.5">{{ $officer->position }}</p>
                @endif
                @if($officer->bio)
                    <p class="text-slate-500 text-xs mt-2 line-clamp-3">{{ $officer->bio }}</p>
                @endif
                @if($officer->contact_info)
                    <p class="text-slate-400 text-xs mt-3 flex items-center justify-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        {{ $officer->contact_info }}
                    </p>
                @endif
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-24">
            <svg class="w-16 h-16 text-brand-200 mx-auto mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
            <h3 class="text-xl font-bold text-slate-600 mb-2">No Officers Listed Yet</h3>
            <p class="text-slate-400">Officer profiles will appear here once added by the admin.</p>
        </div>
        @endif
    </div>
</x-app-layout>
