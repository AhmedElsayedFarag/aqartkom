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
                &nbsp;
                <li>
                    <a href="#">إضافة رقم رخصة اعلان</a>
                </li>
            </ul>
        </div>
    </section>

    <section class="addLicence">

        <div class="container">
            @if (session('fail'))
                <div class="alert alert-danger" role="alert">
                    {{ session('fail') }}
                </div>
            @endif
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="licence">
                        <h2 class="title text-center">
                            بناء على نظام الوساطة العقارية لايمكن الاعلان في المنصات
                            العقارية الا بوجود رخصة اعلان
                        </h2>
                        <div class="identity">

                            <h2 class="text-center">نوع الهوية</h2>
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-home" type="button" role="tab"
                                        aria-controls="pills-home" aria-selected="true">
                                        هوية وطنية
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-building-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-building" type="button" role="tab"
                                        aria-controls="pills-building" aria-selected="false">
                                        منشأة
                                    </button>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                    aria-labelledby="pills-home-tab">
                                    <form
                                        action="{{ route('front.user.ad.add-license-number.store', ['ad' => $ad->uuid]) }}"
                                        method="POST">
                                        <div class="first">
                                            <label>رقم هوية المعلن</label>
                                            <input type="text" name="nationality_number" class="form-control"
                                                placeholder="الرجاء كتابة رقم الهوية" required min="0"
                                                pattern="[0-9]{10}">
                                            <div class="invalid-feedback">
                                                @error('nationality_number')
                                                    {{ $errors->first('nationality_number') }}
                                                @enderror
                                            </div>

                                        </div>
                                        <div class="first">
                                            <label>رقم ترخيص الإعلان</label>
                                            <input type="text" name="license_number" class="form-control"
                                                placeholder="الرجاء كتابة الرقم" required pattern="[0-9]{10}">
                                            <div class="invalid-feedback">
                                                @error('license_number')
                                                    {{ $errors->first('license_number') }}
                                                @enderror
                                            </div>
                                        </div>
                                        @csrf
                                        <input type="hidden" name="nationality_type" value="marketer" />
                                        <button type="submit" class="continue">استمرار</button>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="pills-building" role="tabpanel"
                                    aria-labelledby="pills-building-tab">
                                    <form
                                        action="{{ route('front.user.ad.add-license-number.store', ['ad' => $ad->uuid]) }}"
                                        method="POST">
                                        <div class="first">
                                            <label>رقم رخصة المنشاة</label>
                                            <input type="text" name="nationality_number" class="form-control"
                                                placeholder="رقم رخصة المنشاة" required pattern="[0-9]{10}">
                                            <div class="invalid-feedback">
                                                @error('nationality_number')
                                                    {{ $errors->first('nationality_number') }}
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="first">
                                            <label>رقم ترخيص الإعلان</label>
                                            <input type="text" name="license_number" class="form-control"
                                                placeholder="الرجاء كتابة الرقم" required pattern="[0-9]{10}">
                                            <div class="invalid-feedback">
                                                @error('license_number')
                                                    {{ $errors->first('license_number') }}
                                                @enderror
                                            </div>
                                        </div>
                                        @csrf
                                        <input type="hidden" name="nationality_type" value="company" />
                                        <button type="submit" class="continue">استمرار</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('custom-script')
@endpush
