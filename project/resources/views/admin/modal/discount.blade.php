<div class="modal fade" id="addDiscountModal" tabindex="-1" aria-labelledby="addDiscountModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollablle" style="max-width: 512px">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle" class="modal-title fs-5 text-xl fw-bolder text-gray-900">
                    Thêm mới loại giảm giá mới
                </h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="mb-3" id="discountForm">
                    <input type="hidden" id="discountId" name="id" value="" />
                    <label for="discountName" class="form-label">Tên loại giảm giá</label>
                    <input type="text" class="form-control" id="discountName" name="name"
                        placeholder="Nhập tên loại giảm giá" />

                    <label for="discountDiscount" class="form-label">Phần trăm giảm giá</label>
                    <input type="number" class="form-control" id="discountDiscount" name="discount"
                        placeholder="Nhập phần trăm giảm giá" min="0" max="100" />
                    <label for="discountAmount" class="form-label">Số lượng áp dụng</label>
                    <input type="number" class="form-control" id="discountAmount" name="amount"
                        placeholder="Nhập số lượng" min="1" />
                    <label for="discountType" class="form-label">Loại giảm giá</label>
                    <select name="type" id="discountType" class="form-select">
                        <option value="PRODUCT">Giảm theo sản phẩm</option>
                        <option value="ORDER">Giảm theo đơn hàng</option>
                    </select>
                    <label for="discountExpired" class="form-label">Thời gian hết hạn</label>
                    <input type="date" class="form-control" id="discountExpired" name="expire" />
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" form="discountForm"
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
        const addDiscountModal = document.getElementById("addDiscountModal");
        addDiscountModal.addEventListener("show.bs.modal", function(event) {
            const button = event.relatedTarget;
            const mode = button.getAttribute("data-mode");
            const modalTitle = document.getElementById("modalTitle");
            const discountForm = document.getElementById("discountForm");
            const discountId = document.getElementById("discountId");
            const discountName = document.getElementById("discountName");
            const discountDiscount = document.getElementById("discountDiscount");
            const discountAmount = document.getElementById("discountAmount");
            const discountExpired = document.getElementById("discountExpired");
            const discountType = document.getElementById("discountType");
            discountForm.reset();
            if (mode === "edit") {
                const discount = JSON.parse(button.getAttribute("data-discount"));
                modalTitle.textContent = "Chỉnh sửa loại giảm giá";
                discountForm.action = `discount/update/${discount.id}`;
                discountId.value = discount.id;
                discountName.value = discount.name;
                discountDiscount.value = discount.discount;
                discountAmount.value = discount.amount;
                discountType.value = discount.type;
                const dateOnly = new Date(discount.expired_at).toISOString().split('T')[0];
                discountExpired.value = dateOnly;
                let methodInput = discountForm.querySelector('input[name="_method"]');
                if (!methodInput) {
                    methodInput = document.createElement('input');
                    methodInput.setAttribute('type', 'hidden');
                    methodInput.setAttribute('name', '_method');
                    discountForm.appendChild(methodInput);
                }
                methodInput.value = 'PUT';
            } else {
                modalTitle.textContent = "Thêm mới loại giảm giá";
                discountForm.action = `discount/add`;
                discountId.value = "";
                discountName.value = "";
                discountDiscount.value = "";
                discountAmount.value = "";
                discountExpired.value = "";
                discountType.value = "PRODUCT";
                const methodInput = discountForm.querySelector('input[name="_method"]');
                if (methodInput) {
                    discountForm.removeChild(methodInput);
                }
            }
        });
    });

    document.getElementById("discountForm").addEventListener("submit", function(event) {
        event.preventDefault();
        const discountForm = event.target;
        const formData = new FormData(discountForm);
        const url = discountForm.action;
        const method = discountForm.querySelector('input[name="_method"]') ? 'PUT' : 'POST';
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Content-Type': 'application/json'
            }
        });
        $.ajax({
            url: url,
            type: method,
            data: JSON.stringify(Object.fromEntries(formData.entries())),
            cache: false,
            processData: false,
            success: function(result) {
                $('#addDiscountModal').modal('hide');
                if (method === 'PUT') {
                    const row = document.querySelector(
                        `tr[data-discount-id="${result.discount.id}"]`);
                    if (row) {
                        row.innerHTML = `
                <td class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm">
                    <div class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                        ${result.discount.code}
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm">
                    <div class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                        ${result.discount.name}
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm leading-5 text-gray-500">
                    <div class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                        ${result.discount.discount} %
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm leading-5 text-gray-500">
                    <div class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                        ${result.discount.amount.toLocaleString('en-US')}
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm leading-5 text-gray-500">
                    <div class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                        ${new Date(result.discount.expired_at).toLocaleDateString('en-GB')}
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm leading-5 text-gray-500">
                    <div class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                        ${result.discount.type === 'PRODUCT' ? 'Sản phẩm' : 'Đơn hàng'}
                    </div>
                </td>
                <td class="text-decoration-none px-6 py-4 text-sm leading-5 text-gray-500 whitespace-no-wrap border-bottom border-gray-200 d-flex justify-content-center align-items-center gap-2">
                    <form action="javascript:void(0)" enctype="multipart/form-data" onsubmit="confirmation(event, ${result.discount.id})">
                        <button type="submit" class="text-decoration-none p-2 border rounded-pill fw-bolder bg-red-400 text-white d-flex align-items-center justify-content-center gap-1">
                            Xóa
                            <svg class="w-6 h-6  text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </button>
                    </form>
                    <button type="button" class="text-decoration-none p-2 border rounded-pill fw-bolder bg-yellow-400 text-white d-flex align-items-center justify-content-center gap-1" data-bs-toggle="modal" data-bs-target="#addDiscountModal" data-mode="edit" data-discount="${JSON.stringify(result.discount)}">
                        Chỉnh sửa
                        <svg class="w-6 h-6  text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </button>
                </td>`;
                    }
                    swal({
                        title: 'Thành công!',
                        text: result.message,
                        icon: 'success',
                        button: 'OK'
                        timer: 1000
                    });
                } else if (method === 'POST') {
                    const newRow = document.createElement('tr');
                    newRow.setAttribute('data-discount-id', result.discount.id);
                    newRow.innerHTML = `
                    <td class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm">
                        <div
                            class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                            ${result.discount.code}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm">
                        <div
                            class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                            ${result.discount.name}
                        </div>
                    </td>
                    <td
                        class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm leading-5 text-gray-500">
                        <div
                            class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                            ${result.discount.discount} %</div>
                    </td>
                    <td
                        class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm leading-5 text-gray-500">
                        <div
                            class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                            ${result.discount.amount.toLocaleString('en-US')}
                        </div>
                    </td>

                    <td
                        class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm leading-5 text-gray-500">
                        <div
                            class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                            ${new Date(result.discount.expired_at).toLocaleDateString('en-GB')}

                        </div>
                    </td>
                    <td
                        class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm leading-5 text-gray-500">
                        <div
                            class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                            ${result.discount.type === 'PRODUCT' ? 'Sản phẩm' : 'Đơn hàng'}
                        </div>
                    </td>
                    <td
                        class="text-decoration-none px-6 py-4 text-sm leading-5 text-gray-500 whitespace-no-wrap border-bottom border-gray-200 d-flex justify-content-center align-items-center gap-2">
                        <form action="javascript:void(0)" enctype="multipart/form-data"
                            onsubmit="confirmation(event, ${result.discount.id})">
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
                            data-discount="${JSON.stringify(result.discount)}">
                            Chỉnh sửa
                            <svg class="w-6 h-6  text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </button>
                    </td>`;
                    document.querySelector('tbody').appendChild(newRow);
                    swal({
                        title: 'Thành công!',
                        text: result.message,
                        icon: 'success',
                        button: 'OK',
                        timer: 1000
                    });
                }

            },
            error: function(xhr) {
                const errors = xhr.responseJSON.errors;
                if (errors) {
                    for (const [key, value] of Object.entries(errors)) {
                        console.log(key, value);
                    }
                }
            }
        });
    });
</script>
