<div class="col bg-gray-200">
    <div class="d-flex flex-column mt-8">
        <div class="py-2 -my-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
            <div
                class="d-inline-block min-w-100 overflow-hidden align-items-middle border border-gray-200 shadow rounded bg-white ">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="p-3">Quản lý loại sản phẩm</h4>
                    <button
                        class="p-2 m-3 border rounded-pill bg-blue-300 text-white d-flex align-items-center justify-content-center gap-1 text-decoration-none"
                        data-bs-toggle="modal" data-bs-target="#addCategoryModal" data-mode="create">
                        Thêm mới
                        <svg class="w-6 h-6  text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </button>
                </div>
                <div id="item-lists">
                    @include('admin.content.category-data')
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
                    cache: false,
                })
                .done(function(data) {
                    $("#item-lists").empty().html(data);
                    location.hash = page;
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    alert('No response from server');
                });
        }
    });

    function confirmation(event, id) {
        event.preventDefault();
        const url = 'category/delete/' + id;

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
                    cache: false,
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

                        swal("Dữ liệu đã được xóa!", {
                            icon: "success",
                            timer: 1000,
                        });
                        $('tr[data-category-id="' + id + '"]').remove();
                        $('tr.detail-' + id).remove();
                    }
                })
            }
        });
    }
</script>
