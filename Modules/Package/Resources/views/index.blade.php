@extends('front-end.main')

@section('content')
    <div class="breadcramp">
        <div class="container">
            <ul class="d-flex">
                <li>
                    <a href="{{ route('front.index') }}">الرئسية</a>
                </li>
                >
                <li>
                    <a href="{{ route('front.profile.ads') }}">الملف الشخصي</a>
                </li>
                >
                <li>
                    <span>الباقات والاشتراكات</span>
                </li>
            </ul>
        </div>
    </div>
    <!--end of breadcramp -->
    <!-- start of myProfile -->
    <section class="myProfile">
        <div class="container">
            <div class="row">
                @include('auth::front-end.profile/sidebar')
                <div class="col-lg-8">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-allPackage" role="tabpanel"
                            aria-labelledby="pills-allPackage-tab">

                            <div class="addAdsData packageTypes">
                                <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                    @foreach ($packages['data'] as $index => $package)
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link {{ $index == 0 ? 'active' : '' }}"
                                                id="pills-{{ $index }}-tab" data-bs-toggle="pill"
                                                data-bs-target="#pills-{{ $index }}" type="button" role="tab"
                                                aria-controls="pills-{{ $index }}" aria-selected="true">
                                                {{ $package['title'] }}
                                            </button>
                                        </li>
                                    @endforeach

                                </ul>
                                <div class="tab-content" id="pills-tabContent">
                                    @foreach ($packages['data'] as $index => $package)
                                        <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}"
                                            id="pills-{{ $index }}" role="tabpanel"
                                            aria-labelledby="pills-{{ $index }}-tab">

                                            <div class="row">
                                                <div class="col-md-8 offset-md-2">
                                                    <div class="packageTypeInfo">
                                                        <h2>{{ $package['price'] }} ر.س</h2>
                                                        <ul>
                                                            @foreach ($package['features'] as $feature)
                                                                <li>
                                                                    <i class="fa-solid fa-circle-check"></i>
                                                                    {{ $feature }}
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                        <a
                                                            href="{{ route('front.pay-package.show', ['package' => $package->id]) }}">الإشتراك
                                                            في الباقة</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
