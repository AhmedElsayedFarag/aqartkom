@extends('front-end.main')
@section('content')
    <section class="register">
        <div class="parent d-flex">
            <div class="fill-data">
                <div class="enroll">
                    <h2 class="title">نسيت كلمة المرور</h2>
                    <p class="sub-title">
                        الرجاء ادخال رقم الجوال المسجل لدي منصات عقارتكم
                    </p>
                    <form method="post" action="{{ route('front.forget-password.store') }}">
                        @csrf
                        <div class="first" style="margin-bottom: 50px;">
                            <input type="tel" placeholder="" id="phone" name="phone"
                                class="form-control  @error('phone') is-invalid @enderror"
                                pattern="5(5|0|3|6|4|9|1|8|7)([0-9]{7})" />
                            <i class="fa-solid fa-phone-volume"></i>
                            <p class="country">
                                +966
                                <img src="{{ asset('front-end/images/flag.png') }}" />
                            </p>
                            @error('phone')
                                <div class="invalid-feedback">
                                    {{ $errors->first('phone') }}
                                </div>
                            @enderror
                        </div>

                        <div class="first" style="margin-bottom: 50px;">
                            <input type="submit" value="ارسال" class="form-control" />
                        </div>
                    </form>
                    <p class="haveAccount">
                        لديك حساب ؟
                        <a href="{{ route('front.login') }}">سجل دخول الأن</a>
                    </p>
                </div>
            </div>
            <div class="image">
                <img src="{{ asset('front-end/images/people.png') }}" />
                <div class="overlay"></div>
            </div>
        </div>
    </section>
@endsection
