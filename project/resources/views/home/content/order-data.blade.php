<table class="w-100 text-sm text-left text-gray-500">
    <thead class="text-xs text-gray-700 text-uppercase bg-gray-100">
        <tr>

            <th scope="col" class="fw-bold px-6 py-3">Ngày đặt</th>
            <th scope="col" class="fw-bold px-6 py-3">Ngày giao</th>
            <th scope="col" class="fw-bold px-6 py-3">
                Trạng thái đơn hàng
            </th>
            <th scope="col" class="fw-bold px-6 py-3">Giá tiền</th>
            <th scope="col" class="fw-bold px-6 py-3">
                Phương thức thanh toán
            </th>
            <th scope="col" class="fw-bold px-6 py-3">
                Xem chi tiết
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $order)
            <tr class="bg-white border hover:bg-gray-50">
                <td class="fw-bolder px-6 py-4"> {{ date('d-m-Y', strtotime($order->created_at)) }}
                </td>

                <td class="fw-bolder px-6 py-4">
                    {{ date('d-m-Y', strtotime($order->delivery_date)) }}
                </td>

                <td class="px-6 py-4">
                    @switch($order->status)
                        @case('DELIVERING')
                            <span class="bg-green-300 text-white p-2 fw-bolder border rounded">Đang
                                giao</span>
                        @break

                        @case('DELIVERED')
                            <span class="bg-blue-300 text-white p-2 fw-bolder border rounded">Đã
                                giao</span>
                        @break

                        @case('CANCELLED')
                            <span class="bg-red-400 text-white p-2 fw-bolder border rounded ">Hủy
                                đơn</span>
                        @break

                        @case('UNACCEPTED')
                            <span class="bg-red-400 text-white p-2 fw-bolder border rounded">Bị từ
                                chối</span>
                        @break

                        @default
                            <span class="bg-yellow-300 text-white p-2 fw-bolder border rounded">Chờ
                                xác nhận</span>
                    @endswitch

                </td>

                <td class="fw-bolder px-6 py-4">{{ $order->total_price }} đồng</td>
                <td class="fw-bolder px-6 py-4 text-center">
                    {{ $order->payment_type === 'CASH' ? 'Tiền mặt' : 'Ngân hàng' }}
                </td>
                <td class="fw-bolder px-6 py-4">
                    <button type="button" class="btn btn-primary font-medium text-blue-600 hover:underline"
                        data-bs-toggle="modal" data-bs-target="#orderModal" data-order="{{ json_encode($order) }}">
                        Xem
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
{{ $orders->links() }}
