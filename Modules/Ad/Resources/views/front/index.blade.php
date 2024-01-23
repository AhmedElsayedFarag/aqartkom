@extends('front-end.main')
@section('content')
    <section class="topSelectSearch">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <select id="order" class="js-states form-control" onchange="changeOrder()">
                        <option></option>
                        <option value="0">الاحدث الى الاقدم</option>
                        <option value="1"> الاقدم الى الاحدث</option>
                        <option value="2">المساحة - الأكبر إلي الأصغر</option>
                        <option value="3">المساحة - الأصغر إلي الأكبر</option>
                        <option value="4">البناء - الأقدم إلي الأحدث</option>
                    </select>
                </div>
                <div class="col-md-5 offset-md-1">
                    <div class="detectCountry d-flex">
                        <div class="search">
                            <button><i class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                        <div class="country">
                            <select id="country" class="js-states" onchange="getNeighborhoods()">
                                <option></option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}" data-lat="{{ $city->lat }}"
                                        data-lng="{{ $city->long }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="destination">
                            <select id="neighborhood" class="js-states" onchange="changeNeighborhood()">
                                <option></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 offset-md-1">
                    <div class="showMap">
                        <a href="javascript:;" onclick="showMap()" id="mapButton">
                            <img src="{{ asset('front-end/images/icons/map.png') }}" />
                            عرض الخريطة
                        </a>
                        <a href="javascript:;" class="d-none" onclick="showGroupAds()" id="groupButton">
                            <img src="{{ asset('front-end/images/group-icon.svg') }}" />
                            عرض القائمة </a>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section class="filteration">
        <div class="container">
            <div class="row">
                @include('ad::front.filter-sidebar')
                <div class="col-md-8" id="result-ads">
                    <div class="featured-aqars pagination">
                        <div class="box" style="width:100%">
                            <div class="row">
                                {{-- @foreach ($ads as $ad)
                                    @include('ad::front.ad-component')
                                @endforeach --}}

                            </div>
                            <div class="d-flex justify-content-center d-none" id="loadMoreBtn"><button class="load-btn"
                                    onclick="getAds(true)">اظهر المزيد</button></div>

                        </div>
                    </div>
                </div>
                <div class="col-md-8 d-none" id="map-ads">
                    <div id="map"></div>
                </div>
            </div>
    </section>
    @include('partials.not-licensed-ads');
@endsection

@push('custom-style')
    <link rel="stylesheet" href="{{ asset('front-end/css/rSlider.min.css') }}">
    <style>
        .marker-label {
            padding-bottom: 12px
        }

        .photo img {
            border-radius: 12px;
            width: 125px;
            height: 104px;
        }
    </style>
@endpush

@push('custom-script')
    <script src="{{ asset('front-end/js/rSlider.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.2.2/axios.min.js"
        integrity="sha512-QTnb9BQkG4fBYIt9JGvYmxPpd6TBeKp6lsUrtiVQsrJ9sb33Bn9s0wMQO9qVBFbPX3xHRAsBHvXlcsrnJjExjg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('front-end/js/rangeSliderHelpers.js') }}"></script>
    <script src="{{ asset('front-end/js/rangeSliderFilter.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.21/lodash.min.js"
        integrity="sha512-WFN04846sdKMIP5LKNphMaWzU7YpMyCU245etK3g/2ARYbPK9Ub18eG+ljU96qKRCWh+quCY7yefSmlkQw1ANQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @include('ad::front.map-filter-scripts')
    @include('ad::front.ads-builder')
    <script src="{{ asset('front-end/js/adFilter.js') }}"></script>
    <script>
        const adsContainer = document.querySelector('#result-ads');
        const mapContainer = document.querySelector('#map-ads');
        const mapButton = document.querySelector('#mapButton');
        const groupButton = document.querySelector('#groupButton');
        const showMap = () => {
            mapContainer.classList.remove('d-none');
            adsContainer.classList.add('d-none');
            mapButton.classList.add('d-none');
            groupButton.classList.remove('d-none');
        }
        const showGroupAds = () => {
            mapContainer.classList.add('d-none');
            adsContainer.classList.remove('d-none');
            mapButton.classList.remove('d-none');
            groupButton.classList.add('d-none');
        }
    </script>
    <script>
        navigator.geolocation.getCurrentPosition((pos) => {
            getDefaultCity(pos.coords.latitude, pos.coords.longitude);
        }, (error) => {
            getDefaultCity();
        })
        const setDefaultLocation = () => {
            searchForm.center = {
                lat: 24.774265,
                long: 46.738586,
            };
            searchForm.second_point = {
                lat: 24.815250108574347,
                long: 46.812057069335935,
            };

        }
        const getDefaultCity = (lat, lng, city) => {
            axios.get('/api/v1/home', {
                params: {
                    lat: lat,
                    lng: lng,
                    city
                }
            }).then((res) => {
                return res.data
            }).then((res) => {

                searchForm.city = res.city.id;
                document.getElementById("country").value = res.city.id;
                setNeighborhood();
                changeCenter(res.city.lat, res.city.long);

                getAds();
            })
        }
    </script>
@endpush
