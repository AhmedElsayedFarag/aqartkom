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
                    <span>مزاداتي</span>
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
                        <div class="tab-pane fade show active" id="pills-ads" role="tabpanel"
                            aria-labelledby="pills-ads-tab">

                            <div class="addAdsData">
                                <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="pills-review-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-review" type="button" role="tab"
                                            aria-controls="pills-review" aria-selected="true"
                                            onclick="currentTab('pending')">
                                            قيد المراجعة
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="pills-accept-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-accept" type="button" role="tab"
                                            aria-controls="pills-accept" aria-selected="false"
                                            onclick="currentTab('approved')">
                                            المقبولة
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="pills-refused-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-refused" type="button" role="tab"
                                            aria-controls="pills-refused" aria-selected="false"
                                            onclick="currentTab('cancelled')">
                                            المرفوضه
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="pills-closed-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-closed" type="button" role="tab"
                                            aria-controls="pills-closed" aria-selected="false"
                                            onclick="currentTab('closed')">
                                            المغلقة
                                        </button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-review" role="tabpanel"
                                        aria-labelledby="pills-review-tab">
                                        <div class="allMzads" id="pending-ads">
                                            <div class="row">

                                            </div>
                                            <div id="loader" class="skeleton-loader">
                                                <div class="skeleton-card">
                                                    <div class="all">
                                                        <div class="parent d-flex">
                                                            <figure class="photo">
                                                                <a href="#">
                                                                    <img src="">
                                                                </a>
                                                            </figure>
                                                            <div class="info">
                                                                <p class="title">
                                                                    <a href="#">

                                                                    </a>
                                                                </p>
                                                                <p class="sub-title">
                                                                </p>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="amount">
                                                                            <span></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="amount">
                                                                            <span></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="amount">
                                                                            <span></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="amount">
                                                                            <span></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="price">
                                                                            <p></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button>تحديث</button>
                                                    </div>
                                                </div>

                                                <div class="skeleton-card">
                                                    <div class="all">
                                                        <div class="parent d-flex">
                                                            <figure class="photo">
                                                                <a href="#">
                                                                    <img src="">
                                                                </a>
                                                            </figure>
                                                            <div class="info">
                                                                <p class="title">
                                                                    <a href="#">

                                                                    </a>
                                                                </p>
                                                                <p class="sub-title">
                                                                </p>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="amount">
                                                                            <span></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="amount">
                                                                            <span></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="amount">
                                                                            <span></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="amount">
                                                                            <span></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="price">
                                                                            <p></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button>تحديث</button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-accept" role="tabpanel"
                                        aria-labelledby="pills-accept-tab">
                                        <div class="allMzads" id="approved-ads">
                                            <div class="row">

                                            </div>
                                            <div id="loader" class="skeleton-loader">
                                                <div class="skeleton-card">
                                                    <div class="all">
                                                        <div class="parent d-flex">
                                                            <figure class="photo">
                                                                <a href="#">
                                                                    <img src="">
                                                                </a>
                                                            </figure>
                                                            <div class="info">
                                                                <p class="title">
                                                                    <a href="#">

                                                                    </a>
                                                                </p>
                                                                <p class="sub-title">
                                                                </p>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="amount">
                                                                            <span></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="amount">
                                                                            <span></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="amount">
                                                                            <span></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="amount">
                                                                            <span></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="price">
                                                                            <p></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button>تحديث</button>
                                                    </div>
                                                </div>

                                                <div class="skeleton-card">
                                                    <div class="all">
                                                        <div class="parent d-flex">
                                                            <figure class="photo">
                                                                <a href="#">
                                                                    <img src="">
                                                                </a>
                                                            </figure>
                                                            <div class="info">
                                                                <p class="title">
                                                                    <a href="#">

                                                                    </a>
                                                                </p>
                                                                <p class="sub-title">
                                                                </p>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="amount">
                                                                            <span></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="amount">
                                                                            <span></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="amount">
                                                                            <span></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="amount">
                                                                            <span></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="price">
                                                                            <p></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button>تحديث</button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-refused" role="tabpanel"
                                        aria-labelledby="pills-refused-tab">
                                        <div class="allMzads" id="cancelled-ads">
                                            <div class="row">

                                            </div>
                                            <div id="loader" class="skeleton-loader">
                                                <div class="skeleton-card">
                                                    <div class="all">
                                                        <div class="parent d-flex">
                                                            <figure class="photo">
                                                                <a href="#">
                                                                    <img src="">
                                                                </a>
                                                            </figure>
                                                            <div class="info">
                                                                <p class="title">
                                                                    <a href="#">

                                                                    </a>
                                                                </p>
                                                                <p class="sub-title">
                                                                </p>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="amount">
                                                                            <span></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="amount">
                                                                            <span></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="amount">
                                                                            <span></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="amount">
                                                                            <span></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="price">
                                                                            <p></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button>تحديث</button>
                                                    </div>
                                                </div>

                                                <div class="skeleton-card">
                                                    <div class="all">
                                                        <div class="parent d-flex">
                                                            <figure class="photo">
                                                                <a href="#">
                                                                    <img src="">
                                                                </a>
                                                            </figure>
                                                            <div class="info">
                                                                <p class="title">
                                                                    <a href="#">

                                                                    </a>
                                                                </p>
                                                                <p class="sub-title">
                                                                </p>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="amount">
                                                                            <span></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="amount">
                                                                            <span></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="amount">
                                                                            <span></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="amount">
                                                                            <span></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="price">
                                                                            <p></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button>تحديث</button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-closed" role="tabpanel"
                                        aria-labelledby="pills-closed-tab">
                                        <div class="allMzads" id="closed-ads">
                                            <div class="row">

                                            </div>
                                            <div id="loader" class="skeleton-loader">
                                                <div class="skeleton-card">
                                                    <div class="all">
                                                        <div class="parent d-flex">
                                                            <figure class="photo">
                                                                <a href="#">
                                                                    <img src="">
                                                                </a>
                                                            </figure>
                                                            <div class="info">
                                                                <p class="title">
                                                                    <a href="#">

                                                                    </a>
                                                                </p>
                                                                <p class="sub-title">
                                                                </p>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="amount">
                                                                            <span></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="amount">
                                                                            <span></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="amount">
                                                                            <span></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="amount">
                                                                            <span></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="price">
                                                                            <p></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button>تحديث</button>
                                                    </div>
                                                </div>

                                                <div class="skeleton-card">
                                                    <div class="all">
                                                        <div class="parent d-flex">
                                                            <figure class="photo">
                                                                <a href="#">
                                                                    <img src="">
                                                                </a>
                                                            </figure>
                                                            <div class="info">
                                                                <p class="title">
                                                                    <a href="#">

                                                                    </a>
                                                                </p>
                                                                <p class="sub-title">
                                                                </p>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="amount">
                                                                            <span></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="amount">
                                                                            <span></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="amount">
                                                                            <span></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="amount">
                                                                            <span></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="price">
                                                                            <p></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button>تحديث</button>
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
    @endsection

    @push('custom-script')
        <script src="{{ asset('front-end/js/auction-multiple-timers.js') }}"></script>
        <script src="{{ asset('front-end/js/clipboard.js') }}"></script>
        <script>
            let tab = 'pending';
            let currentPage = 1;
            const btnLoadMore =
                `<div class="d-flex justify-content-center load-container"><button class="load-btn" onclick="getAds()">اظهر المزيد</button></div>`
            //    pending,approved,cancelled,closed
            const data = {
                pending: {
                    currentPage: 1,
                    container: document.querySelector('#pending-ads .row'),
                    hasMorePages: false,
                    skeletonLoader: document.querySelector('#pending-ads .skeleton-loader'),
                },
                approved: {
                    currentPage: 1,
                    container: document.querySelector('#approved-ads .row'),
                    hasMorePages: false,
                    skeletonLoader: document.querySelector('#approved-ads .skeleton-loader'),
                },
                cancelled: {
                    currentPage: 1,
                    container: document.querySelector('#cancelled-ads .row'),
                    hasMorePages: false,
                    skeletonLoader: document.querySelector('#cancelled-ads .skeleton-loader'),
                },
                closed: {
                    currentPage: 1,
                    container: document.querySelector('#closed-ads .row'),
                    hasMorePages: false,
                    skeletonLoader: document.querySelector('#closed-ads .skeleton-loader'),
                },

            }
            const currentTab = (currentTab) => {
                tab = currentTab;
                if (!data[currentTab].container.childElementCount)
                    getAds();
            }
            const removeLoaderButton = () => {
                if (data[tab].container.querySelector('.load-container'))
                    data[tab].container.querySelector('.load-container').remove();
            }
            const getAds = () => {
                removeLoaderButton();
                data[tab].skeletonLoader.style.display = 'flex';
                axios.get('/user/bids-ajax', {
                    params: {
                        status: tab,
                        page: data[tab].currentPage,
                    }
                }).then((response) => {
                    data[tab].container.innerHTML += response.data.data;
                    data[tab].hasMorePages = response.data.has_more;
                    data[tab].skeletonLoader.style.display = 'none';
                    if (response.data.has_more) {
                        data[tab].currentPage++;
                        data[tab].container.innerHTML += btnLoadMore;
                    } else {
                        removeLoaderButton();
                    }
                    loadTimers();
                }).catch((error) => {
                    console.log(error);
                });
            }



            const resetAds = () => {
                data[tab].currentPage = 1;
                data[tab].container.innerHTML = '';
                data[tab].container.hasMorePages = false;
            }
            getAds();
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

            .skeleton-card .title,
            .skeleton-card .sub-title {
                height: 25px;
            }

            .skeleton-card img {
                border: 0.5px solid #989898;
                border-radius: 10px;
                width: 170px;
                height: 160px;
            }
        </style>
    @endpush
