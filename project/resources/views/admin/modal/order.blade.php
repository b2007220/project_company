<div class="modal fade" id="updateOrderModal" tabindex="-1" aria-labelledby="updateOrderModal">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 512px">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle2" class="modal-title fs-5 text-xl fw-bolder text-gray-900">
                    Điều chỉnh trạng thái đơn hàng
                </h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="mb-3" id="updateOrderForm" method="POST"
                    action="{{ route('admin.order.update-type') }}">
                    @csrf
                    <input type="hidden" name="orderId" id="orderId">
                    <select name="status" id="status" class="form-select max-w-100 overflow-auto">
                        <option value="PENDING">Đang chờ xử lý</option>
                        <option value="DELIVERING">Đang giao hàng</option>
                        <option value="CANCEL">Đã hủy</option>
                        <option value="DELIVERED">Đã giao</option>
                        <option value="UNACCEPTED">Đã từ chối</option>
                    </select>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" form="updateOrderForm"
                    class="p-2 m-3 border rounded-pill bg-blue-300 text-white d-flex align-items-center justify-content-center gap-1">
                    Điều chỉnh
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
    $('#updateOrderModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var orderId = button.data('order-id');
        var modal = $(this);
        modal.find('#orderId').val(orderId);
        console.log(orderId);
    });
</script>
