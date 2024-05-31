@if ($paginator->hasPages())
    <nav class="d-flex justify-content-end p-2">
        <ul class="pagination d-flex align-items-center  h-10 fw-normal">
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link px-4 h-10" aria-hidden="true">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 1 1 5l4 4" />
                        </svg>
                    </span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link  px-4 h-10" href="{{ $paginator->previousPageUrl() }}" rel="prev"
                        aria-label="@lang('pagination.previous')">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 1 1 5l4 4" />
                        </svg>
                    </a>
                </li>
            @endif
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true"><span
                            class="page-link px-4 h-10">{{ $element }}</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page"><span
                                    class="page-link px-4 h-10">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link px-4 h-10"
                                    href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link px-4 h-10" href="{{ $paginator->nextPageUrl() }}" rel="next"
                        aria-label="@lang('pagination.next')"><svg class="w-3 h-3" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg></a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link px-4 h-10" aria-hidden="true">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                    </span>
                </li>
            @endif
        </ul>
    </nav>
    {{-- @php
        echo $paginator;
    @endphp --}}
@endif
