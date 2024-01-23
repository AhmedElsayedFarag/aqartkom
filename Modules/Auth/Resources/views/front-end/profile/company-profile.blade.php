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
                    <a href="#">الملف للشركة</a>
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
                    <div class="tab-pane" id="pills-data" role="tabpanel" aria-labelledby="pills-data-tab">
                        <div class="company-data">
                            <form method="post" action="#" onsubmit="event.preventDefault();submitForm();"
                                id="subscription-form">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="first">
                                            <label for="name">اسم الشركة</label>
                                            <input type="text" id="name-input" name="name"
                                                class="form-control @error('name') is-invalid @enderror"
                                                value="{{ $company->name }}">
                                            <div class="invalid-feedback" id="name-error-message">
                                                @error('name')
                                                    {{ $errors->first('name') }}
                                                @enderror
                                            </div>
                                        </div>
                                        {{-- <div class="first">
                                            <label>المدينة</label>
                                            <br />
                                            <select class="js-states" id="city-input" name="city_id" style="width:100%">
                                                <option></option>
                                                @foreach ($cities as $city)
                                                    <option value="{{ $city->id }}"
                                                        {{ $company->city_id == $city->id ? 'selected' : '' }}>
                                                        {{ $city->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback" id="city-error-message">
                                                @error('city')
                                                    {{ $errors->first('city') }}
                                                @enderror
                                            </div>
                                        </div> --}}
                                        <div class="first">
                                            <label for="segal">رخصة فال</label>
                                            <input type="text" value="5122223525" id="register-number-input"
                                                name="commercial_register_number" class="form-control"
                                                value="{{ $company->commercial_register_number }}">
                                            <div class="invalid-feedback" id="register-number-error-message">
                                                @error('commercial_register_number')
                                                    {{ $errors->first('commercial_register_number') }}
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="first">
                                            <label>رقم الواتس اب</label>
                                            <input type="tel" id="whatsapp-input" name="whatsapp"
                                                placeholder="الرجاء إدخال رقم الواتس اب"
                                                class="form-control @error('whatsapp') is-invalid @enderror"
                                                value="{{ str_replace('+966', '', $company->whatsapp_number) }}">
                                            <div class="wizard-form-error wizard-form-error3"></div>
                                            <div class="invalid-feedback" id="whatsapp-error-message">
                                                @error('whatsapp')
                                                    {{ $errors->first('whatsapp') }}
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <figure class="photo">
                                            <img src="{{ asset('storage/companies/' . $company->logo) }}">
                                        </figure>
                                    </div>
                                    <div class="col-md-12">
                                        <label>نبذه عن الشركة</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" rows="5" id="description-input"
                                            name="description">{{ $company->description }}</textarea>
                                        <div class="invalid-feedback" id="description-error-message">
                                            @error('description')
                                                {{ $errors->first('description') }}
                                            @enderror
                                        </div>
                                    </div>
                                    <input type="hidden" id="lat" name="lat" value="{{ $company->lat }}" />
                                    <input type="hidden" id="long" name="long" value="{{ $company->long }}" />

                                    <div class="row" style="height:400px;margin-top:5%;">
                                        <label>موقع الشركة علي خرائط جوجل</label>
                                        <input id="pac-input" class="controls" style="width:50%" type="text"
                                            placeholder="Search Box" />
                                        <div id="map" style="height:100%"></div>
                                    </div>
                                </div>
                                <input type="submit" value="حفظ">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection


@push('custom-script')
    @include('partials.map-scripts')
    <script src="{{ asset('front-end/js/validations.js') }}"></script>
    <script>
        function submitForm() {
            let currentForm = document.querySelector(`#subscription-form`);
            let nameInput = currentForm.querySelector('#name-input');
            let cityInput = currentForm.querySelector('#city-input');
            let registerInput = currentForm.querySelector('#register-number-input');
            let whatsappInput = currentForm.querySelector('#whatsapp-input');
            let descriptionInput = currentForm.querySelector('#description-input');
            let logoInput = currentForm.querySelector('#logo-input');

            let nameErrorMessage = currentForm.querySelector('#name-error-message');
            let cityErrorMessage = currentForm.querySelector('#city-error-message');
            let registerErrorMessage = currentForm.querySelector('#register-number-error-message');
            let whatsappErrorMessage = currentForm.querySelector('#whatsapp-error-message');
            let descriptionErrorMessage = currentForm.querySelector('#description-error-message');
            let logoErrorMessage = currentForm.querySelector('#logo-error-message');
            let packageErrorMessage = currentForm.querySelector('#package-error-message');
            let errorStatuses = {
                name: false,
                city: false,
                register: false,
                whatsapp: false,
                description: false,
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

            if (!cityInput.value.length) {
                cityInput.classList.add('is-invalid');
                cityErrorMessage.innerHTML = "يجب اختيار المدينة";
                cityErrorMessage.classList.add('d-block');
                errorStatuses.city = true;
            } else {
                cityInput.classList.remove('is-invalid');
                cityErrorMessage.classList.remove('d-block');
                cityErrorMessage.innerHTML = "";
                errorStatuses.city = false;
            }


            if (!isValidPhone(whatsappInput.value)) {
                whatsappInput.classList.add('is-invalid');
                whatsappErrorMessage.innerHTML = "رقم الواتس اب غير صحيح";
                whatsappErrorMessage.classList.add('d-block');
                errorStatuses.whatsapp = true;
            } else {
                whatsappInput.classList.remove('is-invalid');
                whatsappErrorMessage.classList.remove('d-block');
                whatsappErrorMessage.innerHTML = "";
                errorStatuses.whatsapp = false;
            }

            if (!isValidLength(descriptionInput.value, 3, 1000)) {
                descriptionInput.classList.add('is-invalid');
                descriptionErrorMessage.innerHTML = "يجب ان يكون الوصف اكثر من 3 احرف واقل من ١٠٠٠ حرف";
                descriptionErrorMessage.classList.add('d-block');
                errorStatuses.description = true;
            } else {
                descriptionInput.classList.remove('is-invalid');
                descriptionErrorMessage.classList.remove('d-block');
                descriptionErrorMessage.innerHTML = "";
                errorStatuses.description = false;
            }

            if (!isValidAdvertisement(registerInput.value)) {
                registerInput.classList.add('is-invalid');
                registerErrorMessage.innerHTML = "السجل التجاري غير صحيح";
                registerErrorMessage.classList.add('d-block');
                errorStatuses.register = true;
            } else {
                registerInput.classList.remove('is-invalid');
                registerErrorMessage.classList.remove('d-block');
                registerErrorMessage.innerHTML = "";
                errorStatuses.register = false;
            }
            let errorStatus = false;
            for (const key in errorStatuses) {
                errorStatus |= errorStatuses[key];
            }
            console.log(errorStatuses);
            if (errorStatus) {
                currentForm.action = "#"
                return;
            }

            currentForm.action = "{{ route('front.company-profile.store') }}";
            currentForm.submit();
        }
    </script>
@endpush


@push('custom-style')
@endpush
