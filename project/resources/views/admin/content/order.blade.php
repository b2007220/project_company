<div class="d-flex flex-column mt-8">
    <div class="py-2 -my-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
        <div
            class="d-inline-block min-w-100 overflow-hidden align-items-middle  border-gray-200 shadow  bg-white border rounded">
            <h4 class="p-3">Chi tiết đơn hàng</h4>
            <table class="min-w-100">
                <thead>
                    <tr>
                        <th
                            class="px-6 py-3 text-xs fw-bolder text-left text-gray-500 text-uppercase border-top border-bottomottom border-gray-200 bg-gray-50">
                            Tên khách hàng
                        </th>
                        <th
                            class="px-6 py-3 text-xs fw-bolder text-left text-gray-500 text-uppercase border-top border-bottomottom border-gray-200 bg-gray-50">
                            Địa chỉ giao hàng
                        </th>
                        <th
                            class="px-6 py-3 text-xs fw-bolder text-left text-gray-500 text-uppercase border-top border-bottomottom border-gray-200 bg-gray-50">
                            Trạng thái đơn hàng
                        </th>
                        <th
                            class="px-6 py-3 text-xs fw-bolder text-left text-gray-500 text-uppercase border-top border-bottomottom border-gray-200 bg-gray-50">
                            Tổng tiền
                        </th>
                        <th
                            class="px-6 py-3 text-xs fw-bolder text-left text-gray-500 text-uppercase border-top border-bottomottom border-gray-200 bg-gray-50">
                            Phương thức thanh toán
                        </th>
                        <th
                            class="px-6 py-3 text-xs fw-bolder text-left text-gray-500 text-uppercase border-top border-bottomottom border-gray-200 bg-gray-50">
                            Thao tác
                        </th>
                    </tr>
                </thead>

                <tbody class="bg-white">
                    @foreach ($orders as $order)
                        <tr data-bs-toggle="collapse" data-bs-target=".detail-{{ $order->id }}">

                            <td
                                class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm">
                                <div
                                    class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                                    {{ $order->user->name }}
                                </div>
                            </td>

                            <td
                                class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm">
                                <div
                                    class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                                    {{ $order->address }}
                                </div>
                            </td>
                            @switch($order->status)
                                @case('DELIVERING')
                                    <td
                                        class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm">
                                        <div
                                            class="ml-4 text-sm leading-5 font-medium d-flex justify-content-center align-items-center">
                                            <span class="bg-green-300 text-white p-2 fw-bolder border rounded">Đang giao</span>
                                        </div>
                                    </td>
                                @break

                                @case('DELIVERED')
                                    <td
                                        class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm">
                                        <div
                                            class="ml-4 text-sm leading-5 font-medium d-flex justify-content-center align-items-center">
                                            <span class="bg-blue-300 text-white p-2 fw-bolder border rounded">Đã giao</span>
                                        </div>
                                    </td>
                                @break

                                @case('CANCELLED')
                                    <td
                                        class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm">
                                        <div
                                            class="ml-4 text-sm leading-5 font-medium d-flex justify-content-center align-items-center">
                                            <span class="bg-red-400 text-white p-2 fw-bolder border rounded">Hủy đơn</span>
                                        </div>
                                    </td>
                                @break

                                @case('UNACCEPTED')
                                    <td
                                        class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm">
                                        <div
                                            class="ml-4 text-sm leading-5 font-medium d-flex justify-content-center align-items-center">
                                            <span class="bg-orange-300 text-white p-2 fw-bolder border rounded">Hủy đơn</span>
                                        </div>
                                    </td>
                                @break

                                @default
                                    <td
                                        class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm">
                                        <div
                                            class="ml-4 text-sm leading-5 font-medium d-flex justify-content-center align-items-center">
                                            <span class="bg-violet-600 text-white p-2 fw-bolder border rounded">Chờ duyệt</span>
                                        </div>
                                    </td>
                            @endswitch


                            <td
                                class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm">
                                <div
                                    class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                                    {{ number_format($order->total, 0, ',', '.') }} đ
                                </div>
                            </td>

                            <td
                                class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm">
                                <div
                                    class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                                    @if ($order->payment_type === 'CASH')
                                        Tiền mặt
                                    @else
                                        Chuyển khoản
                                    @endif
                                </div>
                            </td>
                            <td
                                class="text-decoration-none px-6 py-4 text-sm leading-5 text-gray-500 whitespace-no-wrap border-bottom border-gray-200 d-flex justify-content-center align-items-center gap-2">

                                <button
                                    class="p-2 m-3 border rounded-pill bg-blue-300 text-white d-flex align-items-center justify-content-center gap-1"
                                    data-bs-toggle="modal" data-bs-target="#updateOrderModal"
                                    data-order="{{ json_encode($order) }}">
                                    Điều chỉnh
                                    <svg class="w-6 h-6  text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        <tr class="detail-{{ $order->id }} collapse">
                            <td colspan="7">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th
                                                class="px-6 py-3 text-xs fw-bolder text-left text-gray-500 text-uppercase border-top border-bottomottom border-gray-200 bg-gray-50">
                                                ID sản phẩm
                                            </th>
                                            <th
                                                class="px-6 py-3 text-xs fw-bolder text-left text-gray-500 text-uppercase border-top border-bottomottom border-gray-200 bg-gray-50">
                                                sản phẩm
                                            </th>
                                            <th
                                                class="px-6 py-3 text-xs fw-bolder text-left text-gray-500 text-uppercase border-top border-bottomottom border-gray-200 bg-gray-50">
                                                Số lượng
                                            </th>
                                            <th
                                                class="px-6 py-3 text-xs fw-bolder text-left text-gray-500 text-uppercase border-top border-bottomottom border-gray-200 bg-gray-50">
                                                giá tiền
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->products as $product)
                                            <tr>

                                                <td
                                                    class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm leading-5 text-gray-500 ">
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
                                                        {{ number_format($product->pivot->quantity, 0, ',', '.') }}
                                                    </div>

                                                </td>
                                                <td
                                                    class="px-6 py-4 text-sm font-medium leading-5 text-right whitespace-no-wrap border-bottom border-gray-200">
                                                    <div
                                                        class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                                                        {{ number_format($product->pivot->price, 0, ',', '.') }} đ
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
            {{ $orders->links() }}
        </div>
    </div>
</div>
