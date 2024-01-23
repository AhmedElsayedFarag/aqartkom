@extends('front-end.main')

@section('content')
    <section class="breadcramp">
        <div class="container">
            <ul class="d-flex">
                <li>
                    <a href="{{ route('front.index') }}">الرئسية</a>
                </li>
                <span>></span>
                &nbsp;
                <li>
                    <a href="{{ route('front.marketers') }}">المسوقون العقاريون</a>
                </li>
                <span>></span>
                &nbsp;
                <li>{{ $marketer->name }}</li>
            </ul>
        </div>
    </section>
    <!-- start of company-profile -->
    <section class="company-profile marketer-profile">
        <div class="container">
            <div class="parent">
                <div class="name">
                    <img src="{{ $marketer->formattedProfile }}">
                    <h2>{{ $marketer->name }}</h2>
                </div>
                <div class="info">
                    <ul class="addresses d-flex">
                        <li>
                            <p class="p1">رخصة فال</p>
                            @if ($marketer->advertisement_number)
                                <p class="p2">{{ $marketer->advertisement_number }}</p>
                            @endif
                        </li>
                        <li class="">
                            @if ($marketer->is_authorized)
                                <img src="{{ asset('front-end/images/compainies/check.png') }}">
                                <p>موثق</p>
                            @endif
                        </li>
                        <li>
                            <img src="{{ asset('front-end/images/compainies/megaphone.png') }}">
                            <p>{{ $marketer->ads()->count() }}</p>
                        </li>

                    </ul>
                    <ul class="d-flex links-contact">
                        <li>
                            <a href="tel:{{ $marketer->phone }}">
                                <img src="{{ asset('front-end/images/compainies/phone.png') }}">
                                <span>اتصل بنا</span>
                            </a>
                        </li>
                        <li>
                            @if ($marketer->marketerProfile->whatsapp_number)
                                <a href=" https://wa.me/{{ \str_replace('+', '', $marketer->marketerProfile->whatsapp_number) }}"
                                    target="_blank">
                                    <img src="{{ asset('front-end/images/compainies/check.png') }}">
                                    <span>واتساب</span>
                                </a>
                            @else
                                <a href=" https://wa.me/{{ \str_replace('+', '', $marketer->phone) }}" target="_blank">
                                    <img src="{{ asset('front-end/images/compainies/check.png') }}">
                                    <span>واتساب</span>
                                </a>
                            @endif
                        </li>
                        <li class="barcode dropdown">
                            <a href="#" class="dropdown-toggle" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{ asset('front-end/images/compainies/qrcode (1).png') }}">
                                <span>باركود</span>
                            </a>
                            <ul class="dropdown-menu barcodeDown" aria-labelledby="navbarDropdown">
                                <li>
                                    <div class="photo">
                                        <img
                                            src="{{ \Storage::disk('marketers')->url($marketer->marketerProfile->qr_code) }}">
                                    </div>
                                    <ul class="barcodeLinks">
                                        <li class="d-flex">

                                            <img src="{{ asset('front-end/images/Group 44200.png') }}">
                                            <a href="{{ \Storage::disk('marketers')->url($marketer->marketerProfile->qr_code) }}"
                                                download="{{ $marketer->name }}.png" title="{{ $marketer->name }}">
                                                تحميل الباركود
                                            </a>
                                        </li>
                                        <li class="d-flex">
                                            <img src="{{ asset('front-end/images/Group 44202.png') }}">
                                            <a href="{{ \Storage::disk('marketers')->url($marketer->marketerProfile->qr_code) }}"
                                                target="_blank">
                                                مشاركة الباركود
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- end of company-profile  -->


    <section class="filteration">
        <div class="container">
            <div class="row">
                @include('ad::front.filter-sidebar')
                <div class="col-md-8">
                    <div class="featured-aqars " id="result-ads">
                        <div class="row">
                            {{-- @foreach ($ads as $ad)
                                @include('ad::front.ad-component')
                            @endforeach --}}

                        </div>
                        <div class="d-flex justify-content-center d-none" id="loadMoreBtn"><button class="load-btn"
                                onclick="getAds()">اظهر المزيد</button></div>
                    </div>
                </div>
            </div>
    </section>
    @include('partials.not-licensed-ads');
@endsection

@push('custom-style')
    <link rel="stylesheet" href="{{ asset('front-end/css/rSlider.min.css') }}">
@endpush

@push('custom-script')
    <script>
        const search = () => {
            let url = `{{ route('front.marketer.show', ['marketer' => $marketer->uuid]) }}?${convertArraysToSearch()}`;
            window.location.href = url;
        };
    </script>
    <script src="{{ asset('front-end/js/rSlider.min.js') }}"></script>

    @include('ad::front.ads-builder')

    <script src="{{ asset('front-end/js/rangeSliderHelpers.js') }}"></script>
    <script src="{{ asset('front-end/js/rangeSliderFilter.js') }}"></script>
    <script src="{{ asset('front-end/js/adFilter.js') }}"></script>
    @include('ad::front.map-filter-scripts')
    <script>
        getAds(false);
    </script>
@endpush
