<div
    class="px-0 col-sm-3 col-xl-4 position-relative d-flex flex-column shadow-md rounded-3 overflow-hidden shadow-lg-hover product-card max-w-sm max-h-304">

    <a href="{{ $productLink }}" class="z-2 position-absolute h-100 w-100 top-0 left-0 text-decoration-none">&nbsp;</a>
    <div class="h-auto overflow-hidden">
        <div class="h-44 overflow-hidden position-relative">
            <img src="{{ asset('product/' . $imageSrc) }}" alt="{{ $productName }}" class="max-w-full h-auto d-block" />
        </div>
    </div>
    <div class="bg-white py-2 px-3">
        <h3 class="text-xl mb-2 font-medium truncate ">
            {{ $productName }}
        </h3>
        <div class="d-flex justify-content-between align-items-center">
            <p class="text-md text-gray-400 min-h-56">
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
            <div class="position-relative z-3 d-flex align-items-center gap-2 justify-content-center">
                <a href="{{ $productLink }}"
                    class="text-white bg-red-700 fw-bold rounded-pill text-sm px-3 py-2 text-center  text-decoration-none h-36 min-w-108">
                    Xem thêm
                </a>
            </div>
        </div>
    </div>
</div>
