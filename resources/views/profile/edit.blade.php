<x-app-layout>
    <x-slot name="title">Profile</x-slot>

    <div class="bg-brand-700 text-white py-10">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold">My Profile</h1>
            <p class="text-brand-200 mt-1">Manage your account information</p>
        </div>
    </div>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-6">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sm:p-8">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sm:p-8">
            @include('profile.partials.update-password-form')
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-red-100 p-6 sm:p-8">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</x-app-layout>
