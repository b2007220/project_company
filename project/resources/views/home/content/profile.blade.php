<div class="container d-flex flex-lg-row flex-column justify-content-center align-items-stretch gap-6">
    <div class="position-relative border border-2 rounded max-w-xl  d-flex d-inline-flex w-100 h-auto m-3 p-4">
        <form id="profileForm" method="POST" class="w-full" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="mb-4">
                <label for="name">Họ tên tài khoản</label>
                <input type="text" class="form-control" aria-label="name" value="{{ Auth::user()->name ?? '' }}"
                    name="name" />
            </div>

            <div class="mb-4">
                <label for="email">Email tài khoản </label>
                <input type="email" class="form-control" aria-label="email" value="{{ Auth::user()->email ?? '' }}"
                    readonly="readonly" name="email" />
            </div>

            <div class="mb-4">
                <label for="address">Địa chỉ</label>
                <input type="text" class="form-control" aria-label="address" id="address"
                    value="{{ Auth::user()->address ?? '' }}" name="address" />
            </div>
            <div class="row">
                <div class="col mb-4">
                    <label for="phone"> Số điện thoại</label>
                    <input type="text" class="form-control" aria-label="phone" name="phone"
                        value="{{ Auth::user()->phone ?? '' }}" />

                </div>

                <div class="col mb-4">
                    <label for="gender">Giới tính</label>
                    <select name="gender" aria-label="gender" class="form-select max-w-100 overflow-auto">
                        <option value="MAN" @selected(Auth::user()->gender == 'MAN')>Nam</option>
                        <option value="WOMAN" @selected(Auth::user()->gender == 'WOMAN')>Nữ</option>
                        <option value="OTHER" @selected(Auth::user()->gender == 'OTHER')>Khác</option>
                    </select>
                </div>
            </div>
            <div class="mb-4">
                <label class="d-block mb-2 text-sm fw-bolder text-gray-900" for="avatar">Ảnh đại diện
                </label>
                <input
                    class="d-block w-full text-sm text-gray-900 border border-gray-300 rounded cursor-pointer bg-gray-50"
                    id="avatar" type="file" name="avatar">
            </div>
            <hr class="mb-4" />

            <div class="d-grid gap-2 mb-4">
                <button class="btn btn-dark btn-lg" type="submit" form="profileForm">
                    Lưu thông tin
                </button>
            </div>
        </form>
    </div>
    <div
        class="position-relative d-flex overflow-hidden justify-content-center bg-gray-100 gap-4 py-4 rounded flex-column align-items-center max-w-3xl">
        @if (!Auth::user()->isValidAvatarUrl())
            <img src="avatar/{{ Auth::user()->avatar }}" class="rounded-circle w-320 h-320" alt="Avatar"
                id="avatar-image" />
        @else
            <img src="{{ Auth::user()->avatar }}" class="rounded-circle w-320 h-320" alt="Avatar" id="avatar-image" />
        @endif
        <span class="d-block mb-2 text-sm fw-bolder text-gray-900">Ảnh đại diện</span>

    </div>
</div>


<script>
    document.getElementById("profileForm").addEventListener("submit", function(event) {
        event.preventDefault();
        const formData = new FormData(this);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        });

        $.ajax({
            url: 'profile',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            success: function(result) {
                console.log(result);
                if (result.avatar) {
                    const avatarImage = document.getElementById("avatar-image");
                    avatarImage.src = 'avatar/' + result.avatar;
                    const avatarImageHeader = document.getElementById("avatar-image-header");
                    avatarImageHeader.src = 'avatar/' + result.avatar;
                }
                swal({
                    title: 'Thành công!',
                    text: result.message,
                    icon: 'success',
                    button: 'OK',
                    timer: 1000
                });
            },
            error: function(xhr) {
                const errors = xhr.responseJSON.errors;
                if (errors) {
                    for (const [key, value] of Object.entries(errors)) {
                        console.log(key, value);
                    }
                }
                swal({
                        title: 'Thất bại!',
                        text: xhr.responseJSON.message,
                        icon: 'error',
                        button: 'OK',
                        timer: 1000
                    });
            }
        });
    });
</script>
