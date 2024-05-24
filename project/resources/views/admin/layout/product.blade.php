<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.components.head')
</head>

<body>
    <div class="container-fluid">
        <div class="row flex-nowrap">
            @include('admin.components.sidebar')
            @include('admin.content.product')
        </div>
    </div>
    @include('admin.modal.productdiscount')
    @include('admin.modal.product')


</body>

</html>
