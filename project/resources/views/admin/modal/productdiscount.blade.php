<div class="modal fade" id="addProductDiscountModal" tabindex="-1" aria-labelledby="addProductDiscountModal">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 512px">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle2" class="modal-title fs-5 text-xl fw-bolder text-gray-900">
                    Thêm mới loại giảm giá mới
                </h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="mb-3" id="productDiscountForm" method="POST"
                    action="{{ route('admin.product.discount-add') }}">
                    @csrf
                    <input type="hidden" name="productId" id="productId">
                    <select name="discount_ids[]" id="discount" multiple class="form-select max-w-100 overflow-auto">
                        @foreach ($discounts as $discount)
                            <option value="{{ $discount->id }}">{{ $discount->name }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" form="productDiscountForm"
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
        const addProductDiscountModal = document.getElementById("addProductDiscountModal");
        addProductDiscountModal.addEventListener("show.bs.modal", function(event) {
            const button = event.relatedTarget;
            const addProductDiscountModal = document.getElementById("addProductDiscountModal");
            const productId = document.getElementById("productId");
            // const status = document.getElementById("status");
            productDiscountForm.reset();
            const product = JSON.parse(button.getAttribute("data-product"));
            productDiscountForm.action = `product/add-discount`;
            productId.value = product.id;
            // discount_ids.value = product.discount_ids;
        });
    });
</script>
