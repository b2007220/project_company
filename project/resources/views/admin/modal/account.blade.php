<div class="modal fade" id="adjustAccountModal" tabindex="-1" aria-labelledby="adjustAccountModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollabll" style="max-width: 512px">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="adjustAccountModal" class="modal-title fs-5 text-xl fw-bolder text-gray-900">
                    Chỉnh sửa tài khoản
                </h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="mb-3" id="adjustAccountForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="adjustAccountId" name="adjustAccountId" value="" />
                    <label for="adjustAccountRole" class="form-label">Tên loại giảm giá</label>
                    <select class="form-select max-w-100 overflow-auto" id="adjustAccountRole" name="role">
                        <option value="USER">Tài khoản thông thường</option>
                        <option value="ADMIN">Quản trị viên</option>
                    </select>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" form="adjustAccountForm"
                    class="p-2 m-3 border rounded-pill bg-blue-300 text-white d-flex align-items-center justify-content-center gap-1">
                    Lưu
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
        const adjustAccountModal = document.getElementById("adjustAccountModal");
        adjustAccountModal.addEventListener("show.bs.modal", function(event) {
            const button = event.relatedTarget;
            const adjustAccountForm = document.getElementById("adjustAccountForm");
            const adjustAccountId = document.getElementById("adjustAccountId");
            const adjustAccountRole = document.getElementById("adjustAccountRole");
            adjustAccountForm.reset();
            const account = JSON.parse(button.getAttribute("data-account"));
            adjustAccountForm.action = `account/update-role`;
            adjustAccountId.value = account.id;
            adjustAccountRole.value = account.role;
        });
    });
</script>
