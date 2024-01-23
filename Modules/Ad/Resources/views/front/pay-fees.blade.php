@extends('front-end.main')
@push('custom-style')
@endpush
@section('content')
    <section class="breadcramp">
        <div class="container">
            <ul class="d-flex">
                <li>
                    <a href="{{ route('front.index') }}">الرئسية</a>
                </li>
                <span>></span>
                <li>
                    <a href="#"> طلب ترخيص اعلان بواسطة عقاراتكم</a>
                </li>
                <span>></span>
                &nbsp;
                <li>إتمام الدفع</li>
            </ul>
        </div>
    </section>

    <section class="payment">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="right">
                        <h2 class="title">الخدمة</h2>
                        <div class="package-type d-flex">
                            <div class="name">
                                <h2> طلب ترخيص اعلان بواسطة عقاراتكم</h2>
                            </div>
                            <div class="price">
                                <p>99 ر.س</p>
                            </div>
                        </div>
                        <div class="payment-method">
                            <h2>الدفع بواسطة</h2>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="flexRadioDefault"
                                    id="flexRadioDefault1">
                                <label class="form-check-label" for="flexRadioDefault1">
                                    <div class="parent d-flex">
                                        <div class="photo">
                                            <img src="{{ asset('front-end/images/visa.png') }}">
                                        </div>
                                        <div class="info">
                                            <p>الدفع بواسطة بطاقة الخصم/ الإئتمان</p>

                                        </div>
                                    </div>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="flexRadioDefault"
                                    id="flexRadioDefault2">
                                <label class="form-check-label" for="flexRadioDefault2">
                                    <div class="parent d-flex">
                                        <div class="photo">
                                            <img src="{{ asset('front-end/images/apple-pay.png') }}">
                                        </div>
                                        <div class="info">
                                            <p>الدفع بواسطة ابل باي</p>

                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                        <div class="coupon">
                            <h2>هل لديك كوبون خصم ؟</h2>
                            <div class="enter">
                                <input type="text" placeholder="">
                                <button type="submit">ارسال</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="left">
                        <div class="billing">
                            <h2>الفاتورة</h2>
                            <ul>
                                <li class="d-flex">
                                    <div class="title">
                                        <p>المجموع</p>
                                    </div>
                                    <div class="type">
                                        <p>99 &nbsp; ر.س</p>
                                    </div>
                                </li>
                                <li class="d-flex discount">
                                    <div class="title">
                                        <p>الخصم</p>
                                    </div>
                                    <div class="type">
                                        <p>-30 &nbsp; ر.س</p>
                                    </div>
                                </li>
                                <li class="d-flex">
                                    <div class="title">
                                        <p>ضريبة القيمة المضافة</p>
                                    </div>
                                    <div class="type">
                                        <p>15 &nbsp; ر.س</p>
                                    </div>
                                </li>
                                <li class="d-flex total">
                                    <div class="title">
                                        <p>الإجمالي</p>
                                    </div>
                                    <div class="type">
                                        <p>59 ر.س</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <button type="submit" class="pay-now" data-bs-toggle="modal" data-bs-target="#pay">إتمام الدفع</button>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('custom-script')
@endpush
