{{-- <div class="modal fade" id="addProductDiscountModal" tabindex="-1" aria-labelledby="addProductDiscountModal">
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
    document.addEventListener("DOMContentLoaded", function() {
        const addProductDiscountModal = document.getElementById("addProductDiscountModal");
        addProductDiscountModal.addEventListener("show.bs.modal", function(event) {
            const button = event.relatedTarget;
            const productDiscountForm = document.getElementById("productDiscountForm");
            const productId = document.getElementById("productId");

            productDiscountForm.reset();

            const product = JSON.parse(button.getAttribute("data-product"));
            productDiscountForm.action = `/add-discount`;


            let methodInput = accountForm.querySelector('input[name="_method"]');
            if (!methodInput) {
                methodInput = document.createElement('input');
                methodInput.setAttribute('type', 'hidden');
                methodInput.setAttribute('name', '_method');
                accountForm.appendChild(methodInput);
            }
            methodInput.value = 'POST';
        });
    });

    document.getElementById("productDiscountForm").addEventListener("submit", function(event) {
        event.preventDefault();
        const productDiscountForm = event.target;
        const formData = new FormData(productDiscountForm);
        const url = productDiscountForm.action;
        const method = productDiscountForm.querySelector('input[name="_method"]') ? 'PUT' : 'POST';
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
                $('#addProductDiscountModal').modal('hide');
                if (method === 'PUT') {
                    const row = document.querySelector(
                        `tr[data-category-id="${result.category.id}"]`);
                    if (row) {
                        row.querySelector('td div').textContent = result.category.name;
                    }
                    swal({
                        title: 'Thành công!',
                        text: result.message,
                        icon: 'success',
                        button: 'OK'
                    });
                } else if (method === 'POST') {
                    const newRow = document.createElement('tr');
                    newRow.setAttribute('data-discount-id', result.category.id);
                    newRow.innerHTML = `
                                            <td
                            class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm leading-5 text-gray-500 ">
                            <div class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">

                                {{ $discount->code }}
                            </div>
                        </td>
                        <td
                            class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm leading-5 text-gray-500 ">
                            <div class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">

                                {{ $discount->name }}
                            </div>

                        </td>
                        <td
                            class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm leading-5 text-gray-500 ">
                            <div class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">

                                {{ $discount->discount }}
                            </div>

                        </td>
                        <td
                            class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm leading-5 text-gray-500 ">
                            <div class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">

                                {{ number_format($discount->amount, 0, ',', '.') }}</div>
                            </div>


                        </td>
                        <td
                            class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm leading-5 text-gray-500 ">
                            <div class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                                {{ date('d-m-Y', strtotime($discount->expired_at)) }}
                            </div>

                        </td>

                        <td
                            class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm leading-5 text-gray-500 ">
                            <div class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                                @if ($discount->pivot->is_predefined)
                                    <span class="text-success">Áp dụng trực tiếp</span>
                                @else
                                    <span class="text-danger">Chưa áp dụng</span>
                                @endif
                            </div>

                        </td>
                        <td class="px-6 py-4 text-sm leading-5 text-gray-500 whitespace-no-wrap border-bottom border-gray-200 d">
                            <div class="d-flex justify-content-center align-items-center gap-2">
                                <form action="{{ route('admin.product.discount-remove', [$product->id, $discount->id]) }}" method="POST"
                                    onsubmit="return confirmation(event, this)">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-decoration-none p-2 border rounded-pill fw-bolder bg-red-400 text-white d-flex align-items-center justify-content-center gap-1">
                                        Xóa
                                        <svg class="w-6 h-6  text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>
                                    </button>
                                </form>
                                <form action="{{ route('admin.product.update-predefine', [$product->id, $discount->id]) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <button type="submit"
                                        class=" p-2 border rounded-pill bg-green-300 text-white d-flex align-items-center justify-content-center gap-1">
                                        Áp dụng
                                        <svg class="w-6 h-6  text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>`;
                    document.querySelector('tbody').appendChild(newRow);
                    swal({
                        title: 'Thành công!',
                        text: result.message,
                        icon: 'success',
                        button: 'OK',
                        timer: 1000
                    });
                }

            },
            error: function(xhr) {
                const errors = xhr.responseJSON.errors;
                if (errors) {
                    for (const [key, value] of Object.entries(errors)) {
                        console.log(key, value);
                    }
                }
            }
        });
    });
    $('#discount').select2({
        theme: "bootstrap-5",
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
        closeOnSelect: false,
    });
</script> --}}
