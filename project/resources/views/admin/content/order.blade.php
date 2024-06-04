<div class="d-flex flex-column mt-8">
    <div class="py-2 -my-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
        <div
            class="d-inline-block min-w-100 overflow-hidden align-items-middle  border-gray-200 shadow  bg-white border rounded">
            <h4 class="p-3">Chi tiết đơn hàng</h4>
            <div id="item-lists">
                @include('admin.content.order-data')
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
                        text: result.message,
                        icon: 'error',
                        button: 'Đã hiểu',
                        timer: 1000
                    });
                });
        }
    });
</script>
