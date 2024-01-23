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
                    <span> تعديل بيانات الملف الشخصي
                    </span>
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
                            تعديل بيانات الملف الشخصي
                        </h2>
                        <form action="{{ route('front.change-data.update') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="first">
                                        <label for="fullname">الاسم الكامل</label>
                                        <input type="text" value="{{ old('name') ?? auth()->user()->name }}"
                                            id="fullname" name="name"
                                            class="form-control @error('name') is-invalid @enderror" required />
                                        <i class="fa-regular fa-user"></i>
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $errors->first('name') }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="first">
                                        <label for="email">البريد الإلكتروني</label>
                                        <input type="email" value="{{ old('email') ?? auth()->user()->email }}"
                                            id="email" name="email"
                                            class="form-control @error('email') is-invalid @enderror" />
                                        <i class="fa-regular fa-envelope"></i>
                                        @error('email')
                                            <div class="invalid-feedback">
                                                {{ $errors->first('email') }}
                                            </div>
                                        @enderror
                                    </div>

                                    @if (auth()->user()->type == 'marketer')
                                        <div class="first">
                                            <label for="whatsapp_number">رقم الواتساب</label>
                                            <input type="tel" placeholder="521365478"
                                                value="{{ old('whatsapp_number') ?? str_replace('+966', '', auth()->user()->marketerProfile->whatsapp_number) }}"
                                                id="whatsapp_number" name="whatsapp_number"
                                                class="form-control @error('phone') is-invalid @enderror" />
                                            <i class="fa-solid fa-phone-volume"></i>
                                            <p class="country">
                                                +966
                                                <img src="{{ asset('front-end/images/flag.png') }}" />
                                            </p>
                                            @error('whatsapp_number')
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('whatsapp_number') }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="first">
                                            <label for="advertisement_number">رخصة فال</label>
                                            <input type="tel" placeholder="10XXXX"
                                                value="{{ old('advertisement_number') ?? auth()->user()->marketerProfile->advertisement_number }}"
                                                id="advertisement_number" name="advertisement_number"
                                                class="form-control @error('phone') is-invalid @enderror" />
                                            <i class="fa-regular fa-file-lines"></i>
                                            @error('advertisement_number')
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('advertisement_number') }}
                                                </div>
                                            @enderror
                                        </div>
                                    @endif
                                </div>

                                <div class="col-md-6">
                                    <div class="company-subscripe">
                                        <div class="form-group upload-block">
                                            <div class="upload-images">
                                                <p>تغيير الصوره</p>
                                                <div class="form-upload">
                                                    <div class="preview preview-user img-wrapper">
                                                    </div>
                                                    <div class="file-upload-wrapper">
                                                        <input type="file" name="image" class="file-upload-native"
                                                            accept="image/*">
                                                        <input type="text" disabled="" placeholder=""
                                                            class="file-upload-text">
                                                        @error('image')
                                                            <div class="invalid-feedback">
                                                                {{ $errors->first('image') }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
