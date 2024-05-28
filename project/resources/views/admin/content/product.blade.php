<div class="col bg-gray-200">
    <div class="d-flex flex-column mt-8">
        <div class="py-2 -my-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
            <div
                class="d-inline-block min-w-100 overflow-hidden align-items-middle border border-gray-200 shadow rounded bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="p-3">Quản lý sản phẩm</h4>
                    <button
                        class="p-2 m-3 border rounded-pill bg-blue-300 text-white d-flex align-items-center justify-content-center gap-1 text-decoration-none"
                        data-bs-toggle="modal" data-bs-target="#addProductModal" data-mode="create">
                        Thêm mới
                        <svg class="w-6 h-6  text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </button>
                </div>
                <table class="min-w-100">
                    <thead>
                        <tr>
                            <th
                                class="px-6 py-3 text-xs fw-bolder  text-gray-500 text-uppercase border-top border-bottomottom border-gray-200 bg-gray-50 text-center">
                                Tên sản phẩm
                            </th>
                            <th
                                class="px-6 py-3 text-xs fw-bolder  text-gray-500 text-uppercase border-top border-bottomottom border-gray-200 bg-gray-50 text-center">
                                Mô tả sản phẩm
                            </th>
                            <th
                                class="px-6 py-3 text-xs fw-bolder  text-gray-500 text-uppercase border-top border-bottomottom border-gray-200 bg-gray-50 text-center">
                                Loại sản phẩm
                            </th>
                            <th
                                class="px-6 py-3 text-xs fw-bolder  text-gray-500 text-uppercase border-top border-bottomottom border-gray-200 bg-gray-50 text-center">
                                Giá gốc
                            </th>
                            <th
                                class="px-6 py-3 text-xs fw-bolder  text-gray-500 text-uppercase border-top border-bottomottom border-gray-200 bg-gray-50 text-center">
                                Giá đã áp dụng giảm giá
                            </th>
                            <th
                                class="px-6 py-3 text-xs fw-bolder  text-gray-500 text-uppercase border-top border-bottomottom border-gray-200 bg-gray-50 text-center">
                                Số lượng
                            </th>
                            <th
                                class="px-6 py-3 text-xs fw-bolder  text-gray-500 text-uppercase border-top border-bottomottom border-gray-200 bg-gray-50 text-center">
                                Thao tác
                            </th>
                        </tr>
                    </thead>

                    <tbody class="bg-white">
                        @foreach ($products as $product)
                            <tr data-bs-toggle="collapse" data-bs-target=".detail-{{ $product->id }}">

                                <td
                                    class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm">
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

                                <td
                                    class="px-6 py-4 text-sm leading-5 text-gray-500 whitespace-no-wrap border-bottom border-gray-200">
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
                                        class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                                        @foreach ($product->discounts as $discount)
                                            @if ($discount->pivot->is_predefined)
                                                {{ number_format($product->price - ($product->price * $discount->discount) / 100, 0, ',', '.') }}
                                                đ
                                            @endif
                                        @endforeach
                                    </div>

                                </td>
                                <td
                                    class="px-6 py-4 text-sm font-medium leading-5 text-right whitespace-no-wrap border-bottom border-gray-200">
                                    <div
                                        class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                                        {{ number_format($product->amount, 0, ',', '.') }}
                                    </div>


                                </td>
                                <td
                                    class="px-6 py-4 text-sm leading-5 text-gray-500 whitespace-no-wrap border-bottom border-gray-200 d-flex justify-content-center align-items-center gap-2">
                                    <form action="{{ route('admin.product.delete', $product) }}" method="POST"
                                        onsubmit="return confirmation(event, this)">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-decoration-none p-2 border rounded-pill fw-bolder bg-red-400 text-white d-flex align-items-center justify-content-center gap-1">
                                            Xóa
                                            <svg class="w-6 h-6  text-white" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                            </svg>
                                        </button>
                                    </form>
                                    <button type="button"
                                        class="text-decoration-none p-2 border rounded-pill fw-bolder bg-yellow-400 text-white d-flex align-items-center justify-content-center gap-1"
                                        data-bs-toggle="modal" data-bs-target="#addProductModal" data-mode="edit"
                                        data-product="{{ json_encode($product) }}">
                                        Chỉnh sửa
                                        <svg class="w-6 h-6  text-white" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>
                                    </button>

                                </td>
                            </tr>
                            <tr class="detail-{{ $product->id }} collapse ">

                                <td colspan="12">
                                    <h5 class="p-3">Hình ảnh của sản phẩm</h5>
                                    <div
                                        class="d-flex align-items-center justify-content-center px-6 gap-4 flex-column-max-lg">
                                        @foreach ($product->pictures as $picture)
                                            <div class="col">
                                                <img class="img-fluid custom-img rounded "
                                                    src="{{ asset('product/' . $picture->link) }}" alt="">
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="p-3 ">Giảm giá của sản phẩm</h5>
                                        <button
                                            class="p-2 m-3 border rounded-pill bg-blue-300 text-white d-flex align-items-center justify-content-center gap-1"
                                            data-bs-toggle="modal" data-bs-target="#addProductDiscountModal"
                                            data-product="{{ json_encode($product) }}">
                                            Thêm mới
                                            <svg class="w-6 h-6  text-white" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                            </svg>
                                        </button>
                                    </div>
                                    <table class="w-100">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="px-6 py-3 text-xs fw-bolder  text-gray-500 text-uppercase border-top border-bottomottom border-gray-200 bg-gray-50  text-center">
                                                    Code giảm giá
                                                </th>
                                                <th
                                                    class="px-6 py-3 text-xs fw-bolder  text-gray-500 text-uppercase border-top border-bottomottom border-gray-200 bg-gray-50 text-center">
                                                    Tên giảm giá
                                                </th>
                                                <th
                                                    class="px-6 py-3 text-xs fw-bolder  text-gray-500 text-uppercase border-top border-bottomottom border-gray-200 bg-gray-50 text-center">
                                                    Phần trăm giảm giá
                                                </th>
                                                <th
                                                    class="px-6 py-3 text-xs fw-bolder  text-gray-500 text-uppercase border-top border-bottomottom border-gray-200 bg-gray-50 text-center">
                                                    Số lượng giảm giá
                                                </th>
                                                <th
                                                    class="px-6 py-3 text-xs fw-bolder  text-gray-500 text-uppercase border-top border-bottomottom border-gray-200 bg-gray-50 text-center">
                                                    Ngày hết hạn
                                                </th>
                                                <th
                                                    class="px-6 py-3 text-xs fw-bolder  text-gray-500 text-uppercase border-top border-bottomottom border-gray-200 bg-gray-50 text-center">
                                                    Đang áp dụng
                                                </th>
                                                <th
                                                    class="px-6 py-3 text-xs fw-bolder  text-gray-500 text-uppercase border-top border-bottomottom border-gray-200 bg-gray-50 text-center">
                                                    Thao tác
                                                </th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($product->discounts as $discount)
                                                <tr>

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

                                                            {{ $discount->amount }}
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
                                                        class="px-6 py-4 text-sm leading-5 text-gray-500 whitespace-no-wrap border-bottom border-gray-200 d-flex justify-content-center align-items-center gap-2">

                                                        <form
                                                            action="{{ route('admin.product.discount-remove', [$product->id, $discount->id]) }}"
                                                            method="POST"
                                                            onsubmit="return confirmation(event, this)">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="text-decoration-none p-2 border rounded-pill fw-bolder bg-red-400 text-white d-flex align-items-center justify-content-center gap-1">
                                                                Xóa
                                                                <svg class="w-6 h-6  text-white" aria-hidden="true"
                                                                    xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" fill="none"
                                                                    viewBox="0 0 24 24">
                                                                    <path stroke="currentColor" stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                                </svg>
                                                            </button>
                                                        </form>
                                                        <form
                                                            action="{{ route('admin.product.update-predefine', [$product->id, $discount->id]) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')

                                                            <button type="submit"
                                                                class=" p-2 border rounded-pill bg-green-300 text-white d-flex align-items-center justify-content-center gap-1">
                                                                Áp dụng
                                                                <svg class="w-6 h-6  text-white" aria-hidden="true"
                                                                    xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" fill="none"
                                                                    viewBox="0 0 24 24">
                                                                    <path stroke="currentColor" stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                                </svg>
                                                            </button>
                                                        </form>
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
                {{ $products->links()
                }}
            </div>
        </div>
    </div>
</div>
<script>
    function confirmation(event, form) {
        event.preventDefault();
        const url = form.action;
        swal({
            title: "Bạn có chắc chắn muốn xóa?",
            text: "Sau khi xóa, bạn sẽ không thể khôi phục dữ liệu!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                form.submit();
            }
        });
    }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
    integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
