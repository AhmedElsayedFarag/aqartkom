@extends('front-end.main')

@section('content')
    <section class="register">
        <div class="parent d-flex">
            <div class="fill-data {{ $errors->count() ? 'd-none' : '' }}" id="phone-form">
                <div class="enroll">
                    <h2 class="title">
                        التسجيل
                    </h2>
                    <p class="sub-title">
                        الرجاء ادخال رقم الجوال
                    </p>
                    {{-- <form method="post" action="{{ route('front.forget-password.store') }}"> --}}

                    <div class="first" style="margin-bottom: 50px;">
                        <input type="tel" placeholder="" id="phone" class="form-control "
                            pattern="5(5|0|3|6|4|9|1|8|7)([0-9]{7})" />
                        <i class="fa-solid fa-phone-volume"></i>
                        <p class="country">
                            +966
                            <img src="{{ asset('front-end/images/flag.png') }}" />
                        </p>
                        <div class="invalid-feedback">
                        </div>
                    </div>

                    <div class="first" style="margin-bottom: 50px;">
                        <input type="submit" value="ارسال" onclick="sendCode()" class="form-control" />
                    </div>
                    {{-- </form> --}}
                    <p class="haveAccount">
                        لديك حساب ؟
                        <a href="{{ route('front.login') }}">سجل دخول الأن</a>
                    </p>
                </div>
            </div>
            <div class="fill-data d-none" id="otpForm">
                <div class="enroll">
                    <h2 class="title">التحقق من رقم الجوال</h2>
                    <p class="sub-title">
                        ادخل الرمز المرسل علي جوالك للاستمرار
                    </p>
                    <form onsubmit="event.preventDefault(); return false;" method="post" action="">
                        <div class="number-verification d-flex justify-content-between flex-row-reverse">
                            <input type="tel" class="codeNumber" maxlength="1" pattern="[0-9]" tabindex="0" />
                            <input type="tel" class="codeNumber" maxlength="1" pattern="[0-9]" tabindex="1" />
                            <input type="tel" class="codeNumber" maxlength="1" pattern="[0-9]" tabindex="2" />
                            <input type="tel" class="codeNumber" maxlength="1" pattern="[0-9]" tabindex="3" />
                            <input type="tel" class="codeNumber" maxlength="1" pattern="[0-9]" tabindex="3" />
                            <input type="tel" class="codeNumber" maxlength="1" pattern="[0-9]" tabindex="3" />

                        </div>

                        <div class="invalid-feedback" id="code-error-message">
                        </div>

                        @csrf

                        <div class="first" style="margin-bottom: 50px;">
                            <button type="button" id="submitButton" onclick="showForm()"
                                class="form-control verify-btn">رمز
                                التحقق</button>
                        </div>
                        <p class="haveAccount" id="timer-code">
                            يرجي انتظار 30 ثواني لاستلام رمز التحقق
                        </p>
                        <button class="btn btn-primary verify-btn" id="sendBtn" onclick="sendCode()" disabled>ارسال الكود
                            مره
                            اخرى</button>
                    </form>
                </div>
            </div>
            <div class="fill-data {{ $errors->count() ? '' : 'd-none' }}" id="register-form">
                {{-- {{ dd($errors) }} --}}
                <div class="enroll">
                    <ul class="nav nav-pills d-flex" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button
                                class="nav-link
                            @if (old('type') == 'customer') active @endif
                            @if (is_null(old('type'))) active @endif
                            "
                                id="pills-person-tab" data-bs-toggle="pill" data-bs-target="#pills-person" type="button"
                                role="tab" aria-controls="pills-person" aria-selected="true"
                                onclick="changeTab('customer')">
                                فرد
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button
                                class="nav-link
                              @if (old('type') == 'marketer') active @endif
                            "
                                id="pills-marketer-tab" data-bs-toggle="pill" data-bs-target="#pills-marketer"
                                type="button" role="tab" aria-controls="pills-marketer" aria-selected="false"
                                onclick="changeTab('marketer')">
                                مسوق عقاري
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button
                                class="nav-link
                             @if (old('type') == 'company') active @endif
                            "
                                id="pills-company-tab" data-bs-toggle="pill" data-bs-target="#pills-company"
                                type="button" role="tab" aria-controls="pills-company" aria-selected="false"
                                onclick="changeTab('company')">
                                شركة
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        {{-- {{ dd($errors) }} --}}
                        <div class="tab-pane fade show active" id="pills-person" role="tabpanel"
                            aria-labelledby="pills-person-tab">
                            <form method="post" action="#" onsubmit="event.preventDefault();submitForm();"
                                id="customer-form">
                                @csrf
                                <div class="first">
                                    <label for="fullname">الاسم الكامل</label>
                                    <input type="text" placeholder="" id="fullname" name="name"
                                        class="form-control @error('name') is-invalid @enderror" />
                                    <i class="fa-regular fa-user"></i>
                                    <div class="invalid-feedback" id="name-error-message">
                                        @error('name')
                                            {{ $errors->first('name') }}
                                        @enderror
                                    </div>
                                </div>
                                <input type="hidden" name="type" value="customer" />
                                <div class="first">
                                    <label for="phone">رقم الجوال</label>
                                    <input type="text" class="phone-input form-control" placeholder="" id="phone"
                                        name="phone" disabled value="{{ old('phone') }}" />
                                    <input type="hidden" class="phone-input" name="phone"
                                        value="{{ old('phone') }}" />
                                    <i class="fa-solid fa-phone-volume"></i>
                                    <p class="country">
                                        +966
                                        <img src="{{ asset('front-end/images/flag.png') }}" />
                                    </p>
                                </div>
                                <div class="first">
                                    <label for="email">البريد الإلكتروني</label>
                                    <input type="email" placeholder="" id="email" name="email"
                                        class="form-control  @error('email') is-invalid @enderror" />
                                    <i class="fa-regular fa-envelope"></i>
                                    <div class="invalid-feedback" id="email-error-message">
                                        @error('email')
                                            {{ $errors->first('email') }}
                                        @enderror
                                    </div>
                                </div>
                                <input type="hidden" class="code" name="otp" value="{{ old('otp') }}" />
                                <div class="first">
                                    <label for="inputpass">كلمة المرور</label>
                                    <input type="password" placeholder="" id="inputpass1" name="password"
                                        class="form-control @error('password') is-invalid @enderror inputpass" />
                                    <i class="fa-solid fa-lock"></i>
                                    <div class="showEl" onclick="myFunction('inputpass1')">
                                        <i class="fa-regular fa-eye-slash"></i>
                                    </div>
                                    <div class="invalid-feedback" id="password-error-message">
                                        @error('password')
                                            {{ $errors->first('password') }}
                                        @enderror
                                    </div>
                                </div>
                                <div class="first">
                                    <label for="confirmpass">تأكيد كلمة المرور</label>
                                    <input type="password" placeholder="" id="confirmpass1" name="password_confirmation"
                                        class="form-control @error('password_confirmation') is-invalid @enderror confirmpass" />
                                    <i class="fa-solid fa-lock"></i>
                                    <div class="showEl" onclick="myFunction2('confirmpass1')">
                                        <i class="fa-regular fa-eye-slash"></i>
                                    </div>
                                    <div class="invalid-feedback" id="password-confirmation-error-message">
                                        @error('password_confirmation')
                                            {{ $errors->first('password_confirmation') }}
                                        @enderror
                                    </div>
                                </div>
                                <div class="first">
                                    <input class="form-check-input " type="checkbox" value=""
                                        id="flexCheckDefault" />
                                    <label class="form-check-label" for="flexCheckDefault">
                                        بتسجل العضوية أنت توافق علي
                                        <a href="{{ route('front.policy', ['page' => 'terms-conditions']) }}">الشروط
                                            والأحكام</a>
                                        و
                                        <a href="{{ route('front.policy', ['page' => 'privacy-policy']) }}">سياسة
                                            الخصوصيه</a>
                                    </label>
                                    <div class="invalid-feedback" id="check-error-message">

                                    </div>
                                </div>
                                <div class="first">
                                    <input type="submit" value="انشاء الحساب" class="form-control" />
                                </div>
                            </form>
                            <p class="haveAccount">
                                لديك حساب ؟
                                <a href="{{ route('front.login') }}">سجل دخول الان</a>
                            </p>
                        </div>
                        <div class="tab-pane fade" id="pills-marketer" role="tabpanel"
                            aria-labelledby="pills-marketer-tab">
                            <form method="post" action="#" onsubmit="event.preventDefault();submitForm();"
                                id="marketer-form">
                                @csrf
                                <div class="first">
                                    <label for="fullname">الاسم الكامل</label>
                                    <input type="text" placeholder="" id="fullname" name="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name') }}" />
                                    <i class="fa-regular fa-user"></i>
                                    <div class="invalid-feedback" id="name-error-message">
                                        @error('name')
                                            {{ $errors->first('name') }}
                                        @enderror
                                    </div>
                                </div>
                                <input type="hidden" name="type" value="marketer" />
                                <div class="first">
                                    <label for="phone">رقم الجوال</label>
                                    <input type="text" class="phone-input form-control" placeholder="" id="phone"
                                        name="phone" disabled value="{{ old('phone') }}" />
                                    <input type="hidden" class="phone-input" name="phone"
                                        value="{{ old('phone') }}" />
                                    <i class="fa-solid fa-phone-volume"></i>
                                    <p class="country">
                                        +966
                                        <img src="{{ asset('front-end/images/flag.png') }}" />
                                    </p>
                                </div>
                                <div class="first">
                                    <label for="advertisement_number">رخصة فال</label>
                                    <input type="text" placeholder="" id="advertisement_number"
                                        name="advertisement_number" value="{{ old('advertisement_number') }}"
                                        class="form-control  @error('email') is-invalid @enderror"
                                        pattern="[0-9]{6,16}" />
                                    <img src="{{ asset('front-end/images/icons/megaphone.png') }}"
                                        class="advertisal_img" />
                                    <div class="invalid-feedback" id="advertisement_number-error-message">
                                        @error('advertisement_number')
                                            {{ $errors->first('advertisement_number') }}
                                        @enderror
                                    </div>
                                </div>
                                <div class="first">
                                    <label for="email">البريد الإلكتروني</label>
                                    <input type="email" placeholder="" id="email" name="email"
                                        class="form-control  @error('email') is-invalid @enderror"
                                        value="{{ old('email') }}" />
                                    <i class="fa-regular fa-envelope"></i>
                                    <div class="invalid-feedback" id="email-error-message">
                                        @error('email')
                                            {{ $errors->first('email') }}
                                        @enderror
                                    </div>
                                </div>
                                <input type="hidden" class="code" name="otp" value="{{ old('otp') }}" />
                                <div class="first">
                                    <label for="inputpass">كلمة المرور</label>
                                    <input type="password" placeholder="" id="inputpass2" name="password"
                                        class="form-control @error('password') is-invalid @enderror inputpass" />
                                    <i class="fa-solid fa-lock"></i>
                                    <div class="showEl" onclick="myFunction('inputpass2')">
                                        <i class="fa-regular fa-eye-slash"></i>
                                    </div>
                                    <div class="invalid-feedback" id="password-error-message">
                                        @error('password')
                                            {{ $errors->first('password') }}
                                        @enderror
                                    </div>
                                </div>
                                <div class="first">
                                    <label for="confirmpass">تأكيد كلمة المرور</label>
                                    <input type="password" placeholder="" id="confirmpass2" name="password_confirmation"
                                        class="form-control @error('password_confirmation') is-invalid @enderror confirmpass" />
                                    <i class="fa-solid fa-lock"></i>
                                    <div class="showEl" onclick="myFunction2('confirmpass2')">
                                        <i class="fa-regular fa-eye-slash"></i>
                                    </div>
                                    <div class="invalid-feedback" id="password-confirmation-error-message">
                                        @error('password_confirmation')
                                            {{ $errors->first('password_confirmation') }}
                                        @enderror
                                    </div>
                                </div>
                                <div class="first">
                                    <input class="form-check-input " type="checkbox" value=""
                                        id="flexCheckDefault" />
                                    <label class="form-check-label" for="flexCheckDefault">
                                        بتسجل العضوية أنت توافق علي
                                        <a href="{{ route('front.policy', ['page' => 'terms-conditions']) }}">الشروط
                                            والأحكام</a>
                                        و
                                        <a href="{{ route('front.policy', ['page' => 'privacy-policy']) }}">سياسة
                                            الخصوصيه</a>
                                    </label>
                                    <div class="invalid-feedback" id="check-error-message">

                                    </div>
                                </div>
                                <div class="first">
                                    <input type="submit" value="انشاء الحساب" class="form-control" />
                                </div>
                            </form>
                            <p class="haveAccount">
                                لديك حساب ؟
                                <a href="{{ route('front.login') }}">سجل دخول الان</a>
                            </p>
                        </div>

                        <div class="tab-pane fade" id="pills-company" role="tabpanel"
                            aria-labelledby="pills-company-tab">
                            {{-- {{ dd($errors) }} --}}
                            <form method="post" action="#" onsubmit="event.preventDefault();submitForm();"
                                id="company-form" enctype="multipart/form-data">
                                @csrf
                                <div class="first">
                                    <label for="fullname">الاسم الكامل</label>
                                    <input type="text" value="{{ old('name') }}" placeholder="" id="fullname"
                                        name="name" class="form-control  @error('name') is-invalid @enderror" />
                                    <i class="fa-regular fa-user"></i>
                                    <div class="invalid-feedback" id="name-error-message">
                                        @error('name')
                                            {{ $errors->first('name') }}
                                        @enderror
                                    </div>
                                </div>
                                <input type="hidden" name="type" value="company" />
                                <div class="first">
                                    <label for="phone">رقم الجوال</label>
                                    <input type="tel" placeholder="" class="phone-input" id="phone"
                                        name="phone" class="form-control" value="{{ old('phone') }}" disabled />
                                    <i class="fa-solid fa-phone-volume"></i>
                                    <p class="country">
                                        +966
                                        <img src="{{ asset('front-end/images/flag.png') }}" />
                                    </p>
                                    <input type="hidden" class="phone-input" name="phone"
                                        value="{{ old('phone') }}" />
                                </div>
                                <input type="hidden" class="code" name="otp" value="{{ old('otp') }}" />
                                <div class="first">
                                    <label for="advertise">رخصة فال</label>
                                    <input type="text" placeholder="" id="advertise" name="advertisement_number"
                                        class="form-control" pattern="[0-9]{6,16}"
                                        value="{{ old('advertisement_number') }}" />
                                    <i class="fa-regular fa-file-lines"></i>
                                    <div class="invalid-feedback" id="advertisement-error-message">
                                        @error('advertisement_number')
                                            {{ $errors->first('advertisement_number') }}
                                        @enderror
                                    </div>
                                </div>
                                <div class="first">
                                    <label for="logo">شعار الشركة</label>
                                    <input type="file" accept="image/jpg,image/png,image/jpeg" id="logo"
                                        name="logo" class="form-control  @error('email') is-invalid @enderror" />
                                    <div class="invalid-feedback" id="logo-error-message">
                                        @error('logo')
                                            {{ $errors->first('logo') }}
                                        @enderror
                                    </div>
                                </div>
                                <div class="first">
                                    <label for="fullname">وصف الشركة</label>
                                    <input type="text" placeholder="" id="fullname"
                                        value="{{ old('description') }}" name="description"
                                        class="form-control  @error('name') is-invalid @enderror" />
                                    <i class="fa-regular fa-user"></i>
                                    <div class="invalid-feedback" id="description-error-message">
                                        @error('description')
                                            {{ $errors->first('description') }}
                                        @enderror
                                    </div>
                                </div>
                                <input type="hidden" id="lat" name="lat"
                                    value="{{ old('lat', 24.774265) }}" />
                                <input type="hidden" id="long" name="long"
                                    value="{{ old('long', 46.738586) }}" />

                                <div class="row" style="height:400px;margin-top:5%;">
                                    <input id="pac-input" class="controls" style="width:50%" type="text"
                                        placeholder="Search Box" />
                                    <div id="map" style="height:100%"></div>
                                </div>
                                <div class="first">
                                    <label for="email">البريد الإلكتروني</label>
                                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                                        class="form-control  @error('email') is-invalid @enderror" />
                                    <i class="fa-regular fa-envelope"></i>
                                    <div class="invalid-feedback" id="email-error-message">
                                        @error('email')
                                            {{ $errors->first('email') }}
                                        @enderror
                                    </div>
                                </div>
                                <div class="first">
                                    <label for="inputpass">كلمة المرور</label>
                                    <input type="password" placeholder="" id="inputpass3" name="password"
                                        class="form-control  @error('password') is-invalid @enderror inputpass" />
                                    <i class="fa-solid fa-lock"></i>
                                    <div class="showEl" onclick="myFunction('inputpass3')">
                                        <i class="fa-regular fa-eye-slash"></i>
                                    </div>
                                    <div class="invalid-feedback" id="password-error-message">
                                        @error('password')
                                            {{ $errors->first('password') }}
                                        @enderror
                                    </div>
                                </div>
                                <div class="first">
                                    <label for="confirmpass">تأكيد كلمة المرور</label>
                                    <input type="password" placeholder="" id="confirmpass3" name="password_confirmation"
                                        class="form-control  @error('password_confirmation') is-invalid @enderror confirmpass" />
                                    <i class="fa-solid fa-lock"></i>
                                    <div class="showEl" onclick="myFunction2('confirmpass3')">
                                        <i class="fa-regular fa-eye-slash"></i>
                                    </div>
                                    <div class="invalid-feedback" id="password-confirmation-error-message">
                                        @error('password_confirmation')
                                            {{ $errors->first('password_confirmation') }}
                                        @enderror
                                    </div>
                                </div>
                                <div class="first">
                                    <input class="form-check-input" type="checkbox" value=""
                                        id="flexCheckDefault" />
                                    <label class="form-check-label" for="flexCheckDefault">
                                        بتسجل العضوية أنت توافق علي
                                        <a href="{{ route('front.policy', ['page' => 'terms-conditions']) }}">الشروط
                                            والأحكام</a>
                                        و
                                        <a href="{{ route('front.policy', ['page' => 'privacy-policy']) }}">سياسة
                                            الخصوصيه</a>
                                    </label>
                                    <div class="invalid-feedback" id="check-error-message">

                                    </div>
                                </div>
                                <div class="first">
                                    <input type="submit" value="انشاء الحساب" class="form-control" />
                                </div>
                            </form>
                            <p class="haveAccount">
                                لديك حساب ؟
                                <a href="{{ route('front.login') }}">سجل دخول الان</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="image">
                <img src="{{ asset('front-end/images/people.png') }}" />
                <div class="overlay"></div>
            </div>
        </div>
    </section>
@endsection

@push('custom-script')
    <script src="{{ asset('front-end/js/validations.js') }}"></script>
    <script src="{{ asset('front-end/js/verify.js') }}"></script>
    @include('partials.map-scripts')
    <script>
        const timerText = document.querySelector('#timer-code');
        const sendCodeBtn = document.querySelector('#sendBtn');
        const phoneInput = document.querySelector('#phone');
        const codeInputs = document.querySelectorAll('.code');
        let retrievedCode = '';
        let errorStatus = false;

        const changeTimer = () => {
            let time = 60;
            sendCodeBtn.disabled = true;
            const timer = setInterval(() => {
                time--;
                timerText.innerHTML = `يرجي انتظار ${time} ثواني لاستلام رمز التحقق`;
                if (time === 0) {
                    clearInterval(timer);
                    timerText.innerHTML = `لم تصلك رسالة؟`;
                    sendCodeBtn.disabled = false;
                }
            }, 1000)
        }
        const sendCode = () => {
            if (!isValidPhone(phoneInput.value)) {
                phoneInput.classList.add('is-invalid');
                document.querySelector('#phone ~ .invalid-feedback').innerHTML = 'رقم الجوال غير صحيح';
                return;
            }

            axios.post('/api/v1/auth/generate-otp', {
                phone: `+966${phoneInput.value}`
            }).then(res => {
                retrievedCode = res.data.code;
                showOtpForm();
                changeTimer();
            }).catch(err => {
                if (!err)
                    return;
                phoneInput.classList.add('is-invalid');
                document.querySelector('#phone ~ .invalid-feedback').innerHTML = err.response.data.message;

            })
        }
        const showForm = () => {
            currentCode = getCode();

            codeInputs.forEach(element => {
                element.value = currentCode;
            });
            if (currentCode != retrievedCode) {
                let codeErrorMessage = document.querySelector('#code-error-message');
                codeErrorMessage.innerHTML = 'رمز التحقق غير صحيح';
                codeErrorMessage.classList.add('d-block');
                submitButton.disabled = true;
                return;
            }

            document.querySelector('#register-form').classList.remove('d-none');
            document.querySelector('#otpForm').classList.add('d-none');
        }
        const showOtpForm = () => {
            document.querySelector('#phone-form').classList.add('d-none');
            document.querySelector('#otpForm').classList.remove('d-none');
            document.querySelectorAll('.phone-input').forEach(element => {
                element.value = phoneInput.value
            });
        }
        let currentTab = "customer";
        const submitForm = () => {

            let currentForm = document.querySelector(`#${currentTab}-form`);
            let nameInput = currentForm.querySelector('#fullname');
            let descriptionInput = currentForm.querySelector('#description');
            let emailInput = currentForm.querySelector('#email');
            let passwordInput = currentForm.querySelector('.inputpass');
            let confirmPasswordInput = currentForm.querySelector('.confirmpass');
            let checkInput = currentForm.querySelector('#flexCheckDefault');
            let advertisementInput = currentForm.querySelector('#advertise');
            let advertisementMessage = currentForm.querySelector('#advertisement-error-message');

            let advertisementNumberInput = currentForm.querySelector('#advertisement_number');
            let advertisementNumberMessage = currentForm.querySelector('#advertisement_number-error-message');

            let logoInput = currentForm.querySelector('#logo');
            let logoMessage = currentForm.querySelector('#logo-error-message');
            let nameErrorMessage = currentForm.querySelector('#name-error-message');
            let descriptionErrorMessage = currentForm.querySelector('#description-error-message');
            let emailErrorMessage = currentForm.querySelector('#email-error-message');
            let passwordErrorMessage = currentForm.querySelector('#password-error-message');
            let confirmPasswordErrorMessage = currentForm.querySelector('#password-confirmation-error-message');
            let checkErrorMessage = currentForm.querySelector('#check-error-message');

            let errorStatuses = {
                name: false,
                email: false,
                password: false,
                confirmPassword: false,
                check: false,
                // advertisement: false
            }
            if (!isValidLength(nameInput.value, 3, 120)) {
                nameInput.classList.add('is-invalid');
                nameErrorMessage.innerHTML = "يجب ان يكون الاسم اكثر من 3 احرف واقل من ١٢٠ حرف";
                nameErrorMessage.classList.add('d-block');
                errorStatuses.name = true;
            } else {
                nameInput.classList.remove('is-invalid');
                nameErrorMessage.classList.remove('d-block');
                nameErrorMessage.innerHTML = "";
                errorStatuses.name = false;
            }
            if (!isValidEmail(emailInput.value)) {
                emailInput.classList.add('is-invalid');
                emailErrorMessage.innerHTML = 'البريد الالكتروني غير صحيح';
                emailErrorMessage.classList.add('d-block');
                errorStatuses.email = true;
            } else {
                emailInput.classList.remove('is-invalid');
                emailErrorMessage.classList.remove('d-block');
                emailErrorMessage.innerHTML = "";
                errorStatuses.email = false;
            }
            if (!isValidLength(passwordInput.value, 8, 120)) {
                passwordInput.classList.add('is-invalid');
                passwordErrorMessage.innerHTML = "يجب ان يكون كلمة المرور اكثر من 8 احرف واقل من ١٢٠ حرف";
                passwordErrorMessage.classList.add('d-block');
                errorStatuses.password = true;
            } else {
                passwordInput.classList.remove('is-invalid');
                passwordErrorMessage.classList.remove('d-block');
                passwordErrorMessage.innerHTML = "";
                errorStatuses.password = false;
            }
            if (!isValidLength(confirmPasswordInput.value, 8, 120)) {
                confirmPasswordInput.classList.add('is-invalid');
                confirmPasswordErrorMessage.innerHTML = "يجب ان يكون تاكيد كلمة المرور اكثر من 8 احرف واقل من ١٢٠ حرف";
                confirmPasswordErrorMessage.classList.add('d-block');
                errorStatuses.confirmPassword = true;
            } else {
                confirmPasswordInput.classList.remove('is-invalid');
                confirmPasswordErrorMessage.classList.remove('d-block');
                confirmPasswordErrorMessage.innerHTML = "";
                errorStatuses.confirmPassword = false;
            }
            if (passwordInput.value != confirmPasswordInput.value) {
                confirmPasswordInput.classList.add('is-invalid');
                confirmPasswordErrorMessage.innerHTML = "كلمة المرور غير متطابقة";
                confirmPasswordErrorMessage.classList.add('d-block');
                errorStatuses.confirmPassword = true;
            } else {
                confirmPasswordInput.classList.remove('is-invalid');
                confirmPasswordErrorMessage.classList.remove('d-block');
                confirmPasswordErrorMessage.innerHTML = "";
                errorStatuses.confirmPassword = false;
            }
            if (!checkInput.checked) {
                checkInput.classList.add('is-invalid');
                checkErrorMessage.innerHTML = "يجب الموافقة على الشروط والاحكام";
                checkErrorMessage.classList.add('d-block');
                errorStatuses.check = true;
            } else {
                checkInput.classList.remove('is-invalid');
                checkErrorMessage.innerHTML = "";
                checkErrorMessage.classList.remove('d-block');
                errorStatuses.check = false;
            }
            if (advertisementInput) {

                if (!/^(12)\d{8,20}$/.test(advertisementInput.value)) {
                    advertisementInput.classList.add('is-invalid');
                    advertisementMessage.innerHTML = "رخصة فال غير صحيح";
                    advertisementMessage.classList.add('d-block');
                    errorStatuses.advertisement = true;
                } else {
                    advertisementInput.classList.remove('is-invalid');
                    advertisementMessage.classList.remove('d-block');
                    advertisementMessage.innerHTML = "";
                    errorStatuses.advertisement = false;
                }
            }
            if (descriptionInput) {
                if (!isValidLength(descriptionInput.value, 3, 200)) {
                    descriptionInput.classList.add('is-invalid');
                    descriptionErrorMessage.innerHTML = "يجب ان يكون الاسم اكثر من 3 احرف واقل من 200 حرف";
                    descriptionErrorMessage.classList.add('d-block');
                    errorStatuses.description = true;
                } else {
                    descriptionInput.classList.remove('is-invalid');
                    descriptionErrorMessage.classList.remove('d-block');
                    descriptionErrorMessage.innerHTML = "";
                    errorStatuses.description = false;
                }
            }
            if (advertisementNumberInput) {

                if (!/^(11)\d{8,20}$/.test(advertisementNumberInput.value)) {
                    advertisementNumberInput.classList.add('is-invalid');
                    advertisementNumberMessage.innerHTML = "رخصة فال غير صحيح";
                    advertisementNumberMessage.classList.add('d-block');
                    errorStatuses.advertisement = true;
                } else {
                    advertisementNumberInput.classList.remove('is-invalid');
                    advertisementNumberMessage.classList.remove('d-block');
                    advertisementNumberMessage.innerHTML = "";
                    errorStatuses.advertisement = false;
                }
            }
            if (logoInput) {
                if (logoInput.value == "") {
                    logoInput.classList.add('is-invalid');
                    logoMessage.innerHTML = "الشعار مطلوب"
                    logoMessage.classList.add('d-block');
                    errorStatuses.logo = true;
                } else {
                    logoInput.classList.remove('is-invalid');
                    logoMessage.classList.remove('d-block');
                    logoMessage.innerHTML = "";
                    errorStatuses.logo = false;
                }
            }

            let errorStatus = false;
            for (const key in errorStatuses) {
                errorStatus |= errorStatuses[key];
            }
            if (errorStatus) {
                currentForm.action = "#"
                return;
            }

            currentForm.action = "{{ route('front.register') }}";
            currentForm.submit();

        }
        const changeTab = (tab) => {
            currentTab = tab;
        }
    </script>
@endpush
