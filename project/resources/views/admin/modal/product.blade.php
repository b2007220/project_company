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
                <form id="productForm" method="POST">
                    @csrf
                    <input type="hidden" id="productId" name="id" value="" />
                    <label for="productName" class="my-2">Tên sản phẩm</label>
                    <input type="text" class="form-control" id="productName" name="name"
                        placeholder="Nhập tên sản phẩm" required />
                    <label for="productDescription" class="my-2">Mô tả</label>
                    <textarea class="form-control" id="productDescription" name="description" placeholder="Nhập mô tả" required></textarea>
                    <label for="categories" class="my-2">Loại sản phẩm</label>
                    <select name="categories[]" id="categories" multiple class="form-select max-w-100 overflow-auto">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <label for="productPrice" class="my-2">Giá</label>
                    <input type="number" class="form-control" id="productPrice" name="price" placeholder="Nhập giá"
                        required />
                    <label for="productQuantity" class="my-2">Số lượng</label>
                    <input type="number" class="form-control" id="productQuantity" name="amount"
                        placeholder="Nhập số lượng" required />
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" form="productForm"
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
        const addProductModal = document.getElementById("addProductModal");
        addProductModal.addEventListener("show.bs.modal", function(event) {
            const button = event.relatedTarget;
            const mode = button.getAttribute("data-mode");
            const modalTitle = document.getElementById("modalTitle");
            const productForm = document.getElementById("productForm");
            const productId = document.getElementById("productId");
            const productName = document.getElementById("productName");
            const productDescription = document.getElementById("productDescription");
            const productPrice = document.getElementById("productPrice");
            const productQuantity = document.getElementById("productQuantity");

            productForm.reset();
            if (mode === "edit") {
                const product = JSON.parse(button.getAttribute("data-product"));
                modalTitle.textContent = "Chỉnh sửa sản phẩm";
                productForm.action = `product/update/${product.id}`;
                productId.value = product.id;
                productName.value = product.name;
                productDescription.value = product.description;
                productPrice.value = product.price;
                productQuantity.value = product.amount;
                
            } else {
                modalTitle.textContent = "Thêm mới sản phẩm";
                productForm.action = `product/add`;
                productId.value = "";
                productName.value = "";
                productDescription.value = "";
                productPrice.value = "";
                productQuantity.value = "";
            }
        });
    });
</script>
