<div class="container-fluid d-flex flex-lg-row flex-column justify-content-center align-items-stretch">
    <div
        class="position-relative d-flex overflow-hidden justify-content-center bg-gray-100 gap-4 py-4 rounded flex-column align-items-center max-w-3xl">

        <div id="carouselExampleIndicators" class="carousel carousel-dark slide relative max-w-3xl"
            data-bs-ride="carousel">
            <div class="carousel-inner overflow-hidden h-md-96 position-relative">
                @foreach ($product->pictures as $picture)
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }} overflow-hidden h-md-96">
                        <img src="{{ asset('product/' . $picture->link) }}" class="d-block max-w-full h-auto rounded"
                            alt="" />
                    </div>
                @endforeach
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
            </button>

            <ol class="carousel-indicators">
                @foreach ($product->pictures as $picture)
                    <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{ $loop->index }}"
                        class="{{ $loop->first ? 'active' : '' }}" aria-current="{{ $loop->first }}"
                        aria-label="Slide {{ $loop->index + 1 }}">
                        <img src="{{ asset('product/' . $picture->link) }}" alt="" class="border rounded" />
                    </li>
                @endforeach
            </ol>
        </div>

    </div>
    <div class="position-relative border border-2 rounded max-w-xl  d-flex d-inline-flex w-100 h-auto m-3 p-4">
        <form id="addToCart" class="w-100" action="javascript:void(0)">
            <div class="flex flex-column" name="product-id">
                <h1 class="mb-4 fs-3 fw-bold leading-none tracking-tight text-gray-900 text-md-2xl text-lg-3xl"
                    name="product-name">
                    {{ $product->name }}
                </h1>
                <p class="mb-4 fs-6 fw-normal text-gray-500 text-lg-sm" name="product-describe">
                    {{ $product->description }}
                </p>
                @if ($product->discounts->isNotEmpty())
                    @php
                        $discount = $product->discounts->first();
                        $productDiscount = $discount->discount;
                        $priceWithDiscount = $product->price - ($product->price * $productDiscount) / 100;
                    @endphp
                    <span class="text-gray-900 text-lg">Giá tiền:<s> {{ number_format($product->price, 0, ',', '.') }}
                            đ</s><strong>
                            {{ number_format($priceWithDiscount, 0, ',', '.') }}
                            đ</strong></span>
                @else
                    <strong class="fw-semibold text-gray-900 text-lg">Giá tiền:
                        {{ number_format($product->price, 0, ',', '.') }}
                        đ</strong>
                @endif
                <div class="d-flex gap-6 mb-6 flex-column">
                    <div class="w-full">
                        <label for="number-input" class="block mb-2 text-xl font-medium text-gray-900">Số lượng:</label>
                        <div class="position-relative d-flex align-items-center max-w-50">
                            <button type="button" id="decrement-button" data-input-counter-decrement="quantity-input"
                                class="bg-gray-100 hover:bg-gray-200 border border-gray-300 rounded-start p-3 h-11 focus:ring-gray-100 focus:ring-2 focus:outline-none d-flex align-items-center justify-content-center">
                                <svg class="w-3 h-3 text-gray-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 18 2">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M1 1h16" />
                                </svg>
                            </button>
                            <input type="text" id="quantity-input" data-input-counter
                                aria-describedby="helper-text-explanation"
                                class="bg-gray-50 border-0 border-top border-bottom border-gray-300 h-11 text-center text-gray-900 fs-5 focus:ring-blue-500 focus:border-blue-500 d-block w-100 py-25"
                                value="1" min="1" required name="amount" />
                            <button type="button" id="increment-button" data-input-counter-increment="quantity-input"
                                class="bg-gray-100 hover:bg-gray-200 border border-gray-300 rounded-end p-3 h-11 focus:ring-gray-100 focus:ring-2 focus:outline-none d-flex align-items-center justify-content-center">
                                <svg class="w-3 h-3 text-gray-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 18 18">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M9 1v16M1 9h16" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center align-items-center">
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit" form="addToCart"
                            class="text-dark text-uppercase bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 fw-bold rounded-pill fs-5 px-5 py-25 me-2 mb-2">
                            thêm vào giỏ hàng
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="container d-flex flex-column justify-content-center overflow-hidden py-3 bg-gray-10">
    <h2 class="fw-bold text-gray-900 d-flex justify-content-center">
        Sản phẩm tương tự khác
    </h2>
    <hr class="h-px my-3 bg-gray-200" />
    <div id="similarProduct" class="carousel carousel-dark slide" data-bs-ride="false">
        <div class="carousel-inner">
            @php
                $chunkedProducts = $products->chunk(3);
            @endphp

            @foreach ($chunkedProducts as $index => $chunk)
                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                    <div class="card-group justify-content-evenly">
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
            @if ($chunkedProducts->count() > 1)
                <button class="carousel-control-prev z-2 justify-content-start" type="button"
                    data-bs-target="#similarProduct" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next z-2 justify-content-end" type="button"
                    data-bs-target="#similarProduct" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </button>
            @endif
        </div>
    </div>

    <script>
        const decrementButton = document.getElementById("decrement-button");

        const incrementButton = document.getElementById("increment-button");

        const quantityInput = document.getElementById("quantity-input");

        decrementButton.addEventListener("click", () => {
            if (parseInt(quantityInput.value) > 1) {
                quantityInput.value = parseInt(quantityInput.value) - 1;
            }
        });

        incrementButton.addEventListener("click", () => {
            quantityInput.value = parseInt(quantityInput.value) + 1;
        });
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Content-Type': 'application/json'
                }
            });
            $('#addToCart').submit(function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                $.ajax({
                    url: '/cart/add',
                    type: 'POST',
                    data: JSON.stringify(Object.fromEntries(formData.entries())),
                    cache: false,
                    processData: false,
                    success: function(result) {
                        swal({
                            title: 'Thành công!',
                            text: result.message,
                            icon: 'success',
                            button: 'OK',
                            timer: 1000
                        });
                    },
                    error: function(xhr) {
                        const errors = xhr.responseJSON.errors;
                        if (errors) {
                            for (const [key, value] of Object.entries(errors)) {
                                console.log(key, value);
                            }
                        }
                    }
                });
            })


        })
    </script>
