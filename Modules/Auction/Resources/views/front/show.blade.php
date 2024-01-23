@extends('front-end.main')
@push('custom-head')
    <title>{{ $auction->estate->title }}|{{ $seos['title']['value'] }}</title>
    <meta property="og:title" content="{{ $auction->estate->title }}">
    <meta property="og:type" content="article" />
    <meta property="og:description" content="{{ $auction->estate->title }}">
    <meta property="og:image" content="{{ $auction->estate->media->firstWhere('type', 'image')->formatted_url }}">
    <meta name="twitter:image:alt" content="{{ $auction->estate->title }}">
    {{-- <meta property="og:site_name" content="عقارتكم"> --}}
    <meta property="og:url" content="{{ route('front.auction.show', ['auction' => $auction->uuid]) }}">
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
                    <span>{{ $auction->estate->title }}</span>
                </li>
            </ul>
        </div>
    </div>
    <!--end of breadcramp -->

    <!-- start section of mzad-details -->
    <section class="mzad-details">
        <div class="container">
            <div class="row">
                <input type="hidden" id="lat" value="{{ $auction->estate->lat }}" />
                <input type="hidden" id="long" value="{{ $auction->estate->long }}" />
                <div class="col-lg-8">
                    <input type="hidden" value="{{ $auction->end_at }}" id="timer" />
                    <div class="slider">
                        <div class="owl-carousel owl-theme" id="mzadPhotos">
                            @foreach ($auction->estate->media as $media)
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
                    {{-- <ul class="d-flex features">
                        <li>
                            <img src="{{ asset('front-end/images/icons/true.png') }}">
                            <span>معتمد</span>
                        </li>
                        <li>
                            <span>تمت المشاهدة</span>
                        </li>
                        <li>
                            <img src="{{ asset('front-end/images/icons/area.png') }}">
                            <span>{{ $auction->estate->category->name }}</span>
                        </li>
                        <li>
                            <img src="{{ asset('front-end/images/icons/area.png') }}">
                            <span>{{ $auction->estate->area }} متر</span>
                        </li>
                        <li>
                            <img src="{{ asset('front-end/images/icons/area.png') }}">
                            <span>{{ 'AUC' . str_pad($auction->id, 2, 0, STR_PAD_LEFT) }}</span>
                        </li>
                    </ul> --}}
                    <div class="description">
                        <p class="title">{{ $auction->estate->title }}</p>
                        <p class="content">
                            {{ $auction->estate->address }}
                            <a href="https://maps.google.com?q={{ $auction->estate->lat }},{{ $auction->estate->long }}">عرض
                                علي الخريطة
                                <i class="fa-solid fa-chevron-left"></i>
                            </a>
                        </p>
                        <p class="title">التفاصيل</p>
                        <p class="content">
                            {{ $auction->estate->description }}
                        </p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <ul class="d-flex actions">
                        @auth
                            <li>
                                <button onclick="toggleFavorite('{{ $auction->uuid }}','auction')"
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
                    <div class="mzadPeriod">
                        <div class="remain">
                            <p class="title">متبقي علي انتهاء المزاد</p>
                            <ul class="d-flex">
                                <li>
                                    <p class="number" id="days">00</p>
                                    <p class="date">يوم</p>
                                </li>
                                <li>
                                    <p class="number" id="hours">00</p>
                                    <p class="date">ساعه</p>
                                </li>
                                <li>
                                    <p class="number" id="minutes">00</p>
                                    <p class="date">دقيقه</p>
                                </li>
                            </ul>
                        </div>
                        <div class="mzadAmount d-flex">
                            <div class="total">
                                <p class="title">اعلي مزايدة</p>
                                <p class="content">
                                    <span>{{ number_format($auction->top_price) }}</span>
                                    ريال / م 2
                                </p>
                            </div>
                            <div class="total">
                                <p class="title">السعر الإجمالي</p>
                                <p class="content">
                                    <span>{{ number_format($auction->top_price * $auction->estate->area) }}</span>
                                    ر.س
                                </p>
                            </div>
                        </div>
                        <div class="download">
                            <a href="{{ asset($settings['auction']['auction_document']['value']) }}" for="file-upload"
                                class="custom-file-upload" target="_blank">
                                <img src="{{ asset('front-end/images/icons/download (4).svg') }}">
                                <span>
                                    تحميل النشرة التسويقية للعقار
                                </span>
                            </a>
                            <input id="file-upload" type="file" />
                        </div>
                        @auth
                            @if (!$auction->is_closed && now()->isBefore($auction->end_at))
                                <a href="{{ route('front.auction.bid.show', ['auction' => $auction->uuid]) }}"
                                    class="Participation">المشاركة في المزاد</a>
                            @endif
                        @endauth

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
                                        <span>{{ $auction->estate->area }}</span>
                                        متر
                                    </p>
                                </div>
                            </li>
                            @if ($auction->estate->bedroom)
                                <li class="d-flex">
                                    <div class="right">
                                        <p>عدد الغرف</p>
                                    </div>
                                    <div class="left">
                                        <p>
                                            <span>{{ $auction->estate->bedroom }}</span>
                                            غرف
                                        </p>
                                    </div>
                                </li>
                            @endif
                            @if ($auction->estate->age)
                                <li class="d-flex">
                                    <div class="right">
                                        <p> عمر العقار</p>
                                    </div>
                                    <div class="left">
                                        <p>
                                            <span>{{ $auction->estate->age }}</span>
                                            سنة
                                        </p>
                                    </div>
                                </li>
                            @endif
                            @foreach ($auction->estate->details as $detail)
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
@endsection

@push('custom-script')
    <script src="{{ asset('front-end/js/clipboard.js') }}"></script>
    <script src="{{ asset('front-end/js/favorite.js') }}"></script>
    <script src="{{ asset('front-end/js/auction-timer.js') }}"></script>
    <script async
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBSji4f8rxgtuD-JnkBgm4jrIUaXkFDyCw&callback=initMap&v=weekly&libraries=places">
    </script>
    @include('ad::front.nearby-scripts')
    <script>
        // document.onload = () => {

        // }


        loadTimer();
    </script>
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
