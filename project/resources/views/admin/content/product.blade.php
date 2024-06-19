<div class="col bg-gray-200">
    <div class="d-flex flex-column mt-8">
        <div class="py-2 -my-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
            <div
                class="d-inline-block min-w-100 overflow-hidden align-items-middle border border-gray-200 shadow rounded bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="p-3">Quản lý sản phẩm</h4>
                    <button
                        class="p-2 m-3 border rounded-pill bg-blue-300 text-white d-flex align-items-center justify-content-center gap-1 text-decoration-none"
                        data-bs-toggle="modal" data-bs-target="#addProductModal" data-mode="create">
                        Thêm mới
                        <svg class="w-6 h-6  text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </button>
                </div>
                <div id="item-lists">
                    @include('admin.content.product-data')
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $(window).on('hashchange', function() {
            if (window.location.hash) {
                var page = window.location.hash.replace('#', '');
                if (page == Number.NaN || page <= 0) {
                    return false;
                } else {
                    getData(page);
                }
            }
        });

        $(document).on('click', '.pagination a', function(event) {
            $('li').removeClass('active');
            $(this).parent('li').addClass('active');
            event.preventDefault();

            var myurl = $(this).attr('href');
            var page = $(this).attr('href').split('page=')[1];

            getData(page);
        });

        function getData(page) {
            $.ajax({
                    url: '?page=' + page,
                    type: "get",
                    datatype: "html",
                })
                .done(function(data) {
                    $("#item-lists").empty().html(data);
                    location.hash = page;
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    swal({
                        title: 'Lỗi!',
                        text: result.message,
                        icon: 'error',
                        button: 'Đã hiểu',
                        timer: 1000
                    });
                });
        }
    });

    function confirmation(event, id) {
        event.preventDefault();
        const url = 'product/delete/' + id;

        swal({
            title: "Bạn có chắc chắn muốn xóa?",
            text: "Sau khi xóa, bạn sẽ không thể khôi phục dữ liệu!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }
                });
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    contentType: 'application/json',
                    success: function(result) {
                        swal("Dữ liệu đã được xóa!", {
                            icon: "success",
                            timer: 1000,
                        });
                        $('tr[data-product-id="' + id + '"]').remove();
                        $('tr.detail-' + id).remove();
                    }
                })
            }
        });
    }



    function updateProductPrice(productId) {
        const url = `product/${productId}/discounted-price`;
        $.ajax({
            url: url,
            type: 'GET',
            success: function(result) {
                const priceDiv = document.querySelector(
                    `tr[data-product-id="${productId}"] .product-price`);
                if (priceDiv) {
                    priceDiv.innerHTML = `${result.discounted_price.toLocaleString('en-US')} đ`;
                }
            },
            error: function(xhr) {
                console.error("Error updating product price", xhr);
            }
        });
    }

    function removeDiscount(event, productId, discountId, pivotId) {
        event.preventDefault();
        const url = `product/remove-discount/product/${productId}/discount/${discountId}`;
        swal({
            title: "Bạn có chắc chắn muốn xóa?",
            text: "Sau khi xóa, bạn sẽ không thể khôi phục dữ liệu!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                            'content'),
                        'Content-Type': 'application/json'
                    }
                });
                $.ajax({
                    url: url,
                    type: 'DELETE',

                    success: function(result) {
                        updateProductPrice(productId);
                        const row = document.querySelector(
                            `tr[data-pivot-id="${pivotId}"]`);
                        if (row) {
                            row.remove();
                        }
                        swal("Dữ liệu đã được xóa!", {
                            icon: "success",
                            timer: 1000,
                        });
                    },
                    error: function(xhr) {
                        const errors = xhr.responseJSON.errors;
                        if (errors) {
                            for (const [key, value] of Object.entries(
                                    errors)) {
                                console.log(key, value);
                            }
                        }
                    }
                })
            }
        });
    }

    function apply(event, productId, discountId, pivotId) {
        event.preventDefault();
        const url = `product/update-predefine/product/${productId}/discount/${discountId}`;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                    'content'),
                'Content-Type': 'application/json'
            }
        });
        $.ajax({
            url: url,
            type: 'PUT',

            success: function(result) {
                updateProductPrice(productId);
                const row = document.querySelector(
                    `tr[data-pivot-id="${pivotId}"]`);
                if (row) {
                    row.innerHTML = `
                        <td
                            class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm leading-5 text-gray-500 ">
                            <div class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">

                            ${result.discount.code}
                            </div>
                        </td>
                        <td
                            class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm leading-5 text-gray-500 ">
                            <div class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">

                            ${result.discount.name}
                            </div>

                        </td>
                        <td
                            class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm leading-5 text-gray-500 ">
                            <div class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">

                                ${result.discount.discount} %
                            </div>

                        </td>
                        <td
                            class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm leading-5 text-gray-500 ">
                            <div class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">

                                ${Number(result.discount.amount).toLocaleString('de-DE')}
                            </div>


                        </td>
                        <td
                            class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm leading-5 text-gray-500 ">
                            <div class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                                ${result.discount.expired_at ? new Date(result.discount.expired_at).toLocaleDateString('en-GB') :  new Date().toLocaleDateString('en-GB')}
                            </div>

                        </td>

                        <td
                            class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm leading-5 text-gray-500 ">
                            <div class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                                ${result.is_predefined ? ' <span class="text-success">Áp dụng trực tiếp</span>' : '<span class="text-danger">Chưa áp dụng</span>'}
                            </div>

                        </td>
                        <td class="px-6 py-4 text-sm leading-5 text-gray-500 whitespace-no-wrap border-bottom border-gray-200 d">
                            <div class="d-flex justify-content-center align-items-center gap-2">
                                <form action="javascript:void(0)" enctype="multipart/form-data" id="removeDiscountForm-${result.pivot_id}"
                            onsubmit="removeDiscount(event, ${productId},${result.discount.id}, ${result.pivot_id})">
                                    <button type="submit" form="removeDiscountForm-${result.pivot_id}"
                                        class="text-decoration-none p-2 border rounded-pill fw-bolder bg-red-400 text-white d-flex align-items-center justify-content-center gap-1">
                                        Xóa
                                        <svg class="w-6 h-6  text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>
                                    </button>
                                </form>
                                <form  action="javascript:void(0)" enctype="multipart/form-data" id="applyDiscountForm-${result.pivot_id}"
                            onsubmit="apply(event,${productId}, ${result.discount.id}, ${result.pivot_id})">
                                    <button type="submit" form="applyDiscountForm-${result.pivot_id}"
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
                };
                swal("Dữ liệu đã được xóa!", {
                    icon: "success",
                    timer: 1000,
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
        })
    }
    const selectedPictures = new Set();

    function setupPictureItemEvents() {
        document.querySelectorAll('.picture-item').forEach(item => {
            item.addEventListener('click', function() {
                const pictureId = this.getAttribute('data-id');
                if (selectedPictures.has(pictureId)) {
                    selectedPictures.delete(pictureId);
                    this.classList.remove('selected');
                } else {
                    selectedPictures.add(pictureId);
                    this.classList.add('selected');
                }
            });
        });
    }
    document.addEventListener('DOMContentLoaded', function() {
        setupPictureItemEvents();
        document.querySelector('#deletePictureForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const productId = document.querySelector('#deletePictureForm').getAttribute(
                'data-select-product');
            const inputHidden = document.getElementById('selected_pictures');
            inputHidden.value = JSON.stringify(Array.from(selectedPictures));
            deleteImages(event, productId);
        });
    });

    function deleteImages(event, id) {
        event.preventDefault();
        const url = `product/${id}/pictures/delete`;
        const form = document.getElementById('deletePictureForm');
        const formData = new FormData(form);
        console.log(Object.fromEntries(formData.entries()));

        swal({
            title: "Bạn có chắc chắn muốn xóa?",
            text: "Sau khi xóa, bạn sẽ không thể khôi phục dữ liệu!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Content-Type': 'application/json'
                    }
                });
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: JSON.stringify(Object.fromEntries(formData.entries())),
                    success: function(result) {
                        selectedPictures.clear();

                        const inputHidden = document.getElementById('selected_pictures');
                        inputHidden.value = JSON.stringify(Array.from(selectedPictures));

                        const pictures = document.querySelectorAll('.picture-item.selected');
                        pictures.forEach(picture => {
                            picture.remove();
                        });
                        swal("Dữ liệu đã được xóa!", {
                            icon: "success",
                            timer: 1000,
                        });

                    }
                });
            }
        });
    }
</script>
