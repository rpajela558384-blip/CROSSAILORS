<x-app-layout>
    <x-slot name="title">Add to Officer Board</x-slot>

    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-6">
            <a href="{{ route('officer.officers.index') }}" class="inline-flex items-center gap-1.5 text-brand-700 hover:text-brand-800 text-sm font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Back to Officers
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
            <h1 class="text-2xl font-bold text-slate-800 mb-1">Add to Officer Board</h1>
            <p class="text-slate-500 text-sm mb-6">Only users with the <strong>Officer</strong> or <strong>Admin</strong> role can be featured on the board.</p>

            @if($errors->any())
                <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">{{ $errors->first() }}</div>
            @endif

            @if($eligible->isEmpty())
                <div class="py-10 text-center text-slate-400">
                    <p class="font-medium">No eligible officers available.</p>
                    <p class="text-sm mt-1">All officers are already on the board, or no officer accounts exist yet.</p>
                </div>
            @else
            <form method="POST" action="{{ route('officer.officers.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-5">
                    <x-input-label for="user_id" value="Select Officer" />
                    <select id="user_id" name="user_id" required
                            class="mt-1 w-full border-slate-300 focus:border-brand-500 focus:ring-brand-500 rounded-lg shadow-sm text-sm">
                        <option value="">— Choose an officer —</option>
                        @foreach($eligible as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }}) — {{ ucfirst($user->role) }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <x-input-label for="position" value="Position / Role Title" />
                    <x-text-input id="position" name="position" type="text" class="mt-1 w-full" :value="old('position')" placeholder="e.g. President, Secretary" />
                    <x-input-error :messages="$errors->get('position')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <x-input-label for="bio" value="Bio (optional)" />
                    <textarea id="bio" name="bio" rows="3" class="mt-1 w-full border-slate-300 focus:border-brand-500 focus:ring-brand-500 rounded-lg shadow-sm resize-none text-sm">{{ old('bio') }}</textarea>
                    <x-input-error :messages="$errors->get('bio')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <x-input-label for="contact_info" value="Contact Info (optional)" />
                    <x-text-input id="contact_info" name="contact_info" type="text" class="mt-1 w-full" :value="old('contact_info')" placeholder="Email, FB, phone..." />
                    <x-input-error :messages="$errors->get('contact_info')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <x-input-label for="photo" value="Board Photo (optional)" />
                    <input id="photo" name="photo" type="file" accept="image/*"
                           class="mt-1 w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100">
                    <p class="text-xs text-slate-400 mt-1">Shown on the officer board. Falls back to account avatar if not set.</p>
                    <x-input-error :messages="$errors->get('photo')" class="mt-2" />
                </div>
                <div class="mb-6">
                    <x-input-label for="display_order" value="Display Order" />
                    <x-text-input id="display_order" name="display_order" type="number" class="mt-1 w-24" :value="old('display_order', 0)" min="0" />
                    <x-input-error :messages="$errors->get('display_order')" class="mt-2" />
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('officer.officers.index') }}" class="px-5 py-2.5 text-sm font-medium text-slate-600 border border-slate-200 rounded-xl hover:bg-slate-50 transition">Cancel</a>
                    <x-primary-button class="px-6 py-2.5">Add to Board</x-primary-button>
                </div>
            </form>
            @endif
        </div>
    </div>
</x-app-layout>
