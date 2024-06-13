<div
    class="position-relative d-flex min-h-max justify-content-center overflow-hidden bg-gray-100 gap-4 py-4 flex-column-max-lg rounded border">
    <div class="border-4 rounded p-4 d-flex d-inline-flex border-cyan-800 border">
        <div class="d-flex flex-column">
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
        </div>
    </div>
</div>
