@extends('front-end.main')

@section('content')
    <section class="register verify">
        <div class="parent d-flex">
            <div class="fill-data" id="otpForm">
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

                        <div class="invalid-feedback">
                            @error('code')
                                {{ $errors->first('code') }}
                            @enderror
                        </div>

                        @csrf

                        <div class="first" style="margin-bottom: 50px;">
                            <button type="button" id="submitButton" onclick="showForm()" class="form-control verify-btn"
                                disabled>رمز
                                التحقق</button>
                        </div>
                        <p class="haveAccount">
                            يرجي انتظار 30 ثواني لاستلام رمز التحقق
                        </p>
                        <button class="btn btn-primary verify-btn" id="sendBtn" onclick="sendCode()" disabled>ارسال الكود
                            مره
                            اخرى</button>
                    </form>
                </div>
            </div>
            <div class="fill-data d-none" id="newPasswordForm">
                <div class="enroll">
                    <h2 class="title">تعين كلمة المرور</h2>
                    <p class="sub-title">
                        الرجاء ادخال كلمة المرور الجديدة وتأكيد كلمة المرور
                    </p>
                    <form method="post" action="{{ route('front.reset-password.store') }}">
                        @csrf
                        <div class="first">
                            <label for="inputpass">كلمة المرور</label>
                            <input type="password" minlength="8" maxlength="120" placeholder id="inputpass" name="password"
                                class="form-control" />
                            <i class="fa-solid fa-lock"></i>
                            <div class="showEl" onclick="myFunction()">
                                <i class="fa-regular fa-eye-slash"></i>
                            </div>
                            @error('password')
                                {{ $errors->first('password') }}
                            @enderror
                        </div>
                        <div class="first">
                            <label for="confirmpass">تأكيد كلمة المرور</label>
                            <input type="password" minlength="8" maxlength="120" placeholder id="confirmpass"
                                name="password_confirmation" class="form-control" />
                            <i class="fa-solid fa-lock"></i>
                            <div class="showEl" onclick="myFunction2()">
                                <i class="fa-regular fa-eye-slash"></i>
                            </div>

                            @error('password_confirmation')
                                {{ $errors->first('password_confirmation') }}
                            @enderror
                        </div>

                        <input type="hidden" value="" id="code" name="code" />
                        <input type="hidden" value="{{ $phone }}" name="phone" />
                        <div class="first">
                            <input type="submit" value="تعين كلمة المرور" class="form-control" />
                        </div>
                    </form>

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
    <script src="{{ asset('front-end/js/verify.js') }}"></script>
    <script>
        const timerText = document.querySelector('.haveAccount');
        const sendCodeBtn = document.querySelector('#sendBtn');
        const changeTimer = () => {
            let time = 120;
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
        changeTimer();
        const sendCode = () => {
            axios.post('/api/v1/auth/generate-otp', {
                phone: '{{ $phone }}'
            }).then(res => {
                changeTimer();
            }).catch(err => {
                console.log(err);
            })
        }
    </script>
    <script>
        const showForm = () => {
            code.value = getCode();
            document.querySelector('#newPasswordForm').classList.remove('d-none');
            document.querySelector('#otpForm').classList.add('d-none');
        }
    </script>
@endpush
@push('custom-style')
    <style>
        .invalid-feedback {
            display: block;
        }
    </style>
@endpush
