@extends('front-end.main')

@section('content')
    <section class="company-subscripe">
        <div class="container">

            <form method="POST" action="#" id="subscription-form" enctype="multipart/form-data"
                onsubmit="event.preventDefault();submitForm();">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="field">
                                    <label>اسم الشركة</label>
                                    <input type="text" id="name-input" name="name"
                                        placeholder="الرجاء إدخال اسم الشركة"
                                        class="form-control  @error('name') is-invalid @enderror">
                                    <div class="invalid-feedback" id="name-error-message">
                                        @error('name')
                                            {{ $errors->first('name') }}
                                        @enderror
                                    </div>
                                </div>
                                <div class="field">
                                    <label>المدينة</label>
                                    <br />
                                    <select class="js-states" id="city-input" name="city_id" style="width:100%">
                                        <option></option>
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback" id="city-error-message">
                                        @error('city')
                                            {{ $errors->first('city') }}
                                        @enderror
                                    </div>
                                </div>
                                <div class="field">
                                    <label>رقم السجل التجاري</label>
                                    <input type="text" id="register-number-input"
                                        placeholder="الرجاء إدخال رقم السجل التجاري"
                                        class="form-control @error('commercial_register_number') is-invalid @enderror"
                                        name="commercial_register_number">
                                    <div class="wizard-form-error wizard-form-error2"></div>
                                    <div class="invalid-feedback" id="register-number-error-message">
                                        @error('commercial_register_number')
                                            {{ $errors->first('commercial_register_number') }}
                                        @enderror
                                    </div>
                                </div>
                                <div class="field">
                                    <label>رقم الواتس اب</label>
                                    <input type="tel" id="whatsapp-input" name="whatsapp"
                                        placeholder="الرجاء إدخال رقم الواتس اب"
                                        class="form-control @error('whatsapp') is-invalid @enderror">
                                    <div class="wizard-form-error wizard-form-error3"></div>
                                    <div class="invalid-feedback" id="whatsapp-error-message">
                                        @error('whatsapp')
                                            {{ $errors->first('whatsapp') }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">

                                <div class="form-group upload-block">

                                    <div class="upload-images">
                                        <p>رفع شعار الشركة</p>
                                        <div class="form-upload">
                                            <div class="preview preview-user img-wrapper">
                                            </div>
                                            <div class="file-upload-wrapper">
                                                <input type="file" name="image" id="logo-input"
                                                    class="file-upload-native  @error('logo') is-invalid @enderror"
                                                    accept="image/*">
                                                <input type="text" id="upimage" disabled="" placeholder=""
                                                    class="file-upload-text">
                                                <div class="wizard-form-error"></div>
                                            </div>
                                            <div class="invalid-feedback" id="logo-error-message">
                                                @error('image')
                                                    {{ $errors->first('image') }}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="field">
                                    <label>نبذه عن الشركة</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" rows="5" id="description-input"
                                        name="description" placeholder="الرجاء كتابة نبذة عن الشركة"></textarea>
                                    <div class="wizard-form-error wizard-form-error4"></div>
                                    <div class="invalid-feedback" id="description-error-message">
                                        @error('description')
                                            {{ $errors->first('description') }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="price">
                            <h2 class="title">الإشتركات</h2>
                            <ul>
                                @foreach ($packages as $package)
                                    <li>
                                        <input type="radio" name="package" value="{{ $package->id }}"
                                            id="package-{{ $loop->iteration }}">
                                        <label for="package-{{ $loop->iteration }}">
                                            {{ $package->title }}
                                            <p>
                                                <span>{{ $package->price }}</span>
                                                رس
                                            </p>
                                        </label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="invalid-feedback" id="package-error-message">
                            @error('package')
                                {{ $errors->first('package') }}
                            @enderror
                        </div>

                    </div>
                </div>
                <input type="hidden" id="lat" name="lat" value="24.774265" />
                <input type="hidden" id="long" name="long" value="46.738586" />

                <div class="row" style="height:400px;width:50%;margin-top:5%;">
                    <input id="pac-input" class="controls" style="width:50%" type="text" placeholder="Search Box" />
                    <div id="map" style="height:100%"></div>
                </div>
                <button class="btn btn-primary ">الاشتراك</button>
            </form>
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
                logo: false,
                whatsapp: false,
                description: false,
                package: false
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

            if (!logoInput.value.length) {
                logoInput.classList.add('is-invalid');
                logoErrorMessage.innerHTML = "يجب اختيار الشعار";
                logoErrorMessage.classList.add('d-block');
                errorStatuses.logo = true;
            } else {
                logoInput.classList.remove('is-invalid');
                logoErrorMessage.classList.remove('d-block');
                logoErrorMessage.innerHTML = "";
                errorStatuses.logo = false;
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
            if (document.querySelector('[name=package]:checked') == null) {
                errorStatuses.package = true;
                packageErrorMessage.innerHTML = "يجب اختيار الباقة";
                packageErrorMessage.classList.add('d-block');
            } else {
                packageErrorMessage.classList.remove('d-block');
                packageErrorMessage.innerHTML = "";
                errorStatuses.package = false;
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

            currentForm.action = "{{ route('front.subscription.store') }}";
            currentForm.submit();
        }
    </script>
@endpush
