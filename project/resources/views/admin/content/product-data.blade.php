<table class="min-w-100">
    <thead>
        <tr>
            <th
                class="px-6 py-3 text-xs fw-bolder  text-gray-500 text-uppercase border-top border-bottom border-gray-200 bg-gray-50 text-center">
                Tên sản phẩm
            </th>
            <th
                class="px-6 py-3 text-xs fw-bolder  text-gray-500 text-uppercase border-top border-bottom border-gray-200 bg-gray-50 text-center">
                Mô tả sản phẩm
            </th>
            <th
                class="px-6 py-3 text-xs fw-bolder  text-gray-500 text-uppercase border-top border-bottom border-gray-200 bg-gray-50 text-center">
                Loại sản phẩm
            </th>
            <th
                class="px-6 py-3 text-xs fw-bolder  text-gray-500 text-uppercase border-top border-bottom border-gray-200 bg-gray-50 text-center">
                Giá gốc
            </th>
            <th
                class="px-6 py-3 text-xs fw-bolder  text-gray-500 text-uppercase border-top border-bottom border-gray-200 bg-gray-50 text-center">
                Giá đã áp dụng giảm giá
            </th>
            <th
                class="px-6 py-3 text-xs fw-bolder  text-gray-500 text-uppercase border-top border-bottom border-gray-200 bg-gray-50 text-center">
                Số lượng
            </th>
            <th
                class="px-6 py-3 text-xs fw-bolder  text-gray-500 text-uppercase border-top border-bottom border-gray-200 bg-gray-50 text-center">
                Thao tác
            </th>
        </tr>
    </thead>

    <tbody class="bg-white">
        @foreach ($products as $product)
            <tr data-bs-toggle="collapse" data-bs-target=".detail-{{ $product->id }}"
                data-product-id="{{ $product->id }}">
                <td class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm">
                    <div
                        class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                        {{ $product->name }}
                    </div>
                </td>
                <td
                    class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm leading-5 text-gray-500 ">

                    <div
                        class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                        {{ $product->description }}
                    </div>
                </td>

                <td class="px-6 py-4 text-sm leading-5 text-gray-500 whitespace-no-wrap border-bottom border-gray-200">
                    <div
                        class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center flex-column">

                        @foreach ($product->categories as $category)
                            <span> {{ $category->name }}</span>
                        @endforeach
                    </div>

                </td>
                <td
                    class="px-6 py-4 text-sm font-medium leading-5 text-right whitespace-no-wrap border-bottom border-gray-200">
                    <div
                        class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">

                        {{ number_format($product->price, 0, ',', '.') }} đ
                    </div>

                </td>
                <td
                    class="px-6 py-4 text-sm font-medium leading-5 text-right whitespace-no-wrap border-bottom border-gray-200">
                    <div
                        class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center product-price">
                        @php
                            $total_discount = 0;
                            if ($product->discounts->count() > 0) {
                                foreach ($product->discounts as $discount) {
                                    if ($discount->pivot->is_predefined) {
                                        $total_discount += $discount->discount;
                                    }
                                }
                            }
                        @endphp
                        @if ($product->discounts->count() > 0)
                            {{ number_format($product->price - ($product->price * $total_discount) / 100, 0, ',', '.') }}
                            đ
                        @else
                            {{ number_format($product->price, 0, ',', '.') }} đ
                        @endif
                    </div>

                </td>
                <td
                    class="px-6 py-4 text-sm font-medium leading-5 text-right whitespace-no-wrap border-bottom border-gray-200">
                    <div
                        class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                        {{ number_format($product->amount, 0, ',', '.') }}
                    </div>
                </td>
                <td class="px-6 py-4 text-sm leading-5 text-gray-500 whitespace-no-wrap border-bottom border-gray-200 ">
                    <div class="d-flex justify-content-center align-items-center gap-2">
                        <form action="javascript:void(0)" enctype="multipart/form-data"
                            onsubmit="confirmation(event, {{ $product->id }})">
                            <button type="submit"
                                class="text-decoration-none p-2 border rounded-pill fw-bolder bg-red-400 text-white d-flex align-items-center justify-content-center gap-1">
                                Xóa
                                <svg class="w-6 h-6  text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </button>
                        </form>
                        <button type="button"
                            class="text-decoration-none p-2 border rounded-pill fw-bolder bg-yellow-400 text-white d-flex align-items-center justify-content-center gap-1"
                            data-bs-toggle="modal" data-bs-target="#addProductModal" data-mode="edit"
                            data-product="{{ json_encode($product) }}">
                            Chỉnh sửa
                            <svg class="w-6 h-6  text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </button>
                    </div>
                </td>
            </tr>
            <tr class="detail-{{ $product->id }} collapse">
                <td colspan="7">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="p-3">Hình ảnh của sản phẩm</h5>
                        <button type="submit" form="deletePictureForm"
                            class="p-2 m-3 border rounded-pill bg-red-400 text-white d-flex align-items-center justify-content-center gap-1">
                            Xóa ảnh
                            <svg class="w-6 h-6  text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </button>
                    </div>
                    <form action="javascript:void(0)" enctype="multipart/form-data" id="deletePictureForm"
                        onsubmit="deleteImages(event,{{ $product->id }})">
                        <input type="hidden" name="selected_pictures" id="selected_pictures">
                        <div class="d-flex align-items-center px-6 gap-6 flex-column-max-lg" id="pictures-container">
                            @php
                                $chunkedProducts = $product->pictures->chunk(4);
                            @endphp
                            <div id="similarProduct-{{ $product->id }}"
                                class="carousel carousel-dark slide w-100 max-w-1516" data-bs-ride="false">
                                <div class="carousel-inner">
                                    @foreach ($chunkedProducts as $index => $chunk)
                                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                            <div class="card-group justify-content-evenly">
                                                @foreach ($chunk as $picture)
                                                    <div class="border rounded border-gray-300 picture-item"
                                                        data-id="{{ $picture->id }}">
                                                        <img class="img-fluid custom-img rounded"
                                                            src="{{ asset('product/' . $picture->link) }}"
                                                            alt="">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                    @if ($chunkedProducts->count() > 1)
                                        <button class="carousel-control-prev z-2 justify-content-start" type="button"
                                            data-bs-target="#similarProduct-{{ $product->id }}" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        </button>
                                        <button class="carousel-control-next z-2 justify-content-end" type="button"
                                            data-bs-target="#similarProduct-{{ $product->id }}"
                                            data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="p-3 ">Giảm giá của sản phẩm</h5>
                        <button
                            class="p-2 m-3 border rounded-pill bg-blue-300 text-white d-flex align-items-center justify-content-center gap-1"
                            data-bs-toggle="modal" data-bs-target="#addProductDiscountModal"
                            data-product="{{ json_encode($product) }}">
                            Thêm mới
                            <svg class="w-6 h-6  text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </button>
                    </div>
                    <table class="w-100" id="discount-table">
                        <thead>
                            <tr>
                                <th
                                    class="px-6 py-3 text-xs fw-bolder  text-gray-500 text-uppercase border-top border-bottom border-gray-200 bg-gray-50  text-center">
                                    Code giảm giá
                                </th>
                                <th
                                    class="px-6 py-3 text-xs fw-bolder  text-gray-500 text-uppercase border-top border-bottom border-gray-200 bg-gray-50 text-center">
                                    Tên giảm giá
                                </th>
                                <th
                                    class="px-6 py-3 text-xs fw-bolder  text-gray-500 text-uppercase border-top border-bottom border-gray-200 bg-gray-50 text-center">
                                    Phần trăm giảm giá
                                </th>
                                <th
                                    class="px-6 py-3 text-xs fw-bolder  text-gray-500 text-uppercase border-top border-bottom border-gray-200 bg-gray-50 text-center">
                                    Số lượng giảm giá
                                </th>
                                <th
                                    class="px-6 py-3 text-xs fw-bolder  text-gray-500 text-uppercase border-top border-bottom border-gray-200 bg-gray-50 text-center">
                                    Ngày hết hạn
                                </th>
                                <th
                                    class="px-6 py-3 text-xs fw-bolder  text-gray-500 text-uppercase border-top border-bottom border-gray-200 bg-gray-50 text-center">
                                    Đang áp dụng
                                </th>
                                <th
                                    class="px-6 py-3 text-xs fw-bolder  text-gray-500 text-uppercase border-top border-bottom border-gray-200 bg-gray-50 text-center">
                                    Thao tác
                                </th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($product->discounts as $discount)
                                <tr data-pivot-id="{{ $discount->pivot->id }}">
                                    <td
                                        class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm leading-5 text-gray-500 ">
                                        <div
                                            class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">

                                            {{ $discount->code }}
                                        </div>
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm leading-5 text-gray-500 ">
                                        <div
                                            class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">

                                            {{ $discount->name }}
                                        </div>

                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm leading-5 text-gray-500 ">
                                        <div
                                            class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">

                                            {{ $discount->discount }}
                                        </div>

                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm leading-5 text-gray-500 ">
                                        <div
                                            class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">

                                            {{ number_format($discount->amount, 0, ',', '.') }}</div>
                                        </div>


                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm leading-5 text-gray-500 ">
                                        <div
                                            class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                                            {{ date('d-m-Y', strtotime($discount->expired_at)) }}
                                        </div>

                                    </td>

                                    <td
                                        class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm leading-5 text-gray-500 ">
                                        <div
                                            class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                                            @if ($discount->pivot->is_predefined)
                                                <span class="text-success">Áp dụng trực tiếp</span>
                                            @else
                                                <span class="text-danger">Chưa áp dụng</span>
                                            @endif
                                        </div>

                                    </td>
                                    <td
                                        class="px-6 py-4 text-sm leading-5 text-gray-500 whitespace-no-wrap border-bottom border-gray-200 d">
                                        <div class="d-flex justify-content-center align-items-center gap-2">
                                            <form action="javascript:void(0)" enctype="multipart/form-data"
                                                id="removeDiscountForm-{{ $discount->pivot->id }}"
                                                onsubmit="removeDiscount(event,{{ $product->id }}, {{ $discount->id }},{{ $discount->pivot->id }})">
                                                <button type="submit"
                                                    form="removeDiscountForm-{{ $discount->pivot->id }}"
                                                    class="text-decoration-none p-2 border rounded-pill fw-bolder bg-red-400 text-white d-flex align-items-center justify-content-center gap-1">
                                                    Xóa
                                                    <svg class="w-6 h-6  text-white" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                    </svg>
                                                </button>
                                            </form>
                                            <form action="javascript:void(0)" enctype="multipart/form-data"
                                                id="applyDiscountForm-{{ $discount->pivot->id }}"
                                                onsubmit="apply(event,{{ $product->id }}, {{ $discount->id }},{{ $discount->pivot->id }})">

                                                <button type="submit"
                                                    form="applyDiscountForm-{{ $discount->pivot->id }}"
                                                    class=" p-2 border rounded-pill bg-green-300 text-white d-flex align-items-center justify-content-center gap-1">
                                                    Áp dụng
                                                    <svg class="w-6 h-6  text-white" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
{{ $products->links() }}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectedPictures = new Set();

        document.querySelectorAll('.picture-item').forEach(item => {
            item.addEventListener('click', function() {
                const pictureId = this.getAttribute('data-id');
                if (selectedPictures.has(pictureId)) {
                    selectedPictures.delete(pictureId);
                    this.classList.remove('selected');
                } else {
                    selectedPictures.add(pictureId);
                    this.classList.add('selected');
                }
                console.log(Array.from(selectedPictures));
            });
        });

        document.querySelector('#deletePictureForm').addEventListener('submit', function(event) {
            const inputHidden = document.getElementById('selected_pictures');
            inputHidden.value = JSON.stringify(Array.from(selectedPictures));
            console.log(inputHidden.value);
        });
    });
</script>
