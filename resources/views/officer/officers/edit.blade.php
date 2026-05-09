<x-app-layout>
    <x-slot name="title">Edit Officer</x-slot>

    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-6">
            <a href="{{ route('officer.officers.index') }}" class="inline-flex items-center gap-1.5 text-brand-700 hover:text-brand-800 text-sm font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Back to Officers
            </a>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
            {{-- Read-only user info --}}
            <div class="flex items-center gap-4 mb-6 pb-6 border-b border-slate-100">
                @if($officer->user->avatar)
                    <img src="{{ Storage::url($officer->user->avatar) }}" class="w-14 h-14 rounded-full object-cover ring-4 ring-brand-100" alt="">
                @else
                    <div class="w-14 h-14 rounded-full bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center">
                        <span class="text-white font-bold text-xl">{{ strtoupper(substr($officer->user->name, 0, 1)) }}</span>
                    </div>
                @endif
                <div>
                    <h1 class="text-xl font-bold text-slate-800">{{ $officer->user->name }}</h1>
                    <p class="text-sm text-slate-400">{{ $officer->user->email }}</p>
                </div>
            </div>

            <form method="POST" action="{{ route('officer.officers.update', $officer) }}" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="mb-4">
                    <x-input-label for="position" value="Position / Role Title" />
                    <x-text-input id="position" name="position" type="text" class="mt-1 w-full" :value="old('position', $officer->position)" placeholder="e.g. President, Secretary" />
                    <x-input-error :messages="$errors->get('position')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <x-input-label for="bio" value="Bio (optional)" />
                    <textarea id="bio" name="bio" rows="3" class="mt-1 w-full border-slate-300 focus:border-brand-500 focus:ring-brand-500 rounded-lg shadow-sm resize-none text-sm">{{ old('bio', $officer->bio) }}</textarea>
                </div>
                <div class="mb-4">
                    <x-input-label for="contact_info" value="Contact Info (optional)" />
                    <x-text-input id="contact_info" name="contact_info" type="text" class="mt-1 w-full" :value="old('contact_info', $officer->contact_info)" />
                </div>
                <div class="mb-4">
                    <x-input-label value="Board Photo" />
                    @php $boardPhoto = $officer->photo ? Storage::url($officer->photo) : ($officer->user->avatar ? Storage::url($officer->user->avatar) : null); @endphp
                    @if($boardPhoto)
                    <div class="mt-2 mb-2">
                        <img src="{{ $boardPhoto }}" class="w-20 h-20 rounded-full object-cover ring-4 ring-brand-100" alt="">
                        <p class="text-xs text-slate-400 mt-1">{{ $officer->photo ? 'Board photo' : 'Using account avatar' }}</p>
                    </div>
                    @endif
                    <input id="photo" name="photo" type="file" accept="image/*"
                           class="mt-1 w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100">
                    <p class="text-xs text-slate-400 mt-1">Replace board photo. Falls back to account avatar if not set.</p>
                    <x-input-error :messages="$errors->get('photo')" class="mt-2" />
                </div>
                <div class="mb-6">
                    <x-input-label for="display_order" value="Display Order" />
                    <x-text-input id="display_order" name="display_order" type="number" class="mt-1 w-24" :value="old('display_order', $officer->display_order)" min="0" />
                </div>
                <div class="flex justify-end gap-3">
                    <a href="{{ route('officer.officers.index') }}" class="px-5 py-2.5 text-sm font-medium text-slate-600 border border-slate-200 rounded-xl hover:bg-slate-50 transition">Cancel</a>
                    <x-primary-button class="px-6 py-2.5">Save Changes</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
