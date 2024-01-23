<!DOCTYPE html>
<!--
Template Name: Rubick - HTML Admin Dashboard Template
Author: Left4code
Website: http://www.left4code.com/
Contact: muhammadrizki@left4code.com
Purchase: https://themeforest.net/user/left4code/portfolio
Renew Support: https://themeforest.net/user/left4code/portfolio
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    class="{{ session('dark_mode') ? 'dark' : '' }}{{ session('color_scheme') != 'default' ? ' ' . session('color_scheme') : '' }}"
    dir="rtl">
<!-- BEGIN: Head -->

<head>
    <meta charset="utf-8">
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('default/fav-icons/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('default/fav-icons/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('default/fav-icons/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('default/fav-icons/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('default/fav-icons/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('default/fav-icons/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('default/fav-icons/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('default/fav-icons/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('default/fav-icons/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192"
        href="{{ asset('default/fav-icons/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('default/fav-icons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('default/fav-icons/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('default/fav-icons/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('default/fav-icons/manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('default/fav-icons/ms-icon-144x144.png') }}">
    {{-- <meta name="theme-color" content="#ffffff"> --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @yield('head')

    <!-- BEGIN: CSS Assets-->
    <link rel="stylesheet" href="{{ mix('dist/css/app.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/rtl-style.css') }}" />
    <title>عقاراتكم |لوحة التحكم</title>
    <!-- END: CSS Assets-->
    @stack('stylesStack')
    <style>
        :root {
            --color-primary: 38 47 106 !important;
        }
    </style>
    {{-- <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700&display=swap');

        * {
            font-family: 'Tajawal', sans-serif !important;
        }
    </style> --}}
    <style>
        @font-face {
            font-family: Shamel;
            src: url('/assets/Tajawal/Tajawal-Bold.ttf');
            font-weight: bold;
        }

        @font-face {
            font-family: Shamel;
            src: url('/assets/Tajawal/Tajawal-Medium.ttf');
            font-weight: 500;
        }

        @font-face {
            font-family: Shamel;
            src: url('/assets/Tajawal/Tajawal-Light.ttf');
            font-weight: 300;
        }

        * {
            font-family: 'Shamel', sans-serif !important;
        }
    </style>
</head>
<!-- END: Head -->

@yield('body')

</html>
