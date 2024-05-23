<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.components.head')
</head>

<body>
    <main class="container-fluid">
        <div class="row flex-nowrap">
            @include('admin.components.slider')
            <div class="col bg-gray-200">
                @include('admin.content.summary')
                @include('admin.content.summarychart')
                @include('admin.content.order')
            </div>
        </div>
    </main>
</body>


</html>
