<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.components.head')
</head>

<body>
    <div class="container-fluid">
        <div class="row flex-nowrap">
            @include('admin.components.sidebar')
            @include('admin.content.account')
        </div>
    </div>

    @include('admin.modal.account')
    @include('admin.modal.accountadding')
    <script src="{{ asset('js/ajax-form-setup.js') }}"></script>
</body>


</html>
