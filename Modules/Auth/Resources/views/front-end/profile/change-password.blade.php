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
                @include('auth::front-end.profile.sidebar')
                <div class="col-md-8">
                    <div class="editPersonalData register">
                        <h2>
                            تغيير كلمة المرور
                        </h2>
                        <form action="{{ route('front.change-password.update') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="first">
                                        <label for="inputpass_old">كلمة المرور القديمة</label>
                                        <input type="text" placeholder="***********" id="inputpass_old"
                                            name="old_password"
                                            class="form-control @error('old_password')
                                                 is-invalid
                                            @enderror" />
                                        <i class="fa-solid fa-lock" style="bottom:2rem !important"></i>
                                        @error('old_password')
                                            <div class="invalid-feedback">
                                                {{ $errors->first('old_password') }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="first">
                                        <label for="inputpass">كلمة المرور</label>
                                        <input type="password" placeholder="***********" id="inputpass" name="password"
                                            class="form-control @error('password')
                                                is-invalid
                                            @enderror" />
                                        <i class="fa-solid fa-lock" style="bottom:2rem !important"></i>
                                        <div class="showEl" onclick="myFunction()">
                                            <i class="fa-regular fa-eye-slash" style="bottom:2rem !important"></i>
                                        </div>
                                        @error('password')
                                            <div class="invalid-feedback">
                                                {{ $errors->first('password') }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="first">
                                        <label for="confirmpass">تأكيد كلمة المرور</label>
                                        <input type="password" placeholder="***********" id="confirmpass"
                                            name="password_confirmation"
                                            class="form-control @error('password_confirmation')
                                                 is-invalid
                                            @enderror" />
                                        <i class="fa-solid fa-lock" style="bottom:2rem !important"></i>
                                        <div class="showEl" onclick="myFunction2()">
                                            <i class="fa-regular fa-eye-slash" style="bottom:2rem !important"></i>
                                        </div>
                                        @error('password_confirmation')
                                            <div class="invalid-feedback">
                                                {{ $errors->first('password_confirmation') }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <input type="submit" value="حفظ">
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
