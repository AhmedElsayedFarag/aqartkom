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
                <span>></span>
                &nbsp;
                <li>إضافة إعلان</li>
            </ul>
        </div>
    </section>

    <section class="addSteps">
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <form action="{{ route('front.user.ad-steps.redirect') }}" method="POST">
                        @csrf
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="1" name="step"
                                id="flexRadioDefault1" checked>
                            <label class="form-check-label" for="flexRadioDefault1">
                                <div class="parent d-flex">
                                    <div class="photo">
                                        {{-- images/Group 44648.svg --}}
                                        <img src="{{ asset('front-end/images/Group 44648.svg') }}">
                                    </div>
                                    <div class="info">
                                        <h2>اضافة اعلان مرخص</h2>
                                        <p>لدي رقم ترخيص الاعلان</p>
                                    </div>
                                </div>
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" value="2" type="radio" name="step"
                                id="flexRadioDefault2">
                            <label class="form-check-label" for="flexRadioDefault2">
                                <div class="parent d-flex">
                                    <div class="photo">
                                        <img src="{{ asset('front-end/images/Group 44733.png') }}">
                                    </div>
                                    <div class="info">
                                        <h2>اضافة اعلان (مع إصدار ترخيص)</h2>
                                        <p>إصدار الترخص سيكون من خلال منصة عقاراتكمـ</p>
                                    </div>
                                </div>
                            </label>
                        </div>

                        <button type="submit">
                            استمرار
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('custom-script')
    <script>
        $('.form-check').on('click', function() {
            $(this).children()[0].click();
        });
    </script>
@endpush
