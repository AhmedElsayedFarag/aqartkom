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
                    <a href="{{ route('front.profile.ads') }}">الملف الشخصي</a>
                </li>
                >
                <li>
                    <span>الباقات والاشتراكات</span>
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
                <div class="col-lg-8">
                    <div class="tab-content" id="pills-tabContent">

                        <div class="tab-pane fade show active" id="pills-myPackage" role="tabpanel"
                            aria-labelledby="pills-myPackage-tab">
                            <div class="table-package">
                                @if ($subscription)
                                    <table class="table">
                                        <thead>

                                            <tr>
                                                <th scope="col">الخدمة</th>
                                                <th scope="col">العدد</th>
                                                <th scope="col">المدة</th>
                                                <th scope="col">المستخدم</th>
                                                <th scope="col">المتبقي</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($subscription->features as $feature)
                                                <tr>
                                                    <th scope="row">{{ $feature->feature_title }}</th>
                                                    <td><span>{{ $feature->feature_value['count'] }}</span></td>
                                                    <td><span>{{ isset($feature->feature_value['days']) ? $feature->feature_value['days'] : '-' }}</span>
                                                    </td>
                                                    <td><span>{{ $feature->start_count - $feature->remaining_count }}</span>
                                                    </td>
                                                    <td><span>{{ $feature->remaining_count }}</span></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="date d-flex">
                                        <div class="right">
                                            <P>تاريخ الإشتراك</P>
                                        </div>
                                        <div class="left">
                                            <p>{{ \Carbon\Carbon::parse($subscription->start_at)->format('d/m/Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="date date-finish d-flex">
                                        <div class="right">
                                            <P>تاريخ الإنتهاء</P>
                                        </div>
                                        <div class="left">
                                            <p>{{ \Carbon\Carbon::parse($subscription->end_at)->format('d/m/Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="parent">
                                        <div class="upgrade">
                                            <button data-bs-toggle="modal" data-bs-target="#upgrading">ترقية الباقة</button>
                                        </div>
                                        <div class="alarm text-center">
                                            <img src="{{ asset('front-end/images/danger.svg') }}">
                                            <h2>تنبيه</h2>
                                            <p>تنتهي الباقة بنفاذ عدد الإعلانات أو بمرور سنة</p>
                                        </div>
                                        <div class="cancel">
                                            <button data-bs-toggle="modal" data-bs-target="#canceling">إلغاء
                                                الإشتراك</button>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-12 alert alert-danger text-center">
                                        أنت غير مشترك في أي باقة
                                    </div>
                                @endif

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- Modal upgrading package -->
    <div class="modal fade" id="upgrading" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header modal-header-marketing">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body modal-marcketing text-center">
                    <img src="{{ asset('front-end/images/Layer 35.svg') }}">
                    <h2>ترقية الباقة</h2>
                    <p>في حالة ترقية الباقة سوف يتم إلغاء الباقة الحالية</p>
                    <div class="action-pages">
                        <ul class="d-flex">
                            <li><button>إلغاء</button></li>
                            <li><button
                                    onclick="window.location.href='{{ route('front.profile.packages') }}'">تأكيد</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal canceling subscription -->
    <div class="modal fade" id="canceling" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header modal-header-marketing">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body modal-marcketing text-center">
                    <img src="{{ asset('front-end/images/Group 44697.svg') }}">
                    <h2>إلغاء الإشتراك</h2>
                    <p>في حالة إلغاء الإشتراك الرسوم المدفوعة لا تسترد</p>
                    <div class="action-pages">
                        <ul class="d-flex">
                            <li><button>إلغاء</button></li>
                            <li><button style="background-color: #F44336;"
                                    onclick="window.location.href='{{ route('front.profile.subscription.cancel') }}'">قبول</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
