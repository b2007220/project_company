<div class="container-fluid d-flex flex-column justify-content-center overflow-hidden py-3 bg-gray-100">
    <h2 class="fw-bold text-gray-900 d-flex justify-content-center text-uppercase">
        Sản phẩm
    </h2>
    <hr class="h-px my-3 bg-gray-200" />
    <div class="mx-auto container-fluid row gap-3">
        <div class="col-md-2 p-0 overflow-auto ">
            <ul class="list-group rounded border shadow-md ">
                <li class="list-group-item border-0 border-bottom border-dark border-2 rounded-0">
                    <nav class="navbar navbar-dark">
                        <div class="d-flex justify-content-between gap-3  align-items-center w-100">
                            <span class="fs-4 fw-bolder text-uppercase d-flex justify-content-between">Tìm
                                kiếm</span>
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                                data-bs-target="#searchProduct" aria-controls="searchProduct" aria-expanded="false"
                                aria-label="Toggle navigation">
                                <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M5 12h14m-7 7V5" />
                                </svg>
                            </button>
                        </div>
                    </nav>
                    <div class="collapse" id="searchProduct">
                        <div class="max-w-md mx-auto">
                            <div class="position-relative w-100">
                                <div class="position-absolute inset-y-0 start-0 d-flex align-items-center ps-3 pe-none">
                                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                    </svg>
                                </div>
                                <input type="text" id="search"
                                    class="d-block w-100 p-4 ps-10 small text-gray-900 border border-gray-300 rounded bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                                    required placeholder="Tên sản phẩm" />
                            </div>
                        </div>
                    </div>
                </li>
                <li
                    class="list-group-item d-block justify-content-between align-items-center border-0 border-bottom border-dark border-2 rounded-0">
                    <nav class="navbar navbar-dark">
                        <div class="d-flex justify-content-between  align-items-center w-100 gap-3">
                            <span class="fs-4 fw-bolder text-uppercase">Nhu cầu</span>
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                                data-bs-target="#productSort" aria-controls="productSort" aria-expanded="false"
                                aria-label="Toggle navigation">
                                <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M5 12h14m-7 7V5" />
                                </svg>
                            </button>
                        </div>
                    </nav>
                    <div class="collapse" id="productSort">
                        <button id="sort-new"
                            class="list-group-item list-group-item-action border-0 rounded p-2 mb-2 fs-5 text-uppercase bg-primary-hover">
                            Sản phẩm mới
                        </button>
                        <button id="sort-discount"
                            class="list-group-item list-group-item-action border-0 rounded p-2 mb-2 fs-5 text-uppercase bg-primary-hover">
                            Giảm giá
                            </a>
                            <button id="sort-priceAsc"
                                class="list-group-item list-group-item-action border-0 rounded p-2 mb-2 fs-5 text-uppercase bg-primary-hover">
                                Tăng dần
                            </button>
                            <button id="sort-priceDesc"
                                class="list-group-item list-group-item-action border-0 rounded p-2 mb-2 fs-5 text-uppercase bg-primary-hover">
                                Giảm dần
                            </button>
                    </div>
                </li>
                <li
                    class="list-group-item d-block justify-content-between align-items-center border-0 border-bottom border-dark border-2 rounded-0">
                    <nav class="navbar navbar-dark">
                        <div class="d-flex justify-content-between align-items-center gap-3 w-100">
                            <span class="fs-4 fw-bolder text-uppercase">loại mặt hàng</span>
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                                data-bs-target="#productType" aria-controls="productType" aria-expanded="false"
                                aria-label="Toggle navigation">
                                <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M5 12h14m-7 7V5" />
                                </svg>
                            </button>
                        </div>
                    </nav>
                    <div class="collapse" id="productType">
                        <div class="list-group">
                            <div id="category-pagination">
                                @include('home.content.category-pagination')
                            </div>
                        </div>
                    </div>
                </li>



            </ul>
        </div>
        <div id="item-lists" class="row gap-6 col-md-10 col-12 py-3">
            @include('home.content.category-data')
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#search').on('keyup', function(event) {
            event.preventDefault();
            let value = $(this).val();
            $.ajax({
                url: "{{ route('category') }}",
                type: "GET",
                data: {
                    search: value
                },
                success: function(data) {
                    $('#item-lists').html(data);
                }
            });
        });
        let currentSort = '';

        let currentCategory = '';

        $("#sort-new, #sort-discount, #sort-priceAsc, #sort-priceDesc").click(function(event) {
            event.preventDefault();
            currentSort = $(this).attr('id').split('-')[1];
            fetchProducts();
        });
        $(document).on('click', '.carousel-button', function(event) {
            event.preventDefault();
            currentCategory = $(this).val();
            fetchProducts();
        });

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

        function fetchProducts() {
            $.ajax({
                url: "{{ route('category') }}",
                type: "GET",
                data: {
                    sort: currentSort,
                    category: currentCategory
                },
                success: function(data) {
                    $('#item-lists').html(data);
                }
            });
        }

        // function fetchCategories(categoryPage = 1) {
        //     $.ajax({
        //         url: "{{ route('categories') }}",
        //         type: "GET",
        //         data: {
        //             page: categoryPage
        //         },
        //         success: function(data) {
        //             $('#category-pagination').html(data);
        //         },
        //         error: function() {
        //             swal({
        //                 title: 'Lỗi!',
        //                 text: 'Có lỗi xảy ra. Vui lòng thử lại.',
        //                 icon: 'error',
        //                 button: 'Đã hiểu',
        //                 timer: 1000
        //             });
        //         }
        //     });
        // }

        // fetchCategories();
    });
</script>
