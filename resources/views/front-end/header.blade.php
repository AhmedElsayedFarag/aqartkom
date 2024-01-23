  <head>
      <meta charset="UTF-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <!--custom fremeworks -->
      <link rel="stylesheet" href="{{ asset('front-end/css/bootstrap.rtl.min.css') }}" />
      <link rel="stylesheet" href="{{ asset('front-end/css/all.min.css') }}" />
      <link rel="stylesheet" href="{{ asset('front-end/css/owl.carousel.min.css') }}" />
      <link rel="stylesheet" href="{{ asset('front-end/css/owl.theme.default.min.css') }}" />
      <link rel="stylesheet" href="{{ asset('front-end/css/hover.css') }}" />
      <!-- Select2 CSS -->
      <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
      <link rel="stylesheet" href="{{ asset('front-end/css/style.css') }}" />
      <link rel="stylesheet" href="{{ asset('front-end/css/responsive.css') }}" />
      @foreach ($seos as $setting)
          @if (str_starts_with($setting['key'], 'og:'))
              <meta property="{{ $setting['key'] }}" content="{{ $setting['value'] }}">
          @elseif (str_starts_with($setting['key'], 'twitter:'))
              <meta name="{{ $setting['key'] }}" content="{{ $setting['value'] }}">
          @endif
      @endforeach
      {{-- <meta property="og:title" content="عقارتكم">
      <meta property="og:type" content="article" />
      <meta property="og:description" content="عقارتكم"> --}}
      <meta property="og:image" content="{{ asset('front-end/images/mzad.png') }}">
      {{-- <meta name="twitter:image:alt" content="عقارتكم">
      <meta property="og:site_name" content="عقارتكم"> --}}
      <meta property="og:url" content="{{ route('front.index') }}">
      {{-- <meta name="twitter:card" content="summary_large_image"> --}}
      <meta name="google-site-verification" content="IceeIJXakyVYfFvbxISFH-FjOh5416TsGvMDsobKo4A" />
      <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('favicons/apple-icon-57x57.png') }}">
      <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('favicons/apple-icon-60x60.png') }}">
      <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('favicons/apple-icon-72x72.png') }}">
      <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('favicons/apple-icon-76x76.png') }}">
      <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('favicons/apple-icon-114x114.png') }}">
      <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('favicons/apple-icon-120x120.png') }}">
      <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('favicons/apple-icon-144x144.png') }}">
      <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('favicons/apple-icon-152x152.png') }}">
      <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicons/apple-icon-180x180.png') }}">
      <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('favicons/android-icon-192x192.png') }}">
      <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicons/favicon-32x32.png') }}">
      <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicons/favicon-96x96.png') }}">
      <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicons/favicon-16x16.png') }}">
      <link rel="manifest" href="{{ asset('favicons/manifest.json') }}">
      <meta name="msapplication-TileColor" content="#262F6A">
      <meta name="msapplication-TileImage" content="{{ asset('favicons/ms-icon-144x144.png') }}">
      <meta name="theme-color" content="#262F6A">
      @stack('custom-head')
      <title>{{ $seos['title']['value'] }}</title>
      <link rel="stylesheet" href="{{ asset('front-end/css/lib.css') }}" />
      @stack('custom-style')
  </head>
