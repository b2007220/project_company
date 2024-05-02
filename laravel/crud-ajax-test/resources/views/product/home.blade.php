<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.dataTables.min.css">
    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.min.js"></script>
</head>

<body>
    <div class="container">
        <h1>Laravel</h1>
        <button href="#" class="btn btn-info ml-3" id="create-new-product">Add new</button>
        <br><br>
        <table class="table table-bordered table-striped" id="datatable">
            <thead>
                <tr>
                    <th>id</th>
                    <th>no</th>
                    <th>title</th>
                    <th>category</th>
                    <th>price</th>
                    <th>image</th>
                    <th>action</th>
                </tr>
            </thead>

    </div>
    <div class="modal fade" id="product-modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="productCrudModal"></h4>
                </div>
                <div class="modal-body">
                    <form id="productForm" name="productForm" class="form-horizontal" enctype="multipart/form-data">
                        <input type="hidden" name="product_id" id="product_id">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Title</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="title" name="title" placeholder="Enter Tilte" value="" maxlength="50" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Category</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="category" name="category" placeholder="Enter Category" value="" maxlength="50" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Price</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="price" name="price" placeholder="Enter Price" value="" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Image</label>
                            <div class="col-sm-12">
                                <input id="image" type="file" name="image" accept="image/*" onchange="readURL(this);">
                                <input type="hidden" name="hidden_image" id="hidden_image">
                            </div>
                        </div>
                        <img id="modal-preview" src="https://via.placeholder.com/150" alt="Preview" class="form-group hidden" width="100" height="100">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" id="btn-save" value="create">Save changes</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>
    <script>
        var SITEURL = 'http://127.0.0.1:8000/'
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: SITEURL + "products",
                    type: 'GET'
                },
                columns: [{
                    data: 'id',
                    name: 'id',
                    visible: false
                }, {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                }, {
                    data: 'title',
                    name: 'title'
                }, {
                    data: 'category',
                    name: 'category'
                }, {
                    data: 'price',
                    name: 'price'
                }, {
                    data: 'image',
                    name: 'image',
                    orderable: false
                }, {
                    data: 'action',
                    name: 'action',
                    orderable: false
                }],
                order: [
                    [0, 'desc']
                ]
            })
            $('#create-new-product').click(function() {
                $('#btn-save').val("create-product");
                $('#productFrom').trigger("reset");
                $('#productCrudModal').html("Add new product");
                $('#product-modal').modal('show');
                $('#modal-preview').attr('src', 'https://via.placeholder.com/150');
            });

            $('body').on('click', '.edit-product', function() {
                var product_id = $(this).data('id');
                $.get('products/edit/' + product_id, function(data) {
                    $('#title-error').hide();
                    $('#product-category-error').hide();
                    $('#category-error').hide();
                    $('#productCrudModal').html("Edit product");
                    $('#btn-save').val("edit-product");
                    $('#product-modal').modal('show');
                    $('#product_id').val(data.id);
                    $('#title').val(data.title);
                    $('#category').val(data.category);
                    $('#price').val(data.price);
                    $('#modal-preview').attr('alt', 'No image');
                    if (data.image) {
                        $('#modal-preview').attr('src', SITEURL + 'public/product/' + data.image);
                        $('#hidden_image').attr('src', SITEURL + 'public/product/' + data.image);
                    } else {
                        $('#modal-preview').attr('src', 'https://via.placeholder.com/150');
                    }
                })
            });

            $('body').on('click', '.delete', function() {
                var product_id = $(this).data("id");
                if (confirm("Are you sure you want to delete this product?")) {
                    $.ajax({
                        type: "GET",
                        url: SITEURL + "products/delete/" + product_id,
                        success: function(data) {
                            var oTable = $('#datatable').DataTable();
                            oTable.draw(false);
                        },
                        error: function(data) {
                            console.log('Error:', data);
                        }
                    });
                }
            });
        });


        $('body').on('submit', '#productForm', function(e) {
            e.preventDefault();
            var actionType = $('#btn-save').val();
            $('#btn-save').html('Sending..');
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: SITEURL + "products/store",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: (data) => {
                    console.log(data);
                    $('#productForm').trigger("reset");
                    $('#product-modal').modal('hide');
                    $('#btn-save').html('Save changes');
                    var oTable = $('#datatable').DataTable();
                    oTable.draw(false);
                },
                error: function(data) {
                    console.log('Error:', data);
                    $('#btn-save').html('Save changes');
                }
            });

        });

        function readURL(input, id) {
            id = id || '#modal-preview';
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $(id).attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
                $('#modal-preview').removeClass('hidden');
                $('#start').hide();
            }
        }
    </script>
</body>

</html>
