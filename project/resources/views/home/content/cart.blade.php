<div class="container-fluid p-0">
    <div class="bg-gray-100 py-3 w-100 max-h-5xl px-8">
        <h2 class="fw-bold text-gray-900 mb-2 text-center text-uppercase">
            Giỏ hàng
        </h2>
        <hr class="h-px my-3 bg-gray-200" />
        <div class="mx-auto max-w-6xl max-h-xl px-6 justify-content-center d-flex px-xl-0 pb-5 gap-4 flex-column-max-lg">
            <div class="rounded space-x-6-md w-23-md overflow-y-scroll-custom">
                @foreach ($carts as $cart)
                    <div class="justify-content-between mb-6 rounded bg-white d-sm-flex justify-content-sm-start p-3 shadow mr-6"
                        id="product-{{ $cart->product->id }}" data-product-id="{{ $cart->product->id }}"
                        data-price="{{ $cart->price }}" data-predifined="{{ $cart->predifined }}">
                        <img src="{{ 'product/' . $cart->link }}" alt="product-image"
                            class="rounded w-sm-40 img-fluid border" />
                        <div class="ml-sm-4 flex-sm w-sm-100 sm-justify-between">
                            <div class="mt-5 mt-sm-0">
                                <h2 class="fs-4 fw-bold text-gray-900 text-truncate max-w-72">{{ $cart->product->name }}
                                </h2>
                                <p class="mt-1 text-xs text-gray-700">
                                    @if ($cart->predifined)
                                        <span class="text-gray-900 text-lg"><s>{{ number_format($cart->price) }}</s>
                                            Đồng<br>
                                            <strong>{{ number_format($cart->price - ($cart->price * $cart->predifined) / 100) }}</strong>
                                            đồng</span>
                                    @else
                                        {{ number_format($cart->price) }} đồng
                                    @endif
                                </p>
                            </div>
                            <div class="mt-4 d-flex justify-content-between mt-sm-0 block-sm w-40-rem">
                                <div
                                    class="space-y-6-sm space-x-6-sm d-flex align-items-center border-gray-100 max-w-xs">
                                    <button type="button" data-input-counter-decrement="quantity-input"
                                        data-product-id="{{ $cart->product->id }}"
                                        class="decrement-button bg-gray-100 hover:bg-gray-200 border border-gray-300 rounded-start p-3 h-11 focus:ring-gray-100 focus:ring-2 focus:outline-none d-flex align-items-center justify-content-center">
                                        <svg class="w-3 h-3 text-gray-900" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="M1 1h16" />
                                        </svg>
                                    </button>
                                    <input type="text" data-product-id="{{ $cart->product->id }}" name="amount"
                                        data-input-counter aria-describedby="helper-text-explanation"
                                        class="quantity-input bg-gray-50 border-0 border-top border-bottom border-gray-300 h-11 text-center text-gray-900 fs-5 focus:ring-blue-500 focus:border-blue-500 d-block w-100 py-25"
                                        value="{{ $cart->amount }}" min="0" required />
                                    <button type="button" data-product-id="{{ $cart->product->id }}"
                                        data-input-counter-increment="quantity-input"
                                        class="increment-button bg-gray-100 hover:bg-gray-200 border border-gray-300 rounded-end p-3 h-11 focus:ring-gray-100 focus:ring-2 focus:outline-none d-flex align-items-center justify-content-center">
                                        <svg class="w-3 h-3 text-gray-900" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="M9 1v16M1 9h16" />
                                        </svg>
                                    </button>
                                </div>
                                <div
                                    class="space-y-6-sm space-x-6-sm d-flex align-items-center justify-content-between">
                                    <p class="text-sm space-x-4 text-center mb-0">
                                        <span class="text-gray-900">{{ number_format($cart->price) }} đồng</span>
                                    </p>
                                    <button type="button" data-product-id="{{ $cart->product->id }}"
                                        class="remove-button bg-gray-100 hover:bg-gray-200 border-0 p-1 focus:ring-gray-100 focus:ring-2 focus:outline-none d-flex align-items-center justify-content-center">
                                        <svg class="w-5 h-5 text-gray-900" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
            <div class="rounded border bg-white p-3 shadow-md t-0-md w-13-md h-100">
                <form id="paymentForm">

                    <h4 class="fw-bold text-gray-900 mb-4 text-center text-uppercase">Thông tin đơn hàng</h4>
                    <div class="d-flex justify-content-between">
                        <p class="text-gray-700">Tiền sản phẩm</p>
                        @php
                            $total = 0;
                            $discount = 0;
                            foreach ($carts as $cart) {
                                $price = $cart->price;
                                if ($cart->predifined) {
                                    $discount += $cart->predifined;

                                    $price -= ($price * $discount) / 100;
                                }
                                $total += $price * $cart->amount;
                            }
                        @endphp
                        <input type="hidden" value="{{ $total }}" name="price">
                        <p class="text-gray-700" id="total">{{ number_format($total) }} Đồng</p>
                    </div>

                    <div class="d-flex justify-content-between">
                        <p class="text-gray-700">Mã giảm giá</p>
                        <p class="text-gray-700 discount-display">-0%</p>
                    </div>
                    <input type="hidden" value="" id="discount" name="code" />
                    <input type="hidden" name="code" id="discount-code">
                    <hr class="my-4" />
                    <div class="d-flex justify-content-between">
                        <p class="fs-5 fw-bold">Tổng tiền</p>
                        <div class="">
                            <p class="mb-1 fs-6 fw-bold total-amount-display">{{ number_format($total) }} Đồng
                            </p>
                            <input type="hidden" value="{{ $total }}" name="total" id='total-amount'>
                            <p class="small text-gray-700">Đã bao gồm VAT</p>
                        </div>
                    </div>
                </form>


                <div class="position-relative pt-4">
                    <form action="" id="applyDiscountForm">
                        <input type="input" id="code" name="code"
                            class="d-block w-100 p-4 small text-gray-900 border border-gray-300 rounded bg-gray-50 focus:ring-blue-500 focus:border-blue-500 overflow-hidden"
                            placeholder="Mã giảm giá" required />
                        <button type="submit" form="applyDiscountForm"
                            class="text-white position-absolute end-25 bottom-25 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded small px-4 py-2">
                            Áp dụng
                        </button>
                    </form>
                </div>
                <button type="submit" form="paymentForm"
                    class="mt-6 w-100 rounded border bg-blue-500 py-15 fw-bolder text-blue-50 hover-bg-blue-600">
                    Thanh toán
                </button>
            </div>
        </div>
    </div>
</div>
</div>
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        });
        document.getElementById("applyDiscountForm").addEventListener("submit", function(event) {
            event.preventDefault();
            const applyDiscountForm = event.target;
            const formData = new FormData(applyDiscountForm);
            const url = '/cart/apply-discount'
            const method = 'POST';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                }
            });
            $.ajax({
                url: url,
                type: method,
                data: JSON.stringify(Object.fromEntries(formData.entries())),
                contentType: 'application/json',
                cache: false,
                processData: false,
                success: function(result) {
                    if (result.discount) {
                        var discountPercentage = result.discount.discount;
                        var discountCode = result.discount.code;
                        $('#discount').val(
                            discountPercentage);
                        $('.discount-display').text('-' + discountPercentage +
                            '%');
                        $('#discount-code').val(discountCode);

                        updateTotal();
                    }

                },
                error: function(xhr) {
                    const errors = xhr.responseJSON.errors;
                    if (errors) {
                        for (const [key, value] of Object.entries(errors)) {
                            console.log(key, value);
                        }
                        swal({
                            title: 'Thất bại!',
                            text: xhr.responseJSON.message,
                            icon: 'error',
                            button: 'OK',
                            timer: 1000
                        });
                    }
                }
            });
        });
        $('.remove-button').click(function() {
            var id = $(this).data('product-id');
            var removeForm = new FormData();
            removeForm.append('id', id);
            $.ajax({
                url: '/cart/remove',
                method: 'DELETE',
                data: JSON.stringify(Object.fromEntries(removeForm.entries())),
                contentType: 'application/json',
                success: function(response) {
                    $('#product-' + id).remove();
                    updateTotal();
                },
                error: function(xhr) {
                    const errors = xhr.responseJSON.errors;
                    if (errors) {
                        for (const [key, value] of Object.entries(errors)) {
                            console.log(key, value);
                        }
                        swal({
                            title: 'Thất bại!',
                            text: xhr.responseJSON.message,
                            icon: 'error',
                            button: 'OK',
                            timer: 1000
                        });
                    }
                }
            });
        });

        $('.quantity-input').change(function() {
            var id = $(this).data('product-id');
            var amount = $(this).val();
            var updateForm = new FormData();
            updateForm.append('id', id);
            updateForm.append('amount', amount);
            $.ajax({
                url: '/cart/update',
                method: 'PUT',
                data: JSON.stringify(Object.fromEntries(updateForm.entries())),
                contentType: 'application/json',
                success: function(response) {
                    updateTotal();
                },
                error: function(xhr) {
                    const errors = xhr.responseJSON.errors;
                    if (errors) {
                        for (const [key, value] of Object.entries(errors)) {
                            console.log(key, value);
                        }
                        swal({
                            title: 'Thất bại!',
                            text: xhr.responseJSON.message,
                            icon: 'error',
                            button: 'OK',
                            timer: 1000
                        });
                    }

                }
            });
        });

        $('.decrement-button').click(function() {
            var id = $(this).data('product-id');
            var quantityInput = $('.quantity-input[data-product-id="' + id + '"]');
            var amount = parseInt(quantityInput.val()) - 1;
            console.log(amount);
            if (amount >= 0) {
                quantityInput.val(amount).trigger('change');
            }
            if (amount === 0) {
                $('.remove-button[data-product-id="' + id + '"]').click();
            }
        });

        $('.increment-button').click(function() {
            var id = $(this).data('product-id');
            var quantityInput = $('.quantity-input[data-product-id="' + id + '"]');
            var amount = parseInt(quantityInput.val()) + 1;
            quantityInput.val(amount).trigger('change');
        });

        $('.remove-button').click(function() {
            var id = $(this).data('product-id');
            removeProduct(id);
        });

        function removeProduct(id) {
            $('#product-' + id).remove();
            updateTotal();
        }

        function updateTotal() {
            var total = 0;
            $('.quantity-input').each(function() {
                var id = $(this).data('product-id');
                var amount = $(this).val();
                var productElement = $('#product-' + id);
                var price = parseFloat(productElement.data('price'));
                var predifined = parseFloat(productElement.data('predifined'));
                var discount = parseFloat($('#discount').val());

                if (predifined > 0) {
                    var itemTotal = price - (price * predifined / 100);
                } else {
                    var itemTotal = price;
                }
                if (discount > 0) {
                    total += itemTotal * amount * (1 - discount / 100);
                } else {
                    total += itemTotal * amount;
                }
            });

            var finalTotal = total;
            $('.total-amount-display').text(finalTotal.toLocaleString('de-DE') + ' Đồng');
            $('#total-amount').val(finalTotal);
            $('#total').text(total.toLocaleString('de-DE') + ' Đồng');
        }
    });
    document.getElementById("paymentForm").addEventListener("submit", function(event) {
        event.preventDefault();
        const paymentForm = event.target;
        var discountCode = $('#discount-code').val();
        const formData = new FormData(paymentForm);
        formData.append('code', discountCode);
        console.log(Object.fromEntries(formData.entries()));
        const url = 'order/checkout';
        const method = 'POST';
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        });
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
                window.location.href =
                    `${window.location.origin}/order/checkout/${result.order.id}`;
            },
            error: function(xhr) {
                const errors = xhr.responseJSON.errors;
                if (errors) {
                    for (const [key, value] of Object.entries(errors)) {
                        console.log(key, value);
                    }
                    swal({
                        title: 'Thất bại!',
                        text: xhr.responseJSON.message,
                        icon: 'error',
                        button: 'OK',
                        timer: 1000
                    });
                }

            }
        });
    });
</script>
