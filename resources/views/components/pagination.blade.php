@if ($paginator->hasPages())
    <nav class="flex items-center justify-center gap-1">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="px-4 py-2 text-gray-500 bg-gray-200 border border-gray-300 rounded-md cursor-not-allowed" aria-disabled="true" aria-label="@lang('pagination.previous')">
                &laquo;
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="px-4 py-2 text-black bg-white border border-gray-300 rounded-md hover:bg-gray-100" rel="prev" aria-label="@lang('pagination.previous')">
                &laquo;
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($paginator->links()->elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="px-4 py-2 text-black bg-gray-200 border border-gray-300 rounded-md">
                    {{ $element }}
                </span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-4 py-2 text-white bg-blue-600 border border-blue-600 rounded-md">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" class="px-4 py-2 text-black bg-white border border-gray-300 rounded-md hover:bg-gray-100">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="px-4 py-2 text-black bg-white border border-gray-300 rounded-md hover:bg-gray-100" rel="next" aria-label="@lang('pagination.next')">
                &raquo;
            </a>
        @else
            <span class="px-4 py-2 text-gray-500 bg-gray-200 border border-gray-300 rounded-md cursor-not-allowed" aria-disabled="true" aria-label="@lang('pagination.next')">
                &raquo;
            </span>
        @endif
    </nav>
@endif
