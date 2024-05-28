<div class="modal fade" id="addAccountModal" tabindex="-1" aria-labelledby="addAccountModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollabll" style="max-width: 512px">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="addAccountModal" class="modal-title fs-5 text-xl fw-bolder text-gray-900">
                    Thêm mới tài khoản
                </h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="mb-3" id="addAccountForm" method="POST">
                    @csrf
                    <label for="accountName" class="form-label">Tên loại sản phẩm</label>
                    <input type="text" class="form-control" id="accountName" placeholder="Nhập tên tài khoản" />
                    <label for="accountPassword" class="form-label">Mật khẩu</label>
                    <input type="password" class="form-control" id="accountPassword"
                        placeholder="Nhập mật khẩu tài khoản" />
                    <label for="confirmPassword" class="form-label">Xác nhận lại mật khẩu</label>
                    <input type="password" class="form-control" id="confirmPassword"
                        placeholder="Nhập lại mật khẩu tài khoản" />
                    <label for="accountRole" class="form-label">Vai trò tài khoản</label>
                    <select class="form-select max-w-100 overflow-auto" id="accountRole">
                        <option value="1">Tài khoản thông thường</option>
                        <option value="2">Admin</option>
                    </select>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" form="addAccountForm"
                    class="p-2 m-3 border rounded-pill bg-blue-300 text-white d-flex align-items-center justify-content-center gap-1">
                    Thêm mới
                    <svg class="w-6 h-6 text-gray-800 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 5v9m-5 0H5a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1h-2M8 9l4-5 4 5m1 8h.01" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>
