<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.components.head')
</head>

<body>
    <div class="container-fluid">
        <div class="row flex-nowrap">
            @include('admin.components.slider')
            @include('admin.content.category')
        </div>
    </div>
    @include('admin.modal.category')
</body>

</html>
