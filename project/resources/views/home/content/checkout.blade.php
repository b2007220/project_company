<div class="container">
    <h2 class="fw-bold text-gray-900 d-flex justify-content-center text-uppercase py-3">
        Bảng thanh toán
    </h2>
    <hr class="h-px my-3 bg-gray-200" />
    <div class="row gap-3 mt-4">
        <div
            class="col-md-4 order-2 rounded bg-white p-3 shadow-md t-0-md w-13-md h-100 border-gray-300 border sticky-top z-1">
            <div class="mb-2 d-flex justify-content-between">
                <p class="text-gray-700">Tiền sản phẩm</p>
                <p class="text-gray-700 text-end" name="total" id="total">{{ $order->total }} đồng</p>
            </div>
            <div class="d-flex justify-content-between">
                <p class="text-gray-700">Tiền phí ship</p>
                <p class="text-gray-700 text-end" name="ship" id="ship">0 đồng</p>
            </div>
            <div class="d-flex justify-content-between">
                <p class="text-gray-700 ">Áp dụng phiếu giảm giá</p>
                @php
                    $discountPercentage = 0;
                    if ($order->discounts) {
                        foreach ($order->discounts as $discount) {
                            $discountPercentage = $discount->discount;
                        }
                    }
                @endphp
                @if ($discountPercentage)
                    <p class="text-gray-700 text-end" name="discount" id="discount">
                        {{ ($order->total * $discountPercentage) / 100 }} đồng</p>
                @else
                    <p class="text-gray-700 text-end" name= "discount" id="discount">0 đồng</p>
                @endif
            </div>
            <hr class="my-4" />
            <div class="d-flex justify-content-between">
                <p class="fs-5 fw-bold">Tổng tiền</p>
                <div class="">
                    <p class="mb-1 fs-6 fw-bold text-end" id="grand-total" name="grand-total">
                        {{ $order->total - ($order->total * $discountPercentage) / 100 }}</p>
                    <p class="small text-gray-700 text-end">Đã bao gồm VAT</p>
                </div>
            </div>
        </div>

        <div class="col-md-7 order-1 rounded border px-5">
            <h4 class="my-3">Phiếu thanh toán</h4>
            <form action="{{ route('order.confirm') }}" id="confirmForm" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $order->id }}">
                <div class="mb-4">
                    <label for="name">Họ tên người nhận</label>
                    <input type="text" class="form-control" aria-label="name" value="{{ Auth::user()->name ?? '' }}"
                        required name="receiver_name" />
                </div>
                <div class="mb-4">
                    <label for="phone">Số điện thoại người nhận</label>
                    <input type="phone" class="form-control" aria-label="phone"
                        value="{{ Auth::user()->phone ?? '' }}" name="phone" required />
                </div>
                <div class="mb-4">
                    <label for="email">Email tài khoản sử dụng</label>
                    <input type="email" class="form-control" aria-label="email" readonly="readonly"
                        value="{{ Auth::user()->email ?? '' }}" name="email" />
                </div>


                <div class="mb-4 row">
                    <div class="col"><label for="address">Địa chỉ nhận hàng</label>
                        <input type="text" class="form-control" aria-label="address" id="address" required
                            value="{{ Auth::user()->address ?? '' }}" name="address" />
                    </div>
                    <div class="col"><label for="address">Địa chỉ nhận hàng</label>
                        <select class="form-select max-w-100 overflow-auto" name="location" id="location" required>
                            <option value="" disabled selected>Chọn tỉnh thành</option>
                            @foreach ($locations as $location)
                                @if ($location->parent_id === null)
                                    <option value="{{ $location->id }}">{{ $location->name }}</option>
                                @else
                                    <option value="{{ $location->id }}">{{ $location->name }} -
                                        {{ $location->parent->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <hr class="mb-4" />
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="payment_type" id="flexRadioDefault1" checked
                        value="TRANSFER" />
                    <label class="form-check-label" for="flexRadioDefault1">
                        Thẻ ngân hàng
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="payment_type" id="flexRadioDefault2"
                        value="CASH" />
                    <label class="form-check-label" for="flexRadioDefault2">
                        Tiền mặt
                    </label>
                </div>


                <div class="row">
                    <div class="col mb-4">
                        <label for="card1"> Tên ngân hàng</label>
                        <input type="text" class="form-control" aria-label="card1" name="bankName" />

                    </div>

                    <div class="col mb-4">
                        <label for="card2"> Số thẻ</label>
                        <input type="text" class="form-control" placeholder="1234-5678-9012" aria-label="card2"
                            name="bankNumber" />
                    </div>
                </div>


                <hr class="mb-4" />

                <div class="d-grid gap-2 mb-4">
                    <button class="btn btn-primary btn-lg" type="submit" form="confirmForm">
                        Thanh toán
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    });
    document.getElementById("confirmForm").addEventListener("submit", function(event) {
        event.preventDefault();
        const confirmForm = event.target;
        const formData = new FormData(confirmForm);
        const url = '/order/confirm';
        const method = 'POST';
        $.ajax({
            url: url,
            type: method,
            data: JSON.stringify(Object.fromEntries(formData.entries())),
            cache: false,
            contentType: 'application/json',
            processData: false,
            success: function(result) {
                swal({
                    title: 'Thành công!',
                    text: result.message,
                    icon: 'success',
                    button: 'OK',
                    timer: 1000
                });
                window.location.href = 'order';
            },
            error: function(xhr) {
                const errors = xhr.responseJSON.errors;
                if (errors) {
                    for (const [key, value] of Object.entries(errors)) {
                        console.log(key, value);
                    }
                }
                swal({
                    title: 'Thất bại!',
                    text: xhr.responseJSON.message,
                    icon: 'error',
                    button: 'OK',
                    timer: 1000
                });
            }
        });
    });
    $('#location').change(function() {
        const location = $(this).val();
        const total = @json($order->total);
        const shipElement = $('#ship');
        const grandTotalElement = $('#grand-total');
        const discount = @json(($order->total * $discountPercentage) / 100);
        $.ajax({
            url: '/order/shipfee/' + location,
            type: 'GET',
            cache: false,
            contentType: 'application/json',
            processData: false,
            success: function(result) {
                const shipFee = result.shipFee;
                const grandTotal = total + shipFee - discount;
                shipElement.text(shipFee + ' đồng');
                grandTotalElement.text(grandTotal + ' đồng');
            },
            error: function(xhr) {
                console.log(xhr);
            }
        });
    })
</script>
