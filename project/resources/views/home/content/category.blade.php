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
                            @foreach ($categories as $category)
                                <a href="{{ $category->id }}"
                                    class="list-group-item list-group-item-action border-0 rounded p-2 mb-2 fs-5 text-uppercase bg-primary-hover">
                                    {{ $category->name }}
                                </a>
                            @endforeach

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
            @foreach ($products as $product)
                <x-product-card :product-name="$product->name" :price="$product->price" :image-src="$product->pictures && $product->pictures->isNotEmpty() ? $product->pictures[0]->link : ''" :product-discount="$product->discounts && $product->discounts->isNotEmpty()
                    ? $product->discounts[0]->discount
                    : 0"
                    :product-link="route('product', $product->id)" />
            @endforeach


        </div>

    </div>
    <div class="container"> {{ $products->links() }}</div>
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
