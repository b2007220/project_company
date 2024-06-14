<nav
    class="container-fluid navbar navbar-expand-lg position-relative border border-light-subtle bg-secondary-subtle py-0 ">
    <div
        class="container collapse navbar-collapse d-flex flex-wrap align-items-center justify-content-between mx-auto h-100">
        <div class="align-items-center justify-content-between w-100 flex-md w-auto-md h-100" id="navbarUser">
            <div
                class="navbar-nav align-items-center d-flex fs-5 p-md-0rounded bg-secondary-subtle flex-row-md mt-0-md border-gray-500 p-0 h-100">
                <div class="navigation space-x-8 py-2 px-1 h-100 border rounded">
                    <a class="nav-link d-block py-2 px-3 text-dark rounded p-md-0  fw-bold h-100"
                        href="{{ route('home') }}">Trang
                        chủ</a>
                </div>
                <div class="navigation space-x-8 py-2 px-1 h-100 border rounded"> <a
                        class="nav-link d-block py-2 px-3 text-dark rounded p-md-0  fw-bold h-100"
                        href="{{ route('category') }}">Sản
                        phẩm</a></div>
                <div class="navigation space-x-8 py-2 px-1 h-100 border rounded"><a
                        class="nav-link d-block py-2 px-3 text-dark rounded p-md-0   fw-bold h-100"
                        href="
{{ route('cart.index') }}">Giỏ
                        hàng</a></div>
                <div class="navigation space-x-8 py-2 px-1 h-100 border rounded"><a
                        class="nav-link d-block py-2 px-3 text-dark rounded p-md-0  fw-bold h-100"
                        href="{{ route('about') }}">Hỗ
                        trợ</a></div>



            </div>
        </div>
    </div>
</nav>
