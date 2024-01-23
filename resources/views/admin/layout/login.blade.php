@extends('../admin/layout/base')

@section('body')

    <body class="login">
        @yield('content')
        @include('../admin/layout/components/success-notification')
        {{-- @include('../admin/layout/components/dark-mode-switcher') --}}
        {{-- @include('../layout/components/main-color-switcher') --}}

        <!-- BEGIN: JS Assets-->
        <script src="{{ mix('dist/js/app.js') }}"></script>
        <!-- END: JS Assets-->

        @yield('script')
        @stack('scriptsStack')
    </body>
@endsection
