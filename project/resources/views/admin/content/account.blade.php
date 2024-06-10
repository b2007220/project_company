<div class="col bg-gray-200">
    <div class="d-flex flex-column mt-8">
        <div class="py-2 -my-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
            <div
                class="d-inline-block min-w-100 overflow-hidden align-items-middle border border-gray-200 shadow rounded bg-white ">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="p-3">Quản lý tài khoản</h4>
                    <button
                        class="p-2 m-3 border rounded-pill bg-blue-300 text-white d-flex align-items-center justify-content-center gap-1"
                        data-bs-toggle="modal" data-bs-target="#addAccountModal">
                        Thêm mới
                        <svg class="w-6 h-6  text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </button>
                </div>
                <div id="item-lists">
                    @include('admin.content.account-data')
                </div>
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
                    alert('No response from server');
                });
        }
    });

    function disableAccount(accountid) {
        event.preventDefault();
        const url = 'account/active/' + accountid;

        swal({
            title: "Bạn có chắc chắn muốn thay đổi?",
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
                    type: 'PUT',
                    data: JSON.stringify({
                        accountid: accountid
                    }),
                    cache: false,
                    processData: false,
                    success: function(result) {

                        $('#adjustAccountModal').modal('hide');
                        content = `<td class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm">
                    <div
                        class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                        ${result.account.email ? result.account.email : 'Chưa cập nhật'}
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm">
                    <div
                        class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                        ${result.account.name ? result.account.name : 'Chưa cập nhật'}
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm">
                    <div
                        class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                        ${result.account.phone ? result.account.phone : 'Chưa cập nhật'}
                    </div>
                </td>

                <td class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm">
                    <div
                        class="ml-4 text-sm leading-5 text-gray-900 font-medium d-flex justify-content-center align-items-center">
                        ${result.account.address ? result.account.address : 'Chưa cập nhật'}
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm">
                    ${result.account.is_active ? `<div
                            class="ml-4 text-sm leading-5 font-medium d-flex justify-content-center align-items-center">
                            <span class="bg-green-300 text-white p-2 fw-bolder border rounded">Đang hoạt
                                động</span>
                        </div>` : ` <div
                            class="ml-4 text-sm leading-5 font-medium d-flex justify-content-center align-items-center">
                            <span class="bg-red-700 text-white p-2 fw-bolder border rounded">Vô hiệu
                                hóa</span>
                        </div>`}

                </td>

                <td class="px-6 py-4 whitespace-no-wrap border-bottom border-gray-200 overflow-auto max-w-sm text-sm">

                    ${result.account.role==='ADMIN' ? `<div
                            class="ml-4 text-sm leading-5 font-medium d-flex justify-content-center align-items-center">
                            <span class="bg-orange-300 text-white p-2 fw-bolder border rounded">Quản trị
                                viên</span>
                        </div>` : ` <div
                            class="ml-4 text-sm leading-5 font-medium d-flex justify-content-center align-items-center">
                            <span class="bg-blue-300 text-white p-2 fw-bolder border rounded">Người
                                dùng</span>
                        </div>`}

                </td>
                <td
                    class="px-6 py-4 text-sm leading-5 text-gray-500 whitespace-no-wrap border-bottom border-gray-200 d-flex justify-content-center align-items-center gap-2">
                    <form onsubmit="disableAccount(${result.account.id})">

                         ${result.account.is_active ? `
                        <button type="submit"
                            class="text-decoration-none p-2 border rounded-pill fw-bolder bg-green-300 text-white d-flex align-items-center justify-content-center gap-1">
                            Kích hoạt
                            <svg class="w-6 h-6  text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </button>` : `
                        <button type="submit"
                            class="text-decoration-none p-2 border rounded-pill fw-bolder bg-red-400 text-white d-flex align-items-center justify-content-center gap-1">
                            Vô hiệu hóa
                            <svg class="w-6 h-6  text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </button>`}
                    </form>
                    <button type="button"
                        class="text-decoration-none p-2 border rounded-pill fw-bolder bg-yellow-400 text-white d-flex align-items-center justify-content-center gap-1"
                        data-bs-toggle="modal" data-bs-target="#adjustAccountModal"
                        data-account="${JSON.stringify(result.account)}">
                        Chỉnh sửa
                        <svg class="w-6 h-6  text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </button>

                </td>`;
                        const row = document.querySelector(
                            `tr[data-account-id="${result.account.id}"]`);
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
</script>
