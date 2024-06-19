<div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollabll max-h-lg-100 max-w-screen-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="orderModalLabel" class="modal-title fs-5 text-xl fw-bolder text-gray-900">
                    Chi tiết đơn hàng
                </h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="bg-gray-100 pt-10 border-2 rounded max-w-5xl max-h-xl  pl-8 pr-8">
                    <h1 class="mb-10 text-center text-2xl font-bold">Giỏ hàng</h1>
                    <div class="mx-auto justify-content-center flex-md xl:px-0 max-h-92 gap-2">
                        <div class="position-relative shadow rounded border w-100 overflow-y-scroll-custom">
                            <table class="w-100 text-sm text-left rtl:text-right text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th scope="col" class="fw-bold px-6 py-3">
                                            <span class="sr-only">Hình ảnh</span>
                                        </th>
                                        <th scope="col" class="fw-bold px-6 py-3">
                                            Tên sản phẩm
                                        </th>
                                        <th scope="col" class="fw-bold px-6 py-3">Số lượng</th>
                                        <th scope="col" class="fw-bold px-6 py-3">Giá tiền</th>
                                        <th scope="col" class="fw-bold px-6 py-3">
                                            Chi tiết sản phẩm
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="order-products-body">
                                </tbody>
                            </table>
                        </div>
                        <div class="rounded border bg-white mt-0-md w-13-md p-3 overflow-y-scroll-custom">
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="text-gray-700">Tiền sản phẩm</p>
                                <p id="product-price" class="text-gray-700 text-end">0 đồng</p>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="text-gray-700">Tiền phí ship</p>
                                <p id="shipping-fee" class="text-gray-700 text-end">0 đồng</p>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="text-gray-700">Phiếu giảm giá</p>
                                <p id="discount" class="text-gray-700 text-end">0 đồng</p>
                            </div>
                            <hr class="my-2" />
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="text-lg fw-bold">Tổng tiền</p>
                                <div class="">
                                    <p id="total-price" class="mb-1 text-lg fw-bold text-end">0 đồng</p>
                                    <p class="text-sm text-gray-700 text-end">Đã bao gồm VAT</p>
                                </div>
                            </div>
                            <hr class="my-2" />
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="text-lg fw-bold">Giao đến</p>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <p id="delivery-address" class="mb-1 text-lg ">
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="cancel-order-button">
                    Hủy bỏ đơn hàng
                </button>
                <button type="button" class="btn btn-primary" id="reorder-button">
                    Thêm vào giỏ hàng
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Content-Type': 'application/json'
            }
        });
        const orderModal = document.getElementById("orderModal");
        orderModal.addEventListener("show.bs.modal", function(event) {
            const button = event.relatedTarget;
            const order = JSON.parse(button.getAttribute("data-order"));
            const orderProductsBody = document.getElementById("order-products-body");
            orderProductsBody.innerHTML = '';
            var total = 0;
            order.products.forEach(product => {
                total += product.pivot.price * product.pivot.amount;
                const row = document.createElement('tr');
                row.className = 'bg-white border-b hover:bg-gray-50';
                row.innerHTML = `
                <td class="fw-bolder p-4">
                    <img src="product/${product.pictures[0].link}" class="w-16 w-32-md max-w-100 max-h-full" alt="${product.name}" />
                </td>
                <td class="fw-bolder px-6 py-4 fw-bolder text-gray-900">${product.name}</td>
                <td class="fw-bolder px-6 py-4 fw-bolder text-gray-900">${Number(product.pivot.amount).toLocaleString('de-DE')}</td>
                <td class="fw-bolder px-6 py-4 fw-bolder text-gray-900">${Number(product.pivot.price).toLocaleString('de-DE')}</td>
                <td class="fw-bolder px-6 py-4 fw-bolder text-gray-900">
                    <a href="/product/${product.id}" class="btn btn-success">Chi tiết</a>
                </td>
            `;
                orderProductsBody.appendChild(row);
            });
            document.getElementById('product-price').innerText =
                `${Number(total).toLocaleString('de-DE')} đồng`;
            document.getElementById('shipping-fee').innerText =
                `${Number(order.ship).toLocaleString('de-DE')} đồng`;
            if (order.discounts.length == 0)
                discountMoney = 0;
            else
                discountMoney = total * (order.discounts[0].discount / 100);

            document.getElementById('discount').innerText =
                `${Number(discountMoney).toLocaleString('de-DE')} đồng`;
            document.getElementById('total-price').innerText =
                `${Number(order.total_price).toLocaleString('de-DE')} đồng`;
            document.getElementById('delivery-address').innerText = order.address;
            const cancelOrderButton = document.getElementById('cancel-order-button');
            cancelOrderButton.onclick = function() {
                event.preventDefault();
                $.ajax({
                    url: 'order/cancle/' + order.id,
                    type: 'PUT',
                    success: function(result) {
                        const row = document.getElementById("order-status-" + result
                            .order.id);
                        if (row) {
                            row.innerHTML =
                                ` <span class="bg-red-400 text-white p-2 fw-bolder border rounded ">Hủy đơn</span>`;
                        }
                        $('#orderModal').modal('hide');
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
                        swal({
                            title: 'Thất bại!',
                            text: xhr.responseJSON.message,
                            icon: 'error',
                            button: 'OK',
                            timer: 1000
                        });
                    }
                });

            };
            const reorderButton = document.getElementById('reorder-button');
            reorderButton.onclick = function() {
                event.preventDefault();
                $.ajax({
                    url: 'order/reorder/' + order.id,
                    type: 'POST',
                    success: function(result) {
                        $('#orderModal').modal('hide');
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
                        swal({
                            title: 'Thất bại!',
                            text: xhr.responseJSON.message,
                            icon: 'error',
                            button: 'OK',
                            timer: 1000
                        });
                    }
                });
            };

        });


    });
</script>
