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
                <form class="mb-3" id="categoryForm" method="POST">
                    @csrf

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
            } else {
                modalTitle.textContent = "Thêm mới loại sản phẩm";
                categoryForm.action = `category/add`;
                categoryId.value = "";
                categoryName.value = "";
            }
        });
    });
</script>
