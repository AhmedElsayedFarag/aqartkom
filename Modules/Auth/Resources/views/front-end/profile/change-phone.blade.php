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

                    <div class="editPersonalData register">
                        <h2>تغير رقم الجوال</h2>
                        <form action="" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="first">
                                        <label for="phone">رقم الجوال</label>
                                        <input type="tel" placeholder="521365478" id="phone" name="phone"
                                            class="form-control  @error('phone') is-invalid @enderror" />
                                        <i class="fa-solid fa-phone-volume" style="bottom: 2rem !important"></i>
                                        <p class="country" style="bottom:1rem !important">
                                            +966
                                            <img src="{{ asset('front-end/images/flag.png') }}" />
                                        </p>
                                        @error('phone')
                                            <div class="invalid-feedback">
                                                {{ $errors->first('phone') }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <input type="submit" value="حفظ" style="margin-top: 50px;">
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </section>
@endsection
