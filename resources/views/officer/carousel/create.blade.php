<x-app-layout>
    <x-slot name="title">Add Carousel Item</x-slot>

    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-6">
            <a href="{{ route('officer.carousel.index') }}" class="inline-flex items-center gap-1.5 text-brand-700 hover:text-brand-800 text-sm font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Back to Carousels
            </a>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
            <h1 class="text-2xl font-bold text-slate-800 mb-6">Add Home Page Slide</h1>
            <form method="POST" action="{{ route('officer.carousel.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <x-input-label for="title" value="Title (optional)" />
                    <x-text-input id="title" name="title" type="text" class="mt-1 w-full" :value="old('title')" />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <x-input-label for="caption" value="Caption (optional)" />
                    <textarea id="caption" name="caption" rows="3" class="mt-1 w-full border-slate-300 focus:border-brand-500 focus:ring-brand-500 rounded-lg shadow-sm resize-none">{{ old('caption') }}</textarea>
                    <x-input-error :messages="$errors->get('caption')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <x-input-label for="link_url" value="Link URL (optional — Facebook post, article, etc.)" />
                    <x-text-input id="link_url" name="link_url" type="url" class="mt-1 w-full" :value="old('link_url')" placeholder="https://..." />
                    <p class="text-xs text-slate-400 mt-1">Shown as a clickable button on the slide.</p>
                    <x-input-error :messages="$errors->get('link_url')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <x-input-label for="media" value="Media — Image, GIF, or Video (optional)" />
                    <input id="media" name="media" type="file" accept="image/*,video/*,.gif"
                           class="mt-1 w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100">
                    <p class="text-xs text-slate-400 mt-1">Accepted: JPG, PNG, GIF, WEBP, MP4, MOV, AVI, WEBM — max 50 MB</p>
                    <x-input-error :messages="$errors->get('media')" class="mt-2" />
                </div>
                <div class="mb-6">
                    <x-input-label for="order" value="Display Order" />
                    <x-text-input id="order" name="order" type="number" class="mt-1 w-24" :value="old('order', 0)" min="0" />
                    <x-input-error :messages="$errors->get('order')" class="mt-2" />
                </div>
                <div class="mb-6 flex items-center gap-2">
                    <input id="active" name="active" type="checkbox" value="1" {{ old('active', true) ? 'checked' : '' }} class="rounded border-slate-300 text-brand-700 focus:ring-brand-500">
                    <x-input-label for="active" value="Visible on Home Page" />
                </div>
                <div class="flex justify-end gap-3">
                    <a href="{{ route('officer.carousel.index') }}" class="px-5 py-2.5 text-sm font-medium text-slate-600 border border-slate-200 rounded-xl hover:bg-slate-50 transition">Cancel</a>
                    <x-primary-button class="px-6 py-2.5">Save Slide</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
