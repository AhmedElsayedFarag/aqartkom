    <!--start of top-header -->
    <header>
        <!--start of top-header -->
        <div class="top-header">
            <p>المنصة الحصرية للعقارات في المملكة</p>
        </div>
        <!--end of top-header -->
        <!--start of navbar -->
        <nav class="navbar navbar-expand-lg navbar-light shadow-navbar">
            <div class="container">
                <a class="navbar-brand" href="{{ route('front.index') }}"><img class="logo-img"
                        src="{{ asset('logo.png') }}" /></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#navbarSupportedContent">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <div class="offcanvas offcanvas-top" id="navbarSupportedContent">
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('front.index') ? 'active' : '' }}"
                                aria-current="page" href="{{ route('front.index') }}">
                                الرئيسيه
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('front.companies') ? 'active' : '' }}"
                                href="{{ route('front.aqar.index') }}?type=sell">البحث</a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle help-toggle" href="#" id="navbarDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                المساعدة
                            </a>
                            <ul class="dropdown-menu help" aria-labelledby="navbarDropdown">
                                <li>
                                    <p>للاستعلامات والاستفسارات</p>
                                    <a href="tel:{{ $settings['contact-us']['phone']['value'] }}">
                                        {{ $settings['contact-us']['phone']['value'] }}
                                        &nbsp;
                                        <img src="{{ asset('front-end/images/icons/phone-call (4).svg') }}">
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <div class="actions">
                        <ul class="d-flex">
                            <li class="download dropdown">
                                <a href="#" class="link-style-small dropdown-toggle" id="navbarDropdown"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span>
                                        <i class="fa-solid fa-download"></i>
                                        حمل التطبيق
                                    </span>
                                </a>
                                <ul class="dropdown-menu download-app" aria-labelledby="navbarDropdown">
                                    <li>
                                        <p>متوفر علي المتاجر</p>
                                        <ul>
                                            <li>
                                                <a href="{{ $settings['app']['google_play']['value'] }}"><img
                                                        src="{{ asset('front-end/images/PlayStore.svg') }}"></a>
                                            </li>
                                            <li>
                                                <a href="{{ $settings['app']['app_store']['value'] }}"><img
                                                        src="{{ asset('front-end/images/AppStore.svg') }}"></a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li class="add">
                                <a href="{{ route('front.user.ad-steps.show-form') }}" class="link-style-small">
                                    <span>
                                        <i class="fa-solid fa-house-chimney"></i>
                                        إضافة عقار
                                    </span>
                                </a>
                            </li>
                            @guest
                                <li class="login">
                                    <a href="{{ route('front.login') }}" class="link-style-small">
                                        <span>
                                            <i class="fa-regular fa-user"></i>
                                            تسجيل الدخول
                                        </span>
                                    </a>
                                </li>
                            @endguest
                            @auth
                                <li class="dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <img src="{{ auth()->user()->formatted_profile }}" class="profile-img-nav">
                                        {{ auth()->user()->name }}
                                        <i class="fa-solid fa-angle-down"></i>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown" style="height: auto">
                                        <li><a class="dropdown-item" href="{{ route('front.profile.ads') }}">لوحة
                                                التحكم</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('logout') }}">تسجيل خروج</a>
                                        </li>
                                    </ul>
                                </li>
                            @endauth
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <!--end of navbar -->
    </header>
    <!-- end of top-header -->
