@extends('front-end.main')

@section('content')
    <section class="breadcramp">
        <div class="container">
            <ul class="d-flex">
                <li>
                    <a href="{{ route('front.index') }}">الرئسية</a>
                </li>
                <span>></span>
                &nbsp;
                <li>إتمام الدفع</li>
            </ul>
        </div>
    </section>

    <section class="payment">
        <div class="container">
            <form action="{{ route('front.user.ad.buy-feature', ['ad' => $ad->uuid]) }}" id="paymentForm"
                onsubmit="event.preventDefault();">
                <div class="row">
                    @csrf
                    <div class="col-md-6">
                        <div class="right">
                            <h2 class="title">الخدمة</h2>
                            <div class="package-type d-flex">
                                <div class="name">
                                    <h2>{{ $package->title }}</h2>
                                </div>
                                <div class="price">
                                    <p>{{ $package->price }} ر.س</p>
                                </div>
                            </div>
                            <input type="package_id" value="{{ $package->id }}" id="package_id" />
                            <input type="hidden" value="{{ $package->price }}" id="package_price" />
                            <div class="payment-method">
                                <h2>الدفع بواسطة</h2>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method"
                                        id="flexRadioDefault1" checked>
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
                                    <input class="form-check-input" type="radio" name="payment_method"
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
                                    <input type="text" name="coupon" placeholder="SDF125E" id="coupon">
                                    <button onclick="checkCoupon()">ارسال</button>
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
                                            <p>{{ $package->price }} &nbsp; ر.س</p>
                                        </div>
                                    </li>
                                    <li class="d-flex discount">
                                        <div class="title">
                                            <p>الخصم</p>
                                        </div>
                                        <div class="type">
                                            <p id="discount_coupon">0 &nbsp; ر.س</p>
                                        </div>
                                    </li>
                                    <li class="d-flex">
                                        <div class="title">
                                            <p>ضريبة القيمة المضافة</p>
                                        </div>
                                        <div class="type">
                                            <p id="vat">{{ $package->price * 0.15 }} &nbsp; ر.س</p>
                                        </div>
                                    </li>
                                    <li class="d-flex total">
                                        <div class="title">
                                            <p>الإجمالي</p>
                                        </div>
                                        <div class="type">
                                            <p id="total_invoice">{{ $package->price * 1.15 }} ر.س</p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="pay-now" onclick="pay()">إتمام الدفع</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
@push('custom-script')
    <script>
        function decimalAdjust(type, value, exp) {
            type = String(type);
            if (!["round", "floor", "ceil"].includes(type)) {
                throw new TypeError(
                    "The type of decimal adjustment must be one of 'round', 'floor', or 'ceil'.",
                );
            }
            exp = Number(exp);
            value = Number(value);
            if (exp % 1 !== 0 || Number.isNaN(value)) {
                return NaN;
            } else if (exp === 0) {
                return Math[type](value);
            }
            const [magnitude, exponent = 0] = value.toString().split("e");
            const adjustedValue = Math[type](`${magnitude}e${exponent - exp}`);
            // Shift back
            const [newMagnitude, newExponent = 0] = adjustedValue.toString().split("e");
            return Number(`${newMagnitude}e${+newExponent + exp}`);
        }

        // Decimal round
        const round10 = (value, exp) => decimalAdjust("round", value, exp);
        // Decimal floor
        const floor10 = (value, exp) => decimalAdjust("floor", value, exp);
        // Decimal ceil
        const ceil10 = (value, exp) => decimalAdjust("ceil", value, exp);
    </script>
    <script>
        let vat = document.querySelector('#vat');
        let total_invoice = document.querySelector('#total_invoice');
        let discount_coupon = document.querySelector('#discount_coupon');
        let package_price = document.querySelector('#package_price');

        function checkCoupon() {
            axios.post(`/api/v1/coupon/apply`, {
                coupon: document.querySelector('#coupon').value,
            }).then((response) => {
                let coupon = response.data.data;
                let discountAmount = 0;
                if (coupon.type == 'percentage') {
                    discountAmount = parseFloat(package_price.value) * parseFloat(coupon.value) / 100;
                } else {
                    discountAmount = coupon.value;
                }
                discount_coupon.innerHTML = round10(discountAmount, -4) + ' ر.س';
                vat.innerHTML = round10((parseFloat(package_price.value) - discountAmount) * 0.15, -4) + ' ر.س';
                total_invoice.innerHTML = round10((parseFloat(package_price.value) - discountAmount) * 1.15, -4) +
                    ' ر.س';

            }).catch((error) => {
                console.log(error);
                swal("خطا", error.response.data.message, "error");
            });
        }
        let payForm = document.querySelector('#paymentForm');

        function pay() {
            payForm.onsubmit = function() {

            };

        }
    </script>
@endpush
