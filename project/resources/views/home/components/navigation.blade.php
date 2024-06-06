<nav class="container-fluid navbar navbar-expand-lg position-relative border border-light-subtle bg-secondary-subtle">
    <div class="container collapse navbar-collapse d-flex flex-wrap align-items-center justify-content-between mx-auto">
        <div class="align-items-center justify-content-between w-100 flex-md w-auto-md" id="navbarUser">
            <div
                class="navbar-nav align-items-center d-flex fs-5 p-md-0rounded bg-secondary-subtle flex-row-md mt-0-md border-gray-500 p-0">
                <a class="nav-link d-block py-2 px-3 text-dark rounded p-md-0 space-x-8" href="{{ route('home') }}">Trang
                    chủ</a>
                <a class="nav-link d-block py-2 px-3 text-dark rounded p-md-0 space-x-8"
                    href="{{ route('category') }}">Sản
                    phẩm</a>
                <a class="nav-link d-block py-2 px-3 text-dark rounded p-md-0 space-x-8"
                    href="
                {{ route('cart.index') }}">Giỏ
                    hàng</a>
                <a class="nav-link d-block py-2 px-3 text-dark rounded p-md-0 space-x-8" href="{{ route('about') }}">Hỗ
                    trợ</a>
            </div>
        </div>
    </div>
</nav>
