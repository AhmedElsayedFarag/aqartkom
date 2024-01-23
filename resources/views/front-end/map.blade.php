<!DOCTYPE html>
<html lang="en" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .marker-label {
            padding-bottom: 15px;
        }
    </style>
    <link href="{{ asset('front-end/css/style.css') }}" rel="stylesheet" />


</head>

<body>
    <div id="map" style="width:100%;height:400px;direction: ltr !important;"></div>

    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

    <script async
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBSji4f8rxgtuD-JnkBgm4jrIUaXkFDyCw&callback=initMap&libraries=marker&v=beta">
    </script>
    <script>
        function initMap() {
            const center = {
                lat: 37.43238031167444,
                lng: -122.16795397128632,
            };
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 11,
                center,
                mapId: "4504f8b37365c3d0",
            });

            for (const property of properties) {
                const advancedMarkerView = new google.maps.marker.AdvancedMarkerView({
                    map,
                    content: buildContent(property),
                    position: property.position,
                    title: property.description,
                });
                const element = advancedMarkerView.element;
                console.log(advancedMarkerView);
                ["focus", "pointerenter"].forEach((event) => {
                    element.addEventListener(event, () => {
                        highlight(advancedMarkerView, property);
                    });
                });
                ["blur", "pointerleave"].forEach((event) => {
                    element.addEventListener(event, () => {
                        unhighlight(advancedMarkerView, property);
                    });
                });
                advancedMarkerView.addListener("click", (event) => {
                    unhighlight(advancedMarkerView, property);
                });
            }
        }

        function highlight(markerView, property) {
            markerView.content.classList.add("highlight");
            markerView.element.style.zIndex = 1;
        }

        function unhighlight(markerView, property) {
            markerView.content.classList.remove("highlight");
            markerView.element.style.zIndex = "";
        }

        function buildContent(property) {
            const content = document.createElement("div");
            content.style.backgroundImage = "url({{ asset('front-end/map-markers/selectedMarker.svg') }})";
            content.classList.add("property");
            content.innerHTML = `
    <div class="icon">
        ${property.price}
    </div>
    <div class="details">
        <div class="d-flex">
        <div class="photo-map">
            <img src=${property.url}>
            </div>
            <div class="info-map">
        <h2 class="map-address">${property.address}</h2>
        <h2 class="map-location">${property.place}</h2>
        <h2 class="map-size">${property.size}</h2>
        <h2 class="map-hour">${property.hour}</h2>
        <h3 class="map-price">${property.price}</h3>
        </div>
       </div>
        <div class="features">

            <ul class="d-flex mapLinks">
                <li><a href=${property.whatsapp}>واتساب <img src="{{ asset('front-end/images/icons/whatsapp.svg') }}"></a></li>
                <li><a href=${property.appointment}>حجز موعد <i class="fa-solid fa-calendar-days"></i></a></li>
                <li><a href=${property.phone}>اتصل بنا <i class="fa-solid fa-phone-volume"></i></a></li>
                </ul>

        </div>
    </div>
    `;
            return content;
        }

        const properties = [{
                address: "فيلا للبيع حي النرجس",
                description: "فيلا للبيع حي النرجس",
                price: "1.5 مليون ريال",
                place: 'النرجس ، شمال ، الرياض',
                size: '350 متر',
                hour: 'تم إضافتها قبل 16 يوم',
                url: "{{ asset('front-end/images/mapimage.png') }}",
                whatsapp: '#',
                phone: '#',
                appointment: '#',

                position: {
                    lat: 37.50024109655184,
                    lng: -122.28528451834352,
                },
            },
            {
                address: "فيلا للبيع حي النرجس",
                description: "فيلا للبيع حي النرجس",
                price: "1.5 مليون ريال",
                place: 'النرجس ، شمال ، الرياض',
                size: '350 متر',
                hour: 'تم إضافتها قبل 16 يوم',
                url: "{{ asset('front-end/images/mapimage.png') }}",
                whatsapp: '#',
                phone: '#',
                appointment: '#',

                position: {
                    lat: 37.44440882321596,
                    lng: -122.2160620727,
                },
            },
            {
                address: "فيلا للبيع حي النرجس",
                description: "فيلا للبيع حي النرجس",
                price: "1.5 مليون ريال",
                place: 'النرجس ، شمال ، الرياض',
                size: '350 متر',
                hour: 'تم إضافتها قبل 16 يوم',
                url: "{{ asset('front-end/images/mapimage.png') }}",
                whatsapp: '#',
                phone: '#',
                appointment: '#',

                position: {
                    lat: 37.39561833718522,
                    lng: -122.21855116258479,
                },
            },
            {
                address: "فيلا للبيع حي النرجس",
                description: "فيلا للبيع حي النرجس",
                price: "1.5 مليون ريال",
                place: 'النرجس ، شمال ، الرياض',
                size: '350 متر',
                hour: 'تم إضافتها قبل 16 يوم',
                url: "{{ asset('front-end/images/mapimage.png') }}",
                whatsapp: '#',
                phone: '#',
                appointment: '#',

                position: {
                    lat: 37.423928529779644,
                    lng: -122.1087629822001,
                },
            },
            {
                address: "فيلا للبيع حي النرجس",
                description: "فيلا للبيع حي النرجس",
                price: "1.5 مليون ريال",
                place: 'النرجس ، شمال ، الرياض',
                size: '350 متر',
                hour: 'تم إضافتها قبل 16 يوم',
                url: "{{ asset('front-end/images/mapimage.png') }}",
                whatsapp: '#',
                phone: '#',
                appointment: '#',

                position: {
                    lat: 37.40578635332598,
                    lng: -122.15043378466069,
                },
            },
            {
                address: "فيلا للبيع حي النرجس",
                description: "فيلا للبيع حي النرجس",
                price: "1.5 مليون ريال",
                place: 'النرجس ، شمال ، الرياض',
                size: '350 متر',
                hour: 'تم إضافتها قبل 16 يوم',
                url: "{{ asset('front-end/images/mapimage.png') }}",
                whatsapp: '#',
                phone: '#',
                appointment: '#',

                position: {
                    lat: 37.36399747905774,
                    lng: -122.10465384268522,
                },
            },
            {
                address: "فيلا للبيع حي النرجس",
                description: "فيلا للبيع حي النرجس",
                price: "1.5 مليون ريال",
                place: 'النرجس ، شمال ، الرياض',
                size: '350 متر',
                hour: 'تم إضافتها قبل 16 يوم',
                url: "{{ asset('front-end/images/mapimage.png') }}",
                whatsapp: '#',
                phone: '#',
                appointment: '#',

                position: {
                    lat: 37.38343706184458,
                    lng: -122.02340436985183,
                },
            },
            {
                address: "فيلا للبيع حي النرجس",
                description: "فيلا للبيع حي النرجس",
                price: "1.5 مليون ريال",
                place: 'النرجس ، شمال ، الرياض',
                size: '350 متر',
                hour: 'تم إضافتها قبل 16 يوم',
                url: "{{ asset('front-end/images/mapimage.png') }}",
                whatsapp: '#',
                phone: '#',
                appointment: '#',

                position: {
                    lat: 37.34576403052,
                    lng: -122.04455090047453,
                },
            },
            {
                address: "فيلا للبيع حي النرجس",
                description: "فيلا للبيع حي النرجس",
                price: "1.5 مليون ريال",
                place: 'النرجس ، شمال ، الرياض',
                size: '350 متر',
                hour: 'تم إضافتها قبل 16 يوم',
                url: "{{ asset('front-end/images/mapimage.png') }}",
                whatsapp: '#',
                phone: '#',
                appointment: '#',

                position: {
                    lat: 37.362863347890716,
                    lng: -121.97802139023555,
                },
            },
            {
                address: "فيلا للبيع حي النرجس",
                description: "فيلا للبيع حي النرجس",
                price: "1.5 مليون ريال",
                place: 'النرجس ، شمال ، الرياض',
                size: '350 متر',
                hour: 'تم إضافتها قبل 16 يوم',
                url: "{{ asset('front-end/images/mapimage.png') }}",
                whatsapp: '#',
                phone: '#',
                appointment: '#',

                position: {
                    lat: 37.41391636421949,
                    lng: -121.94592071575907,
                },
            },
        ];


        window.initMap = initMap;
    </script>
</body>

</html>
