<div class="modal fade" id="addBannerModal" tabindex="-1" aria-labelledby="addBannerModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 512px">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle" class="modal-title fs-5 text-xl fw-bolder text-gray-900">
                    Thêm mới banner
                </h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="mb-3" id="bannerForm">
                    <input type="hidden" id="bannerId" name="id" value="" />
                    <label for="bannerImage">Hình ảnh</label>
                    <input type="file" name="image" id="bannerImage" class="form-control">
                    <label for="bannerLink" class="form-label">Link sự kiện</label>
                    <input type="text" class="form-control" id="bannerLink" name="link"
                        placeholder="Nhập link sự kiện" />
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" form="bannerForm"
                    class="p-2 m-3 border rounded-pill bg-blue-300 text-white d-flex align-items-center justify-content-center gap-1">
                    Thêm mới
                    <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 5v9m-5 0H5a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1h-2M8 9l4-5 4 5m1 8h.01" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const addBannerModal = document.getElementById("addBannerModal");
        addBannerModal.addEventListener("show.bs.modal", function(event) {
            const button = event.relatedTarget;
            const mode = button.getAttribute("data-mode");
            const modalTitle = document.getElementById("modalTitle");
            const bannerForm = document.getElementById("bannerForm");
            const bannerId = document.getElementById("bannerId");
            const bannerLink = document.getElementById("bannerLink");

            bannerForm.reset();

            if (mode === "edit") {
                const banner = JSON.parse(button.getAttribute("data-banner"));
                modalTitle.textContent = "Chỉnh sửa banner";
                bannerForm.action = `banner/update/${banner.id}`;
                bannerId.value = banner.id;
                bannerLink.value = banner.link;
                let methodInput = bannerForm.querySelector('input[name="_method"]');
                if (!methodInput) {
                    methodInput = document.createElement('input');
                    methodInput.setAttribute('type', 'hidden');
                    methodInput.setAttribute('name', '_method');
                    bannerForm.appendChild(methodInput);
                }
                methodInput.value = 'PUT';
            } else {
                modalTitle.textContent = "Thêm mới banner";
                bannerForm.action = `banner/add`;
                bannerId.value = "";
                bannerLink.value = "";
                const methodInput = bannerForm.querySelector('input[name="_method"]');
                if (methodInput) {
                    bannerForm.removeChild(methodInput);
                }
            }
        });
    });

    document.getElementById("bannerForm").addEventListener("submit", function(event) {
        event.preventDefault();
        const bannerForm = event.target;
        const formData = new FormData(bannerForm);
        const url = bannerForm.action;
        const method = bannerForm.querySelector('input[name="_method"]') ? 'PUT' : 'POST';
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        });
        $.ajax({
            url: url,
            type: method,
            data: JSON.stringify(Object.fromEntries(formData.entries())),
            dataType: 'json',
            contentType: 'application/json',
            cache: false,
            processData: false,
            success: function(result) {
                console.log(result);
                $('#addBannerModal').modal('hide');
                const imageInput = document.getElementById("bannerImage");
                const imageFile = imageInput.files[0];
                if (imageFile) {
                    const imageFormData = new FormData();
                    imageFormData.append('image', imageFile);
                    $.ajax({
                        url: 'banner/' + result.banner.id + '/upload-image',
                        type: 'POST',
                        data: imageFormData,
                        processData: false,
                        enctype: 'multipart/form-data',
                        contentType: false,
                        cache: false,
                        success: function(fileResponse) {

                            var content = `<td class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm ">
                    <div
                        class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                        ${fileResponse.image ? `<img src="/banner/${fileResponse.image}" alt="" class="w-100 h-120">` : `<img src="/banner/${result.banner.image}" alt="" class="w-100 h-120">`}
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm ">
                    <div
                        class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                        ${result.banner.link ? `<a href="${result.banner.link}" target="_blank"
                            class="text-decoration-none">${result.banner.link }</a>` : `<a href="#" target="_blank"
                            class="text-decoration-none">Không có link</a>`}
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm ">
                    <div
                        class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                        ${result.banner.status ? `<div

                                class="ml-4 text-sm leading-5 font-medium d-flex justify-content-center align-items-center">
                                <span class="bg-green-300 text-white p-2 fw-bolder border rounded">Đang hoạt
                                    động</span>
                            </div>`
                            :`<div
                                class="ml-4 text-sm leading-5 font-medium d-flex justify-content-center align-items-center">
                                <span class="bg-red-700 text-white p-2 fw-bolder border rounded">Vô hiệu
                                    hóa</span>
                            </div>`}
                    </div>
                </td>
                <td
                    class="text-decoration-none px-6 py-4 text-sm leading-5 text-gray-500 whitespace-no-wrap border-bottom border-gray-200 ">

                    <div class="d-flex justify-content-center align-items-center gap-2">
                        <form onsubmit="disableBanner(${result.banner.id })">

                            ${result.banner.status ? `<button type="submit"

                                    class="text-decoration-none p-2 border rounded-pill fw-bolder bg-red-400 text-white d-flex align-items-center justify-content-center gap-1">
                                    Vô hiệu hóa
                                    <svg class="w-6 h-6  text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                </button>
                            `:`
                                <button type="submit"
                                    class="text-decoration-none p-2 border rounded-pill fw-bolder bg-green-300 text-white d-flex align-items-center justify-content-center gap-1">
                                    Kích hoạt
                                    <svg class="w-6 h-6  text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                </button>
                             `}
                        </form>
                        <form action="javascript:void(0)" enctype="multipart/form-data"
                            onsubmit="confirmation(event, ${result.banner.id})">
                            <button type="submit"
                                class="text-decoration-none p-2 border rounded-pill fw-bolder bg-red-400 text-white d-flex align-items-center justify-content-center gap-1">
                                Xóa
                                <svg class="w-6 h-6  text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </button>
                        </form>
                        <button type="button"
                            class="text-decoration-none p-2 border rounded-pill fw-bolder bg-yellow-400 text-white d-flex align-items-center justify-content-center gap-1"
                            data-bs-toggle="modal" data-bs-target="#addBannerModal" data-mode="edit"
                            data-banner="${JSON.stringify(result.product)}">
                            Chỉnh sửa
                            <svg class="w-6 h-6  text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </button>
                    </div>
                </td>`
                            if (method === 'PUT') {
                                const row = document.querySelector(
                                    `tr[data-banner-id="${result.banner.id}"]`);
                                if (row) {
                                    row.querySelector('td div').textContent = content;
                                }
                            } else if (method === 'POST') {
                                const newRow = document.createElement('tr');
                                newRow.setAttribute('data-banner-id', result.banner.id);
                                newRow.innerHTML = content;
                                document.querySelector('tbody').appendChild(newRow);
                            }
                            swal({
                                title: 'Thành công!',
                                text: result.message,
                                icon: 'success',
                                button: 'OK',
                                timer: 1000
                            });
                        },
                        error: function(fileError) {
                            const errors = xhr.responseJSON.errors;
                            if (errors) {
                                for (const [key, value] of Object.entries(errors)) {
                                    console.log(key, value);
                                }
                            }
                        }
                    });
                }

            },
            error: function(xhr) {
                const errors = xhr.responseJSON.errors;
                if (errors) {
                    for (const [key, value] of Object.entries(errors)) {
                        console.log(key, value);
                    }
                }
            }
        });
    });
</script>
