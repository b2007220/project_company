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
                    <label for="parent-category">Loại sản phẩm chính</label>
                    <input type="checkbox" name="is_parent" id="parent-category" value="1">
                    <select class="form-select max-w-100 overflow-auto" multiple name="categories" id="categories">
                        <option value="" disabled>Chọn loại sản phẩm</option>
                        @foreach ($allCategories as $category)
                            @if ($category->parent_id === null)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @else
                                <option value="{{ $category->id }}">{{ $category->name }} -
                                    {{ $category->parent->name }}</option>
                            @endif
                        @endforeach
                    </select>
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
            const parentCategory = document.getElementById("parent-category");
            const categories = document.getElementById("categories");

            categoryForm.reset();

            if (mode === "edit") {
                const category = JSON.parse(button.getAttribute("data-category"));
                modalTitle.textContent = "Chỉnh sửa loại sản phẩm";
                categoryForm.action = `category/update/${category.id}`;
                categoryId.value = category.id;
                categoryName.value = category.name;
                const categoryIds = category.children ? category.children.map(child => child.id) : [];
                for (let option of categories.options) {
                    option.selected = categoryIds.includes(parseInt(option.value));
                    if (parseInt(option.value) === category.id) {
                        option.style.display = 'none';
                    } else {
                        option.style.display = 'block';
                    }
                }

                parentCategory.checked = category.parent_id === null;

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
                parentCategory.checked = false;
                for (let option of categories.options) {
                    option.selected = false;
                }
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
        const selectedCategories = [];
        const categories = document.getElementById("categories");
        const selectedOptions = [...categories.selectedOptions];
        selectedOptions.forEach(option => {
            selectedCategories.push(option.value);
        });
        formData.append('categories', selectedCategories);
        const url = categoryForm.action;
        const method = categoryForm.querySelector('input[name="_method"]') ? 'PUT' : 'POST';
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        });
        $.ajax({
            url: url,
            type: "POST",
            data: JSON.stringify(Object.fromEntries(formData.entries())),
            contentType: 'application/json',
            cache: false,
            processData: false,
            success: function(result) {
                const allCategories = result.allCategories;
                const categoriesSelect = document.getElementById('categories');
                categoriesSelect.innerHTML = '';
                allCategories.forEach(category => {
                    const option = document.createElement('option');
                    option.value = category.id;
                    option.textContent = category.name;
                    if (category.parent_id !== null) {
                        option.textContent += ` - ${category.parent.name}`;
                    }
                    categoriesSelect.appendChild(option);
                });
                $('#addCategoryModal').modal('hide');
                var content = `
                    <td class="px-6 py-4  border-bottom border-gray-200 overflow-auto max-w-sm text-sm ">
                        <div
                            class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                            ${result.newCategory.name}
                        </div>
                    </td>
                    <td
                        class="text-decoration-none px-6 py-4 text-sm leading-5 text-gray-500  border-bottom border-gray-200">
                        <div class="  d-flex justify-content-center align-items-center gap-2">
                            <form action="javascript:void(0)" enctype="multipart/form-data"
                                onsubmit="confirmation(event, ${result.newCategory.id})">
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
                                data-bs-toggle="modal" data-bs-target="#addCategoryModal" data-mode="edit"
                               data-category='${JSON.stringify(result.newCategory)}'>
                                Chỉnh sửa
                                <svg class="w-6 h-6  text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                `;

                var subCategoryContent = `
                <tr class="detail-${result.newCategory.id} collapse w-100">
                    <td colspan="2" class="w-100">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="p-3">Chi tiết thể loại</h5>
                            <button type="submit" form=""
                                class="p-2 m-3 border rounded-pill bg-red-400 text-white d-flex align-items-center justify-content-center gap-1">
                                Thêm loại
                                <svg class="w-6 h-6  text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </button>
                        </div>
                        <table class="min-w-100">
                            <thead>
                                <tr>
                                    <th
                                        class="px-6 py-3 text-xs fw-bolder text-left text-gray-500 text-uppercase border-top border-bottomottom border-gray-200 bg-gray-50">
                                        Tên loại sản phẩm
                                    </th>
                                    <th
                                        class="px-6 py-3 text-xs fw-bolder text-left text-gray-500 text-uppercase border-top border-bottomottom border-gray-200 bg-gray-50">
                                        Thao tác
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                ${result.subCategories ? result.subCategories.map(subCategory => `
                                    <tr data-category-id="${subCategory.id}" data-bs-toggle="collapse"
                                        data-bs-target=".detail-${subCategory.id}">
                                        <td
                                            class="px-6 py-4  border-bottom border-gray-200 overflow-auto max-w-sm text-sm ">
                                            <div
                                                class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                                                ${subCategory.name}
                                            </div>
                                        </td>
                                        <td
                                            class="text-decoration-none px-6 py-4 text-sm leading-5 text-gray-500  border-bottom border-gray-200">

                                            <div class="  d-flex justify-content-center align-items-center gap-2">
                                                <form action="javascript:void(0)" enctype="multipart/form-data"
                                                    onsubmit="confirmation(event, ${subCategory.id})">
                                                    <button type="submit"
                                                        class="text-decoration-none p-2 border rounded-pill fw-bolder bg-red-400 text-white d-flex align-items-center justify-content-center gap-1">
                                                        Xóa
                                                        <svg class="w-6 h-6  text-white" aria-hidden="true"
                                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            fill="none" viewBox="0 0 24 24">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                        </svg>
                                                    </button>
                                                </form>
                                                <button type="button"
                                                    class="text-decoration-none p-2 border rounded-pill fw-bolder bg-yellow-400 text-white d-flex align-items-center justify-content-center gap-1"
                                                    data-bs-toggle="modal" data-bs-target="#addCategoryModal"
                                                    data-mode="edit" data-category='${JSON.stringify(subCategory)}'>
                                                    Chỉnh sửa
                                                    <svg class="w-6 h-6  text-white" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                `).join(''): ''
                                }
                            </tbody>
                        </table>
                    </td>
                </tr>
                    `;
                if (method === 'PUT') {
                    const row = document.querySelector(
                        `tr[data-category-id="${result.newCategory.id}"]`);
                    if (row) {
                        row.innerHTML = content;
                        const nextRow = row.nextElementSibling;
                        result.subCategories.forEach(subCategory => {
                            const removeRow = document.querySelector(
                                `tr[data-category-id="${subCategory.id}"]`);
                            if (removeRow) {
                                removeRow.remove();
                                $('tr.detail-' + subCategory.id).remove();

                            }
                        });
                        if (nextRow && nextRow.classList.contains(
                                `detail-${result.newCategory.id}`)) {
                            nextRow.remove();
                        }
                        const newRow = document.createElement('tr');
                        newRow.classList.add('detail-' + result.newCategory.id);
                        newRow.classList.add('collapse');
                        newRow.classList.add('w-100');
                        newRow.innerHTML = subCategoryContent;
                        row.parentNode.insertBefore(newRow, row.nextSibling);
                    }
                } else if (method === 'POST') {
                    const newRow = document.createElement('tr');
                    newRow.setAttribute('data-bs-toggle', 'collapse');
                    newRow.setAttribute('data-category-id', result.newCategory.id);
                    newRow.setAttribute('data-bs-target', `.detail-${result.newCategory.id}`);
                    newRow.classList.add('w-100');
                    newRow.innerHTML = content;
                    document.querySelector('tbody').appendChild(newRow);
                    result.subCategories.forEach(subCategory => {
                        const removeRow = document.querySelector(
                            `tr[data-category-id="${subCategory.id}"]`);
                        if (removeRow) {
                            removeRow.remove();
                        }
                    });

                    const subRow = document.createElement('tr');
                    subRow.classList.add('detail-' + result.newCategory.id);
                    subRow.classList.add('collapse');
                    subRow.classList.add('w-100');
                    subRow.innerHTML = subCategoryContent;
                    document.querySelector('tbody').appendChild(subRow);
                };
                if (result.newCategory.parent_id) {
                    const parentCategoryRow = document.querySelector(
                        `tr[data-category-id="${result.newCategory.parent_id}"]`);
                    if (parentCategoryRow) {
                        const parentSubCategoryContent = `
                            <tr class="detail-${result.newCategory.parent_id} collapse w-100">
                                <td colspan="2" class="w-100">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="p-3">Chi tiết thể loại</h5>
                                        <button type="submit" form="" class="p-2 m-3 border rounded-pill bg-red-400 text-white d-flex align-items-center justify-content-center gap-1">
                                            Thêm loại
                                            <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                            </svg>
                                        </button>
                                    </div>
                                    <table class="min-w-100">
                                        <thead>
                                            <tr>
                                                <th class="px-6 py-3 text-xs fw-bolder text-left text-gray-500 text-uppercase border-top border-bottom border-gray-200 bg-gray-50">
                                                    Tên loại sản phẩm
                                                </th>
                                                <th class="px-6 py-3 text-xs fw-bolder text-left text-gray-500 text-uppercase border-top border-bottom border-gray-200 bg-gray-50">
                                                    Thao tác
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white">
                                            ${result.subCategories.map(subCategory => `
                                                <tr data-category-id="${subCategory.id}" data-bs-toggle="collapse" data-bs-target=".detail-${subCategory.id}">
                                                    <td class="px-6 py-4 border-bottom border-gray-200 overflow-auto max-w-sm text-sm">
                                                        <div class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                                                            ${subCategory.name}
                                                        </div>
                                                    </td>
                                                    <td class="text-decoration-none px-6 py-4 text-sm leading-5 text-gray-500 border-bottom border-gray-200">
                                                        <div class="d-flex justify-content-center align-items-center gap-2">
                                                            <form action="javascript:void(0)" enctype="multipart/form-data" onsubmit="confirmation(event, ${subCategory.id})">
                                                                <button type="submit" class="text-decoration-none p-2 border rounded-pill fw-bolder bg-red-400 text-white d-flex align-items-center justify-content-center gap-1">
                                                                    Xóa
                                                                    <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                                    </svg>
                                                                </button>
                                                            </form>
                                                            <button type="button" class="text-decoration-none p-2 border rounded-pill fw-bolder bg-yellow-400 text-white d-flex align-items-center justify-content-center gap-1" data-bs-toggle="modal" data-bs-target="#addCategoryModal" data-mode="edit" data-category='${JSON.stringify(subCategory)}'>
                                                                Chỉnh sửa
                                                                <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            `).join('')}
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        `;
                        const parentRow = parentCategoryRow.nextElementSibling;
                        if (parentRow && parentRow.classList.contains(
                                `detail-${result.newCategory.parent_id}`)) {
                            parentRow.remove();
                        }
                        const newParentRow = document.createElement('tr');
                        newParentRow.classList.add(`detail-${result.newCategory.parent_id}`);
                        newParentRow.classList.add('collapse');
                        newParentRow.classList.add('w-100');
                        newParentRow.innerHTML = parentSubCategoryContent;
                        parentCategoryRow.parentNode.insertBefore(newParentRow, parentCategoryRow
                            .nextSibling);
                    }
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
