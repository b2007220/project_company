<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 512px">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle" class="modal-title fs-5 text-xl fw-bolder text-gray-900">
                    Thêm mới loại sản phẩm
                </h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="mb-3" id="categoryForm">
                    <input type="hidden" id="categoryId" name="id" value="" />
                    <label for="categoryName" class="form-label">Tên loại sản phẩm</label>
                    <input type="text" class="form-control" id="categoryName" name="name"
                        placeholder="Nhập tên loại sản phẩm" required />
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" form="categoryForm"
                    class="p-2 m-3 border rounded-pill bg-blue-300 text-white d-flex align-items-center justify-content-center gap-1">
                    Thêm mới
                    <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
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
        const addCategoryModal = document.getElementById("addCategoryModal");
        addCategoryModal.addEventListener("show.bs.modal", function(event) {
            const button = event.relatedTarget;
            const mode = button.getAttribute("data-mode");
            const modalTitle = document.getElementById("modalTitle");
            const categoryForm = document.getElementById("categoryForm");
            const categoryId = document.getElementById("categoryId");
            const categoryName = document.getElementById("categoryName");

            categoryForm.reset();

            if (mode === "edit") {
                const category = JSON.parse(button.getAttribute("data-category"));
                modalTitle.textContent = "Chỉnh sửa loại sản phẩm";
                categoryForm.action = `category/update/${category.id}`;
                categoryId.value = category.id;
                categoryName.value = category.name;
                let methodInput = categoryForm.querySelector('input[name="_method"]');
                if (!methodInput) {
                    methodInput = document.createElement('input');
                    methodInput.setAttribute('type', 'hidden');
                    methodInput.setAttribute('name', '_method');
                    categoryForm.appendChild(methodInput);
                }
                methodInput.value = 'PUT';
            } else {
                modalTitle.textContent = "Thêm mới loại sản phẩm";
                categoryForm.action = `category/add`;
                categoryId.value = "";
                categoryName.value = "";
                const methodInput = categoryForm.querySelector('input[name="_method"]');
                if (methodInput) {
                    categoryForm.removeChild(methodInput);
                }
            }
        });
    });

    document.getElementById("categoryForm").addEventListener("submit", function(event) {
        event.preventDefault();
        const categoryForm = event.target;
        const formData = new FormData(categoryForm);
        const url = categoryForm.action;
        const method = categoryForm.querySelector('input[name="_method"]') ? 'PUT' : 'POST';
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
                $('#addCategoryModal').modal('hide');
                if (method === 'PUT') {
                    const row = document.querySelector(
                        `tr[data-category-id="${result.category.id}"]`);
                    if (row) {
                        row.querySelector('td div').textContent = result.category.name;
                    }

                } else if (method === 'POST') {
                    const newRow = document.createElement('tr');
                    newRow.setAttribute('data-category-id', result.category.id);
                    newRow.innerHTML = `
                    <td class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm">
                        <div class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                            ${result.category.name}
                        </div>
                    </td>
                    <td class="text-decoration-none px-6 py-4 text-sm leading-5 text-gray-500 whitespace-no-wrap border-bottom border-gray-200 d-flex justify-content-center align-items-center gap-2">
                        <form action="javascript:void(0)" enctype="multipart/form-data" onsubmit="confirmation(event, ${result.category.id})">
                            <button type="submit" class="text-decoration-none p-2 border rounded-pill fw-bolder bg-red-400 text-white d-flex align-items-center justify-content-center gap-1">
                                Xóa
                                <svg class="w-6 h-6  text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </button>
                        </form>
                        <button type="button" class="text-decoration-none p-2 border rounded-pill fw-bolder bg-yellow-400 text-white d-flex align-items-center justify-content-center gap-1" data-bs-toggle="modal" data-bs-target="#addCategoryModal" data-mode="edit" data-category='${JSON.stringify(result.category)}'>
                            Chỉnh sửa
                            <svg class="w-6 h-6  text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </button>
                    </td>`;
                    document.querySelector('tbody').appendChild(newRow);
                }
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
    });
</script>
