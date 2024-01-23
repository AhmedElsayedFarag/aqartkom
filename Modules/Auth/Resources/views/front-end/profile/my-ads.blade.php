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
                                        <button class="nav-link active" id="pills-accept-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-accept" type="button" role="tab"
                                            aria-controls="pills-accept" aria-selected="false"
                                            onclick="currentTab('approved')">
                                            الإعلانات المفعلة
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
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="pills-closed-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-closed" type="button" role="tab"
                                            aria-controls="pills-closed" aria-selected="false"
                                            onclick="currentTab('closed')">
                                            الاعلانات الغير مفعله
                                        </button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="pills-tabContent">

                                    <div class="tab-pane fade show active" id="pills-accept" role="tabpanel"
                                        aria-labelledby="pills-accept-tab">
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

                                    <div class="tab-pane fade" id="pills-closed" role="tabpanel"
                                        aria-labelledby="pills-closed-tab">
                                        <div class="featured-aqars" id="closed-ads">
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
                    <form action="{{ route('front.user.ad.show-feature-form') }}" method="get">
                        @csrf
                        <input type="hidden" name="ad" value="" id="feature_ad_id" />
                        @foreach ($packages as $key => $package)
                            <div class="form-check">
                                <input class="form-check-input" type="radio"
                                    @if ($key == 0) checked @endif name="package" id="flexRadioDefault1"
                                    value="{{ $package->id }}">
                                <label class="form-check-label" for="flexRadioDefault1">
                                    <div class="parent d-flex">
                                        <div class="title">
                                            <h2>{{ $package->title }}</h2>
                                        </div>
                                        <div class="price">
                                            <p>{{ $package->price }} &nbsp; ر.س</p>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        @endforeach
                        <p class="words">
                            للإشتراك في باقات عقاراتكم المميزة
                            <a href="{{ route('front.profile.packages') }}">إضغط هنا</a>
                        </p>
                        <button type="submit">إتمام الدفع</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade addLicence" id="checkLicense" tabindex="-1" aria-labelledby="checkLicense"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered p-0">
            <div class="modal-content">
                <div class="modal-header modal-header-marketing header-highlight p-0">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="licence">
                                <h2 class="title text-center">
                                    بناء على نظام الوساطة العقارية لايمكن الاعلان في المنصات
                                    العقارية الا بوجود رخصة اعلان
                                </h2>
                                <div class="identity">
                                    <input type="hidden" id="ad_id_license" value="">
                                    <h2 class="text-center">نوع الهوية</h2>
                                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                                data-bs-target="#pills-home" type="button" role="tab"
                                                aria-controls="pills-home" aria-selected="true">
                                                هوية وطنية
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="pills-building-tab" data-bs-toggle="pill"
                                                data-bs-target="#pills-building" type="button" role="tab"
                                                aria-controls="pills-building" aria-selected="false">
                                                منشأة
                                            </button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                            aria-labelledby="pills-home-tab">
                                            <form onsubmit="event.preventDefault();checkLicenseNumber('pills-home')">
                                                <div class="first">
                                                    <label>رقم هوية المعلن</label>
                                                    <input type="text" name="nationality_number" class="form-control"
                                                        placeholder="الرجاء كتابة رقم الهوية" required min="0"
                                                        pattern="[0-9]{10}">
                                                    <div class="invalid-feedback">
                                                        @error('nationality_number')
                                                            {{ $errors->first('nationality_number') }}
                                                        @enderror
                                                    </div>

                                                </div>
                                                <div class="first">
                                                    <label>رقم ترخيص الإعلان</label>
                                                    <input type="text" name="license_number" class="form-control"
                                                        placeholder="الرجاء كتابة الرقم" required pattern="[0-9]{10}">
                                                    <div class="invalid-feedback">
                                                        @error('license_number')
                                                            {{ $errors->first('license_number') }}
                                                        @enderror
                                                    </div>
                                                </div>

                                                <input type="hidden" name="nationality_type" value="marketer" />
                                                <button type="submit" class="continue">استمرار</button>
                                            </form>
                                        </div>
                                        <div class="tab-pane fade" id="pills-building" role="tabpanel"
                                            aria-labelledby="pills-building-tab">
                                            <form onsubmit="event.preventDefault();checkLicenseNumber('pills-building')">
                                                <div class="first">
                                                    <label>رقم رخصة المنشاة</label>
                                                    <input type="text" name="nationality_number" class="form-control"
                                                        placeholder="رقم رخصة المنشاة" required pattern="[0-9]{10}">
                                                    <div class="invalid-feedback">
                                                        @error('nationality_number')
                                                            {{ $errors->first('nationality_number') }}
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="first">
                                                    <label>رقم ترخيص الإعلان</label>
                                                    <input type="text" name="license_number" class="form-control"
                                                        placeholder="الرجاء كتابة الرقم" required pattern="[0-9]{10}">
                                                    <div class="invalid-feedback">
                                                        @error('license_number')
                                                            {{ $errors->first('license_number') }}
                                                        @enderror
                                                    </div>
                                                </div>

                                                <input type="hidden" name="nationality_type" value="company" />
                                                <button type="submit" class="continue">استمرار</button>
                                            </form>
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
            axios.get('/user/ad-ajax', {
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
        const addFeature = (adId) => {
            axios.get(`/user/ad/${adId}/add-feature`).then((response) => {
                if (response.is_featured) {
                    resetAds();
                    swal("تم تمييز بنجاح", "تم تمييز الاعلان بنجاح", "success");
                    getAds();
                } else {
                    swal("لم يتم تمييز", "لم يتم تمييز الاعلان  ", "error");
                }
                // alert('تم حذف الاعلان بنجاح');
            }).catch((error) => {
                console.log(error);
            });
        }

        const myModal = new bootstrap.Modal('#highlight');
        const featureAdId = document.querySelector('#feature_ad_id');
        const showAdFeatureForm = (adId) => {
            myModal.show();
            featureAdId.value = adId;
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
        const checkLicenseNumber = (type, ad) => {
            let licenseNumber = document.querySelector(`#${type} input[name="license_number"]`).value;
            let nationalityNumber = document.querySelector(`#${type} input[name="nationality_number"]`).value;
            console.log(licenseNumber, nationalityNumber);
            if (licenseNumber.length < 10 || nationalityNumber.length < 10)
                return;
            //
            axios.post(`/api/v1/user/ad-market/${ad}/add-license-number`, {
                "license_number": licenseNumber,
                "nationality_number": nationalityNumber,
                "nationality_type": type == 'pills-home' ? 'marketer' : 'company'
            }).then((response) => {
                console.log(response);
                return;
                swal("تم التحديث بنجاح", "تم تعطيل الاعلان بنجاح", "success");
                // alert('تم حذف الاعلان بنجاح');
                getAds();
            }).catch((error) => {
                console.log(error);
            });
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
