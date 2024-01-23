@extends('front-end.main')
@push('custom-head')
    <title>{{ $ad->estate->title }}|{{ $seos['title']['value'] }}</title>
    <meta property="og:title" content="{{ $ad->estate->title }}">
    <meta property="og:type" content="article" />
    <meta property="og:description" content="{{ $ad->estate->title }}">
    <meta property="og:image" content="{{ $ad->estate->media->firstWhere('type', 'image')->formatted_url }}">
    <meta name="twitter:image:alt" content="{{ $ad->estate->title }}">
    {{-- <meta property="og:site_name" content="عقارتكم"> --}}
    <meta property="og:url" content="{{ route('front.aqar.show', ['ad' => $ad->uuid]) }}">
    {{-- <meta name="twitter:card" content="summary_large_image"> --}}
@endpush
@section('content')
    <!-- start of breadcramp-->
    <div class="breadcramp">
        <div class="container">
            <ul class="d-flex">
                <li>
                    <a href="{{ route('front.index') }}">الرئسية</a>
                </li>
                >

                <li>
                    <span>{{ $ad->estate->title }}</span>
                </li>
            </ul>
        </div>
    </div>
    <!--end of breadcramp -->

    <!-- start section of mzad-details -->
    <section class="mzad-details theAqarDetails">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="slider">
                        <div class="owl-carousel owl-theme" id="mzadPhotos">
                            @foreach ($ad->estate->media as $media)
                                @if ($media->type == 'image')
                                    <div class="box">
                                        <figure class="photo">
                                            <img src="{{ $media->formatted_url }}">
                                        </figure>
                                    </div>
                                @else
                                    <div class="box">
                                        <video controls>
                                            <source src="{{ $media->formatted_url }}" type="video/mp4">
                                        </video>
                                    </div>
                                @endif
                            @endforeach

                        </div>
                    </div>
                    <input type="hidden" id="lat" value="{{ $ad->estate->lat }}" />
                    <input type="hidden" id="long" value="{{ $ad->estate->long }}" />
                    {{-- <ul class="d-flex features">
                        <li>
                            <img src="{{ asset('front-end/images/icons/true.png') }}">
                            <span>معتمد</span>
                        </li>
                        <li>
                            <span>تمت المشاهدة</span>
                        </li>
                    </ul> --}}
                    <div class="description">
                        <p class="title">{{ $ad->estate->title }}</p>
                        <p class="content">
                            {{ $ad->estate->address }}
                            <a href="https://maps.google.com?q={{ $ad->estate->lat }},{{ $ad->estate->long }}">عرض علي
                                الخريطة
                                <i class="fa-solid fa-chevron-left"></i>
                            </a>
                        </p>
                        <p class="title">التفاصيل</p>
                        <p class="content">
                            {{ $ad->estate->description }}
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <ul class="d-flex actions">
                        @auth
                            <li>
                                <button onclick="toggleFavorite('{{ $ad->uuid }}','ad')"
                                    data-favorite="{{ $isFavorite ? '1' : '0' }}">
                                    <span id="favorite" class="{{ $isFavorite ? 'd-none' : '' }}">
                                        <i class="fa-regular fa-heart"></i>
                                    </span>
                                    <span id="unfavorite" class="{{ $isFavorite ? '' : 'd-none' }}">
                                        <i class="fa-solid fa-heart"></i>
                                    </span>
                                    المفضلة
                                </button>
                            </li>
                        @endauth

                        <li>
                            <button onclick="copyContent(location.href)">
                                <i class="fa-solid fa-share"></i>
                                مشاركة
                            </button>
                        </li>
                        {{-- <li>
                            <button>
                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                إبلاع عن العقار
                            </button>
                        </li> --}}
                    </ul>
                    <div class="mzadPeriod aqarperiod">
                        <h2 class="price">
                            {{ \number_format($ad->price) }}
                            <span>ر.س</span>
                        </h2>
                        <p class="sub">
                            {{ ceil($ad->price / $ad->estate->area) }} ر.س/متر
                        </p>
                        <ul class="d-flex">
                            <li>{{ $ad->formattedStatus }}</li>
                            <li>
                                <img src="{{ asset('front-end/images/newIcons/view.png') }} " />
                                {{ $ad->views }}
                            </li>
                            <li>
                                <img src="{{ asset('front-end/images/newIcons/Group 546.png') }} " />
                                {{ $ad->estate->category->name }}
                            </li>
                            @if ($ad->is_furniture)
                                <li>مفروشه</li>
                            @else
                                <li> غير مفروشه</li>
                            @endif
                        </ul>
                        <div class="words">
                            <h2>تسويق وإدارة العقار من قبل الوسيط</h2>
                            <p>
                                الرقم المرجعي {{ $ad->id }} | خر تحديث: منذ {{ $ad->formattedAcceptedDate }}
                                {{-- <br> --}}
                                {{-- رقم المعلن بالهيئة العامة للعقار : 5272507 --}}
                            </p>
                        </div>
                        <div class="call d-flex">
                            <div class="whatsapp">
                                <a href="https://wa.me/{{ \str_replace('+', '', \get_whatsapp_number($ad->owner)) }}?text=السلام عليكم %0Aاتواصل معك بخصوص إعلانكم على موقع عقاراتكم %0A({{ $ad->estate->title }})
                                    %0A{{ $ad->shareLink }}"
                                    target="_blank">
                                    <img src="{{ asset('front-end/images/icons/whatsapp.svg') }}">
                                    واتساب
                                </a>
                            </div>
                            <div class="phone">
                                <a href="tel:{{ get_contact_number($ad->owner) }}" target="_blank">
                                    <i class="fa-solid fa-phone-volume"></i>
                                    اتصل بنا
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- end section of mzad-details -->

    <!-- start section of aqarDescription -->
    <section class="aqarDescription">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="info">
                        <h2 class="title">مواصفات العقار</h2>
                        <ul>
                            <li class="d-flex">
                                <div class="right">
                                    <p>المساحه</p>
                                </div>
                                <div class="left">
                                    <p>
                                        <span>{{ $ad->estate->area }}</span>
                                        متر
                                    </p>
                                </div>
                            </li>
                            @if ($ad->estate->bedroom)
                                <li class="d-flex">
                                    <div class="right">
                                        <p>عدد الغرف</p>
                                    </div>
                                    <div class="left">
                                        <p>
                                            <span>{{ $ad->estate->bedroom }}</span>
                                            غرف
                                        </p>
                                    </div>
                                </li>
                            @endif
                            @if ($ad->estate->age)
                                <li class="d-flex">
                                    <div class="right">
                                        <p> عمر العقار</p>
                                    </div>
                                    <div class="left">
                                        <p>
                                            <span>{{ $ad->estate->age }}</span>
                                            سنة
                                        </p>
                                    </div>
                                </li>
                            @endif
                            @foreach ($ad->estate->details as $detail)
                                <li class="d-flex">
                                    <div class="right">
                                        <p>{{ $detail->attribute->name }}</p>
                                    </div>
                                    <div class="left">
                                        <p>
                                            <span>{{ $detail->attributeValue?->value ?? $detail->value['value'] }}</span>
                                            {{ $detail->attribute->unit }}
                                        </p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-md-8">
                    @include('ad::front.map')
                </div>
            </div>
        </div>
    </section>
    <section class="featured-aqars">
        <div class="container">
            <div class="the-title">
                <div class="first">
                    <h2>
                        {{-- <img style="padding-left: 5px;" src="{{ asset('front-end/images/icons/placeholder.png') }}" /> --}}
                        العقارات المجاورة
                    </h2>
                    <p class="d-inline">
                        عقارات بالقرب من هذا العقار
                    </p>
                </div>
                <div class="second">
                    <a href="{{ route('front.aqar.index') . '?city=' . $ad->estate->city_id . '&neighborhood=' . $ad->estate->neighborhood_id }}"
                        class="link-style-small"><span>عرض الكل</span></a>
                </div>
            </div>
            <div class="row">
                @foreach ($nearbyAds as $nearbyAd)
                    <div class="col-lg-4 col-md-6" data-sal-duration="700" data-sal="slide-up">
                        <div class="feat">

                            <div class="parent d-flex">

                                <div class="photo">
                                    @if ($nearbyAd->is_licensed)
                                        <a href="{{ route('front.aqar.show', ['ad' => $nearbyAd->uuid]) }}">
                                            <img src="{{ asset($nearbyAd->estate->media->first()->url) }}">
                                        </a>
                                    @else
                                        <a href="javascript:;" data-bs-toggle="modal"
                                            data-bs-target="#not-licensed-ad-modal">
                                            <img src="{{ asset($nearbyAd->estate->media->first()->url) }}">
                                        </a>
                                    @endif
                                    <div class="d-flex">
                                        @if ($nearbyAd->status->value == 'approved')
                                            <div class="verify">
                                                <span>نشط</span>
                                            </div>
                                        @else
                                            <div class="verify unactive">
                                                <span>غير نشط</span>
                                            </div>
                                        @endif
                                        @if ($nearbyAd->is_licensed)
                                            <div class="verify">
                                                <span>مرخص</span>
                                            </div>
                                        @else
                                            <div class="verify unactive">
                                                <span>غير مرخص</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="info">
                                    <p class="title">
                                        @if ($nearbyAd->is_licensed)
                                            <a href="{{ route('front.aqar.show', ['ad' => $nearbyAd->uuid]) }}">
                                                {{ $nearbyAd->estate->title }}
                                            </a>
                                        @else
                                            <a href="javascript:;" data-bs-toggle="modal"
                                                data-bs-target="#not-licensed-ad-modal">
                                                {{ $nearbyAd->estate->title }}
                                            </a>
                                        @endif
                                    </p>
                                    <p class="sub-title">
                                        {{ $nearbyAd->estate->address }}
                                    </p>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="amount">
                                                <span><img
                                                        src="{{ asset('front-end/images/menu (3).png') }}">{{ $nearbyAd->estate->category->name }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="amount">
                                                <span><img
                                                        src="{{ asset('front-end/images/Group 539.png') }}">{{ $nearbyAd->formattedAcceptedDate }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="amount">
                                                <span>
                                                    <img src="{{ asset('front-end/images/Group 541.svg') }}">
                                                    {{ $nearbyAd->views }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="amount">
                                                <span>
                                                    <img src="{{ asset('front-end/images/Group 44464.svg') }}">
                                                    {{ $nearbyAd->estate->area }} متر
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="price">
                                                <p> {{ \number_format($nearbyAd->price) }} ريال</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if ($nearbyAd->is_licensed)
                                <a href="{{ route('front.aqar.show', ['ad' => $nearbyAd->uuid]) }}"
                                    class="watch-details">
                                    مشاهدة تفاصيل الإعلان
                                    <i class="fa-solid fa-arrow-left"></i>
                                </a>
                            @else
                                <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#not-licensed-ad-modal"
                                    class="watch-details">
                                    مشاهدة تفاصيل الإعلان
                                    <i class="fa-solid fa-arrow-left"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @include('partials.not-licensed-ads');
@endsection
@push('custom-script')
    <script src="{{ asset('front-end/js/clipboard.js') }}"></script>
    <script src="{{ asset('front-end/js/favorite.js') }}"></script>
    <script async
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBSji4f8rxgtuD-JnkBgm4jrIUaXkFDyCw&callback=initMap&v=weekly&libraries=places">
    </script>
    @include('ad::front.nearby-scripts')
@endpush
@push('custom-style')
    <style>
        #nearby-places {
            height: 400px;
        }

        .nearby ul li.active {
            color: #262F6A;

        }
    </style>
@endpush
