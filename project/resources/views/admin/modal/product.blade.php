<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 512px">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle" class="modal-title fs-5 text-xl fw-bolder text-gray-900">
                    Thêm mới sản phẩm
                </h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="productForm" method="POST" class="mb-3">
                    @csrf
                    <input type="hidden" id="productId" name="id">
                    <label for="productName" class="form-label">Tên sản phẩm</label>
                    <input type="text" class="form-control" id="productName" name="name" required
                        placeholder="Nhập tên sản phẩm" />
                    <label for="productDescribe" class="form-label">Mô tả</label>
                    <textarea class="form-control" id="productDescribe" name="description" rows="3" placeholder="Nhập mô tả" required></textarea>
                    <label for="categories" class="form-label">Loại</label>
                    <select name="categories[]" id="categories" multiple class="form-select max-w-100 overflow-auto">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <label for="productPrice" class="form-label">Giá tiền</label>
                    <input type="number" class="form-control" id="productPrice" name="price" required
                        placeholder="Nhập giá tiền sản phẩm" min="0" />
                    <label for="productAmount" class="form-label">Số lượng</label>
                    <input type="number" class="form-control" id="productAmount" name="amount" required
                        placeholder="Nhập số lượng sản phẩm" min="0" />
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" form="productForm"
                    class="p-2 m-3 border rounded-pill bg-blue-300 text-white d-flex align-items-center justify-content-center gap-1">
                    Lưu
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const addProductModal = document.getElementById("addProductModal");
        addProductModal.addEventListener("show.bs.modal", function(event) {
            const button = event.relatedTarget;
            const mode = button.getAttribute("data-mode");
            const modalTitle = document.getElementById("modalTitle");
            const productForm = document.getElementById("productForm");
            const productId = document.getElementById("productId");
            const productName = document.getElementById("productName");
            const productAmount = document.getElementById("productAmount");
            const productPrice = document.getElementById("productPrice");
            const productDescribe = document.getElementById("productDescribe");
            const categories = document.getElementById("categories");

            Array.from(categories.options).forEach(option => option.selected = false);
            if (mode === "edit") {
                const product = JSON.parse(button.getAttribute("data-product"));
                modalTitle.textContent = "Chỉnh sửa sản phẩm";
                productForm.action = `product/update/${product.id}`;
                productId.value = product.id;
                productName.value = product.name;
                productPrice.value = product.price;
                productAmount.value = product.amount;
                productDescribe.value = product.description;

                product.categories.forEach(category => {
                    const option = Array.from(categories.options).find(option => option.value ==
                        category.id);
                    if (option) {
                        option.selected = true;
                    }
                });
            } else {
                modalTitle.textContent = "Thêm mới sản phẩm";
                productForm.action = `product/add`;
                productId.value = "";
                productName.value = "";
                productPrice.value = "";
                productAmount.value = "";
                productDescribe.value = "";
            }
        });
    });
</script>
