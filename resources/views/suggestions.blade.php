@extends('front-end.main')
@push('custom-style')
    <style>
        .btn-primary {
            background: #262F6A 0% 0% no-repeat padding-box;
            border-radius: 8px;
            border: none;
            padding: 0.5rem 4rem;
        }
    </style>
@endpush
@section('content')
    <section class="suggestions-form">
        <div class="container">
            <div class="row justify-content-center mb-4">
                <div class="col-md-10" style="color: #707070;font-size:0.9em">
                    الرئسية > الشكاوي والمقترحات
                </div>
                @if (session('message'))
                    <div class="alert alert-success" role="alert">
                        {{ session('message') }}
                    </div>
                @endif
            </div>

            <form action="{{ route('suggestions.store') }}" id="submitForm" method="post" role="form">
                @csrf
                <div class="row justify-content-center">
                    <div class="col-md-5">
                        <div class="first">
                            <label>الاسم بالكامل</label>
                            <input id="validation-form-1" type="text" name="name"
                                class="form-control  @error('name') is-invalid @enderror mt-2 p-3" required
                                value="{{ old('name') }}" placeholder="الرجاء كتابة الاسم بالكامل">
                            <div class="invalid-feedback">
                                @error('name')
                                    {{ $errors->first('name') }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="first">
                            <label>رقم الجوال</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text mt-2 p-3" id="basic-addon1" style="background: #fff">
                                    <img src="{{ asset('front-end/images/rectangle-flag.png') }}" width="40px"
                                        height="30px" style="margin:0 0.5rem;" />
                                    (+966)
                                </span>
                                <input type="tel" class="form-control  @error('phone') is-invalid @enderror  mt-2 p-3"
                                    value="{{ old('phone') }}" style="text-align: right" placeholder="ادخل رقم جوالك هنا"
                                    name="phone" aria-label="رقم الجوال" aria-describedby="basic-addon1">
                            </div>


                            @error('phone')
                                <div class="invalid-feedback d-block">
                                    {{ $errors->first('phone') }}
                                </div>
                            @enderror

                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="first">
                            <label>التفاصيل</label>
                            <textarea id="update-profile-form-5" name="notes" class="form-control  mt-2 @error('notes') is-invalid @enderror"
                                required rows="10">{{ old('notes') }}</textarea>
                            <div class="invalid-feedback">
                                @error('notes')
                                    {{ $errors->first('notes') }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-10 mt-4">
                        <button type="submit" class="btn btn-primary">ارسال</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
