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
                <form class="mb-3" id="addAccountForm">

                    <label for="accountName" class="form-label">Tên tài khoản</label>
                    <input type="text" class="form-control" id="accountName" placeholder="Nhập tên tài khoản"
                        name="name" />
                    <label for="accountEmail" class="form-label" class="form-label">Địa chỉ email</label>
                    <input type="email" class="form-control" id="accountEmail" placeholder="Nhập email tài khoản"
                        name="email" />
                    <label for="accountPassword" class="form-label">Mật khẩu</label>
                    <input type="password" class="form-control" id="accountPassword" name="password"
                        placeholder="Nhập mật khẩu tài khoản" />
                    <label for="confirmPassword" class="form-label">Xác nhận lại mật khẩu</label>
                    <input type="password" class="form-control" id="confirmPassword" name="password_confirmation"
                        placeholder="Nhập lại mật khẩu tài khoản" />
                    <label for="accountRole" class="form-label">Vai trò tài khoản</label>
                    <select class="form-select max-w-100 overflow-auto" id="accountRole" name="role">
                        <option value="USER">Tài khoản thông thường</option>
                        <option value="ADMIN">Admin</option>
                    </select>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" form="addAccountForm"
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
    document.getElementById("addAccountForm").addEventListener("submit", function(event) {
        event.preventDefault();
        const addAccountForm = event.target;
        const formData = new FormData(addAccountForm);
        const url = 'account/add';
        const method = 'POST';
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
                    $('#addAccountModal').modal('hide');
                    content = `<td class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm">
                    <div
                        class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                        ${result.account.email ? result.account.email : 'Chưa cập nhật'}
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm">
                    <div
                        class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                        ${result.account.name ? result.account.name : 'Chưa cập nhật'}
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm">
                    <div
                        class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                        ${result.account.phone ? result.account.phone : 'Chưa cập nhật'}
                    </div>
                </td>

                <td class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm">
                    <div
                        class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                        ${result.account.address ? result.account.address : 'Chưa cập nhật'}
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm">
                    ${result.account.is_active ? `<div
                            class="ml-4 text-sm leading-5 font-medium d-flex justify-content-center align-items-center">
                            <span class="bg-green-300 text-white p-2 fw-bolder border rounded">Đang hoạt
                                động</span>
                        </div>` : ` <div
                            class="ml-4 text-sm leading-5 font-medium d-flex justify-content-center align-items-center">
                            <span class="bg-red-700 text-white p-2 fw-bolder border rounded">Vô hiệu
                                hóa</span>
                        </div>`}

                </td>

                <td class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm">

                    ${result.account.role==='ADMIN' ? `<div
                            class="ml-4 text-sm leading-5 font-medium d-flex justify-content-center align-items-center">
                            <span class="bg-orange-300 text-white p-2 fw-bolder border rounded">Quản trị
                                viên</span>
                        </div>` : ` <div
                            class="ml-4 text-sm leading-5 font-medium d-flex justify-content-center align-items-center">
                            <span class="bg-blue-300 text-white p-2 fw-bolder border rounded">Người
                                dùng</span>
                        </div>`}

                </td>
                <td
                    class="px-6 py-4 text-sm leading-5 text-gray-500 whitespace-no-wrap border-bottom border-gray-200 d-flex justify-content-center align-items-center gap-2">
                    <form onsubmit="disableAccount(${result.account.id})">

                        <button type="submit"
                            class="text-decoration-none p-2 border rounded-pill fw-bolder bg-red-400 text-white d-flex align-items-center justify-content-center gap-1">
                            Vô hiệu hóa
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
                        data-bs-toggle="modal" data-bs-target="#adjustAccountModal"
                        data-account="${JSON.stringify(result.account)}">
                        Chỉnh sửa
                        <svg class="w-6 h-6  text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </button>

                </td>`;

                    const newRow = document.createElement('tr');
                    newRow.innerHTML = content;
                    document.querySelector('tbody').appendChild(newRow);
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
                }
            }

        )
    });
</script>
