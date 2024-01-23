<html lang="ar" dir="rtl">
@include('front-end.header')

<body>
    @include('front-end.navbar')
    <!-- start The video -->
    @yield('content')
    <!--start of footer -->
    @include('front-end.footer')
</body>

</html>
