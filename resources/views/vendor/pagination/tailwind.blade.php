{{-- resources/views/vendor/pagination/tailwind.blade.php --}}
@if ($paginator->hasPages())
<nav role="navigation" aria-label="{{ __('Pagination Navigation') }}"
     class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-10 px-1 select-none">

    {{-- ── Result count ── --}}
    <div class="text-sm text-gray-400 font-medium whitespace-nowrap">
        {!! __('Showing') !!}
        @if ($paginator->firstItem())
            <span class="font-black text-gray-700">{{ $paginator->firstItem() }}</span>
            –
            <span class="font-black text-gray-700">{{ $paginator->lastItem() }}</span>
        @else
            {{ $paginator->count() }}
        @endif
        {!! __('of') !!}
        <span class="font-black text-gray-700">{{ $paginator->total() }}</span>
        {!! __('results') !!}
    </div>

    {{-- ── Page buttons ── --}}
    <div class="flex items-center gap-1.5">

        {{-- Previous --}}
        @if ($paginator->onFirstPage())
        <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl border border-gray-100 bg-gray-50 text-gray-300 cursor-not-allowed text-sm">
            <i class="fas fa-chevron-left text-xs"></i>
        </span>
        @else
        <a href="{{ $paginator->previousPageUrl() }}"
           rel="prev"
           class="inline-flex items-center justify-center w-10 h-10 rounded-xl border border-gray-200 bg-white text-gray-500 hover:bg-orange-50 hover:border-orange-300 hover:text-orange-600 transition shadow-sm text-sm font-bold"
           aria-label="{{ __('pagination.previous') }}">
            <i class="fas fa-chevron-left text-xs"></i>
        </a>
        @endif

        {{-- Page numbers --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" separator --}}
            @if (is_string($element))
            <span class="inline-flex items-center justify-center w-10 h-10 text-gray-300 text-sm font-black tracking-widest pb-1">
                ···
            </span>
            @endif

            {{-- Array of links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                    <span aria-current="page"
                          class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-orange-500 text-white text-sm font-black shadow-md shadow-orange-200 border border-orange-500">
                        {{ $page }}
                    </span>
                    @else
                    <a href="{{ $url }}"
                       class="inline-flex items-center justify-center w-10 h-10 rounded-xl border border-gray-200 bg-white text-gray-600 hover:bg-orange-50 hover:border-orange-300 hover:text-orange-600 transition text-sm font-bold shadow-sm"
                       aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                        {{ $page }}
                    </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}"
           rel="next"
           class="inline-flex items-center justify-center w-10 h-10 rounded-xl border border-gray-200 bg-white text-gray-500 hover:bg-orange-50 hover:border-orange-300 hover:text-orange-600 transition shadow-sm text-sm font-bold"
           aria-label="{{ __('pagination.next') }}">
            <i class="fas fa-chevron-right text-xs"></i>
        </a>
        @else
        <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl border border-gray-100 bg-gray-50 text-gray-300 cursor-not-allowed text-sm">
            <i class="fas fa-chevron-right text-xs"></i>
        </span>
        @endif

    </div>
</nav>
@endif