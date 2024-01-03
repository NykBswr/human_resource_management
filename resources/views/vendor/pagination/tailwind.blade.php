@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between">
        <div class="flex flex-1 justify-between sm:hidden">
            @if ($paginator->onFirstPage())
                <span
                    class="relative inline-flex cursor-default items-center rounded-md border border-dark bg-dark px-4 py-2 text-sm font-medium leading-5 text-white hover:bg-white hover:text-dark">
                    {!! __('pagination.previous') !!}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                    class="active:gradcolor relative inline-flex items-center rounded-md border border-dark bg-dark px-4 py-2 text-sm font-medium leading-5 text-white ring-gray-300 transition duration-150 ease-in-out hover:bg-white hover:text-dark hover:text-dark focus:border-dark focus:outline-none">
                    {!! __('pagination.previous') !!}
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                    class="active:gradcolor relative ml-3 inline-flex items-center rounded-md border border-dark bg-dark px-4 py-2 text-sm font-medium leading-5 text-white ring-gray-300 transition duration-150 ease-in-out hover:bg-white hover:text-dark hover:text-dark focus:border-dark focus:outline-none">
                    {!! __('pagination.next') !!}
                </a>
            @else
                <span
                    class="relative ml-3 inline-flex cursor-default items-center rounded-md border border-dark bg-dark px-4 py-2 text-sm font-medium leading-5 text-white hover:bg-white hover:text-dark">
                    {!! __('pagination.next') !!}
                </span>
            @endif
        </div>

        <div class="sm:flex sm:flex-1 sm:items-center sm:justify-between lg:justify-normal">
            <div>
                <span class="relative z-0 inline-flex rounded-md shadow-sm">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                            <span
                                class="gradcolor relative inline-flex cursor-default items-center rounded-l-md border border-white px-2 py-2 text-sm font-medium leading-5 text-white"
                                aria-hidden="true">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                            class="gradcolor active:gradcolor relative inline-flex items-center rounded-l-md border border-white px-2 py-2 text-sm font-medium leading-5 text-white ring-gray-300 transition duration-150 ease-in-out hover:text-pink-300 focus:z-10 focus:border-dark focus:outline-none"
                            aria-label="{{ __('pagination.previous') }}">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @php
                        $startPage = max(1, $paginator->currentPage() - 2);
                        $endPage = min($paginator->lastPage(), $startPage + 4);
                    @endphp

                    @for ($i = $startPage; $i <= $endPage; $i++)
                        @if ($i == $paginator->currentPage())
                            <span aria-current="page">
                                <span
                                    class="relative -ml-px inline-flex cursor-default items-center border border-white bg-dark px-4 py-2 text-sm font-medium leading-5 text-white hover:bg-white hover:text-dark">{{ $i }}</span>
                            </span>
                        @else
                            <a href="{{ $paginator->url($i) }}"
                                class="active:gradcolor relative -ml-px inline-flex items-center border border-white bg-dark px-4 py-2 text-sm font-medium leading-5 text-white ring-gray-300 transition duration-150 ease-in-out hover:bg-white hover:text-dark focus:z-10 focus:border-dark focus:outline-none"
                                aria-label="{{ __('Go to page :page', ['page' => $i]) }}">
                                {{ $i }}
                            </a>
                        @endif
                    @endfor

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                            class="gradcolor active:gradcolor relative -ml-px inline-flex items-center rounded-r-md border border-white px-2 py-2 text-sm font-medium leading-5 text-white ring-gray-300 transition duration-150 ease-in-out hover:text-pink-300 focus:z-10 focus:border-dark focus:outline-none"
                            aria-label="{{ __('pagination.next') }}">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                            <span
                                class="gradcolor relative -ml-px inline-flex cursor-default items-center rounded-r-md border border-white px-2 py-2 text-sm font-medium leading-5 text-white"
                                aria-hidden="true">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    @endif
                </span>
            </div>

        </div>
    </nav>
@endif
