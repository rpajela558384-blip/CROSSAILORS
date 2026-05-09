<x-app-layout>
    <x-slot name="title">New Ticket</x-slot>

    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-6">
            <a href="{{ route('tickets.index') }}" class="inline-flex items-center gap-1.5 text-brand-700 hover:text-brand-800 text-sm font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Back to Tickets
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
            <h1 class="text-2xl font-bold text-slate-800 mb-1">Submit a Ticket</h1>
            <p class="text-slate-500 text-sm mb-6">Describe your concern and our officers will respond as soon as possible.</p>

            <form method="POST" action="{{ route('tickets.store') }}">
                @csrf

                <div class="mb-5">
                    <x-input-label for="subject" value="Subject" />
                    <x-text-input id="subject" name="subject" type="text" class="mt-1" :value="old('subject')" placeholder="Brief description of your concern" required />
                    <x-input-error :messages="$errors->get('subject')" class="mt-2" />
                </div>

                <div class="mb-6">
                    <x-input-label for="description" value="Description" />
                    <textarea id="description" name="description" rows="6"
                        class="mt-1 w-full border-slate-300 focus:border-brand-500 focus:ring-brand-500 rounded-lg shadow-sm resize-none"
                        placeholder="Provide full details about your concern..."
                        required>{{ old('description') }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('tickets.index') }}" class="px-5 py-2.5 text-sm font-medium text-slate-600 hover:text-slate-800 border border-slate-200 rounded-xl hover:bg-slate-50 transition">Cancel</a>
                    <x-primary-button class="px-6 py-2.5">Submit Ticket</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
