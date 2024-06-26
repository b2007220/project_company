<div class="bg-gray-100 pt-10 border-2 rounded container px-8">
    <h2 class="text-center text-uppercase fw-bold text-gray-900">
        Lịch sử mua hàng
    </h2>
    <div class="mx-auto max-w-8xl justify-center px-6 flex-md px-xl-0 d-flex justify-content-center align-items-center">
        <div
            class="justify-content-between mb-6 rounded border bg-white p-6 shadow flex-sm justify-start-sm d-flex flex-column">
            <div class="position-relative overflow-x-auto shadow rounded-sm border w-100 ">
                <div id="item-lists">
                    @include('home.content.order-data')
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

    function confirmation(event, id) {
        event.preventDefault();
        const url = 'category/delete/' + id;

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
                    }
                });
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    contentType: 'application/json',
                    success: function(result) {
                        console.log(result);
                        swal("Dữ liệu đã được xóa!", {
                            icon: "success",
                            timer: 1000,
                        });
                        $('tr[data-category-id="' + id + '"]').remove();
                    },
                    swal({
                        title: 'Thất bại!',
                        text: xhr.responseJSON.message,
                        icon: 'error',
                        button: 'OK',
                        timer: 1000
                    });
                })
            }
        });
    }
</script>
