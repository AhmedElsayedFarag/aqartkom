<footer>
    <!--start of top-footer -->
    <div class="top-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="log-footer">
                        <div class="logo">
                            <img src="{{ asset('front-end/images/logo-footer.svg') }}">
                        </div>
                        <div class="headquater">
                            <img src="{{ asset('front-end/images/rega-optimized.png') }}">
                            <p>مرخصة من الهيئة العامة للعقار</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="links">
                        <h2>روابط سريعة</h2>
                        <ul>
                            <li><a href="{{ route('front.aqar.index') }}?type=sell">عقارات للبيع</a></li>
                            <li><a href="{{ route('front.aqar.index') }}?type=rent">عقارات للإيجار</a></li>
                            <li><a href="{{ route('front.companies') }}">الشركات العقارية</a></li>
                            <li><a href="{{ route('front.marketers') }}">المسوقين العقارين</a></li>
                            <li><a href="#">الباقات والإشتراكات</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="links">
                        <h2>روابط مهمة</h2>
                        <ul>
                            <li><a href="{{ url('/page/about') }}">من نحن</a></li>
                            <li><a href="{{ route('suggestions.show') }}">الشكاوي والمقترحات</a></li>
                            <li><a href="{{ url('/page/privacy-policy') }}">سياسة الخصوصية</a></li>
                            <li><a href="{{ url('/page/property-rights-policy') }}">حقوق الملكية</a></li>
                            <li><a href="{{ url('/page/terms-conditions') }}">الشروط والأحكام</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="social">
                        <h2>تابعنا علي</h2>
                        <ul class="d-flex">
                            <li><a href="{{ $settings['contact-us']['twitter']['value'] }}"><i
                                        class="fa-brands fa-twitter"></i></a></li>
                            <li><a href="{{ $settings['contact-us']['facebook']['value'] }}"><i
                                        class="fa-brands fa-facebook-f"></i></a></li>
                            <li><a href="{{ $settings['contact-us']['instagram']['value'] }}"><i
                                        class="fa-brands fa-instagram"></i></a></li>
                            <li><a href="{{ $settings['contact-us']['linkedin']['value'] }}"><i
                                        class="fa-brands fa-linkedin-in"></i></a></li>
                        </ul>
                        <div class="number">
                            <h3>الرقم الموحد</h3>
                            <p>
                                <a href="tel:{{ $settings['contact-us']['phone']['value'] }}">
                                    <i class="fa-solid fa-phone-volume"></i>
                                    <span>{{ $settings['contact-us']['phone']['value'] }}</span>
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end of top-footer -->
    <!--start of bottom-footer -->
    <div class="bottom-footer">
        <h2>جميع الحقوق محفوظة لعقارتكم @ {{ now()->format('Y') }}</h2>
    </div>
</footer>
<script>
    function iOS() {
        return [
                'iPad Simulator',
                'iPhone Simulator',
                'iPod Simulator',
                'iPad',
                'iPhone',
                'iPod'
            ].includes(navigator.platform)
            // iPad on iOS 13 detection
            ||
            (navigator.userAgent.includes("Mac") && "ontouchend" in document)
    }

    function isAndroid() {
        var userAgent = navigator.userAgent.toLowerCase();
        return userAgent.indexOf("android") > -1;
    }
    if (isAndroid() || iOS()) {
        window.location.href = "https://m.aqaratikom.com/";
    }
</script>
<!-- end of bottom-footer -->
<!-- end of footer -->
<!--framework js -->
<script src="{{ asset('front-end/js/jquery.js ') }}"></script>
<script src="{{ asset('front-end/js/bootstrap.bundle.min.js ') }}"></script>
<script src="{{ asset('front-end/js/all.min.js ') }}"></script>
<script src="{{ asset('front-end/js/owl.carousel.min.js ') }}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!-- Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.2.2/axios.min.js"
    integrity="sha512-QTnb9BQkG4fBYIt9JGvYmxPpd6TBeKp6lsUrtiVQsrJ9sb33Bn9s0wMQO9qVBFbPX3xHRAsBHvXlcsrnJjExjg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{ asset('front-end/js/main.js ') }}"></script>
@stack('custom-script')
