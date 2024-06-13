<div
    class="position-relative d-flex min-h-max justify-content-center overflow-hidden bg-gray-100 gap-4 py-4 flex-column-max-lg rounded border">
    <div class="border-4 rounded p-4 d-flex d-inline-flex border-cyan-800 border">
        <div class="d-flex flex-column">
            <h2 class="display-6 fw-bold text-center">Đổi mật khẩu</h2>
            <form class="min-w-96 mx-auto pt-10" action="{{ route('password.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="update_password_current_password"
                        class="d-block mb-2 text-sm font-medium text-gray-900 fw-bolder">Mật
                        khẩu cũ</label>
                    <input type="password" id="update_password_current_password" name="current_password"
                        class="bg-gray-50 border border-gray-500 text-gray-900 text-sm rounded d-block w-100 p-25"
                        required />
                </div>
                <div class="mb-3">
                    <label for="update_password_password"
                        class="d-block mb-2 text-sm font-medium text-gray-900 fw-bolder">Mật khẩu
                        mới</label>
                    <input type="password" id="update_password_password" name="password"
                        class="bg-gray-50 border border-gray-500 text-gray-900 text-sm rounded d-block w-100 p-25"
                        required />
                </div>
                <div class="mb-3">
                    <label for="update_password_password_confirmation"
                        class="d-block mb-2 text-sm font-medium text-gray-900 fw-bolder">Nhập lại mật khẩu mới</label>
                    <input type="password" id="update_password_password_confirmation" name="password_confirmation"
                        class="bg-gray-50 border border-gray-500 text-gray-900 text-sm rounded d-block w-100 p-25"
                        required />
                </div>
                <div class="d-flex align-items-center justify-content-between mt-4">
                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 fw-bold fs-6 rounded-pill text-sm  px-5 py-25 text-center border ">
                        Đổi mật khẩu
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
