<div class="container d-flex flex-column justify-content-center overflow-hidden py-3 bg-gray-100">
    <div class="d-flex align-items-center gap-3">
        <h3 class="fw-bolder text-gray-900 pl-6 mb-0">Sản phẩm</h3>
        <img src="cardboard-box.png" class="h-16 w-16" alt="Logo" />
    </div>
    <hr class="h-px my-3 bg-gray-200" />
    <div class="">
        <div class = "row gap-6 py-3 max-h-100 justify-content-evenly d-flex" id = "product-container">
            @include('home.content.extraproduct-data')
        </div>
        <div class="d-flex justify-content-center align-items-center">
            <button id="load-more" class="border  btn rounded-pill border-blue-300 border-blue-700-hover fw-bold">Xem
                thêm</button>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var page = 1;
        $('#load-more').click(function() {
            page++;
            loadMoreData(page);
        });

        function loadMoreData(page) {
            $.ajax({
                url: '/load-more' + '?page=' + page,
                type: 'GET',
                cache: false,
                success: function(data) {
                    $('#product-container').append(data);
                },
                fail: function(jqXHR, ajaxOptions, thrownError) {
                    console.log('Server error occured');
                }
            })
        };
    });
</script>
