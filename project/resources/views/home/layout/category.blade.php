<!DOCTYPE html>
<html lang="en">

<head>
    @include('home.components.head')
</head>

<body>
    @include('home.components.header')
    @include('home.components.navigation')
    <main>
        @include('home.content.category')
    </main>
    @include('home.components.footer')

</body>

</html>
