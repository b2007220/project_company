@if ($paginator->hasPages())
    <div aria-label="Page navigation" class="d-flex justify-content-end p-2">
        <ul class="d-flex align-items-center -space-x-px h-10 fw-normal">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span
                        class="page-link d-flex align-items-center justify-content-center px-4 h-10 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-start hover:bg-gray-100 hover:text-gray-700"
                        aria-hidden="true">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 1 1 5l4 4" />
                        </svg>
                    </span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link d-flex align-items-center justify-content-center px-4 h-10 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-start hover:bg-gray-100 hover:text-gray-700"
                        href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')"><svg
                            class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 1 1 5l4 4" />
                        </svg></a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active d-flex align-items-center justify-content-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 text-decoration-none"
                                aria-current="page"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li
                                class="page-item d-flex align-items-center justify-content-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 text-decoration-none">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link d-flex align-items-center justify-content-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 rounded-end hover:bg-gray-100 hover:text-gray-700"
                        href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')"><svg
                            class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg></a>
                </li>
            @else
                <li class="page-item disabled d-flex align-items-center justify-content-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 rounded-end hover:bg-gray-100 hover:text-gray-700"
                    aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link" aria-hidden="true"><svg class="w-3 h-3" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg></span>
                </li>
            @endif
        </ul>
        <div @endif
