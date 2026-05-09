<x-app-layout>
    <x-slot name="title">Edit Announcement</x-slot>

    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-6">
            <a href="{{ route('officer.announcements.index') }}" class="inline-flex items-center gap-1.5 text-brand-700 hover:text-brand-800 text-sm font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Back to Announcements
            </a>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
            <h1 class="text-2xl font-bold text-slate-800 mb-6">Edit Announcement</h1>
            <form method="POST" action="{{ route('officer.announcements.update', $announcement) }}" enctype="multipart/form-data" x-data="{ cardType: '{{ old('type', $announcement->type) }}' }">
                @csrf @method('PUT')
                <div class="mb-4">
                    <x-input-label value="Card Type" />
                    <div class="flex gap-3 mt-1">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="type" value="text" x-model="cardType" {{ old('type', $announcement->type) === 'text' ? 'checked' : '' }} class="text-brand-700 focus:ring-brand-500">
                            <span class="text-sm text-slate-700">Text Card</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="type" value="image" x-model="cardType" {{ old('type', $announcement->type) === 'image' ? 'checked' : '' }} class="text-brand-700 focus:ring-brand-500">
                            <span class="text-sm text-slate-700">Image Card</span>
                        </label>
                    </div>
                </div>
                <div class="mb-4">
                    <x-input-label for="category" value="Category" />
                    <select id="category" name="category" class="mt-1 w-full border-slate-300 focus:border-brand-500 focus:ring-brand-500 rounded-lg shadow-sm" required>
                        <option value="announcement" {{ old('category', $announcement->category) === 'announcement' ? 'selected' : '' }}>Announcement</option>
                        <option value="schedule" {{ old('category', $announcement->category) === 'schedule' ? 'selected' : '' }}>Schedule</option>
                    </select>
                </div>
                <div class="mb-4">
                    <x-input-label for="title" value="Title" />
                    <x-text-input id="title" name="title" type="text" class="mt-1" :value="old('title', $announcement->title)" required />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>
                <div class="mb-4" x-show="cardType === 'text'">
                    <x-input-label for="body" value="Body Text" />
                    <textarea id="body" name="body" rows="5" class="mt-1 w-full border-slate-300 focus:border-brand-500 focus:ring-brand-500 rounded-lg shadow-sm resize-none">{{ old('body', $announcement->body) }}</textarea>
                </div>
                <div class="mb-4">
                    <x-input-label for="link_url" value="Link URL (optional — Facebook post, article, etc.)" />
                    <x-text-input id="link_url" name="link_url" type="url" class="mt-1 w-full" :value="old('link_url', $announcement->link_url)" placeholder="https://..." />
                    <p class="text-xs text-slate-400 mt-1">A button will appear on the card for users to open this link.</p>
                    <x-input-error :messages="$errors->get('link_url')" class="mt-2" />
                </div>
                @if($announcement->image_path)
                <div class="mb-3" x-show="cardType === 'image'">
                    <p class="text-sm text-slate-500 mb-1">Current image:</p>
                    <img src="{{ Storage::url($announcement->image_path) }}" class="h-28 rounded-lg object-cover" alt="">
                </div>
                @endif
                <div class="mb-4" x-show="cardType === 'image'">
                    <x-input-label for="image" value="Replace Image (optional)" />
                    <input id="image" name="image" type="file" accept="image/*" class="mt-1 w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100">
                </div>
                <div class="mb-4">
                    <x-input-label for="published_at" value="Publish Date" />
                    <x-text-input id="published_at" name="published_at" type="datetime-local" class="mt-1" :value="old('published_at', $announcement->published_at?->format('Y-m-d\TH:i'))" />
                </div>
                <div class="mb-6 flex items-center gap-2">
                    <input id="active" name="active" type="checkbox" value="1" {{ old('active', $announcement->active) ? 'checked' : '' }} class="rounded border-slate-300 text-brand-700 focus:ring-brand-500">
                    <x-input-label for="active" value="Active (visible on homepage)" />
                </div>
                <div class="flex justify-end gap-3">
                    <a href="{{ route('officer.announcements.index') }}" class="px-5 py-2.5 text-sm font-medium text-slate-600 border border-slate-200 rounded-xl hover:bg-slate-50 transition">Cancel</a>
                    <x-primary-button class="px-6 py-2.5">Update</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
