<div class="modal fade" id="addProductDiscountModal" tabindex="-1" aria-labelledby="addProductDiscountModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollabll" style="max-width: 512px">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle" class="modal-title fs-5 text-xl fw-bolder text-gray-900">
                    Thêm mới loại giảm giá mới
                </h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="mb-3" id="productForm" method="POST">
                    @csrf
                    <input type="hidden" id="productId" name="id" value="" />
                    <label for="productName" class="form-label">Tên loại giảm giá</label>
                    <input type="text" class="form-control" id="productName" name="name"
                        placeholder="Nhập tên loại giảm giá" />

                    <label for="productProduct" class="form-label">Phần trăm giảm giá</label>
                    <input type="number" class="form-control" id="productProduct" name="product"
                        placeholder="Nhập phần trăm giảm giá" min="0" max="100" />
                    <label for="productAmount" class="form-label">Số lượng áp dụng</label>
                    <input type="number" class="form-control" id="productAmount" name="amount"
                        placeholder="Nhập số lượng" min="1" />
                    <label for="productExpired" class="form-label">Thời gian hết hạn</label>
                    <input type="date" class="form-control" id="productExpired" name="expire" />
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" form="productForm"
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

