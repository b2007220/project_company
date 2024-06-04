<div class="modal fade" id="updateOrderModal" tabindex="-1" aria-labelledby="updateOrderModal">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 512px">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle2" class="modal-title fs-5 text-xl fw-bolder text-gray-900">
                    Điều chỉnh trạng thái đơn hàng
                </h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="mb-3" id="updateOrderForm" method="POST">
                    @csrf
                    <input type="hidden" name="orderId" id="orderId" value="">
                    <select name="status" id="status" class="form-select max-w-100 overflow-auto">
                        <option value="PENDING">Đang chờ xử lý</option>
                        <option value="DELIVERING">Đang giao hàng</option>
                        <option value="CANCEL">Đã hủy</option>
                        <option value="DELIVERED">Đã giao</option>
                        <option value="UNACCEPTED">Đã từ chối</option>
                    </select>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" form="updateOrderForm"
                    class="p-2 m-3 border rounded-pill bg-blue-300 text-white d-flex align-items-center justify-content-center gap-1">
                    Điều chỉnh
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
        const updateOrderModal = document.getElementById("updateOrderModal");
        updateOrderModal.addEventListener("show.bs.modal", function(event) {
            const button = event.relatedTarget;
            const updateOrderForm = document.getElementById("updateOrderForm");
            const orderId = document.getElementById("orderId");
            const status = document.getElementById("status");

            updateOrderForm.reset();


            const order = JSON.parse(button.getAttribute("data-account"));
            updateOrderForm.action = `account/update-role`;
            adjustAccountId.value = account.id;
            adjustAccountRole.value = account.role;

            let methodInput = accountForm.querySelector('input[name="_method"]');
            if (!methodInput) {
                methodInput = document.createElement('input');
                methodInput.setAttribute('type', 'hidden');
                methodInput.setAttribute('name', '_method');
                accountForm.appendChild(methodInput);
            }
            methodInput.value = 'PUT';

        });
    });

    document.getElementById("updateOrderForm").addEventListener("submit", function(event) {
        event.preventDefault();
        const updateOrderForm = event.target;
        const formData = new FormData(updateOrderForm);
        const url = updateOrderForm.action;
        const method = updateOrderForm.querySelector('input[name="_method"]');
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
                $('#updateOrderModal').modal('hide');

                const row = document.querySelector(
                    `tr[data-account-id="${result.account.id}"]`);
                if (row) {
                    row.querySelector('td div').textContent = result.account.name;
                }
                swal({
                    title: 'Thành công!',
                    text: result.message,
                    icon: 'success',
                    button: 'OK'
                });
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
