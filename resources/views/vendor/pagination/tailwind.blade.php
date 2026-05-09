@if ($paginator->hasPages())
<nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex flex-col sm:flex-row items-center justify-between gap-3 mt-5">

    {{-- Result count --}}
    <p class="text-sm text-slate-500">
        @if ($paginator->firstItem())
            Showing <span class="font-semibold text-slate-700">{{ $paginator->firstItem() }}</span>–<span class="font-semibold text-slate-700">{{ $paginator->lastItem() }}</span>
            of <span class="font-semibold text-slate-700">{{ $paginator->total() }}</span> results
        @else
            {{ $paginator->count() }} results
        @endif
    </p>

    {{-- Page buttons --}}
    <div class="inline-flex items-center gap-1">

        {{-- Prev --}}
        @if ($paginator->onFirstPage())
            <span class="inline-flex items-center justify-center w-9 h-9 rounded-lg border border-slate-200 text-slate-300 cursor-not-allowed bg-white">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center justify-center w-9 h-9 rounded-lg border border-slate-200 text-slate-600 bg-white hover:bg-brand-50 hover:border-brand-300 hover:text-brand-700 transition">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
            </a>
        @endif

        {{-- Page numbers --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="inline-flex items-center justify-center w-9 h-9 text-sm text-slate-400">{{ $element }}</span>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span aria-current="page" class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-brand-700 text-white text-sm font-semibold border border-brand-700 shadow-sm">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="inline-flex items-center justify-center w-9 h-9 rounded-lg border border-slate-200 text-slate-600 bg-white text-sm hover:bg-brand-50 hover:border-brand-300 hover:text-brand-700 transition">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center justify-center w-9 h-9 rounded-lg border border-slate-200 text-slate-600 bg-white hover:bg-brand-50 hover:border-brand-300 hover:text-brand-700 transition">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
            </a>
        @else
            <span class="inline-flex items-center justify-center w-9 h-9 rounded-lg border border-slate-200 text-slate-300 cursor-not-allowed bg-white">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
            </span>
        @endif

    </div>
</nav>
@endif
