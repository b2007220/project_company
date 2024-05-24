<div class="col bg-gray-200">
    <div class="d-flex flex-column mt-8">
        <div class="py-2 -my-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
            <div
                class="d-inline-block min-w-100 overflow-hidden align-items-middle border border-gray-200 shadow rounded bg-white border rounded">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="p-3">Quản lý sản phẩm</h4>
                    <button
                        class="p-2 m-3 border rounded-pill bg-blue-300 text-white d-flex align-items-center justify-content-center gap-1 text-decoration-none"
                        data-bs-toggle="modal" data-bs-target="#addProductModal" data-mode="create">
                        Thêm mới
                        <svg class="w-6 h-6 text-gray-800 text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                            viewBox="0 0 24 24">
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
                                Giá tiền
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
                            <tr data-bs-toggle="collapse" data-bs-target=".{{ $product->id }}">

                                <td
                                    class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm">
                                    <div
                                        class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                                        {{ $product->name }}
                                    </div>
                                </td>

                                <td
                                    class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm leading-5 text-gray-500">
                                    {{ $product->description }}
                                </td>

                                <td
                                    class="px-6 py-4 text-sm leading-5 text-gray-500 whitespace-no-wrap border-bottom border-gray-200">
                                    <div
                                        class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                                        @foreach ($product->categories as $category)
                                            <{{ $category->name }} @endforeach
                                    </div>

                                </td>
                                <td
                                    class="px-6 py-4 text-sm font-medium leading-5 text-right whitespace-no-wrap border-bottom border-gray-200">
                                    <div
                                        class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                                        {{ $product->price }}
                                    </div>

                                </td>
                                <td
                                    class="px-6 py-4 text-sm font-medium leading-5 text-right whitespace-no-wrap border-bottom border-gray-200">
                                    <div
                                        class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                                        {{ $product->amoun }}
                                    </div>


                                </td>
                                <td
                                    class="px-6 py-4 text-sm leading-5 text-gray-500 whitespace-no-wrap border-bottom border-gray-200 d-flex justify-content-center align-items-center gap-2">
                                    <form action="{{ route('admin.product.delete', $product) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-decoration-none p-2 border rounded-pill bg-red-400 text-white d-flex align-items-center justify-content-center gap-1">
                                            Xóa
                                            <svg class="w-6 h-6 text-gray-800 text-white" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                            </svg>
                                        </button>
                                    </form>
                                    <button
                                        class="p-2 border rounded-pill bg-yellow-400 text-white d-flex align-items-center justify-content-center gap-1"
                                        data-bs-toggle="modal" data-bs-target="#addProductModal" data-mode="edit"
                                        data-discount="{{ json_encode($product) }}">
                                        Chỉnh sửa
                                        <svg class="w-6 h-6 text-gray-800 text-white" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>
                                    </button>

                                </td>
                            </tr>
                            <tr class="{{ $product->id }} collapse">
                                <td colspan="7">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h4 class="p-3">Giảm giá của sản phẩm</h4>
                                        <button
                                            class="p-2 m-3 border rounded-pill bg-blue-300 text-white d-flex align-items-center justify-content-center gap-1"
                                            data-bs-toggle="modal" data-bs-target="#addProductDiscountModal">
                                            Thêm mới
                                            <svg class="w-6 h-6 text-gray-800 text-white" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                            </svg>
                                        </button>
                                    </div>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="px-6 py-3 text-xs fw-bolder  text-gray-500 text-uppercase border-top border-bottomottom border-gray-200 bg-gray-50  text-center">
                                                    ID loại giảm giá
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
                                                    Thao tác
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td
                                                    class="px-6 py-4 text-sm leading-5 text-gray-500 whitespace-no-wrap border-bottom border-gray-200 text-center">
                                                    145
                                                </td>
                                                <td
                                                    class="px-6 py-4 text-sm leading-5 text-gray-500 whitespace-no-wrap border-bottom border-gray-200 text-center">
                                                    Giảm giá mùa hè
                                                </td>
                                                <td
                                                    class="px-6 py-4 text-sm leading-5 text-gray-500 whitespace-no-wrap border-bottom border-gray-200 text-center">
                                                    15
                                                </td>
                                                <td
                                                    class="px-6 py-4 text-sm leading-5 text-gray-500 whitespace-no-wrap border-bottom border-gray-200 d-flex justify-content-center align-items-center gap-2">
                                                    <button
                                                        class="p-2 border rounded-pill bg-red-400 text-white d-flex align-items-center justify-content-center gap-1">
                                                        Xóa
                                                        <svg class="w-6 h-6 text-gray-800 text-white"
                                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                            width="24" height="24" fill="none"
                                                            viewBox="0 0 24 24">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                        </svg>
                                                    </button>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td
                                                    class="px-6 py-4 text-sm leading-5 text-gray-500 whitespace-no-wrap border-bottom border-gray-200">
                                                    145
                                                </td>
                                                <td
                                                    class="px-6 py-4 text-sm leading-5 text-gray-500 whitespace-no-wrap border-bottom border-gray-200">
                                                    Giảm giá mùa hè
                                                </td>
                                                <td
                                                    class="px-6 py-4 text-sm leading-5 text-gray-500 whitespace-no-wrap border-bottom border-gray-200">
                                                    15
                                                </td>
                                                <td
                                                    class="px-6 py-4 text-sm leading-5 text-gray-500 whitespace-no-wrap border-bottom border-gray-200 d-flex justify-content-start align-items-center gap-2">
                                                    <button
                                                        class="p-2 border rounded-pill bg-red-400 text-white d-flex align-items-center justify-content-center gap-1">
                                                        Xóa
                                                        <svg class="w-6 h-6 text-gray-800 text-white"
                                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                            width="24" height="24" fill="none"
                                                            viewBox="0 0 24 24">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                        </svg>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
