                {{-- <div class="col-md-4">
                    <div class="personal-data">
                        <div class="infoTitle">
                            <figure class="photo">
                                <img src="{{ auth()->user()->formatted_profile }}" class="profile-img">
                            </figure>
                            <h2>
                                {{ auth()->user()->name }}
                                <img src="{{ asset('front-end/images/correct.png') }}">
                            </h2>
                            <p>عضو {{ auth()->user()->formattedSince }}</p>
                        </div>
                        <ul class="nav nav-pills" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link {{ request()->routeIs('front.profile.ads') ? 'active' : '' }}"
                                    href="{{ route('front.profile.ads') }}">
                                    <img src="{{ asset('front-end/images/profile/Path 2658.png') }}">
                                    إعلاناتي
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link {{ request()->routeIs('front.profile.bids') ? 'active' : '' }}"
                                    href="{{ route('front.profile.bids') }}">
                                    <img src="{{ asset('front-end/images/profile/Group 11061.png') }}">
                                    مزايداتي
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link {{ request()->routeIs('front.favorites') ? 'active' : '' }}"
                                    id="pills-fav-tab" href="{{ route('front.favorites') }}">
                                    <img src="{{ asset('front-end/images/profile/heart (1).png') }}">
                                    المفضلة
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link {{ request()->routeIs('front.profile.subscription.show') ? 'active' : '' }}"
                                    href="{{ route('front.profile.subscription.show') }}">
                                    <img src="{{ asset('front-end/images/icons/package.png') }}">
                                    باقاتي واشتراكاتي
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link {{ request()->routeIs('front.profile.packages') ? 'active' : '' }}"
                                    href="{{ route('front.profile.packages') }}">
                                    <img src="{{ asset('front-end/images/icons/Group 44610.svg') }}">
                                    الباقات والإشتراكات
                                </a>
                            </li>
                            @if (auth()->user()->type == 'company')
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link {{ request()->routeIs('front.change-data.show') ? 'active' : '' }}"
                                        id="pills-fav-tab" href="{{ route('front.company-profile.show') }}">
                                        <img src="{{ asset('front-end/images/icons/user.png') }}">
                                        بيانات الشركة
                                    </a>
                                </li>
                            @endif
                            <li class="nav-item" role="presentation">
                                <a class="nav-link {{ request()->routeIs('front.change-data.show') ? 'active' : '' }}"
                                    id="pills-update-tab" href="{{ route('front.change-data.show') }}">
                                    <img src="{{ asset('front-end/images/icons/user.png') }}">
                                    تحديث معلوماتي
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link {{ request()->routeIs('front.change-password.show') ? 'active' : '' }}"
                                    id="pills-update-tab" href="{{ route('front.change-password.show') }}">
                                    <img src="{{ asset('front-end/images/icons/hide.png') }}">
                                    تغير كلمة المرور
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link {{ request()->routeIs('front.change-phone.show') ? 'active' : '' }}"
                                    id="pills-update-tab" href="{{ route('front.change-phone.show') }}">
                                    <img src="{{ asset('front-end/images/icons/telephone-call.png') }}">
                                    تغير رقم الجوال
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="pills-update-tab" href="{{ route('logout') }}">
                                    <img src="{{ asset('front-end/images/profile/Layer 12.png') }}">
                                    تسجيل الخروج
                                </a>
                            </li>
                        </ul>
                    </div>
                </div> --}}

                <div class="col-lg-4">
                    <div class="personal-data">
                        <div class="infoTitle">
                            <div class="right">
                                <p>مرحبا بك</p>
                                <h2>{{ auth()->user()->name }}</h2>
                                <span>عضو {{ auth()->user()->formattedSince }}</span>
                                {{-- <div class="rating-stars">
                                <ul id="stars" class="d-flex">
                                    <li class="star" title="Poor" data-value="1">
                                        <svg class="svg-inline--fa fa-star" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg=""><path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path></svg><!-- <i class="fa-solid fa-star"></i> Font Awesome fontawesome.com -->
                                    </li>
                                    <li class="star" title="Fair" data-value="2">
                                        <svg class="svg-inline--fa fa-star" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg=""><path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path></svg><!-- <i class="fa-solid fa-star"></i> Font Awesome fontawesome.com -->
                                    </li>
                                    <li class="star" title="Good" data-value="3">
                                        <svg class="svg-inline--fa fa-star" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg=""><path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path></svg><!-- <i class="fa-solid fa-star"></i> Font Awesome fontawesome.com -->
                                    </li>
                                    <li class="star" title="Excellent" data-value="4">
                                        <svg class="svg-inline--fa fa-star" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg=""><path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path></svg><!-- <i class="fa-solid fa-star"></i> Font Awesome fontawesome.com -->
                                    </li>
                                    <li class="star" title="WOW!!!" data-value="5">
                                        <svg class="svg-inline--fa fa-star" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg=""><path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path></svg><!-- <i class="fa-solid fa-star"></i> Font Awesome fontawesome.com -->
                                    </li>
                                </ul>
                            </div> --}}
                            </div>
                            <div class="left">
                                <figure class="photo">
                                    <img src="{{ auth()->user()->formatted_profile }}">
                                </figure>
                                @if (!auth()->user()->is_authorized)
                                    <a href="#" class="not-verified" data-bs-toggle="modal"
                                        data-bs-target="#certified">
                                        <img src="{{ asset('front-end/images/badge (2).svg') }}">
                                        توثيق حسابك
                                    </a>
                                @else
                                    <a href="#" class="verified">
                                        <img src="{{ asset('front-end/images/check.svg') }}">
                                        حسابك موثق
                                    </a>
                                @endif
                            </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="certified" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header modal-header-marketing header-certified"
                                        id="modal-head-verify">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close">
                                            <svg class="svg-inline--fa fa-xmark" aria-hidden="true" focusable="false"
                                                data-prefix="fas" data-icon="xmark" role="img"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"
                                                data-fa-i2svg="">
                                                <path fill="currentColor"
                                                    d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z">
                                                </path>
                                            </svg><!-- <i class="fa-solid fa-xmark"></i> Font Awesome fontawesome.com -->
                                        </button>
                                        <h2 class="text-center">توثيق الحساب</h2>
                                    </div>
                                    <div class="modal-body modal-marcketing modal-cerified text-center"
                                        id="modal-body-verify">
                                        <p>الرجاء ادخال رقم الهوية</p>
                                        <input type="text" placeholder="10xxxxxxxx" class="form-control"
                                            id="verify-nationality">
                                        <p id="error-verification" class="d-none">برجاء ادخال رقم هوية صحيح</p>

                                        <button type="submit" onclick="verifyUser()">توثيق</button>
                                    </div>
                                    <input type="hidden"
                                        value="{{ auth()->user()->createToken('access token')->plainTextToken }}"
                                        id="user-token">
                                    <input type="hidden" value="{{ auth()->id() }}" id="user-id">
                                    <div id="verify-section"
                                        class="d-none modal-body modal-marcketing modal-cerified text-center">
                                        <h3 class="verify-title">رقم الطلب</h3>
                                        <p class="verify-message">فضلنا قم بإختيار رقم الطلب الظاهر لديك في تطبيق النفاذ
                                            الوطني</p>
                                        <div class="verify-number" id="verify-number">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <ul class="nav nav-pills" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link {{ request()->routeIs('front.profile.ads') ? 'active' : '' }}"
                                    href="{{ route('front.profile.ads') }}">
                                    <img src="{{ asset('front-end/images/icons/Group 1074.png') }}">
                                    إعلاناتي
                                </a>
                            </li>
                            {{-- <li class="nav-item" role="presentation">

                                <a href="{{ route('front.profile.marketRequest') }}"
                                    class="nav-link {{ request()->routeIs('front.profile.marketRequest') ? 'active' : '' }}">
                                    <img src="{{ asset('front-end/images/icons/market.svg') }}">
                                    طلبات التسويق
                                </a>
                            </li> --}}
                            <li class="nav-item" role="presentation">

                                <a href="{{ route('front.profile.licenceRequest') }}"
                                    class="nav-link {{ request()->routeIs('front.profile.licenceRequest') || request()->routeIs('front.profile.licenceRequestState') ? 'active' : '' }}">
                                    <img src="{{ asset('front-end/images/icons/Group 44609.svg') }}">
                                    طلبات الترخيص بواسطة عقارتكم
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link {{ request()->routeIs('front.favorites') ? 'active' : '' }}"
                                    id="pills-fav-tab" href="{{ route('front.favorites') }}">
                                    <img src="{{ asset('front-end/images/icons/heart.svg') }}">
                                    المفضلة
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link {{ request()->routeIs('front.profile.subscription.show') ? 'active' : '' }}"
                                    href="{{ route('front.profile.subscription.show') }}">
                                    <img src="{{ asset('front-end/images/icons/package.png') }}">
                                    باقاتي واشتراكاتي
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link {{ request()->routeIs('front.profile.packages') ? 'active' : '' }}"
                                    href="{{ route('front.profile.packages') }}">
                                    <img src="{{ asset('front-end/images/icons/Group 44610.svg') }}">

                                    الباقات والإشتراكات
                                </a>
                            </li>
                            @if (auth()->user()->type == 'company')
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link {{ request()->routeIs('front.company-profile.show') ? 'active' : '' }}"
                                        id="pills-fav-tab" href="{{ route('front.company-profile.show') }}">
                                        <img src="{{ asset('front-end/images/icons/user.png') }}">
                                        بيانات الشركة
                                    </a>
                                </li>
                            @endif
                            <li class="nav-item" role="presentation">
                                <a class="nav-link {{ request()->routeIs('front.change-data.show') ? 'active' : '' }}"
                                    id="pills-update-tab" href="{{ route('front.change-data.show') }}">

                                    <img src="{{ asset('front-end/images/icons/user.png') }}">
                                    معلوماتي
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link {{ request()->routeIs('front.change-phone.show') ? 'active' : '' }}"
                                    id="pills-update-tab" href="{{ route('front.change-phone.show') }}">
                                    <img src="{{ asset('front-end/images/icons/telephone-call.png') }}">
                                    تغير رقم الجوال
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link {{ request()->routeIs('front.change-password.show') ? 'active' : '' }}"
                                    id="pills-update-tab" href="{{ route('front.change-password.show') }}">
                                    <img src="{{ asset('front-end/images/icons/hide.png') }}">
                                    تغير كلمة المرور
                                </a>
                            </li>

                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="pills-update-tab" href="{{ route('logout') }}">
                                    <img src="{{ asset('front-end/images/icons/logout.svg') }}">
                                    تسجيل الخروج
                                </a>
                            </li>

                        </ul>
                    </div>
                </div>

                @push('custom-script')
                    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
                    <script src="{{ asset('front-end/js/verify-user.js') }}">
                        // Enable pusher logging - don't include this in production
                    </script>
                @endpush
