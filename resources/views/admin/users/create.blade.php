<x-app-layout>
    <x-slot name="title">Create User</x-slot>

    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-6">
            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-1.5 text-brand-700 hover:text-brand-800 text-sm font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Back to Users
            </a>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
            <h1 class="text-2xl font-bold text-slate-800 mb-6">Create User Account</h1>
            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf
                <div class="mb-4">
                    <x-input-label for="name" value="Full Name" />
                    <x-text-input id="name" name="name" type="text" class="mt-1" :value="old('name')" required />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <x-input-label for="email" value="Email Address" />
                    <x-text-input id="email" name="email" type="email" class="mt-1" :value="old('email')" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <x-input-label for="role" value="Role" />
                    <select id="role" name="role" class="mt-1 w-full border-slate-300 focus:border-brand-500 focus:ring-brand-500 rounded-lg shadow-sm" required>
                        <option value="officer" {{ old('role') === 'officer' ? 'selected' : '' }}>Officer</option>
                        <option value="admin"   {{ old('role') === 'admin'   ? 'selected' : '' }}>Admin</option>
                    </select>
                    <x-input-error :messages="$errors->get('role')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <x-input-label for="position" value="Position (optional)" />
                    <x-text-input id="position" name="position" type="text" class="mt-1" :value="old('position')" />
                </div>
                <div class="mb-4">
                    <x-input-label for="password" value="Password" />
                    <x-text-input id="password" name="password" type="password" class="mt-1" required />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
                <div class="mb-6">
                    <x-input-label for="password_confirmation" value="Confirm Password" />
                    <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1" required />
                </div>
                <div class="flex justify-end gap-3">
                    <a href="{{ route('admin.users.index') }}" class="px-5 py-2.5 text-sm font-medium text-slate-600 border border-slate-200 rounded-xl hover:bg-slate-50 transition">Cancel</a>
                    <x-primary-button class="px-6 py-2.5">Create Account</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
