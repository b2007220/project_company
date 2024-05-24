<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.components.head')
</head>

<body>
    <div class="container-fluid">
        <div class="row flex-nowrap">
            @include('admin.components.sidebar')
            @include('admin.content.discount')
        </div>
    </div>
    @include('admin.modal.discount')
</body>

</html>
