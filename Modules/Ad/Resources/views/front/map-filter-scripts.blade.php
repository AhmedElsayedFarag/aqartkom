    <script>
        let currentPage = 1;
        const loadMoreBtn = document.getElementById('loadMoreBtn');
        async function postData(url = '', data = {}) {
            // Default options are marked with *
            const response = await fetch(url, {
                method: 'POST', // *GET, POST, PUT, DELETE, etc.
                mode: 'cors', // no-cors, *cors, same-origin
                cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
                credentials: 'same-origin', // include, *same-origin, omit
                headers: {
                    'Content-Type': 'application/json'
                    // 'Content-Type': 'application/x-www-form-urlencoded',
                },
                redirect: 'follow', // manual, *follow, error
                referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
                body: JSON.stringify(data) // body data type must match "Content-Type" header
            });
            return response.json(); // parses JSON response into native JavaScript objects
        }
        const getAds = (isMap = true) => {
            @if (request()->routeIs('front.marketing-requests.index'))
                let url = '/api/v1/ad-marketing';
            @else
                let url = '/api/v1/ad';
            @endif
            postData(url, {
                ...getSearchParams(),
                page: currentPage
            }).then((response) => {
                if (response.meta.last_page > currentPage) {
                    currentPage++;
                    loadMoreBtn.classList.remove('d-none')
                } else {
                    loadMoreBtn.classList.add('d-none')
                }
                buildAds(response.data);
                if (isMap) {
                    let markers = buildMarkers(response.data);
                    markerCluster.clearMarkers();
                    markerCluster.addMarkers(markers);
                }

            });
        }
    </script>

    @if (request()->routeIs('front.aqar.index'))
        <script src="https://unpkg.com/@googlemaps/markerclusterer/dist/index.min.js"></script>

        <script async
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBSji4f8rxgtuD-JnkBgm4jrIUaXkFDyCw&callback=initAutocomplete&libraries=marker&v=beta">
        </script>
        <script>
            let map;
            let infowindow;
            const changeCenter = (lat, long) => {
                console.log(lat, long)
                map.panTo({
                    lat,
                    lng: long
                });

            }
            const SAUDI_ARABA_BOUNDS = {
                north: 32.0,
                south: 16.0,
                west: 34.0,
                east: 55.0,
            };
            let markerCluster;
            const infoWindowTemplate = (ad) => {
                return `<div class="mapFilter"><div class="photo">
                <a href="${ad.link}">
                <img src="${ad.estate.media[0].url}">
                </a>
                </div>
                <div class="words"><h2>${ad.estate.title}</h2><h2 class="location">${ad.estate.address}</h2>
                    <h2 class="size">${ad.estate.area} متر</h2><h2 class="time">${ad.accepted_at}</h2>
                    <h2 class="price"> ${ad.price} رس</h2></div>
                    </div><ul class="d-flex mapLinks">
                        <li><a href="https://wa.me/${ad.phone}">واتساب <img src="{{ asset('front-end/images/icons/whatsapp.svg') }}"></a>
                            </li><li><a href="#">حجز موعد <i class="fa-solid fa-calendar-days"></i></a></li>
                            <li><a href="tel:${ad.phone}">اتصل بنا <i class="fa-solid fa-phone-volume"></i></a>
                                </li>
                                </ul>
                                </div>`
            }

            const dependableIcon = "{{ asset('front-end/map-markers/selectedMarkerVerify.svg') }}";
            const undependableIcon = "{{ asset('front-end/map-markers/selectedMarker.svg') }}";


            function initAutocomplete() {
                let center = {
                    lat: 24.774265,
                    lng: 46.738586,
                }
                map = new google.maps.Map(document.getElementById("map"), {
                    center,
                    zoom: 13,
                    // mapTypeId: "roadmap",
                    mapId: "4504f8b37365c3d0",
                    // restriction: {
                    //     latLngBounds: SAUDI_ARABA_BOUNDS,
                    //     strictBounds: false,
                    // },
                });
                markerCluster = new markerClusterer.MarkerClusterer({
                    map,
                    renderer: {
                        render: clusterIconRenderer
                    },
                });
                infowindow = new google.maps.InfoWindow();

                map.addListener("bounds_changed", _.debounce(onBoundsChangedHandler, 1000));
            }


            const clusterIconRenderer = (cluster, stats) => {

                let position = cluster._position;
                let count = cluster.markers.length;

                return new google.maps.Marker({
                    position,
                    icon: {
                        url: `{{ asset('front-end/map-markers/cluster.svg') }}`,
                        scaledSize: new google.maps.Size(45, 45),
                    },
                    label: {
                        text: String(count),
                        color: "rgba(255,255,255,0.9)",
                        fontSize: "12px",
                    },
                    // adjust zIndex to be above other markers
                    zIndex: 1000 + count,
                });
            }
            const onBoundsChangedHandler = () => {

                //use debounce;
                let center = map.getCenter().toJSON();
                let bounds = map.getBounds().toJSON();
                searchForm.center = {
                    lat: center.lat,
                    long: center.lng,
                };
                searchForm.second_point = {
                    lat: bounds.north,
                    long: bounds.east,
                }
                currentPage = 1;
                getAds()

            }
            const buildMarkers = (ads) => {
                return ads.map((ad) => {
                    let marker = new google.maps.Marker({
                        position: {
                            lat: ad.estate.lat,
                            lng: ad.estate.long,
                        },
                        icon: ad.is_dependable ? dependableIcon : undependableIcon,
                        map: map,
                        label: {
                            text: ad.price + " رس",
                            className: 'marker-label',
                        }
                    });
                    google.maps.event.addListener(marker, 'click', function() {
                        infowindow.setContent(infoWindowTemplate(ad));
                        infowindow.open(map, marker);
                    })
                    return marker;
                    // const advancedMarkerView = new google.maps.marker.AdvancedMarkerView({
                    //     map,
                    //     content: buildContent(ad),
                    //     position: {
                    //         lat: ad.estate.lat,
                    //         lng: ad.estate.long,
                    //     },
                    //     title: ad.estate.title,
                    // });
                    // const element = advancedMarkerView.element;
                    // ["focus", "pointerenter"].forEach((event) => {
                    //     element.addEventListener(event, () => {
                    //         highlight(advancedMarkerView, ad);
                    //     });
                    // });
                    // ["blur", "pointerleave"].forEach((event) => {
                    //     element.addEventListener(event, () => {
                    //         unhighlight(advancedMarkerView, ad);
                    //     });
                    // });
                    // advancedMarkerView.addListener("click", (event) => {
                    //     unhighlight(advancedMarkerView, ad);
                    // });
                    // advancedMarkerView.getPosition = () => {
                    //     return {
                    //         lat: () => ad.estate.lat,
                    //         lng: () => ad.estate.long,
                    //     }
                    // }
                    // return advancedMarkerView;
                });
            }

            function highlight(markerView, property) {
                markerView.content.classList.add("highlight");
                markerView.element.style.zIndex = 1;
            }

            function unhighlight(markerView, property) {
                markerView.content.classList.remove("highlight");
                markerView.element.style.zIndex = "";
            }

            function buildContent(ad) {
                const content = document.createElement("div");
                const icon = ad.is_dependable ? dependableIcon : undependableIcon
                content.style.backgroundImage = `url(${icon})`;
                content.classList.add("property");
                content.innerHTML = `
    <div class="icon">
        ${ad.price}
    </div>
    <div class="details">
        <div class="d-flex">
        <div class="photo-map">
            <img src="${ad.estate.media[0].url}">
            </div>
            <div class="info-map">
        <h2 class="map-address">${ad.estate.title}</h2>
        <h2 class="map-location">${ad.estate.address}</h2>
        <h2 class="map-size">${ad.estate.area}</h2>
        <h2 class="map-hour">${ad.accepted_at}</h2>
        <h3 class="map-price">${ad.price}ر.س</h3>
        </div>
       </div>
        <div class="features">

            <ul class="d-flex mapLinks">
                <li><a href="https://wa.me/${ad.phone}">واتساب <img src="{{ asset('front-end/images/icons/whatsapp.svg') }}"></a></li>
                <li><a href="#">حجز موعد <i class="fa-solid fa-calendar-days"></i></a></li>
                <li><a href="https://wa.me/${ad.phone}">اتصل بنا <i class="fa-solid fa-phone-volume"></i></a></li>
                </ul>

        </div>
    </div>
    `;

                return content;
            }
            window.initAutocomplete = initAutocomplete;
        </script>
    @endif
