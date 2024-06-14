<div
    class="position-relative d-flex min-h-max justify-content-center overflow-hidden bg-gray-100 gap-4 py-4 flex-column-max-lg rounded border">
    <div class="border-4 rounded p-4 d-flex d-inline-flex border-cyan-800 border">
        <div class="d-flex flex-column w-100">
            <h2 class="display-6 fw-bold text-center">Đăng nhập</h2>
            <form class="min-w-96 mx-auto pt-10" action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="d-block mb-2 text-sm font-medium fw-bolder text-gray-900">Tài
                        khoản</label>
                    <input type="email" id="email"
                        class="bg-gray-50 border border-gray-500 text-gray-900 text-sm rounded d-block w-100 p-25"
                        placeholder="name@gmail.com" required name="email" />
                </div>
                <div class="mb-3">
                    <label for="password" class="d-block mb-2 text-sm font-medium text-gray-900 fw-bolder">Mật
                        khẩu</label>
                    <input type="password" id="password" name="password"
                        class="bg-gray-50 border border-gray-500 text-gray-900 text-sm rounded d-block w-100 p-25"
                        required />
                </div>
                <div class="d-flex align-items-center justify-content-between mb-3 mt-4">
                    <div class="d-flex align-items-center h-5">
                        <input id="remember" type="checkbox" value=""
                            class="w-4 h-4 border border-gray-300 rounded bg-gray-50 " name="remember" />
                        <label for="remember" class="ms-2 text-sm font-medium text-gray-900 fw-bolder">Ghi nhớ
                            tôi</label>
                    </div>

                    @if (Route::has('password.request'))
                        <a class=" text-sm text-gray-600 0 rounded text-decoration-underline fw-bolder"
                            href="{{ route('password.request') }}">
                            Quên mật khẩu?
                        </a>
                    @endif
                </div>
                <button type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 fw-bold fs-6 rounded-pill border text-sm w-100 px-5 py-25 text-center">
                    Đăng nhập
                </button>
            </form>
            <hr class="my-4" />

            <div class="d-flex justify-content-evenly align-items-center">
                <a class="border rounded border-gray-300 p-2"
                    href="{{ route('auth.redirect', ['provider' => 'github']) }}">
                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M12.006 2a9.847 9.847 0 0 0-6.484 2.44 10.32 10.32 0 0 0-3.393 6.17 10.48 10.48 0 0 0 1.317 6.955 10.045 10.045 0 0 0 5.4 4.418c.504.095.683-.223.683-.494 0-.245-.01-1.052-.014-1.908-2.78.62-3.366-1.21-3.366-1.21a2.711 2.711 0 0 0-1.11-1.5c-.907-.637.07-.621.07-.621.317.044.62.163.885.346.266.183.487.426.647.71.135.253.318.476.538.655a2.079 2.079 0 0 0 2.37.196c.045-.52.27-1.006.635-1.37-2.219-.259-4.554-1.138-4.554-5.07a4.022 4.022 0 0 1 1.031-2.75 3.77 3.77 0 0 1 .096-2.713s.839-.275 2.749 1.05a9.26 9.26 0 0 1 5.004 0c1.906-1.325 2.74-1.05 2.74-1.05.37.858.406 1.828.101 2.713a4.017 4.017 0 0 1 1.029 2.75c0 3.939-2.339 4.805-4.564 5.058a2.471 2.471 0 0 1 .679 1.897c0 1.372-.012 2.477-.012 2.814 0 .272.18.592.687.492a10.05 10.05 0 0 0 5.388-4.421 10.473 10.473 0 0 0 1.313-6.948 10.32 10.32 0 0 0-3.39-6.165A9.847 9.847 0 0 0 12.007 2Z"
                            clip-rule="evenodd" />
                    </svg>

                </a>
                <a class="border rounded border-gray-300 p-2"
                    href=" {{ route('auth.redirect', ['provider' => 'google']) }} ">
                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M12.037 21.998a10.313 10.313 0 0 1-7.168-3.049 9.888 9.888 0 0 1-2.868-7.118 9.947 9.947 0 0 1 3.064-6.949A10.37 10.37 0 0 1 12.212 2h.176a9.935 9.935 0 0 1 6.614 2.564L16.457 6.88a6.187 6.187 0 0 0-4.131-1.566 6.9 6.9 0 0 0-4.794 1.913 6.618 6.618 0 0 0-2.045 4.657 6.608 6.608 0 0 0 1.882 4.723 6.891 6.891 0 0 0 4.725 2.07h.143c1.41.072 2.8-.354 3.917-1.2a5.77 5.77 0 0 0 2.172-3.41l.043-.117H12.22v-3.41h9.678c.075.617.109 1.238.1 1.859-.099 5.741-4.017 9.6-9.746 9.6l-.215-.002Z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>

    </div>
</div>
