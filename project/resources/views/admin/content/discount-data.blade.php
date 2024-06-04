<table class="min-w-100">
    <thead>
        <tr>
            <th
                class="px-6 py-3 text-xs fw-bolder text-left text-gray-500 text-uppercase border-top border-bottomottom border-gray-200 bg-gray-50">
                Mã giảm giá
            </th>
            <th
                class="px-6 py-3 text-xs fw-bolder text-left text-gray-500 text-uppercase border-top border-bottomottom border-gray-200 bg-gray-50">
                Tên loại giảm giá
            </th>

            <th
                class="px-6 py-3 text-xs fw-bolder text-left text-gray-500 text-uppercase border-top border-bottomottom border-gray-200 bg-gray-50">
                Phần trăm giảm giá
            </th>
            <th
                class="px-6 py-3 text-xs fw-bolder text-left text-gray-500 text-uppercase border-top border-bottomottom border-gray-200 bg-gray-50">
                Số lượng còn lại
            </th>

            <th
                class="px-6 py-3 text-xs fw-bolder text-left text-gray-500 text-uppercase border-top border-bottomottom border-gray-200 bg-gray-50">
                Thời gian hết hạng
            </th>
            <th
                class="px-6 py-3 text-xs fw-bolder text-left text-gray-500 text-uppercase border-top border-bottomottom border-gray-200 bg-gray-50">
                Loại giảm giá
            </th>
            <th
                class="px-6 py-3 text-xs fw-bolder text-left text-gray-500 text-uppercase border-top border-bottomottom border-gray-200 bg-gray-50">
                Thao tác
            </th>
        </tr>
    </thead>
    <tbody class="bg-white">
        @foreach ($discounts as $discount)
            <tr data-discount-id="{{ $discount->id }}">
                <td class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm">
                    <div
                        class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                        {{ $discount->code }}
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm">
                    <div
                        class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                        {{ $discount->name }}
                    </div>
                </td>

                <td
                    class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm leading-5 text-gray-500">
                    <div
                        class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                        {{ $discount->discount }} %</div>

                </td>

                <td
                    class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm leading-5 text-gray-500">
                    <div
                        class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                        {{ number_format($discount->amount, 0, ',', '.') }}</div>

                </td>

                <td
                    class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm leading-5 text-gray-500">
                    <div
                        class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                        {{ date('d-m-Y', strtotime($discount->expired_at)) }}</div>


                </td>
                <td
                    class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm leading-5 text-gray-500">
                    <div
                        class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                        @if ($discount->type === 'PRODUCT')
                            Sản phẩm
                        @else
                            Đơn hàng
                        @endif
                    </div>
                </td>
                <td
                    class="text-decoration-none px-6 py-4 text-sm leading-5 text-gray-500 whitespace-no-wrap border-bottom border-gray-200 ">
                    <div class="d-flex justify-content-center align-items-center gap-2">
                        <form action="javascript:void(0)" enctype="multipart/form-data"
                            onsubmit="confirmation(event, {{ $discount->id }})">
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
                            data-bs-toggle="modal" data-bs-target="#addDiscountModal" data-mode="edit"
                            data-discount="{{ json_encode($discount) }}">
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
        @endforeach
    </tbody>
</table>
{{ $discounts->links() }}
