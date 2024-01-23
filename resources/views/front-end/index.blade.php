@extends('front-end.main')
@section('content')
    <div class="main-search">
        <video autoplay loop muted class="myVideo">
            <source src="{{ asset('front-end/segment.mp4') }}" type="video/mp4" />
        </video>
        <!-- end The video -->
        <!-- start search-aqar -->
        <div class="main-content">
            <div class="content">
                <h2>المنصة الحصرية للعقارات</h2>
                <p>في المملكة العربية السعودية</p>
                <form method="" action="">
                    <div class="searchBy">
                        <input type="text" id="theCity" class="form-control"
                            placeholder="البحث باسم المدينة أو القسم " />

                        <button type="submit ">
                            <img src="{{ asset('front-end/images/icons/search.png') }} " />
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <!-- end search-aqar -->
    </div>
    <section class="featured-services">
        <div class="container">
            <div class="the-title">
                <div class="first">
                    <h2>
                        <img style="padding-left: 5px;" src="{{ asset('front-end/images/group-icon.svg') }}" />
                        خدمات عقاراتكم المميزة
                    </h2>
                    <p>جاهزون لتلبية احتياجاتك بخدماتنا المميزة</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <a href="{{ route('front.aqar.index') }}?type=sell">
                        <div class="service">
                            <div class="parent">
                                <div class="right">
                                    <div class="photo">
                                        <img src="{{ asset('front-end/images/services/Group 44323.svg') }}">
                                    </div>
                                    <div class="content">
                                        <h2>عقارات للبيع</h2>
                                        <p>هل تبحث عن عقار للبيع</p>
                                    </div>
                                </div>
                                <div class="left">
                                    <div class="icon"><i class="fa-solid fa-chevron-left"></i></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="{{ route('front.companies') }}">
                        <div class="service">
                            <div class="parent">
                                <div class="right">
                                    <div class="photo">
                                        <img src="{{ asset('front-end/images/services/Group 44205.svg') }}">
                                    </div>
                                    <div class="content">
                                        <h2>الشركات العقارية</h2>
                                        <p>البحث عن الشركات العقارية في مدينتك</p>
                                    </div>
                                </div>
                                <div class="left">
                                    <div class="icon"><i class="fa-solid fa-chevron-left"></i></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="{{ route('front.aqar.index') }}?type=rent">
                        <div class="service">
                            <div class="parent">
                                <div class="right">
                                    <div class="photo">
                                        <img src="{{ asset('front-end/images/services/Group 44324.svg') }}">
                                    </div>
                                    <div class="content">
                                        <h2>عقارات للإيجار</h2>
                                        <p>هل تبحث عن عقار للإيجار</p>
                                    </div>
                                </div>
                                <div class="left">
                                    <div class="icon"><i class="fa-solid fa-chevron-left"></i></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="{{ route('front.marketers') }}">
                        <div class="service">
                            <div class="parent">
                                <div class="right">
                                    <div class="photo">
                                        <img src="{{ asset('front-end/images/services/Group 44325.svg') }}">
                                    </div>
                                    <div class="content">
                                        <h2>المسوقون العقاريون</h2>
                                        <p>البحث عن المسوقون العقاريون في مدينتك</p>
                                    </div>
                                </div>
                                <div class="left">
                                    <div class="icon"><i class="fa-solid fa-chevron-left"></i></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @auth
                    {{--  <div class="col-md-6">
                        @if (auth()->user()->type != 'marketer')
                            <a href="#" data-bs-toggle="modal" data-bs-target="#marketRequest">
                            @else
                                <a href="{{ route('front.marketing-requests.index') }}">
                        @endif
                         <div class="service">
                            <div class="parent">
                                <div class="right">
                                    <div class="photo">
                                        <img src="{{ asset('front-end/images/services/Group 44325.svg') }}">
                                    </div>
                                    <div class="content">
                                        <h2>طلبات التسويق</h2>
                                        <p>طلبات التسويق الخاصة بملاك العقارات</p>
                                    </div>
                                </div>
                                <div class="left">
                                    <div class="icon"><i class="fa-solid fa-chevron-left"></i></div>
                                </div>
                            </div>
                        </div>
                        </a>

                    </div> --}}
                @endauth
                <!-- Modal -->
                <div class="modal fade" id="marketRequest" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header modal-header-marketing">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>
                            <div class="modal-body modal-marcketing text-center">
                                <img src="{{ asset('front-end/images/Layer_x0020_1.svg') }}">
                                <h2>عذرا</h2>
                                <p>هذه الخدمة متاحة للمسوقين العقارين والشركات العقارية</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <a href="{{ route('front.mortgage.showForm') }}">
                        <div class="service">
                            <div class="parent">
                                <div class="right">
                                    <div class="photo">
                                        <img src="{{ asset('front-end/images/mortgage.svg') }}">
                                    </div>
                                    <div class="content">
                                        <h2>التمويل العقاري</h2>
                                        <p>قدم طلبك الأن للحصول علي تمويل عقاري</p>
                                    </div>
                                </div>
                                <div class="left">
                                    <div class="icon"><i class="fa-solid fa-chevron-left"></i></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- end of featured-services  -->
    <!--start of add-aqar -->
    <section class="add-aqar">
        <div class="container">
            <div class="the-title">
                <div class="first">
                    <h2>
                        هل عندك عقار للبيع او للايجار؟
                    </h2>
                    <p>
                        يمكنك تسويق عقارك على موقعنا بكل سهولة، او بإمكانك تفويض فريق عقاراتكم
                        لبيع وتأجير العقار بالنيابة عنك بكل سهولة
                    </p>
                    <a href="{{ route('front.ad.create') }}">أضف عقارك الأن</a>
                </div>
                <div class="second">
                    <a href="{{ route('front.ad.create') }}">
                        <img src="{{ asset('front-end/images/add-property.png') }}" />
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!--end of add-aqar -->

    <!--start of featured-aqars -->
    <section class="featured-aqars">
        <div class="container">
            <div class="the-title">
                <div class="first">
                    <h2>
                        <img style="padding-left: 5px;" src="{{ asset('front-end/images/icons/placeholder.png') }}" />
                        العقارات المميزة
                    </h2>
                    <p>تصفح أفضل العقارات المميزة علي منصة عقارتكم</p>
                </div>
                <div class="second">
                    <a href="{{ route('front.aqar.index') }}" class="link-style-small">
                        <span>عرض الكل</span>
                    </a>
                </div>
            </div>
            <div class="row">
                @foreach ($latestAds as $ad)
                    <div class="col-lg-4 col-md-6" data-sal-duration="700" data-sal="slide-up">
                        <div class="feat">
                            <div class="parent d-flex">
                                <div class="photo">
                                    @if ($ad->is_licensed)
                                        <a href="{{ route('front.aqar.show', ['ad' => $ad->uuid]) }}">
                                            <img src="{{ asset($ad->estate->images->first()->url) }}" class="photo" />
                                        </a>
                                    @else
                                        <a href="javascript:;" data-bs-toggle="modal"
                                            data-bs-target="#not-licensed-ad-modal">
                                            <img src="{{ asset($ad->estate->images->first()->url) }}" class="photo" />
                                        </a>
                                    @endif
                                    <div class="d-flex">

                                        <div class="verify ">
                                            <span> نشط</span>
                                        </div>

                                        @if ($ad->is_licensed)
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
                                        @if ($ad->is_licensed)
                                            <a href="{{ route('front.aqar.show', ['ad' => $ad->uuid]) }}">
                                                {{ $ad->estate->title }}
                                            </a>
                                        @else
                                            <a href="javascript:;" data-bs-toggle="modal"
                                                data-bs-target="#not-licensed-ad-modal">
                                                {{ $ad->estate->title }}
                                            </a>
                                        @endif
                                    </p>
                                    <p class="sub-title">{{ $ad->estate->address }}</p>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="amount">
                                                <span><img src="{{ asset('front-end/images/menu (3).png') }}">
                                                    {{ $ad->estate->category->name }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="amount">
                                                <span><img
                                                        src="{{ asset('front-end/images/Group 539.png') }}">{{ $ad->formattedAcceptedDate }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="amount">
                                                <span><img
                                                        src="{{ asset('front-end/images/Group 44848.svg') }}">{{ ceil($ad->price / $ad->estate->area) }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="amount">
                                                <span><img
                                                        src="{{ asset('front-end/images/Group 44464.svg') }}">{{ $ad->estate->area }}
                                                    متر</span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="price">
                                                <p>{{ $ad->price }} ريال</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            @if ($ad->is_licensed)
                                <a href="{{ route('front.aqar.show', ['ad' => $ad->uuid]) }}" class="watch-details">
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
    <!--end of featured-aqars -->

    <!--start of download app -->
    <section class="add-aqar downloadNow" style="margin-top:4rem">
        <div class="container">
            <div class="the-title">
                <div class="first">
                    <h2>
                        حمل التطبيق الآن
                    </h2>
                    <p>
                        اضغط على الرابط لتحميل تطبيق عقارتكم للهواتف الذكية وتصفح آلاف
                        العقارات المعتمدة من منصة عقارتكم
                    </p>
                    <ul class="d-flex">
                        <li>
                            <a href="{{ $settings['app']['google_play']['value'] }}"><img
                                    src="{{ asset('front-end/images/app/PlayStore.png') }}" /></a>
                        </li>
                        <li>
                            <a href="{{ $settings['app']['app_store']['value'] }}" class="hvr-bounce-in"><img
                                    src="{{ asset('front-end/images/app/AppStore.png') }}" /></a>
                        </li>
                    </ul>
                </div>
                <div class="second">
                    <img src="{{ asset('front-end/images/app/mobile.png') }}" />
                </div>
            </div>
        </div>
    </section>
    @include('partials.not-licensed-ads');
    <!--end of download app -->
@endsection
@push('custom-script')
    <script>
        document.querySelectorAll('.categories .single').forEach((element) => element.addEventListener('click', () => {
            location.href = element.attributes.href.value;
        }));
    </script>
@endpush
