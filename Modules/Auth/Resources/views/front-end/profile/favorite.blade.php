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
                    <a href="#">الملف الشخصي</a>
                </li>
                >
                <li>
                    <span>إعلاناتي</span>
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
                <div class="col-md-8">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="addAdsData">
                            <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pills-aqar-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-aqar" type="button" role="tab"
                                        aria-controls="pills-aqar" aria-selected="true" onclick="currentTab('ad')">
                                        العقارات
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-mzads-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-mzads" type="button" role="tab"
                                        aria-controls="pills-mzads" aria-selected="false" onclick="currentTab('auction')">
                                        المزادات
                                    </button>
                                </li>

                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-aqar" role="tabpanel"
                                    aria-labelledby="pills-aqar-tab">
                                    <div class="featured-aqars myaqrs">
                                        <div class="row">

                                        </div>
                                        <div id="loader" class="skeleton-loader">

                                            <div class="skeleton-card">
                                                <div class="feat">
                                                    <div class="skeleton-photo">
                                                    </div>
                                                    <div class="info">
                                                        <ul>
                                                            <li class="skeleton-detial">

                                                            </li>
                                                            <li class="skeleton-detial">
                                                            </li>
                                                            <li class="skeleton-detial">
                                                            </li>
                                                        </ul>
                                                        <a href="#" class="skeleton-detial">
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="skeleton-card">
                                                <div class="feat">
                                                    <div class="skeleton-photo">
                                                    </div>
                                                    <div class="info">
                                                        <ul>
                                                            <li class="skeleton-detial">

                                                            </li>
                                                            <li class="skeleton-detial">
                                                            </li>
                                                            <li class="skeleton-detial">
                                                            </li>
                                                        </ul>
                                                        <a href="#" class="skeleton-detial">
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-mzads" role="tabpanel"
                                    aria-labelledby="pills-mzads-tab">
                                    <div class="allMzads mymzads">
                                        <div class="row">

                                        </div>
                                        <div id="loader" class="skeleton-loader">

                                            <div class="skeleton-card">
                                                <div class="feat">
                                                    <div class="skeleton-photo">
                                                    </div>
                                                    <div class="info">
                                                        <ul>
                                                            <li class="skeleton-detial">

                                                            </li>
                                                            <li class="skeleton-detial">
                                                            </li>
                                                            <li class="skeleton-detial">
                                                            </li>
                                                        </ul>
                                                        <a href="#" class="skeleton-detial">
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="skeleton-card">
                                                <div class="feat">
                                                    <div class="skeleton-photo">
                                                    </div>
                                                    <div class="info">
                                                        <ul>
                                                            <li class="skeleton-detial">

                                                            </li>
                                                            <li class="skeleton-detial">
                                                            </li>
                                                            <li class="skeleton-detial">
                                                            </li>
                                                        </ul>
                                                        <a href="#" class="skeleton-detial">
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection


@push('custom-script')
    <script src="{{ asset('front-end/js/favorite.js') }}"></script>
    <script>
        let tab = 'ad';
        let currentPage = 1;
        const btnLoadMore =
            `<div class="d-flex justify-content-center load-container"><button class="load-btn" onclick="getFavorite()">اظهر المزيد</button></div>`
        const data = {
            ad: {
                currentPage: 1,
                container: document.querySelector('.myaqrs .row'),
                hasMorePages: false,
                skeletonLoader: document.querySelector('.myaqrs .skeleton-loader'),
            },
            auction: {
                currentPage: 1,
                container: document.querySelector('.mymzads .row'),
                hasMorePages: false,
                skeletonLoader: document.querySelector('.mymzads .skeleton-loader'),
            }
        }
        const currentTab = (currentTab) => {
            tab = currentTab;
            if (!data[currentTab].container.childElementCount)
                getFavorite();
        }
        const removeLoaderButton = () => {
            if (data[tab].container.querySelector('.load-container'))
                data[tab].container.querySelector('.load-container').remove();
        }
        const getFavorite = () => {
            removeLoaderButton();
            data[tab].skeletonLoader.style.display = 'flex';
            axios.get('/favorite', {
                params: {
                    type: tab,
                    page: data[tab].currentPage,
                }
            }).then((response) => {
                data[tab].container.innerHTML += response.data.data;
                if (tab == 'auction')
                    loadMazadCarousel();
                data[tab].hasMorePages = response.data.has_more;
                data[tab].skeletonLoader.style.display = 'none';
                if (response.data.has_more) {
                    data[tab].currentPage++;
                    data[tab].container.innerHTML += btnLoadMore;
                } else {
                    removeLoaderButton();
                }

            }).catch((error) => {
                console.log(error);
            });
        }

        getFavorite();
    </script>
@endpush

@push('custom-style')
    <style>
        .skeleton-card {
            width: calc((100% / 2) - 16px);
            margin: 8px;
            border-radius: 3px;

            border-radius: 15px;
        }

        .skeleton-card,
        .skeleton-photo,
        .skeleton-detial {
            transition: all 200ms ease-in-out;
            position: relative;
            background-color: #eaeaea;
            overflow: hidden;
            display: block;
        }

        .skeleton-card .feat {
            margin-bottom: 0px;
        }

        .skeleton-photo {
            height: 180px;
            width: 100%;
        }

        .skeleton-detial {
            height: 35px;
            width: 100%;
        }

        .info a.skeleton-detial:last-of-type {
            height: 70px;
        }
    </style>
@endpush
