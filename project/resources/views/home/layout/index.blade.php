<!DOCTYPE html>
<html lang="en">

<head>
    @include('home.components.head')
</head>

<body>
    @include('home.components.header')
    @include('home.components.navigation')
    <main>
        @include('home.content.carousel')
        @include('home.content.bestproduct')
        @include('home.content.saleproduct')
        @include('home.content.extraproduct')
    </main>
    @include('home.components.footer')

</body>



</html>
