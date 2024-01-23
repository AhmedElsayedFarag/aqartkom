@extends('admin.layout.base')
@push('stylesStack')
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <style>
        .ts-control {
            overflow: unset !important;
        }
    </style>
@endpush
@section('body')

    <body class="py-5">
        @include('admin.layout.components.success-notification')
        @include('admin.layout.components.mobile-menu')
        <div class="flex">
            <!-- BEGIN: Side Menu -->
            @include('admin.layout.components.side-bar')
            <!-- END: Side Menu -->
            <!-- BEGIN: Content -->
            <div class="content">
                @include('admin.layout.components.top-bar')
                @yield('content')
            </div>
            <!-- END: Content -->
        </div>

        {{-- @include('admin.layout.components.dark-mode-switcher') --}}
        {{-- @include('layout.components.main-color-switcher') --}}

        <!-- BEGIN: JS Assets-->
        {{-- <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js">
        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBG7gNHAhDzgYmq4-EHvM4bqW1DNj2UCuk&libraries=places">
        </script> --}}
        <script src="{{ mix('dist/js/app.js') }}"></script>

        <script>
            axios.defaults.headers.common['X-CSRF-TOKEN'] = document.head.querySelector('meta[name="csrf-token"]').content;
        </script>
        <!-- END: JS Assets-->
        <!-- Twitter conversion tracking event code -->
        <script>
            ! function(e, t, n, s, u, a) {
                e.twq || (s = e.twq = function() {
                        s.exe ? s.exe.apply(s, arguments) : s.queue.push(arguments);
                    }, s.version = '1.1', s.queue = [], u = t.createElement(n), u.async = !0, u.src =
                    'https://static.ads-twitter.com/uwt.js',
                    a = t.getElementsByTagName(n)[0], a.parentNode.insertBefore(u, a))
            }(window, document, 'script');
            twq('config', 'oeznm');
        </script>
        <script type="text/javascript">
            // Insert Twitter Event ID
            twq('event', 'tw-oeznm-oeznn', {
                contents: [ // use this to pass an array of products or content
                    // add all items to the array
                    // use this for the first item
                    {
                        content_type: null,
                        content_id: null,
                        content_name: null,
                        content_price: null,
                        num_items: null,
                        content_group_id: null
                    },
                    // use this for the second item
                    {
                        content_type: null,
                        content_id: null,
                        content_name: null,
                        content_price: null,
                        num_items: null,
                        content_group_id: null
                    }
                ],
                conversion_id: null, // use this to pass a unique ID for the conversion event for deduplication (e.g. order id '1a2b3c')
                email_address: null, // use this to pass a user’s email address
                phone_number: null // phone number in E164 standard
            });
        </script>
        <!-- Twitter conversion tracking base code -->
        <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
        <script>
            // Enable pusher logging - don't include this in production
            Pusher.logToConsole = true;

            var pusher = new Pusher('b17a36730bcb343ca48f', {
                cluster: 'eu'
            });
            var channel = pusher.subscribe("AdminNotificationChannel");
            channel.bind("AdminNotificationEvent", function(data) {
                console.log(data);
                document.getElementById("notification_message").innerHTML = data.message;
                document.getElementById("pusher-notification-toggle").click();
            });

            function copyToClipboard(content) {
                navigator.clipboard.writeText(content);
            }
        </script>
        <!-- End Twitter conversion tracking base code -->
        <!-- End Twitter conversion tracking event code -->
        @yield('script')
        @stack('scriptsStack')
    </body>
@endsection
