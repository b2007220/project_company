<div class="d-flex flex-column mt-8 col bg-gray-200 ">
    <div class="py-2 -my-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
        <div
            class="d-inline-block min-w-100 overflow-hidden align-items-middle  border-gray-200 shadow  bg-white border rounded">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="p-3">Quản lý banner</h4>
                <button
                    class="p-2 m-3 border rounded-pill bg-blue-300 text-white d-flex align-items-center justify-content-center gap-1 text-decoration-none"
                    data-bs-toggle="modal" data-bs-target="#addBannerModal" data-mode="create">
                    Thêm mới
                    <svg class="w-6 h-6  text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </button>
            </div>

            <div id="item-lists">
                @include('admin.content.banner-data')
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {

        $(window).on('hashchange', function() {
            if (window.location.hash) {
                var page = window.location.hash.replace('#', '');
                if (page == Number.NaN || page <= 0) {
                    return false;
                } else {
                    getData(page);
                }
            }
        });

        $(document).on('click', '.pagination a', function(event) {
            $('li').removeClass('active');
            $(this).parent('li').addClass('active');
            event.preventDefault();

            var myurl = $(this).attr('href');
            var page = $(this).attr('href').split('page=')[1];

            getData(page);
        });

        function getData(page) {
            $.ajax({
                    url: '?page=' + page,
                    type: "get",
                    datatype: "html",
                })
                .done(function(data) {
                    $("#item-lists").empty().html(data);
                    location.hash = page;
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    swal({
                        title: 'Lỗi!',
                        icon: 'error',
                        button: 'Đã hiểu',
                        timer: 1000
                    });
                });
        }
    });

    function disableBanner(bannerId) {
        event.preventDefault();
        const url = 'banner/active/' + bannerId;

        swal({
            title: "Bạn có chắc chắn muốn thay đổi?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                console.log(url);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Content-Type': 'application/json'
                    }
                });
                $.ajax({
                    url: url,
                    type: 'PUT',
                    data: JSON.stringify({
                        id: bannerId
                    }),
                    cache: false,
                    processData: false,
                    success: function(result) {
                        $('#adjustBannerModal').modal('hide');
                        content = `<td class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm ">
                    <div
                        class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center border rounded">
                        <img src="/banner/${result.banner.image}" alt="" class="w-100 h-120">
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
                        </div>` : ` <div
                            class="ml-4 text-sm leading-5 font-medium d-flex justify-content-center align-items-center">
                            <span class="bg-red-700 text-white p-2 fw-bolder border rounded">Vô hiệu
                                hóa</span>
                        </div>`}
                    </div>
                </td>
                <td
                    class="text-decoration-none px-6 py-4 text-sm leading-5 text-gray-500 whitespace-no-wrap border-bottom border-gray-200 ">

                    <div class="  d-flex justify-content-center align-items-center gap-2">
                        <form onsubmit="disableBanner(${ result.banner.id })">
 ${result.banner.status ? `
                        <button type="submit"
                            class="text-decoration-none p-2 border rounded-pill fw-bolder bg-red-400 text-white d-flex align-items-center justify-content-center gap-1">
                            Vô hiệu hóa
                            <svg class="w-6 h-6  text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </button>`:  `
                        <button type="submit"
                            class="text-decoration-none p-2 border rounded-pill fw-bolder bg-green-300 text-white d-flex align-items-center justify-content-center gap-1">
                            Kích hoạt
                            <svg class="w-6 h-6  text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </button>`}
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
                            data-banner="${JSON.stringify(result.banner)}">
                            Chỉnh sửa
                            <svg class="w-6 h-6  text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </button>
                    </div>
                </td>`;
                        const row = document.querySelector(
                            `tr[data-banner-id="${result.banner.id}"]`);
                        if (row) {
                            row.innerHTML = content;
                        }
                        swal({
                            title: 'Thành công!',
                            text: result.message,
                            icon: 'success',
                            button: 'OK'
                        });
                    },
                    error: function(xhr) {
                        const errors = xhr.responseJSON.errors;
                        if (errors) {
                            for (const [key, value] of Object.entries(errors)) {
                                console.log(key, value);
                            }
                        }
                    }
                })
            }
        });
    }

    function confirmation(event, id) {
        event.preventDefault();
        const url = 'banner/delete/' + id;

        swal({
            title: "Bạn có chắc chắn muốn xóa?",
            text: "Sau khi xóa, bạn sẽ không thể khôi phục dữ liệu!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Content-Type': 'application/json'
                    }
                });
                $.ajax({
                    url: url,
                    type: 'DELETE',

                    success: function(result) {
                        console.log(result);
                        swal("Dữ liệu đã được xóa!", {
                            icon: "success",
                            timer: 1000,
                        });
                        $('tr[data-banner-id="' + id + '"]').remove();

                    }
                })
            }
        });
    }
</script>
