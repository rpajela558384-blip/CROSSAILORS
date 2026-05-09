<x-app-layout>
    <x-slot name="title">Home</x-slot>

    {{-- ═══════════════ HERO / GREETING ═══════════════ --}}
    <section class="relative bg-gradient-to-br from-brand-700 via-brand-800 to-brand-900 text-white overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                <polygon fill="white" points="0,100 100,0 100,100"/>
            </svg>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 md:py-32 flex flex-col items-center text-center">
            <span class="inline-block bg-white/10 text-brand-200 text-xs font-semibold uppercase tracking-widest px-4 py-1.5 rounded-full mb-4">BSMT Department Portal</span>
            <h1 class="text-4xl md:text-6xl font-bold leading-tight mb-4">
                Welcome to <span class="text-brand-300">Crossailors</span>
            </h1>
            <p class="text-brand-100 text-lg md:text-xl max-w-2xl mb-8">Stay updated with the latest news, announcements, and projects from the Bachelor of Science in Marine Transportation department.</p>
            @guest
            <div class="flex flex-wrap gap-3 justify-center">
                <a href="{{ route('register') }}" class="px-6 py-3 bg-white text-brand-700 font-semibold rounded-xl hover:bg-brand-50 transition shadow">Join the Portal</a>
                <a href="{{ route('login') }}" class="px-6 py-3 bg-brand-600 text-white font-semibold rounded-xl hover:bg-brand-500 transition border border-white/20">Sign In</a>
            </div>
            @endguest
        </div>
    </section>

    {{-- ═══════════════ ALL CAROUSEL SLIDES ═══════════════ --}}
    @if($introCarousel->count())
    <section class="py-10 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div x-data="carousel({{ $introCarousel->count() }})" class="relative">
                <div class="overflow-hidden rounded-2xl shadow-lg">
                    @foreach($introCarousel as $i => $item)
                    @php $ext = $item->image_path ? strtolower(pathinfo($item->image_path, PATHINFO_EXTENSION)) : ''; @endphp
                    @php $isVideo = in_array($ext, ['mp4','mov','avi','webm']); @endphp
                    @php $mediaSrc = $item->image_path ? Storage::url($item->image_path) : ''; @endphp
                    <div x-show="current === {{ $i }}" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" class="relative">
                        @if($item->image_path)
                        <div class="relative w-full h-80 md:h-[480px] overflow-hidden cursor-zoom-in"
                             @click="$store.lightbox.show('{{ $mediaSrc }}', '{{ $isVideo ? 'video' : 'image' }}')">                            {{-- Blurred background --}}
                            @if($isVideo)
                                <video src="{{ $mediaSrc }}" class="absolute inset-0 w-full h-full object-cover scale-110 blur-lg opacity-60" muted></video>
                                <video src="{{ $mediaSrc }}" class="relative z-10 w-full h-full object-contain" autoplay muted loop playsinline></video>
                            @else
                                <img src="{{ $mediaSrc }}" alt="" class="absolute inset-0 w-full h-full object-cover scale-110 blur-lg opacity-60" aria-hidden="true">
                                <img src="{{ $mediaSrc }}" alt="{{ $item->title }}" class="relative z-10 w-full h-full object-contain">
                            @endif
                        </div>
                        @else
                            <div class="w-full h-80 md:h-[480px] bg-gradient-to-br from-brand-100 to-brand-200 flex items-center justify-center">
                                <svg class="w-24 h-24 text-brand-400" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                        @endif
                        @if($item->title || $item->caption)
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent p-8 pointer-events-none z-20">
                            @if($item->title)<h3 class="text-white font-bold text-2xl drop-shadow">{{ $item->title }}</h3>@endif
                            @if($item->caption)<p class="text-white/85 text-sm mt-1 drop-shadow">{{ $item->caption }}</p>@endif
                        </div>
                        @endif
                        @if($item->link_url ?? null)
                        <div class="absolute bottom-4 right-4 z-30 pointer-events-auto">
                            <a href="{{ $item->link_url }}" target="_blank" rel="noopener"
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white/90 text-brand-700 text-xs font-semibold rounded-full hover:bg-white shadow transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                View Link
                            </a>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
                @if($introCarousel->count() > 1)
                <button @click="prev()" class="absolute left-3 top-1/2 -translate-y-1/2 z-10 bg-white/80 hover:bg-white rounded-full p-2 shadow transition">
                    <svg class="w-5 h-5 text-brand-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button @click="next()" class="absolute right-3 top-1/2 -translate-y-1/2 z-10 bg-white/80 hover:bg-white rounded-full p-2 shadow transition">
                    <svg class="w-5 h-5 text-brand-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </button>
                <div class="flex justify-center gap-2 mt-4">
                    @foreach($introCarousel as $i => $item)
                    <button @click="current = {{ $i }}" :class="current === {{ $i }} ? 'bg-brand-700 w-6' : 'bg-slate-300 w-2'" class="h-2 rounded-full transition-all"></button>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </section>
    @endif

    {{-- ═══════════════ MEET THE OFFICERS CTA ═══════════════ --}}
    <section class="py-14 bg-brand-50 border-y border-brand-100">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <div class="inline-flex items-center justify-center w-14 h-14 bg-brand-100 rounded-full mb-4">
                <svg class="w-7 h-7 text-brand-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <h2 class="text-3xl font-bold text-brand-700 mb-3">Meet Your Officers</h2>
            <p class="text-slate-600 mb-6 max-w-xl mx-auto">Get to know the dedicated officers who serve the BSMT department. They're here to help and guide you.</p>
            <a href="{{ route('officers.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-brand-700 text-white font-semibold rounded-xl hover:bg-brand-800 transition shadow-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                View Officers
            </a>
        </div>
    </section>

    {{-- ═══════════════ UPDATES / NEWS CAROUSEL ═══════════════ --}}
    @if($updatesCarousel->count())
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold text-brand-700">Department Updates</h2>
                <p class="text-slate-500 mt-2">Latest news and announcements from BSMT</p>
            </div>
            <div x-data="carousel({{ $updatesCarousel->count() }})" class="relative">
                <div class="overflow-hidden rounded-2xl shadow-lg">
                    @foreach($updatesCarousel as $i => $item)
                    @php $uExt = $item->image_path ? strtolower(pathinfo($item->image_path, PATHINFO_EXTENSION)) : ''; @endphp
                    @php $uIsVid = in_array($uExt, ['mp4','mov','avi','webm']); @endphp
                    @php $uSrc = $item->image_path ? Storage::url($item->image_path) : ''; @endphp
                    <div x-show="current === {{ $i }}" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="relative">
                        @if($item->image_path)
                        <div class="relative w-full h-80 md:h-96 overflow-hidden cursor-zoom-in"
                             @click="$store.lightbox.show('{{ $uSrc }}', '{{ $uIsVid ? 'video' : 'image' }}')">                            @if($uIsVid)
                                <video src="{{ $uSrc }}" class="absolute inset-0 w-full h-full object-cover scale-110 blur-lg opacity-60" muted></video>
                                <video src="{{ $uSrc }}" class="relative z-10 w-full h-full object-contain" autoplay muted loop playsinline></video>
                            @else
                                <img src="{{ $uSrc }}" alt="" class="absolute inset-0 w-full h-full object-cover scale-110 blur-lg opacity-60" aria-hidden="true">
                                <img src="{{ $uSrc }}" alt="{{ $item->title }}" class="relative z-10 w-full h-full object-contain">
                            @endif
                        </div>
                        @else
                            <div class="w-full h-80 md:h-96 bg-gradient-to-br from-blue-50 to-brand-100 flex items-center justify-center">
                                <svg class="w-24 h-24 text-brand-300" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                            </div>
                        @endif
                        @if($item->title || $item->caption)
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 p-6 pointer-events-none z-20">
                            @if($item->title)<h3 class="text-white font-bold text-xl">{{ $item->title }}</h3>@endif
                            @if($item->caption)<p class="text-white/80 text-sm mt-1">{{ $item->caption }}</p>@endif
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
                @if($updatesCarousel->count() > 1)
                <button @click="prev()" class="absolute left-3 top-1/2 -translate-y-1/2 z-10 bg-white/80 hover:bg-white rounded-full p-2 shadow transition">
                    <svg class="w-5 h-5 text-brand-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button @click="next()" class="absolute right-3 top-1/2 -translate-y-1/2 z-10 bg-white/80 hover:bg-white rounded-full p-2 shadow transition">
                    <svg class="w-5 h-5 text-brand-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </button>
                <div class="flex justify-center gap-2 mt-4">
                    @foreach($updatesCarousel as $i => $item)
                    <button @click="current = {{ $i }}" :class="current === {{ $i }} ? 'bg-brand-700 w-6' : 'bg-slate-300 w-2'" class="h-2 rounded-full transition-all"></button>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </section>
    @endif

    {{-- ═══════════════ ANNOUNCEMENTS & SCHEDULES ═══════════════ --}}
    <section class="py-16 bg-slate-50" x-data="{ modal: null }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold text-brand-700">Announcements & Schedules</h2>
                <p class="text-slate-500 mt-2">Important information from your department</p>
            </div>

            @if($announcements->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($announcements as $ann)
                @php
                    $annData = [
                        'title'      => $ann->title,
                        'body'       => $ann->body,
                        'category'   => $ann->category,
                        'type'       => $ann->type,
                        'image'      => $ann->image_path ? Storage::url($ann->image_path) : null,
                        'published'  => $ann->published_at?->format('F j, Y'),
                        'link_url'   => $ann->link_url,
                    ];
                @endphp
                <button type="button"
                    @click="modal = {{ json_encode($annData) }}"
                    class="text-left bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-lg transition group focus:outline-none focus:ring-2 focus:ring-brand-500 w-full">
                    @if($ann->image_path)
                        <div class="relative w-full aspect-[4/3] overflow-hidden">
                            <img src="{{ Storage::url($ann->image_path) }}" alt="" class="absolute inset-0 w-full h-full object-cover scale-110 blur-md opacity-50" aria-hidden="true">
                            <img src="{{ Storage::url($ann->image_path) }}" alt="{{ $ann->title }}" class="relative z-10 w-full h-full object-contain">
                        </div>
                    @else
                        <div class="w-full aspect-[4/3] bg-gradient-to-br from-brand-50 to-brand-100 flex items-center justify-center">
                            <svg class="w-16 h-16 text-brand-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                        </div>
                    @endif
                    <div class="p-5">
                        <div class="flex items-start justify-between gap-2 mb-2">
                            <h3 class="font-bold text-slate-800 text-base leading-snug">{{ $ann->title }}</h3>
                            <span class="shrink-0 px-2 py-0.5 text-xs font-semibold rounded-full {{ $ann->category === 'announcement' ? 'bg-brand-100 text-brand-700' : 'bg-amber-100 text-amber-700' }}">
                                {{ ucfirst($ann->category) }}
                            </span>
                        </div>
                        @if($ann->body)
                        <p class="text-slate-500 text-sm line-clamp-2">{{ $ann->body }}</p>
                        @endif
                        @if($ann->published_at)
                        <p class="text-xs text-slate-400 mt-3 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            {{ $ann->published_at->format('F j, Y') }}
                        </p>
                        @endif
                    </div>
                </button>
                @endforeach
            </div>
            @else
            <div class="flex flex-col items-center justify-center py-20 text-center">
                <div class="w-16 h-16 rounded-full bg-brand-50 flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-brand-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                </div>
                <h3 class="text-lg font-semibold text-slate-600 mb-1">No Announcements Yet</h3>
                <p class="text-slate-400 text-sm max-w-sm">Check back soon — announcements and schedules from the department will appear here.</p>
            </div>
            @endif
        </div>

        {{-- Announcement Detail Modal --}}
        <div x-show="modal" x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @keydown.escape.window="modal = null"
             @click.self="modal = null"
             class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4">
            <div x-show="modal"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden max-h-[90vh] flex flex-col">
                <template x-if="modal && modal.image">
                    <div class="relative w-full aspect-video overflow-hidden shrink-0 cursor-zoom-in"
                         @click="$store.lightbox.show(modal.image, 'image')">
                        <img :src="modal.image" alt="" class="absolute inset-0 w-full h-full object-cover scale-110 blur-md opacity-50" aria-hidden="true">
                        <img :src="modal.image" :alt="modal.title" class="relative z-10 w-full h-full object-contain">
                        <div class="absolute top-2 right-2 z-20 bg-black/40 rounded-full p-1.5 text-white/80">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0zm-2 0a4 4 0 10-8 0 4 4 0 008 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M13 11h-4m2-2v4"/></svg>
                        </div>
                    </div>
                </template>
                <div class="p-6 overflow-y-auto">
                    <div class="flex items-start justify-between gap-3 mb-3">
                        <h2 class="text-xl font-bold text-slate-800 leading-snug" x-text="modal && modal.title"></h2>
                        <span class="shrink-0 px-2.5 py-0.5 text-xs font-semibold rounded-full"
                              :class="modal && modal.category === 'announcement' ? 'bg-brand-100 text-brand-700' : 'bg-amber-100 text-amber-700'"
                              x-text="modal && (modal.category ? modal.category.charAt(0).toUpperCase() + modal.category.slice(1) : '')"></span>
                    </div>
                    <p class="text-slate-600 text-sm leading-relaxed whitespace-pre-line" x-text="modal && modal.body"></p>
                    <p class="text-xs text-slate-400 mt-4 flex items-center gap-1" x-show="modal && modal.published">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span x-text="modal && modal.published"></span>
                    </p>
                </div>
                <div class="px-6 py-4 border-t border-slate-100 shrink-0 flex gap-3">
                    <template x-if="modal && modal.link_url">
                        <a :href="modal.link_url" target="_blank" rel="noopener"
                           class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-slate-100 text-slate-700 text-sm font-semibold rounded-xl hover:bg-slate-200 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            Open Link
                        </a>
                    </template>
                    <button @click="modal = null" class="flex-1 px-4 py-2.5 bg-brand-700 text-white text-sm font-semibold rounded-xl hover:bg-brand-800 transition">Close</button>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════ PROJECTS / GOALS CAROUSEL ═══════════════ --}}
    @if($projectsCarousel->count())
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold text-brand-700">Projects & Goals</h2>
                <p class="text-slate-500 mt-2">What we're working towards this year</p>
            </div>
            <div x-data="carousel({{ $projectsCarousel->count() }})" class="relative">
                <div class="overflow-hidden rounded-2xl shadow-lg">
                    @foreach($projectsCarousel as $i => $item)
                    @php $pExt = $item->image_path ? strtolower(pathinfo($item->image_path, PATHINFO_EXTENSION)) : ''; @endphp
                    @php $pIsVid = in_array($pExt, ['mp4','mov','avi','webm']); @endphp
                    @php $pSrc = $item->image_path ? Storage::url($item->image_path) : ''; @endphp
                    <div x-show="current === {{ $i }}" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="relative">
                        @if($item->image_path)
                        <div class="relative w-full h-80 md:h-96 overflow-hidden cursor-zoom-in"
                             @click="$store.lightbox.show('{{ $pSrc }}', '{{ $pIsVid ? 'video' : 'image' }}')">                            @if($pIsVid)
                                <video src="{{ $pSrc }}" class="absolute inset-0 w-full h-full object-cover scale-110 blur-lg opacity-60" muted></video>
                                <video src="{{ $pSrc }}" class="relative z-10 w-full h-full object-contain" autoplay muted loop playsinline></video>
                            @else
                                <img src="{{ $pSrc }}" alt="" class="absolute inset-0 w-full h-full object-cover scale-110 blur-lg opacity-60" aria-hidden="true">
                                <img src="{{ $pSrc }}" alt="{{ $item->title }}" class="relative z-10 w-full h-full object-contain">
                            @endif
                        </div>
                        @else
                            <div class="w-full h-80 md:h-96 bg-gradient-to-br from-brand-50 to-brand-100 flex items-center justify-center">
                                <svg class="w-24 h-24 text-brand-300" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                            </div>
                        @endif
                        @if($item->title || $item->caption)
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 p-6 pointer-events-none z-20">
                            @if($item->title)<h3 class="text-white font-bold text-xl">{{ $item->title }}</h3>@endif
                            @if($item->caption)<p class="text-white/80 text-sm mt-1">{{ $item->caption }}</p>@endif
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
                @if($projectsCarousel->count() > 1)
                <button @click="prev()" class="absolute left-3 top-1/2 -translate-y-1/2 z-10 bg-white/80 hover:bg-white rounded-full p-2 shadow transition">
                    <svg class="w-5 h-5 text-brand-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button @click="next()" class="absolute right-3 top-1/2 -translate-y-1/2 z-10 bg-white/80 hover:bg-white rounded-full p-2 shadow transition">
                    <svg class="w-5 h-5 text-brand-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </button>
                <div class="flex justify-center gap-2 mt-4">
                    @foreach($projectsCarousel as $i => $item)
                    <button @click="current = {{ $i }}" :class="current === {{ $i }} ? 'bg-brand-700 w-6' : 'bg-slate-300 w-2'" class="h-2 rounded-full transition-all"></button>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </section>
    @endif


</x-app-layout>
