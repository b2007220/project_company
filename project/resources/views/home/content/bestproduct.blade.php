<div class="container d-flex flex-column justify-content-center overflow-hidden py-3 bg-gray-100">
    <div class="d-flex align-items-center gap-3">
        <h3 class="fw-bolder text-gray-900 pl-6 mb-0">Sản phẩm nổi bật</h3>
        <img src="online-shop.png" class="h-16 w-16" alt="Logo" />
    </div>
    <hr class="h-px my-3 bg-gray-200" />
    <div id="hotProduct" class="carousel carousel-dark slide" data-bs-ride="false">
        <div class="carousel-inner">
            @php
                $chunkedProducts = $topProducts->chunk(3);
            @endphp
            @foreach ($chunkedProducts as $index => $chunk)
                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                    <div class="card-group justify-content-evenly py-3">
                        @foreach ($chunk as $product)
                            <x-product-card :product-name="$product->name" :price="$product->price" :image-src="$product->pictures && $product->pictures->isNotEmpty()
                                ? $product->pictures[0]->link
                                : ''" :product-discount="$product->discounts && $product->discounts->isNotEmpty()
                                ? $product->discounts[0]->discount
                                : 0"
                                :product-link="route('product', $product->id)" />
                        @endforeach
                    </div>
                </div>
            @endforeach

        </div>
        @if ($chunkedProducts->count() > 1)
            <button class="carousel-control-prev z-2 justify-content-start" type="button" data-bs-target="#hotProduct"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            </button>
            <button class="carousel-control-next z-2 justify-content-end" type="button" data-bs-target="#hotProduct"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
            </button>
        @endif
    </div>
</div>
