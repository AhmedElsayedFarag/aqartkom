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
                    <span>طلبات الترخيص</span>
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
                                    {{-- <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="pills-review-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-review" type="button" role="tab"
                                            aria-controls="pills-review" aria-selected="true"
                                            onclick="currentTab('pending')">
                                            قيد المراجعة
                                        </button>
                                    </li> --}}
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="pills-approved-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-approved" type="button" role="tab"
                                            aria-controls="pills-approved" aria-selected="false"
                                            onclick="currentTab('approved')">
                                            مكتمل
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link " id="pills-pending-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-pending" type="button" role="tab"
                                            aria-controls="pills-pending" aria-selected="false"
                                            onclick="currentTab('pending')">
                                            قيد المعالجة
                                        </button>
                                    </li>
                                    {{-- <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="pills-refused-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-refused" type="button" role="tab"
                                            aria-controls="pills-refused" aria-selected="false"
                                            onclick="currentTab('closed')">
                                            الاعلانات الغير مفعله
                                        </button>
                                    </li> --}}

                                </ul>
                                <div class="tab-content" id="pills-tabContent">

                                    <div class="tab-pane fade show active" id="pills-approved" role="tabpanel"
                                        aria-labelledby="pills-approved-tab">
                                        <div class="featured-aqars" id="approved-ads">
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

                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="pills-pending" role="tabpanel"
                                        aria-labelledby="pills-pending-tab">
                                        <div class="featured-aqars" id="pending-ads">
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
    <!-- Modal ad-highlight -->
    <div class="modal fade" id="highlight" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header modal-header-marketing header-highlight">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                    <h2 class="text-center">تميز اللأعلان</h2>
                </div>
                <div class="modal-body modal-marcketing modal-hightlight">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                        <label class="form-check-label" for="flexRadioDefault1">
                            <div class="parent d-flex">
                                <div class="title">
                                    <h2>إعلان مميز لمدة 7 يوم</h2>
                                </div>
                                <div class="price">
                                    <p>99 &nbsp; ر.س</p>
                                </div>
                            </div>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
                        <label class="form-check-label" for="flexRadioDefault2">
                            <div class="parent d-flex">
                                <div class="title">
                                    <h2>إعلان مميز لمدة 15 يوم</h2>
                                </div>
                                <div class="price">
                                    <p>175 &nbsp; ر.س</p>

                                </div>
                            </div>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault3">
                        <label class="form-check-label" for="flexRadioDefault3">
                            <div class="parent d-flex">
                                <div class="title">
                                    <h2>إعلان مميز لمدة 30 يوم</h2>
                                </div>
                                <div class="price">
                                    <p>270 &nbsp; ر.س</p>

                                </div>
                            </div>
                        </label>
                    </div>
                    <p class="words">
                        للإشتراك في باقات عقاراتكم المميزة
                        <a href="#">إضغط هنا</a>
                    </p>
                    <button type="submit">إتمام الدفع</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('custom-script')
    <script src="{{ asset('front-end/js/clipboard.js') }}"></script>
    <script>
        let tab = 'approved';
        let currentPage = 1;
        const btnLoadMore =
            `<div class="d-flex justify-content-center load-container"><button class="load-btn" onclick="getAds()">اظهر المزيد</button></div>`
        //    pending,approved,cancelled,closed
        const data = {
            approved: {
                currentPage: 1,
                container: document.querySelector('#approved-ads .row'),
                hasMorePages: false,
                skeletonLoader: document.querySelector('#approved-ads .skeleton-loader'),
            },
            pending: {
                currentPage: 1,
                container: document.querySelector('#pending-ads .row'),
                hasMorePages: false,
                skeletonLoader: document.querySelector('#pending-ads .skeleton-loader'),
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
            axios.get('/user/ad-licence-ajax', {
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

            }).catch((error) => {
                console.log(error);
            });
        }

        const refresh = (adId) => {
            axios.post(`/user/ad/${adId}/refresh`).then((response) => {
                resetAds();
                swal("تم التحديث بنجاح", "تم تحديث الاعلان بنجاح", "success");
                getAds();
            }).catch((error) => {
                console.log(error);
            });
        }
        const deleteAd = (adId) => {
            axios.delete(`/user/ad/${adId}`).then((response) => {
                resetAds();
                swal("تم الحذف بنجاح", "تم حذف الاعلان بنجاح", "success");
                getAds();
                // alert('تم حذف الاعلان بنجاح');
            }).catch((error) => {
                console.log(error);
            });
        }
        const activeAd = (adId) => {
            axios.post(`/user/ad/${adId}/active`).then((response) => {
                resetAds();
                resetAds('approved');
                swal("تم التحديث بنجاح", "تم تنشيط الاعلان بنجاح", "success");
                // alert('تم حذف الاعلان بنجاح');
                getAds();
            }).catch((error) => {
                console.log(error);
            });
        }
        const unactiveAd = (adId) => {
            axios.post(`/user/ad/${adId}/unactive`).then((response) => {
                resetAds();
                resetAds('closed');
                swal("تم التحديث بنجاح", "تم تعطيل الاعلان بنجاح", "success");
                // alert('تم حذف الاعلان بنجاح');
                getAds();
            }).catch((error) => {
                console.log(error);
            });
        }
        const resetAds = (activeTab = tab) => {
            data[activeTab].currentPage = 1;
            data[activeTab].container.innerHTML = '';
            data[activeTab].container.hasMorePages = false;
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
