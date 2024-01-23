<!DOCTYPE html>

<html>

<head>
    <title>Home</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('landing/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('landing/css/bootstrap-rtl.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('landing/css/all.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('landing/css/hover.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('landing/css/animate.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('landing/css/owl.carousel.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('landing/css/owl.theme.default.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('landing/css/style.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('landing/css/media.css') }}" rel="stylesheet" type="text/css" />
    <script type='text/javascript'>
        (function(e, t, n) {
            if (e.snaptr) return;
            var a = e.snaptr = function() {
                a.handleRequest ? a.handleRequest.apply(a, arguments) : a.queue.push(arguments)
            };
            a.queue = [];
            var s = 'script';
            r = t.createElement(s);
            r.async = !0;
            r.src = n;
            var u = t.getElementsByTagName(s)[0];
            u.parentNode.insertBefore(r, u);
        })(window, document,
            'https://sc-static.net/scevent.min.js');

        snaptr('init', '5d40a5c0-267d-4c25-b954-f5a250117f28', {
            'user_email': '__info@aqaratikom.com__'
        });

        snaptr('track', 'PAGE_VIEW');
    </script>
</head>

<body>
    <section class="intro">
        <div class="container">
            <div class="logo">
                <a href="{{ route('front.index') }}">
                    <img src="{{ asset('landing/images/logo.png') }}">
                </a>
            </div>
            <h2>
                المنصة الحصرية للعقارات
            </h2>
            <p>
                في المملكة العربية السعودية
            </p>
        </div>
    </section>
    <section class="download">
        <h2>حمل التطبيق الآن</h2>
        <p>
            اضغط على الرابط لتحميل تطبيق عقارتكم للهواتف الذكية وتصفح آلاف العقارات المعتمدة من منصة عقارتكم
        </p>
        <ul class="list-group list-group-horizontal">
            <li class="list-group-item">
                <a href="{{ $settings['app']['google_play']['value'] }}">
                    <img src="{{ asset('landing/images/PlayStore.png') }}">
                </a>
            </li>
            <li class="list-group-item">
                <a href="{{ $settings['app']['app_store']['value'] }}">
                    <img src="{{ asset('landing/images/AppStore.png') }}">
                </a>
            </li>
        </ul>
    </section>
    <footer>
        <div class="top-footer">
            <h2>
                تابعنا علي وسائل التواصل الاجتماعي
            </h2>

            <div class="social">
                <a
                    href="https://www.linkedin.com/in/%D8%A7%D9%84%D8%AC%D9%8A%D9%84-%D8%A7%D9%84%D8%AE%D8%A7%D9%85%D8%B3-318336244/">
                    <span><i class="fab fa-linkedin-in"></i></span>
                </a>

                <a href="https://www.instagram.com/5gfordesign/">
                    <span><i class="fab fa-instagram"></i></span>
                </a>

                <a href="https://www.facebook.com/5gfordesignsa/">
                    <span><i class="fab fa-facebook-f"></i></span>
                </a>

                <a href="https://twitter.com/5gfordesign">
                    <span><i class="fab fa-twitter"></i></span>
                </a>

            </div>
            <a href="#">
                <img src="{{ asset('landing/images/gold-logo (2).png') }}">
            </a>

        </div>
    </footer>
    <script src="{{ asset('landing/js/jquery-3.2.1.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('landing/js/popper.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('landing/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('landing/js/all.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('landing/js/owl.carousel.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('landing/js/wow.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('landing/js/main.js') }}" type="text/javascript"></script>
    <script>
        new WOW().init();
    </script>
</body>

</html>
