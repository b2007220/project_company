<div class="modal fade" id="addProductDiscountModal" tabindex="-1" aria-labelledby="addProductDiscountModal">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 512px">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle2" class="modal-title fs-5 text-xl fw-bolder text-gray-900">
                    Thêm mới loại giảm giá mới
                </h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="mb-3" id="productDiscountForm">
                    <input type="hidden" id="discountedProductId">
                    <label for="discounts" class="my-2">Loại giảm giá</label>
                    <select name="discounts" id="discounts" multiple class="form-select max-w-100 overflow-auto">
                        @foreach ($discounts as $discount)
                            <option value="{{ $discount->id }}">{{ $discount->name }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" form="productDiscountForm"
                    class="p-2 m-3 border rounded-pill bg-blue-300 text-white d-flex align-items-center justify-content-center gap-1">
                    Thêm mới
                    <svg class="w-6 h-6  text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 5v9m-5 0H5a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1h-2M8 9l4-5 4 5m1 8h.01" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const addProductDiscountModal = document.getElementById("addProductDiscountModal");
        addProductDiscountModal.addEventListener("show.bs.modal", function(event) {
            const button = event.relatedTarget;
            const productDiscountForm = document.getElementById("productDiscountForm");
            const product = JSON.parse(button.getAttribute("data-product"))
            console.log(product);
            const discountedProductId = document.getElementById("discountedProductId");
            discountedProductId.value = product.id;
            productDiscountForm.reset();

            productDiscountForm.action = `product/add-discount`;

        });
        document.getElementById("productDiscountForm").addEventListener("submit", function(event) {
            event.preventDefault();
            const productDiscountForm = event.target;
            const formData = new FormData();
            const selectedDiscounts = [];
            const discounts = document.getElementById("discounts");
            const productId = document.getElementById('discountedProductId').value;
            const selectedOptions = [...discounts.selectedOptions];
            selectedOptions.forEach(option => {
                selectedDiscounts.push(option.value);
            });
            formData.append('discounts', selectedDiscounts);
            formData.append('productId', productId);
            const url = productDiscountForm.action;
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
                processData: false,
                contentType: 'application/json',
                success: function(result) {
                    $('#addProductDiscountModal').modal('hide');
                    const discountTable = document.getElementById(
                        `discount-table-${productId}`);
                    result.newDiscounts.forEach(function(discountData) {
                        const discount = discountData.discount;
                        const pivot_id = discountData.pivot_id;
                        const is_predefined = discountData.is_predefined;

                        const newRow = document.createElement('tr');
                        newRow.setAttribute('data-pivot-id', pivot_id);
                        newRow.innerHTML = `
                        <td
                            class="px-6 py-4  border-bottom border-gray-200 overflow-auto max-w-sm text-sm leading-5 text-gray-500 ">
                            <div class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">

                            ${discount.code}
                            </div>
                        </td>
                        <td
                            class="px-6 py-4  border-bottom border-gray-200 overflow-auto max-w-sm text-sm leading-5 text-gray-500 ">
                            <div class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">

                            ${discount.name}
                            </div>

                        </td>
                        <td
                            class="px-6 py-4  border-bottom border-gray-200 overflow-auto max-w-sm text-sm leading-5 text-gray-500 ">
                            <div class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">

                                ${discount.discount} %
                            </div>

                        </td>
                        <td
                            class="px-6 py-4  border-bottom border-gray-200 overflow-auto max-w-sm text-sm leading-5 text-gray-500 ">
                            <div class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">

                                ${Number(discount.amount).toLocaleString('de-DE')}
                            </div>


                        </td>
                        <td
                            class="px-6 py-4  border-bottom border-gray-200 overflow-auto max-w-sm text-sm leading-5 text-gray-500 ">
                            <div class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                                ${discount.expired_at ? new Date(discount.expired_at).toLocaleDateString('en-GB') :  new Date().toLocaleDateString('en-GB')}
                            </div>

                        </td>

                        <td
                            class="px-6 py-4  border-bottom border-gray-200 overflow-auto max-w-sm text-sm leading-5 text-gray-500 ">
                            <div class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                                ${is_predefined ? ' <span class="text-success">Áp dụng trực tiếp</span>' : '<span class="text-danger">Chưa áp dụng</span>'}
                            </div>

                        </td>
                        <td class="px-6 py-4 text-sm leading-5 text-gray-500  border-bottom border-gray-200 d">
                            <div class="d-flex justify-content-center align-items-center gap-2">
                                <form action="javascript:void(0)" enctype="multipart/form-data"
                            onsubmit="removeDiscount(event, ${productId},${discount.id}, ${pivot_id})" id="removeDiscountForm-${pivot_id}">
                                    <button type="submit" form="removeDiscountForm-${pivot_id}"
                                        class="text-decoration-none p-2 border rounded-pill fw-bolder bg-red-400 text-white d-flex align-items-center justify-content-center gap-1">
                                        Xóa
                                        <svg class="w-6 h-6  text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>
                                    </button>
                                </form>
                                <form  action="javascript:void(0)" enctype="multipart/form-data" id="applyDiscountForm-${pivot_id}"
                            onsubmit="apply(event,${productId}, ${discount.id}, ${pivot_id})">
                                    <button type="submit" form="applyDiscountForm-${pivot_id}"
                                        class=" p-2 border rounded-pill bg-green-300 text-white d-flex align-items-center justify-content-center gap-1">
                                        Áp dụng
                                        <svg class="w-6 h-6  text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>`;
                        discountTable.appendChild(
                            newRow);
                    });
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
                    };
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
    });
</script>
