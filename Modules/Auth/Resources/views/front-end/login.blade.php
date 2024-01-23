@extends('front-end.main')
@section('content')
    <section class="register">
        <div class="parent d-flex">
            <div class="fill-data">
                <div class="enroll">
                    <h2 class="title">تسجيل الدخول</h2>
                    <p class="sub-title">
                        لتسجيل حساب جديد يرجي تعبئة البيانات التالية
                    </p>
                    <form method="post" class="login-form" action="{{ route('front.login.store') }}">
                        @csrf
                        <div class="first">
                            <label for="phone">رقم الجوال</label>
                            <input type="tel" placeholder="521365478" value="{{ old('phone') }}" id="phone"
                                name="phone" class="form-control @error('phone') is-invalid @enderror" />
                            <i class="fa-solid fa-phone-volume"></i>
                            <p class="country">
                                +966
                                <img src="{{ asset('front-end/images/flag.png') }}" />
                            </p>
                            <div class="invalid-feedback">
                                @error('phone')
                                    {{ $errors->first('phone') }}
                                @enderror
                            </div>


                        </div>
                        <div class="first">
                            <label for="inputpass">كلمة المرور</label>
                            <input type="password" placeholder="***********" id="inputpass" name="password"
                                class="form-control @error('password') is-invalid @enderror" />
                            <i class="fa-solid fa-lock"></i>
                            <div class="showEl" onclick="myFunction()">
                                <i class="fa-regular fa-eye-slash"></i>
                            </div>
                            <div class="invalid-feedback">
                                @error('password')
                                    {{ $errors->first('password') }}
                                @enderror
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" />
                                <label class="form-check-label" for="flexCheckDefault">
                                    تذكر كلمة المرور
                                </label>
                            </div>
                            <div class="forget">
                                <a href="{{ route('front.forget-password') }}">نسيت كلمة المرور؟</a>
                            </div>
                        </div>
                        <div class="first">
                            <input type="submit" value="تسجيل الدخول" class="form-control" />
                        </div>
                    </form>
                    <a class="nafath-login" href="#" data-bs-toggle="modal" data-bs-target="#certified">
                        <img src="{{ asset('front-end/images/IAM.png') }}" />
                        <p>تسجيل الدخول عن طريق بوابة النفاذ الوطني الموحد</p>
                    </a>
                    <p class="haveAccount">
                        ليس لديك حساب ؟
                        <a href="{{ route('front.register') }}">انشاء حساب جديد</a>
                    </p>
                </div>
            </div>
            <div class="image">
                <img src="{{ asset('front-end/images/people.png') }}" />
                <div class="overlay"></div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="certified" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header modal-header-marketing header-certified" id="modal-head-verify">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <svg class="svg-inline--fa fa-xmark" aria-hidden="true" focusable="false" data-prefix="fas"
                            data-icon="xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"
                            data-fa-i2svg="">
                            <path fill="currentColor"
                                d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z">
                            </path>
                        </svg><!-- <i class="fa-solid fa-xmark"></i> Font Awesome fontawesome.com -->
                    </button>
                    <h2 class="text-center">الدخول بواسطة نفاذ</h2>
                </div>
                <div class="modal-body modal-marcketing modal-cerified text-center" id="modal-body-verify">
                    <p>الرجاء ادخال رقم الهوية</p>
                    <input type="text" placeholder="10xxxxxxxx" class="form-control" id="verify-nationality">
                    <p id="error-verification" class="d-none">برجاء ادخال رقم هوية صحيح</p>

                    <button type="submit" onclick="loginUser()" id="nafath-btn">تسجيل دخول</button>
                </div>
                {{-- <input type="hidden" value="{{ auth()->user()->createToken('access token')->plainTextToken }}" --}}
                {{-- id="user-token"> --}}
                {{-- <input type="hidden" value="{{ auth()->id() }}" id="user-id"> --}}
                <div id="verify-section" class="d-none modal-body modal-marcketing modal-cerified text-center">
                    <h3 class="verify-title">رقم الطلب</h3>
                    <p class="verify-message">فضلنا قم بإختيار رقم الطلب الظاهر لديك في تطبيق النفاذ
                        الوطني</p>
                    <div class="verify-number" id="verify-number">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom-script')
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="{{ asset('front-end/js/login-user.js') }}">
        // Enable pusher logging - don't include this in production
    </script>
@endpush
