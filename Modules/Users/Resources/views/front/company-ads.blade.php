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
                    <a href="{{ route('front.companies') }}">الشركات العقارية</a>
                </li>
                <span>></span>
                &nbsp;
                <li>{{ $company->name }}</li>
            </ul>
        </div>
    </section>
    <section class="company-profile">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="photo">
                        <img src="{{ $company->formattedLogo }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <p class="title">{{ $company->name }}</p>
                    <h2 class="sub-title">عن الشركة</h2>
                    <p class="content">{{ $company->description }}</p>
                    <ul class="d-flex links-contact">
                        <li>
                            <a href="tel:{{ $company->user->phone }}" target="_blank">
                                <img src="{{ asset('front-end/images/compainies/phone.png') }}">
                                اتصل بنا
                            </a>
                        </li>
                        <li>
                            <a href=" https://wa.me/{{ \str_replace('+', '', $company->whatsapp_number) }}" target="_blank">
                                <img src="{{ asset('front-end/images/compainies/check.png') }}">
                                واتساب
                            </a>
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
                                        <img src="{{ \Storage::disk('companies')->url($company->qr_code) }}">
                                    </div>
                                    <ul class="barcodeLinks">
                                        <li class="d-flex">

                                            <img src="{{ asset('front-end/images/Group 44200.png') }}">
                                            <a href="{{ \Storage::disk('companies')->url($company->qr_code) }}"
                                                download="{{ $company->name }}.png" title="{{ $company->name }}">
                                                تحميل الباركود
                                            </a>
                                        </li>
                                        <li class="d-flex">
                                            <img src="{{ asset('front-end/images/Group 44202.png') }}">
                                            <a href="{{ \Storage::disk('companies')->url($company->qr_code) }}"
                                                target="_blank">
                                                مشاركة الباركود
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="https://maps.google.com?q={{ $company->lat }},{{ $company->long }}">
                                <img src="{{ asset('front-end/images/compainies/location (2).svg') }}">
                                <span>الموقع</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <ul class="addresses">
                        <li>
                            <p class="p1">رخصة فال</p>
                            @if ($company->commercial_register_number)
                                <p class="p2">{{ $company->commercial_register_number }}</p>
                            @endif

                        </li>
                        <li class="d-none">
                            @if ($company->user->is_authorized)
                                <img src="{{ asset('front-end/images/compainies/check.png') }}">
                                <p>موثق</p>
                            @endif
                        </li>
                        <li>
                            <img src="{{ asset('front-end/images/compainies/megaphone.png') }}">
                            <p>{{ $company->user->ads()->count() }}</p>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="filteration">
        <div class="container">
            <div class="row">
                @include('ad::front.filter-sidebar')
                <div class="col-md-8">
                    <div class="featured-aqars pagination" id="result-ads">
                        <div class="row" style="width:100%">
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
            let url = `{{ route('front.companies.show', ['company' => $company->uuid]) }}?${convertArraysToSearch()}`;
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
