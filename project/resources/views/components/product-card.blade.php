<div
    class="px-0 col-sm-3 col-xl-4 position-relative d-flex flex-column shadow-md rounded-3 overflow-hidden shadow-lg-hover product-card max-w-sm">
    <a href="" class="position-absolute z-3 top-2 right-0 mt-2 me-3">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-6 h-6 text-orange-600">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
        </svg>
    </a>
    <a href="{{ $productLink }}" class="z-2 position-absolute h-100 w-100 top-0 left-0">&nbsp;</a>
    <div class="h-auto overflow-hidden">
        <div class="h-44 overflow-hidden position-relative">
            <img src="{{ asset('product/' . $imageSrc) }}" alt="{{ $productName }}"
                class="max-w-full h-auto d-block" />
        </div>
    </div>
    <div class="bg-white py-4 px-3">
        <h3 class="text-xl mb-2 font-medium truncate ">
            {{ $productName }}
        </h3>
        <div class="d-flex justify-content-between align-items-center">
            <p class="text-md text-gray-400">
                Giá tiền:
                @if ($productDiscount)
                    <span class="text-gray-900 text-lg"><s> {{ number_format($price, 0, ',', '.') }}
                            đ</s> <strong>
                            {{ number_format($price - ($price * $productDiscount) / 100, 0, ',', '.') }}
                            đ</strong></span>
                @else
                    <strong class="fw-semibold text-gray-900 text-lg"> {{ number_format($price, 0, ',', '.') }}
                        đ</strong>
                @endif


            </p>
            <div class="position-relative z-3 d-flex align-items-center gap-2">
                <a href="{{ $productLink }}"
                    class="text-white bg-red-700 fw-bold rounded-pill text-sm px-3 py-2 text-center me-2 mb-2 text-decoration-none">
                    Xem thêm
                </a>
            </div>
        </div>
    </div>
</div>
