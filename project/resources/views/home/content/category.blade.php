<div class="container-fluid d-flex flex-column justify-content-center overflow-hidden py-3 bg-gray-100">
    <h2 class="fw-bold text-gray-900 d-flex justify-content-center text-uppercase">
        Sản phẩm
    </h2>
    <hr class="h-px my-3 bg-gray-200" />
    <div class="mx-auto container-fluid row gap-3">
        <div class="col-md-2 p-0">
            <ul class="list-group">
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
                        <form class="max-w-md mx-auto">
                            <div class="position-relative w-100">
                                <div class="position-absolute inset-y-0 start-0 d-flex align-items-center ps-3 pe-none">
                                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                    </svg>
                                </div>
                                <input type="search" id="default-search"
                                    class="d-block w-100 p-4 ps-10 small text-gray-900 border border-gray-300 rounded bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                                    required placeholder="Tên sản phẩm" onkeyup="productSearch()" />
                            </div>
                        </form>
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
                        <div class="p-3">
                            <div class="list-group">
                                <a href="#"
                                    class="list-group-item list-group-item-action border-0 rounded p-2 mb-2 fs-5 text-uppercase bg-primary-hover">
                                    Quần áo
                                </a>
                                <a href="#"
                                    class="list-group-item list-group-item-action border-0 rounded p-2 mb-2 fs-5 text-uppercase bg-primary-hover">Trang
                                    sức</a>
                                <a href="#"
                                    class="list-group-item list-group-item-action border-0 rounded p-2 mb-2 fs-5 text-uppercase bg-primary-hover">Phụ
                                    kiện</a>
                                <a href="#"
                                    class="list-group-item list-group-item-action border-0 rounded p-2 mb-2 fs-5 text-uppercase bg-primary-hover">khác</a>
                            </div>
                        </div>
                    </div>
                </li>

                <li
                    class="list-group-item d-block justify-content-between align-items-center border-0 border-bottom border-dark border-2 rounded-0">
                    <nav class="navbar navbar-dark">
                        <div class="d-flex justify-content-between gap-3  align-items-center w-100">
                            <span class="fs-4 fw-bolder text-uppercase">Giá tiền</span>
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                                data-bs-target="#productPrice" aria-controls="productPrice" aria-expanded="false"
                                aria-label="Toggle navigation">
                                <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M5 12h14m-7 7V5" />
                                </svg>
                            </button>
                        </div>
                    </nav>
                    <div class="collapse" id="productPrice">
                        <div class="position-relative mb-5">
                            <input id="labels-range-input" type="range" value="1000" min="100"
                                max="1500" class="w-100 h-2 bg-gray-200 rounded appearance-none cursor-pointer" />
                            <span class="fs-6 text-gray-500 position-absolute start-0 -bottom-6">$100</span>
                            <span
                                class="fs-6 text-gray-500 position-absolute start-13 -translate-x-1/2 -bottom-6">$500</span>
                            <span
                                class="fs-6 text-gray-500 position-absolute start-23 -translate-x-1/2 -bottom-6">$1000</span>
                            <span class="fs-6 text-gray-500 position-absolute end-0 -bottom-6">$1500</span>
                        </div>
                    </div>
                </li>
                <li
                    class="list-group-item d-block justify-content-between align-items-center border-0 border-bottom border-dark border-2 rounded-0">
                    <nav class="navbar navbar-dark">
                        <div class="d-flex justify-content-between  align-items-center w-100 gap-3">
                            <span class="fs-4 fw-bolder text-uppercase">Nhu cầu</span>
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                                data-bs-target="#productSale" aria-controls="productSale" aria-expanded="false"
                                aria-label="Toggle navigation">
                                <svg class="w-6 h-6 text-gray-800" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M5 12h14m-7 7V5" />
                                </svg>
                            </button>
                        </div>
                    </nav>
                    <div class="collapse" id="productSale">
                        <div class="d-flex align-items-center mb-4">
                            <input id="default-checkbox" type="checkbox" value=""
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2 dark:bg-gray-700" />
                            <label for="default-checkbox"
                                class="ms-2 fs-5 font-medium text-gray-900 dark:text-gray-300">Sản phẩm
                                mới</label>
                        </div>
                        <div class="d-flex align-items-center">
                            <input checked id="checked-checkbox" type="checkbox" value=""
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 focus:ring-2" />
                            <label for="checked-checkbox"
                                class="ms-2 fs-5 fw-medium text-gray-900 dark:text-gray-300">Giảm giá</label>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="row gap-6 col-md-10 col-12 py-3">
            <div
                class="product px-0 col-sm-3 col-xl-4 position-relative d-flex flex-column shadow-md rounded-3 overflow-hidden shadow-lg-hover hover:-translate-y-1 transition-all duration-300 max-w-sm">
                <a href="" class="position-absolute z-3 top-2 right-0 mt-2 me-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6 text-orange-600">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                    </svg>
                </a>
                <a href="product.html" class="z-2 position-absolute h-100 w-100 top-0 left-0">&nbsp;</a>
                <div class="h-auto overflow-hidden">
                    <div class="h-44 overflow-hidden position-relative">
                        <img src="https://picsum.photos/400/400" alt="" class="max-w-full h-auto d-block" />
                    </div>
                </div>
                <div class="bg-white py-4 px-3">
                    <h3 class="product-name text-xl mb-2 font-medium truncate" name="product-name">
                        Adele
                    </h3>
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="text-md text-gray-400">
                            Giá tiền:
                            <strong class="fw-semibold text-gray-900 text-lg">$xx</strong>
                        </p>
                        <div class="position-relative z-3 d-flex align-items-center gap-2">
                            <a href="product.html"
                                class="text-white bg-red-700 fw-bold rounded-pill text-sm px-3 py-2 text-center me-2 mb-2 text-decoration-none">
                                Xem thêm
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="product px-0 col-sm-3 col-xl-4 position-relative d-flex flex-column shadow-md rounded-3 overflow-hidden shadow-lg-hover hover:-translate-y-1 transition-all duration-300 max-w-sm">
                <a href="" class="position-absolute z-3 top-2 right-0 mt-2 me-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6 text-orange-600">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                    </svg>
                </a>
                <a href="product.html" class="z-2 position-absolute h-100 w-100 top-0 left-0">&nbsp;</a>
                <div class="h-auto overflow-hidden">
                    <div class="h-44 overflow-hidden position-relative">
                        <img src="https://picsum.photos/400/400" alt="" class="max-w-full h-auto d-block" />
                    </div>
                </div>
                <div class="bg-white py-4 px-3">
                    <h3 class="product-name text-xl mb-2 font-medium truncate" name="product-name">
                        Agnes
                    </h3>
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="text-md text-gray-400">
                            Giá tiền:
                            <strong class="fw-semibold text-gray-900 text-lg">$xx</strong>
                        </p>
                        <div class="position-relative z-3 d-flex align-items-center gap-2">
                            <a href="product.html"
                                class="text-white bg-red-700 fw-bold rounded-pill text-sm px-3 py-2 text-center me-2 mb-2 text-decoration-none">
                                Xem thêm
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="product px-0 col-sm-3 col-xl-4 position-relative d-flex flex-column shadow-md rounded-3 overflow-hidden shadow-lg-hover hover:-translate-y-1 transition-all duration-300 max-w-sm">
                <a href="" class="position-absolute z-3 top-2 right-0 mt-2 me-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6 text-orange-600">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                    </svg>
                </a>
                <a href="product.html" class="z-2 position-absolute h-100 w-100 top-0 left-0">&nbsp;</a>
                <div class="h-auto overflow-hidden">
                    <div class="h-44 overflow-hidden position-relative">
                        <img src="https://picsum.photos/400/400" alt="" class="max-w-full h-auto d-block" />
                    </div>
                </div>
                <div class="bg-white py-4 px-3">
                    <h3 class="product-name text-xl mb-2 font-medium truncate" name="product-name">
                        Billy
                    </h3>
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="text-md text-gray-400">
                            Giá tiền:
                            <strong class="fw-semibold text-gray-900 text-lg">$xx</strong>
                        </p>
                        <div class="position-relative z-3 d-flex align-items-center gap-2">
                            <a href="product.html"
                                class="text-white bg-red-700 fw-bold rounded-pill text-sm px-3 py-2 text-center me-2 mb-2 text-decoration-none">
                                Xem thêm
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="product px-0 col-sm-3 col-xl-4 position-relative d-flex flex-column shadow-md rounded-3 overflow-hidden shadow-lg-hover hover:-translate-y-1 transition-all duration-300 max-w-sm">
                <a href="" class="position-absolute z-3 top-2 right-0 mt-2 me-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6 text-orange-600">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                    </svg>
                </a>
                <a href="product.html" class="z-2 position-absolute h-100 w-100 top-0 left-0">&nbsp;</a>
                <div class="h-auto overflow-hidden">
                    <div class="h-44 overflow-hidden position-relative">
                        <img src="https://picsum.photos/400/400" alt="" class="max-w-full h-auto d-block" />
                    </div>
                </div>
                <div class="bg-white py-4 px-3">
                    <h3 class="product-name text-xl mb-2 font-medium truncate" name="product-name">
                        Bob
                    </h3>
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="text-md text-gray-400">
                            Giá tiền:
                            <strong class="fw-semibold text-gray-900 text-lg">$xx</strong>
                        </p>
                        <div class="position-relative z-3 d-flex align-items-center gap-2">
                            <a href="product.html"
                                class="text-white bg-red-700 fw-bold rounded-pill text-sm px-3 py-2 text-center me-2 mb-2 text-decoration-none">
                                Xem thêm
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="product px-0 col-sm-3 col-xl-4 position-relative d-flex flex-column shadow-md rounded-3 overflow-hidden shadow-lg-hover hover:-translate-y-1 transition-all duration-300 max-w-sm">
                <a href="" class="position-absolute z-3 top-2 right-0 mt-2 me-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6 text-orange-600">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                    </svg>
                </a>
                <a href="product.html" class="z-2 position-absolute h-100 w-100 top-0 left-0">&nbsp;</a>
                <div class="h-auto overflow-hidden">
                    <div class="h-44 overflow-hidden position-relative">
                        <img src="https://picsum.photos/400/400" alt="" class="max-w-full h-auto d-block" />
                    </div>
                </div>
                <div class="bg-white py-4 px-3">
                    <h3 class="product-name text-xl mb-2 font-medium truncate" name="product-name">
                        Calvin
                    </h3>
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="text-md text-gray-400">
                            Giá tiền:
                            <strong class="fw-semibold text-gray-900 text-lg">$xx</strong>
                        </p>
                        <div class="position-relative z-3 d-flex align-items-center gap-2">
                            <a href="product.html"
                                class="text-white bg-red-700 fw-bold rounded-pill text-sm px-3 py-2 text-center me-2 mb-2 text-decoration-none">
                                Xem thêm
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="product px-0 col-sm-3 col-xl-4 position-relative d-flex flex-column shadow-md rounded-3 overflow-hidden shadow-lg-hover hover:-translate-y-1 transition-all duration-300 max-w-sm">
                <a href="" class="position-absolute z-3 top-2 right-0 mt-2 me-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6 text-orange-600">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                    </svg>
                </a>
                <a href="product.html" class="z-2 position-absolute h-100 w-100 top-0 left-0">&nbsp;</a>
                <div class="h-auto overflow-hidden">
                    <div class="h-44 overflow-hidden position-relative">
                        <img src="https://picsum.photos/400/400" alt="" class="max-w-full h-auto d-block" />
                    </div>
                </div>
                <div class="bg-white py-4 px-3">
                    <h3 class="product-name text-xl mb-2 font-medium truncate" name="product-name">
                        Christina
                    </h3>
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="text-md text-gray-400">
                            Giá tiền:
                            <strong class="fw-semibold text-gray-900 text-lg">$xx</strong>
                        </p>
                        <div class="position-relative z-3 d-flex align-items-center gap-2">
                            <a href="product.html"
                                class="text-white bg-red-700 fw-bold rounded-pill text-sm px-3 py-2 text-center me-2 mb-2 text-decoration-none">
                                Xem thêm
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="product px-0 col-sm-3 col-xl-4 position-relative d-flex flex-column shadow-md rounded-3 overflow-hidden shadow-lg-hover hover:-translate-y-1 transition-all duration-300 max-w-sm">
                <a href="" class="position-absolute z-3 top-2 right-0 mt-2 me-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6 text-orange-600">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                    </svg>
                </a>
                <a href="product.html" class="z-2 position-absolute h-100 w-100 top-0 left-0">&nbsp;</a>
                <div class="h-auto overflow-hidden">
                    <div class="h-44 overflow-hidden position-relative">
                        <img src="https://picsum.photos/400/400" alt="" class="max-w-full h-auto d-block" />
                    </div>
                </div>
                <div class="bg-white py-4 px-3">
                    <h3 class="text-xl mb-2 font-medium truncate product-name" name="product-name ">
                        Jone
                    </h3>
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="text-md text-gray-400">
                            Giá tiền:
                            <strong class="fw-semibold text-gray-900 text-lg">$xx</strong>
                        </p>
                        <div class="position-relative z-3 d-flex align-items-center gap-2">
                            <a href="product.html"
                                class="text-white bg-red-700 fw-bold rounded-pill text-sm px-3 py-2 text-center me-2 mb-2 text-decoration-none">
                                Xem thêm
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="product px-0 col-sm-3 col-xl-4 position-relative d-flex flex-column shadow-md rounded-3 overflow-hidden shadow-lg-hover hover:-translate-y-1 transition-all duration-300 max-w-sm">
                <a href="" class="position-absolute z-3 top-2 right-0 mt-2 me-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6 text-orange-600">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                    </svg>
                </a>
                <a href="product.html" class="z-2 position-absolute h-100 w-100 top-0 left-0">&nbsp;</a>
                <div class="h-auto overflow-hidden">
                    <div class="h-44 overflow-hidden position-relative">
                        <img src="https://picsum.photos/400/400" alt="" class="max-w-full h-auto d-block" />
                    </div>
                </div>
                <div class="bg-white py-4 px-3">
                    <h3 class="product-name text-xl mb-2 font-medium truncate" name="product-name">
                        Cindy
                    </h3>
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="text-md text-gray-400">
                            Giá tiền:
                            <strong class="fw-semibold text-gray-900 text-lg">$xx</strong>
                        </p>
                        <div class="position-relative z-3 d-flex align-items-center gap-2">
                            <a href="product.html"
                                class="text-white bg-red-700 fw-bold rounded-pill text-sm px-3 py-2 text-center me-2 mb-2 text-decoration-none">
                                Xem thêm
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div aria-label="Page navigation" class="d-flex justify-content-center">
                <ul class="d-flex align-items-center -space-x-px h-10 fw-normal">
                    <li>
                        <a href="#"
                            class="d-flex align-items-center justify-content-center px-4 h-10 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-start hover:bg-gray-100 hover:text-gray-700">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M5 1 1 5l4 4" />
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="d-flex align-items-center justify-content-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 text-decoration-none">1</a>
                    </li>
                    <li>
                        <a href="#"
                            class="d-flex align-items-center justify-content-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 text-decoration-none">2</a>
                    </li>
                    <li>
                        <a href="#" aria-current="page"
                            class="z-10 d-flex align-items-center justify-content-center px-4 h-10 leading-tight text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 text-decoration-none">3</a>
                    </li>
                    <li>
                        <a href="#"
                            class="d-flex align-items-center justify-content-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 text-decoration-none">4</a>
                    </li>
                    <li>
                        <a href="#"
                            class="d-flex align-items-center justify-content-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 text-decoration-none">5</a>
                    </li>
                    <li>
                        <a href="#"
                            class="d-flex align-items-center justify-content-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 rounded-end hover:bg-gray-100 hover:text-gray-700">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
    function productSearch() {
        const searchInput = document.getElementById("default-search");
        const productNames = document.querySelectorAll(".product-name");

        const searchText = searchInput.value.toLowerCase();

        productNames.forEach((product) => {
            const productName = product.textContent.toLowerCase();
            const productParent = product.closest(".product");

            if (!productName.includes(searchText)) {
                productParent.classList.add("d-none");
            } else {
                productParent.classList.remove("d-none");
            }
        });
    }
</script>
