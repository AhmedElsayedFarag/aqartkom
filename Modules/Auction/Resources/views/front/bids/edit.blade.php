@extends('front-end.main')

@section('content')
    <!-- start of breadcramp-->
    <div class="breadcramp">
        <div class="container">
            <ul class="d-flex">
                <li>
                    <a href="{{ route('front.index') }}">الرئسية</a>
                </li>
                >
                <li>
                    <a href="{{ route('front.auction.index') }}">المزادت</a>
                </li>
                >
                <li>
                    <span>المشاركة في المزاد</span>
                </li>
            </ul>
        </div>
    </div>
    <!--end of breadcramp -->

    <section class="particpant">
        <input type="hidden" value="{{ $auction->end_at }}" id="timer" />
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="remain">
                                <p class="title">متبقي علي انتهاء المزاد</p>
                                <ul class="d-flex">
                                    <li>
                                        <p class="number" id="days">00</p>
                                        <p class="date">يوم</p>
                                    </li>
                                    <li>
                                        <p class="number" id="hours">00</p>
                                        <p class="date">ساعه</p>
                                    </li>
                                    <li>
                                        <p class="number" id="minutes">00</p>
                                        <p class="date">دقيقه</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="maxMzad">
                                <p>اعلي مزايدة</p>
                                <h2>
                                    {{ number_format($auction->top_price) }}
                                    <span>ريال / م 2</span>
                                </h2>
                            </div>
                            <div class="maxMzad">
                                <p>السعر الإجمالي</p>
                                <h2>
                                    {{ number_format($auction->top_price * $auction->estate->area) }}
                                    <span>رس</span>
                                </h2>
                            </div>
                        </div>
                    </div>
                    <div class="howmuch">
                        <p>رسوم الإشتراك في المزاد 1000 ريال</p>
                    </div>
                    <input type="hidden" value="{{ $auction->top_price }}" id="top_price" />
                    <div class="download">
                        <a href="{{ asset($settings['auction']['auction_document']['value']) }}" target="_blank">
                            <label for="file-upload" class="custom-file-upload">
                                <img src="{{ asset('front-end/images/icons/download (4).svg') }}">
                                <span>
                                    تحميل النشرة التسويقية للعقار
                                </span>
                            </label>
                            
                        </a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="sendRequest">
                        <h2>الرجاء تعبئة البيانات التالية</h2>
                        <p>للمشاركة في المزاد الرجاء تعبئة البيانات التالية</p>
                        <form action="#" method="post" onsubmit="event.preventDefault();submitForm();"
                            id="participant-form">
                            @csrf

                            <div class="first">
                                <label for="name">الاسم</label>
                                <input type="text"
                                    class="form-control  @error('name') is-invalid @enderror required-field length-field"
                                    data-title="الاسم" data-length-min="3" data-length-max="50" placeholder=""
                                    minlength="3" maxlength="50" name="name" id="name" value="{{ $bid->name }}"
                                    disabled>
                                <input type="hidden" name="name" value="{{ $bid->name }}" />
                                <div class="invalid-feedback">
                                    @error('name')
                                        {{ $errors->first('name') }}
                                    @enderror
                                </div>
                            </div>
                            <div class="first">
                                <label for="phone">رقم الجوال</label>
                                <input type="number"
                                    class="form-control required-field @error('phone') is-invalid @enderror"
                                    data-title="رقم الجوال" name="phone" min="0" id="phone"
                                    value="{{ str_replace('+966', '', $bid->phone) }}" disabled>
                                <input type="hidden" name="phone" value="{{ str_replace('+966', '', $bid->phone) }}" />
                                <div class="invalid-feedback ">
                                    @error('phone')
                                        {{ $errors->first('phone') }}
                                    @enderror
                                </div>
                            </div>
                            <div class="first">
                                <label for="national_number">رقم الهوية الوطنية</label>
                                <input type="number"
                                    class="form-control required-field @error('national_number') is-invalid @enderror"
                                    name="national_number" data-title="رقم الهوية الوطنية" id="national_number"
                                    value="{{ $bid->national_number }}" min="0" disabled>
                                <input type="hidden" name="national_number" value="{{ $bid->national_number }}" />
                                <div class="invalid-feedback">
                                    @error('national_number')
                                        {{ $errors->first('national_number') }}
                                    @enderror
                                </div>
                            </div>
                            <div class="first">
                                <label for="amount">سعر المزايدة</label>
                                <input type="text" placeholder="الرجاء ادخال سعر المزايدة"
                                    class="form-control required-field @error('amount') is-invalid @enderror"
                                    value="{{ $bid->amount }}" min="0" data-title="سعر المزايدة" name="amount"
                                    id="amount">
                                <div class="invalid-feedback">
                                    @error('amount')
                                        {{ $errors->first('amount') }}
                                    @enderror
                                </div>
                                <span>ر.س</span>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefaults" />
                                <label class="form-check-label" for="flexCheckDefaults">
                                    الموافقة علي سياسية الخصوصية الخاصة بالمزادات الإلكترونية
                                </label>
                                <div class="invalid-feedback">
                                </div>
                            </div>

                            <button type="submit" class="form-control">ارسال</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Modal -->
    <div class="modal fade" id="mzading" tabindex="-1" aria-labelledby="mzading" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body mzad-popup">
                    <i class="fa-solid fa-check"></i>
                    <p>شكرا لك</p>
                    <span>تم الإشتراك بنجاح</span>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom-script')
    <script src="{{ asset('front-end/js/auction-timer.js') }}"></script>
    <script src="{{ asset('front-end/js/validations.js') }}"></script>
    <script>
        const validateStaticDetails = () => {
            const staticDetails = document.querySelectorAll(`.required-field`);
            let hasError = false;

            staticDetails.forEach((detail) => {
                let errorMessage = detail.parentNode.querySelector('.invalid-feedback');
                if (detail.value === '') {
                    errorMessage.classList.add('d-block');
                    errorMessage.innerHTML = `هذا الحقل ${detail.dataset.title} مطلوب`;
                    hasError = true;
                    detail.classList.add('is-invalid');
                } else {
                    errorMessage.classList.remove('d-block');
                    detail.classList.remove('is-invalid');
                }
            });
            const lengthInputs = document.querySelectorAll(`.length-field`);
            lengthInputs.forEach((input) => {
                let min = input.dataset.lengthMin;
                let max = input.dataset.lengthMax;
                let errorMessage = input.parentNode.querySelector('.invalid-feedback');
                if (input.value.length < min || input.value.length > max) {
                    errorMessage.classList.add('d-block');
                    errorMessage.innerHTML =
                        `يجب ان يكون ${input.dataset.title} اكبر من ${min} حروف واقل من ${max} حروف`;
                    hasError = true;
                    input.classList.add('is-invalid');
                } else {
                    errorMessage.classList.remove('d-block');
                    input.classList.remove('is-invalid');
                }
            });
            return hasError;
        };
        const submitForm = () => {
            let hasError = false;
            if (validateStaticDetails()) {
                hasError = true;
            }
            const phoneInput = document.querySelector('#phone');
            if (!isValidPhone(phoneInput.value)) {
                phoneInput.classList.add('is-invalid');
                document.querySelector('#phone ~ .invalid-feedback').innerHTML = 'رقم الجوال غير صحيح';
                hasError = true;
            } else {
                phoneInput.classList.remove('is-invalid');
                document.querySelector('#phone ~ .invalid-feedback').innerHTML = '';
            }
            const checkInput = document.querySelector('#flexCheckDefaults');
            const checkErrorMessage = document.querySelector('#flexCheckDefaults ~ .invalid-feedback');
            if (!checkInput.checked) {
                checkInput.classList.add('is-invalid');
                checkErrorMessage.innerHTML = "يجب الموافقة على الشروط والاحكام";
                checkErrorMessage.classList.add('d-block');
                hasError = true;
            } else {
                checkInput.classList.remove('is-invalid');
                checkErrorMessage.innerHTML = "";
                checkErrorMessage.classList.remove('d-block');
            }
            const topPrice = parseInt(document.querySelector('#top_price').value);
            const amount = parseInt(document.querySelector('#amount').value);
            if (amount < topPrice) {
                document.querySelector('#amount').classList.add('is-invalid');
                document.querySelector('#amount ~ .invalid-feedback').innerHTML =
                    "يجب ان يكون السعر اكبر من اعلى سعر مزايدة";
                document.querySelector('#amount ~ .invalid-feedback').classList.add('d-block');
                hasError = true;
            }
            if (hasError) {
                return;
            }
            const form = document.querySelector('#participant-form');
            form.action = "{{ route('front.auction.bid.store', ['auction' => $auction->uuid]) }}";
            form.submit();
        }
        setTimeout(() => {
            loadTimer();
        }, 200);
    </script>
@endpush
