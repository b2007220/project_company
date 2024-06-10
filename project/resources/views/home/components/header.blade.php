<nav class="container-fluid bg-white border-black border-opacity-25">
    <div class="d-flex flex-wrap justify-content-between align-items-center mx-auto container p-4">
        <a href="
        {{ route('home') }}" class="d-flex align-items-center text-decoration-none">
            <img src="{{ asset('fast-delivery.png') }}" class="h-20 w-20" alt="Logo" />
            <span class="align-self-center fs-2 fw-bold text-nowrap text-dark space-x-3">Cửa hàng Online</span>
        </a>
        <div class="dropdown d-flex align-items-center order-md-2">
            @if (Route::has('login'))
                <nav class="-mx-3 d-flex flex-1 justify-content-end gap-2">
                    @auth
                        <button class="d-flex bg-white small rounded-circle border-primary me-md-0 p-0" type="button"
                            id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="http://www.w3.org/2000/svg" alt="" class="w-8 h-8 border rounded-circle" />
                        </button>
                        <div class="dropdown-menu z-3 position-absolute text-base bg-white border rounded shadow"
                            aria-labelledby="userMenu">
                            <div class="border-bottom px-3 py-2">
                                <span class="d-block small text-body">Tên khách hàng</span>
                                <span
                                    class="d-block small text-body-secondary text-truncate">{{ Auth::user()->name }}</span>
                            </div>
                            <div class="border-bottom">
                                <ul class="pt-2 pl-0">
                                    <li class="d-block py-2 px-3 text-dark rounded p-md-0">
                                        <a class="dropdown-item d-block px-3 py-2 small text-dark"
                                            href="{{ route('profile.edit') }}">Thông tin</a>
                                    </li>
                                    <li class="d-block py-2 px-3 text-dark rounded p-md-0">
                                        <a class="dropdown-item d-block px-3 py-2 small text-dark"
                                            href="{{ route('order') }}">Lịch sử
                                            mua
                                            hàng</a>
                                    </li>
                                    <li class="d-block py-2 px-3 text-dark rounded p-md-0">
                                        <a class="dropdown-item d-block px-3 py-2 small text-dark" href="">Đổi mật
                                            khẩu</a>
                                    </li>
                                    <li class="d-block py-2 px-3 text-dark rounded p-md-0">
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf

                                            <button type="submit"
                                                class="dropdown-item d-block px-3 py-2 small text-dark">Đăng
                                                xuất</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                            @if (Auth::user()->role == 'admin')
                                <div class="border-bottom px-4 py-3">
                                    <a href="{{ route('admin.home') }}"
                                        class="d-block small text-body-secondary text-truncate text-decoration-none fs-6">Admin</a>
                                </div>
                            @endif
                        </div>
                        <button
                            class="navbar-toggler d-inline-flex align-items-center p-2 justify-center small text-dark border rounded d-md-none space-x-3"
                            type="button" data-bs-toggle="collapse" data-bs-target="#navbarUser" aria-controls="navbarUser"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 17 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M1 1h15M1 7h15M1 13h15" />
                            </svg>
                        </button>
                    @else
                        <a href="{{ route('login') }}"
                            class="rounded border px-3 py-2 text-black text-decoration-none fw-bolder">
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="rounded border px-3 py-2 text-black text-decoration-none fw-bolder">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </div>
    </div>
</nav>
