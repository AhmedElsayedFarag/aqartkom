@extends('front-end.main')
@push('custom-style')
    <style>
        .form-wizard .form-control {
            padding-left: 15px;
        }
    </style>
@endpush
@section('content')
    <section class="wizard-section">
        <div class="container">
            <div class="row no-gutters">
                <div class="col-md-12">
                    <div class="form-wizard">
                        <form action="{{ route('front.ad.update', ['ad' => $ad->uuid]) }}" id="submitForm" method="post"
                            role="form" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-wizard-header">
                                <ul class="list-unstyled form-wizard-steps clearfix">
                                    <li class="active" data-validation="image">
                                        <span>1</span>
                                        <h1>صور العقار</h1>
                                    </li>
                                    <li data-validation="static-details">
                                        <span>2</span>
                                        <h1>تفاصيل العقار</h1>
                                    </li>
                                    <li data-validation="static-details-second">
                                        <span>3</span>
                                        <h1>مواصفات العقار</h1>
                                    </li>
                                    <li data-validation="default">
                                        <span>4</span>
                                        <h1>عنوان العقار</h1>
                                    </li>
                                </ul>
                            </div>
                            <fieldset class="wizard-fieldset show">
                                <div class="aqar-detalis">
                                    <h2>صور العقار</h2>
                                    <div id="form-upload">
                                        <div class="form-group">
                                            <label for="" style="padding-bottom: 20px;">اختار صور عقارك</label>
                                            <input type="file" class="form-control" name="media[]" multiple
                                                id="upload-img" accept="image/*" />
                                        </div>
                                        <div class="img-thumbs" id="img-preview">
                                            @foreach ($ad->estate->media as $media)
                                                @if ($media->type == 'image')
                                                    <div class="wrapper-thumb" data-id="{{ $media->uuid }}">
                                                        <img src="{{ $media->formattedUrl }}" class="img-preview-thumb">
                                                        <span class="remove-btn">x</span>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                        <div class="adding-video">
                                            <h2>إضافة فيديو</h2>
                                            @forelse ($ad->estate->media->where('type','video') as $video)
                                                <video id="video" controls src="{{ $media->formattedUrl }}"></video>
                                            @empty
                                                <input id="video_uploader" class="form-control" type="file"
                                                    accept="video/mp4" name="media[]">
                                                <video id="video" controls></video>
                                            @endforelse

                                        </div>
                                        <div class="invalid-feedback" id="images-error-message">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group clearfix  confim-info"><a href="javascript:;"
                                                onclick="validateImagesCount()" class="form-wizard-next-btn float-right">
                                                استمرار
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="wizard-fieldset">
                                <div class="aqar-detalis static-details">
                                    <h2>تفاصيل العقار</h2>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="first">
                                                <label>العنوان للاعلان</label>
                                                <input id="validation-form-1" type="text" name="estate[title]"
                                                    class="form-control  @error('estate.title') is-invalid @enderror required-field length-field"
                                                    data-title="عنوان للاعلان" data-length-min="3" data-length-max="50"
                                                    placeholder="" minlength="3" maxlength="50"
                                                    value="{{ isset($ad) ? $ad->estate->title : old('estate.title') }}"
                                                    required placeholder="الرجاء كتابة عنوان مختصر للعقار">
                                                <div class="invalid-feedback">
                                                    @error('estate.title')
                                                        {{ $errors->first('estate.title') }}
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="first">
                                                <label>عنوان العقار</label>
                                                <input id="validation-form-1" type="text" name="estate[address]"
                                                    class="form-control  @error('estate.title') is-invalid @enderror required-field length-field"
                                                    data-title="عنوان العقار" data-length-min="3" data-length-max="120"
                                                    placeholder="" minlength="3" maxlength="120"
                                                    value="{{ isset($ad) ? $ad->estate->address : old('estate.address') }}"
                                                    required>
                                                <div class="invalid-feedback">
                                                    @error('estate.address')
                                                        {{ $errors->first('estate.address') }}
                                                    @enderror
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="first" id="price">
                                                @if ($ad->type == 'rent')
                                                    <label>السعر</label>
                                                    <input id="validation-form-1" type="number" name="price"
                                                        class="form-control  @error('price')is-invalid @enderror required-field"
                                                        style="padding-left: 10%;" data-title="السعر" placeholder=""
                                                        min="1" value="{{ isset($ad) ? $ad->price : old('price') }}"
                                                        required>
                                                    <span class="define">ر .س</span>
                                                @else
                                                    <label>سعر المتر</label>
                                                    <input id="validation-form-1" type="number" name="price_of_meters"
                                                        class="form-control  @error('price_of_meters')is-invalid @enderror required-field"
                                                        style="padding-left: 10%;" data-title="سعر المتر" placeholder=""
                                                        min="1"
                                                        value="{{ isset($ad) ? $ad->price_of_meters : old('price_of_meters') }}"
                                                        required>
                                                    <span class="define">ر .س</span>
                                                @endif
                                                <div class="invalid-feedback">
                                                    @error('price')
                                                        {{ $errors->first('price') }}
                                                    @enderror
                                                    @error('price_of_meters')
                                                        {{ $errors->first('price_of_meters') }}
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="first">
                                                <label>نوع الاعلان</label>
                                                <select data-title="نوع الاعلان" data-placeholder="اختر" name="type"
                                                    class="tom-select w-full required-field" id="type" required
                                                    onchange="changePriceType(this.value)" style="width:100%">
                                                    <option></option>
                                                    <option
                                                        value="sell"{{ isset($ad) ? ($ad->type->value == 'sell' ? 'selected' : '') : '' }}>
                                                        {{ __('admin.ad_type.sell') }}
                                                    </option>
                                                    <option
                                                        value="rent"{{ isset($ad) ? ($ad->type->value == 'rent' ? 'selected' : '') : '' }}>
                                                        {{ __('admin.ad_type.rent') }}
                                                    </option>

                                                </select>
                                                <div class="invalid-feedback">
                                                    @error('type')
                                                        {{ $errors->first('type') }}
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="first">
                                                <label>المساحة</label>
                                                <input id="validation-form-1" type="number" name="estate[area]"
                                                    class="form-control required-field" placeholder="" min="1"
                                                    data-title="المساحة" style="padding-left: 10%;"
                                                    value="{{ isset($ad) ? $ad->estate->area : old('estate.area') }}"
                                                    required>
                                                <div class="invalid-feedback">
                                                    @error('estate.area')
                                                        {{ $errors->first('estate.area') }}
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="first">
                                                <label>الوصف</label>
                                                <textarea id="update-profile-form-5" name="estate[description]" class="form-control required-field length-field"
                                                    data-title="الوصف" placeholder="" data-length-min="3" data-length-max="2000" required>{{ isset($ad) ? $ad->estate->description : old('estate.description') }}</textarea>
                                                <div class="invalid-feedback">
                                                    @error('estate.description')
                                                        {{ $errors->first('estate.description') }}
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="first">
                                                <label for="category-select"
                                                    class="form-label">{{ __('validation.attributes.category') }}</label>
                                                <select data-placeholder="اختر" name="estate[category]"
                                                    class="tom-select w-full required-field" data-title="الفئة"
                                                    style="width:100%" id="category-select">
                                                    <option value=""></option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}"
                                                            data-check="{{ $category->is_building }}"
                                                            @isset($ad){{ $ad->estate->category_id == $category->id ? 'selected' : '' }}@endisset>
                                                            {{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    @error('estate.category')
                                                        {{ $errors->first('estate.category') }}
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="first">
                                                <label for="city-select"
                                                    class="form-label">{{ __('validation.attributes.city') }}</label>
                                                <select data-placeholder="اختر" name="estate[city]"
                                                    class="tom-select w-full required-field" id="city-select"
                                                    style="width:100%" data-title="المدينة">
                                                    <option value=""></option>
                                                    @foreach ($cities as $city)
                                                        <option value="{{ $city->id }}"
                                                            @isset($ad){{ $ad->estate->city_id == $city->id ? 'selected' : '' }}@endisset>
                                                            {{ $city->name }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    @error('estate.city')
                                                        {{ $errors->first('estate.city') }}
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="first">
                                                <label for="neighborhood-select"
                                                    class="form-label">{{ __('validation.attributes.neighborhood') }}</label>
                                                <select data-placeholder="اختر" name="estate[neighborhood]"
                                                    class="tom-select w-full required-field" id="neighborhood-select"
                                                    style="width:100%" data-title="واجهة المدينة">
                                                    <option value=""></option>
                                                    @foreach ($neighborhoods as $neighborhood)
                                                        <option value="{{ $neighborhood->id }}"
                                                            @isset($ad){{ $ad->estate->neighborhood_id == $neighborhood->id ? 'selected' : '' }}@endisset>
                                                            {{ $neighborhood->name }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    @error('estate.neighborhood')
                                                        {{ $errors->first('estate.neighborhood') }}
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="first">
                                                <label>رقم الصك</label>
                                                <input id="validation-form-1" type="number" name="instrument_number"
                                                    class="form-control required-field" placeholder="" min="1"
                                                    data-title="رقم الصك" style="padding-left: 12%;"
                                                    value="{{ isset($model) ? $model->instrument_number : old('instrument_number') }}"
                                                    max="10000000000000000000" required>
                                                <div class="invalid-feedback">
                                                    @error('instrument_number')
                                                        {{ $errors->first('instrument_number') }}
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="first">
                                                <label for="advertiser_relation-select" class="form-label">علاقة
                                                    المعلن</label>
                                                <select data-placeholder="اختر" name="advertiser_relation"
                                                    class="tom-select w-full required-field"
                                                    id="advertiser_relation-select" style="width:100%"
                                                    data-title="علاقة المعلن">
                                                    <option value=""></option>
                                                    <option value="owner"
                                                        {{ isset($model) ? ($model->advertiser_relation == 'owner' ? 'selected' : '') : '' }}>
                                                        مالك</option>
                                                    <option value="agent"
                                                        {{ isset($model) ? ($model->advertiser_relation == 'agent' ? 'selected' : '') : '' }}>
                                                        وكيل</option>
                                                    <option value="marketer"
                                                        {{ isset($model) ? ($model->advertiser_relation == 'marketer' ? 'selected' : '') : '' }}>
                                                        مسوق</option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    @error('advertiser_relation')
                                                        {{ $errors->first('advertiser_relation') }}
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <input type="hidden" name="is_building" id="is_building" />
                                    </div>
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="right-account">
                                                <a href="javascript:;" class="form-wizard-previous-btn float-left">
                                                    رجوع
                                                </a>

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group clearfix confim-info">
                                                <a href="javascript:;"
                                                    class="form-wizard-next-btn float-right">استمرار</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="wizard-fieldset">
                                <div class="aqar-detalis">
                                    <h2>موصفات العقار</h2>
                                    <div class="row">
                                        <div class="col-md-6 hidden" id="bedroom-input">
                                            <div class="first">
                                                <label> {{ __('validation.attributes.bedroom') }}</label>
                                                <input id="validation-form-1" type="number" name="estate[bedroom]"
                                                    class="form-control " placeholder="" min="1" max="50"
                                                    data-title=" {{ __('validation.attributes.bedroom') }}"
                                                    value="{{ isset($ad) ? $ad->estate->bedroom : old('estate.bedroom') }}"
                                                    required>
                                                <div class="invalid-feedback">
                                                    @error('estate.bedroom')
                                                        {{ $errors->first('estate.bedroom') }}
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 hidden" id="age-input">
                                            <div class="first">
                                                <label> {{ __('validation.attributes.age') }}</label>
                                                <input id="validation-form-1" type="number" name="estate[age]"
                                                    class="form-control " placeholder="" min="1" max="50"
                                                    data-title=" {{ __('validation.attributes.age') }}"
                                                    value="{{ isset($ad) ? $ad->estate->age : old('estate.age') }}"
                                                    required>
                                                <div class="invalid-feedback">
                                                    @error('estate.age')
                                                        {{ $errors->first('estate.age') }}
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 hidden" id="furniture-input">
                                            <div class="first">
                                                <label> {{ __('validation.attributes.is_furniture') }}</label>
                                                <input type="hidden" name="estate[is_furniture]" value="0" />
                                                <select data-placeholder="اختر"
                                                    data-title="{{ __('validation.attributes.is_furniture') }}"
                                                    name="estate[is_furniture]" style="width: 100%"
                                                    class="tom-select w-full  custom-input">
                                                    <option value="1">مؤثثة</option>
                                                    <option value="0">غير مؤثثة</option>
                                                </select>

                                                <div class="invalid-feedback">
                                                    @error('estate.is_furniture')
                                                        {{ $errors->first('estate.is_furniture') }}
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="details">
                                        @foreach ($ad->estate->details as $key => $detail)
                                            @if ($detail->attribute->type == 'number')
                                                <div class="col-md-6">
                                                    <div class="first">
                                                        <label for="validation-form-1"
                                                            class="form-label w-full flex flex-col sm:flex-row">
                                                            {{ $detail->attribute->name }}
                                                        </label>
                                                        <input type="hidden"
                                                            name="details[{{ $key }}][attribute]"
                                                            value="{{ $detail->attribute->id }}" />
                                                        <input id="validation-form-1" type="number"
                                                            name="details[{{ $key }}][value]"
                                                            class="form-control required-field"
                                                            data-title="{{ $detail->attribute->name }}" placeholder=""
                                                            min="1" max="50" required
                                                            value="{{ $detail->value['value'] }}">
                                                        <div class="invalid-feedback"></div>
                                                    </div>
                                                </div>
                                            @endif
                                            @if ($detail->attribute->type == 'string')
                                                <div class="col-md-6">
                                                    <div class="first">
                                                        <label for="validation-form-1"
                                                            class="form-label w-full flex flex-col sm:flex-row">
                                                            {{ $detail->attribute->name }}
                                                        </label>
                                                        <input type="hidden"
                                                            name="details[{{ $key }}][attribute]"
                                                            value="{{ $detail->attribute->id }}" />
                                                        <input id="validation-form-1" data-length-min="3"
                                                            data-length-max="120"
                                                            data-title="{{ $detail->attribute->name }}" type="text"
                                                            name="details[{{ $key }}][value]"
                                                            class="form-control required-field length-field"
                                                            value="{{ $detail->value['value'] }}" placeholder=""
                                                            required>
                                                        <div class="invalid-feedback"></div>
                                                    </div>
                                                </div>
                                            @endif
                                            @if ($detail->attribute->type == 'radio' || $detail->attribute->type == 'select')
                                                <div class="col-md-6">
                                                    <div class="first">
                                                        <label for="city-select"
                                                            class="form-label">{{ $detail->attribute->name }}</label>
                                                        <input type="hidden"
                                                            name="details[{{ $key }}][attribute]"
                                                            value="{{ $detail->attribute->id }}" />
                                                        <select data-placeholder="اختر"
                                                            name="details[{{ $key }}][value]"
                                                            style="width: 100%"
                                                            class="tom-select w-full required-field custom-input"
                                                            data-title="{{ $detail->attribute->name }}">
                                                            @foreach ($detail->attribute->values as $value)
                                                                <option value="{{ $value->id }}"
                                                                    {{ $value->id == $detail->estate_attribute_value_id ? 'selected' : '' }}>
                                                                    {{ $value->value }}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="invalid-feedback"></div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="right-account">
                                                <a href="javascript:;" class="form-wizard-previous-btn float-left">
                                                    رجوع
                                                </a>

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group clearfix confim-info">
                                                <a href="javascript:;"
                                                    class="form-wizard-next-btn float-right">استمرار</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="wizard-fieldset">
                                <div class="aqar-detalis">
                                    <div class="row">
                                        <div class="col-12">
                                            <input type="hidden" id="lat" name="estate[lat]"
                                                value="{{ $ad->estate->lat }}" />
                                            <input type="hidden" id="long" name="estate[long]"
                                                value="{{ $ad->estate->long }}" />

                                            <div class="row" style="height:400px;margin-top:5%;">
                                                <input id="pac-input" class="controls" style="width:50%" type="text"
                                                    placeholder="Search Box" />
                                                <div id="map" style="height:100%"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="right-account">
                                                <a href="javascript:;" class="form-wizard-previous-btn float-left">
                                                    رجوع
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-6">

                                            <div class="form-group clearfix confim-info">

                                                <a href="javascript:;"
                                                    class="form-wizard-next-btn float-right form-wizard-submit">تعديل
                                                    الإعلان</a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="advertise" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <i class="fa-solid fa-check"></i>
                    <p>تم تعديل إعلانك بنجاح</p>
                </div>

            </div>
        </div>
    </div>
@endsection
@push('custom-script')
    <script src="{{ asset('front-end/js/image-viewer.js') }}"></script>
    <script src="{{ asset('front-end/js/video_previewer.js') }}"></script>
    @include('partials.map-scripts')
    <script>
        $(".custom-input").select2({
            placeholder: "",
        });
        const validateImagesCount = () => {
            let hasError = false;
            let count = imgUpload.files.length + document.querySelectorAll('.wrapper-thumb').length;
            if (count < 2 || count > 10) {
                const errorMessage = document.querySelector('#images-error-message');
                errorMessage.classList.add('d-block');
                errorMessage.innerHTML = "يجب ان يكون عدد الصور بين 2 و 10"
                hasError = true;
            }

            for (const file in imgUpload.files) {
                if (((file.size / 1024) / 1024).toFixed(4) > 15) {
                    const errorMessage = document.querySelector('#images-error-message');
                    errorMessage.classList.add('d-block');
                    errorMessage.innerHTML = "يجب ان يكون حجم الصور اقل من 15 ميجا بايت"
                    hasError = true;
                }
            }

            return hasError;
        };
        const validateStaticDetails = (isSecond = false) => {
            const query = isSecond ? '.static-details-second' : '.static-details'
            const staticDetails = document.querySelectorAll(`${query} .required-field`);
            let hasError = false;

            staticDetails.forEach((detail) => {
                let errorMessage = detail.parentNode.querySelector('.invalid-feedback');
                if (detail.value === '') {
                    errorMessage.classList.add('d-block');
                    errorMessage.innerHTML = `هذا الحقل ${detail.dataset.title} مطلوب`;
                    hasError = true;
                    detail.classList.add('is-invalid');
                } else {
                    errorMessage.classList.remove('d-block');
                    detail.classList.remove('is-invalid');
                }
            });
            const lengthInputs = document.querySelectorAll(`${query} .length-field`);
            lengthInputs.forEach((input) => {
                let min = input.dataset.lengthMin;
                let max = input.dataset.lengthMax;
                let errorMessage = input.parentNode.querySelector('.invalid-feedback');
                if (input.value.length < min || input.value.length > max) {
                    errorMessage.classList.add('d-block');
                    errorMessage.innerHTML =
                        `يجب ان يكون ${input.dataset.title} اكبر من ${min} حروف واقل من ${max} حروف`;
                    hasError = true;
                    input.classList.add('is-invalid');
                } else {
                    errorMessage.classList.remove('d-block');
                    input.classList.remove('is-invalid');
                }
            });
            return hasError;
        };
        const validationMethods = {
            image: validateImagesCount,
            "static-details": validateStaticDetails,
            "static-details-second": validateStaticDetails,
            "default": () => false
        }
        // click on next button
        jQuery(".form-wizard-next-btn").click(function() {
            var parentFieldset = jQuery(this).parents(".wizard-fieldset");
            var currentActiveStep = jQuery(this)
                .parents(".form-wizard")
                .find(".form-wizard-steps .active");
            var next = jQuery(this);
            var nextWizardStep = true;
            parentFieldset.find(".wizard-required").each(function() {
                var thisValue = jQuery(this).val();

                if (thisValue == "") {
                    jQuery(this).siblings(".wizard-form-error").slideDown();
                    nextWizardStep = false;
                } else {
                    jQuery(this).siblings(".wizard-form-error").slideUp();
                }
            });
            nextWizardStep = !validationMethods[currentActiveStep[0].dataset.validation](currentActiveStep[0]
                .dataset.validation == 'static-details-second');

            if (nextWizardStep) {
                next.parents(".wizard-fieldset").removeClass("show", "400");
                currentActiveStep
                    .removeClass("active")
                    .addClass("activated")
                    .next()
                    .addClass("active", "400");
                next.parents(".wizard-fieldset")
                    .next(".wizard-fieldset")
                    .addClass("show", "400");
                jQuery(document)
                    .find(".wizard-fieldset")
                    .each(function() {
                        if (jQuery(this).hasClass("show")) {
                            var formAtrr = jQuery(this).attr("data-tab-content");
                            jQuery(document)
                                .find(".form-wizard-steps .form-wizard-step-item")
                                .each(function() {
                                    if (
                                        jQuery(this).attr("data-attr") == formAtrr
                                    ) {
                                        jQuery(this).addClass("active");
                                        var innerWidth = jQuery(this).innerWidth();
                                        var position = jQuery(this).position();
                                        jQuery(document)
                                            .find(".form-wizard-step-move")
                                            .css({
                                                left: position.left,
                                                width: innerWidth,
                                            });
                                    } else {
                                        jQuery(this).removeClass("active");
                                    }
                                });
                        }
                    });
            }
        });
        //click on previous button
        jQuery(".form-wizard-previous-btn").click(function() {
            var counter = parseInt(jQuery(".wizard-counter").text());
            var prev = jQuery(this);
            var currentActiveStep = jQuery(this)
                .parents(".form-wizard")
                .find(".form-wizard-steps .active");
            prev.parents(".wizard-fieldset").removeClass("show", "400");
            prev.parents(".wizard-fieldset")
                .prev(".wizard-fieldset")
                .addClass("show", "400");
            currentActiveStep
                .removeClass("active")
                .prev()
                .removeClass("activated")
                .addClass("active", "400");
            jQuery(document)
                .find(".wizard-fieldset")
                .each(function() {
                    if (jQuery(this).hasClass("show")) {
                        var formAtrr = jQuery(this).attr("data-tab-content");
                        jQuery(document)
                            .find(".form-wizard-steps .form-wizard-step-item")
                            .each(function() {
                                if (jQuery(this).attr("data-attr") == formAtrr) {
                                    jQuery(this).addClass("active");
                                    var innerWidth = jQuery(this).innerWidth();
                                    var position = jQuery(this).position();
                                    jQuery(document)
                                        .find(".form-wizard-step-move")
                                        .css({
                                            left: position.left,
                                            width: innerWidth,
                                        });
                                } else {
                                    jQuery(this).removeClass("active");
                                }
                            });
                    }
                });
        });
        //click on form submit button
        jQuery(document).on(
            "click",
            ".form-wizard .form-wizard-submit",
            function() {
                document.querySelector('#submitForm').submit();
                // var parentFieldset = jQuery(this).parents(".wizard-fieldset");
                // var currentActiveStep = jQuery(this)
                //     .parents(".form-wizard")
                //     .find(".form-wizard-steps .active");
                // parentFieldset.find(".wizard-required").each(function() {
                //     var thisValue = jQuery(this).val();
                //     if (thisValue == "") {
                //         jQuery(this).siblings(".wizard-form-error").slideDown();
                //     } else {
                //         jQuery(this).siblings(".wizard-form-error").slideUp();
                //     }
                // });
            }
        );
        const citySelect = document.querySelector('#city-select');
        const categorySelect = document.querySelector('#category-select');
        const neighborhoodSelect = document.querySelector('#neighborhood-select');
        let isBuildingInput = document.getElementById('is_building');
        let ageInput = document.getElementById('age-input');
        let bedroomInput = document.getElementById('bedroom-input');
        let furnitureInput = document.getElementById('furniture-input');
        citySelect.onchange = event => {
            let selectedOption = citySelect.selectedOptions[0];
            let cityID = parseInt(selectedOption.value);
            getCityNeighborhoods(cityID);
        }

        function getCategoryAttributes(categoryID) {
            let attributesContainer = document.getElementById('details');
            fetch(`/api/v1/category/${categoryID}/attributes`)
                .then((response) => response.json())
                .then((data) => {
                    let attributes = data.data;
                    let attributeContent = '';
                    attributesContainer.innerHTML = '';
                    attributes.forEach((attribute, index) => {
                        attributeContent = '';
                        if (attribute.type == 'number')
                            attributeContent = generateNumberInput(attribute, index);
                        if (attribute.type == "string")
                            attributeContent = generateStringInput(attribute, index);
                        if (attribute.type == 'radio')
                            attributeContent = generateRadioInput(attribute, index);
                        if (attribute.type == "select")
                            attributeContent = generateSelectInput(attribute, index);
                        attributesContainer.innerHTML += attributeContent;
                        setTimeout(() => {
                            $(".custom-input").select2({
                                placeholder: "",
                            });
                        }, 500);
                    });
                })

        }

        categorySelect.onchange = event => {
            let selectedOption = categorySelect.selectedOptions[0];
            let isBuilding = parseInt(selectedOption.dataset.check);
            let categoryID = parseInt(selectedOption.value);
            isBuildingInput.value = isBuilding;
            getCategoryAttributes(categoryID);
            checkIsBuilding(isBuilding);
            let adType = document.getElementById('type').selectedOptions[0].value;
            changePriceType(adType);
        }

        function checkIsBuilding(isBuilding) {
            if (isBuilding) {
                ageInput.classList.remove('d-none');
                bedroomInput.classList.remove('d-none');
                furnitureInput.classList.remove('d-none');
                ageInput.querySelector('input').classList.add('required-field');
                bedroomInput.querySelector('input').classList.add('required-field');
                furnitureInput.querySelector('input').classList.add('required-field');
            } else {
                ageInput.classList.add('d-none');
                bedroomInput.classList.add('d-none');
                furnitureInput.classList.add('d-none');
                ageInput.querySelector('input').classList.remove('required-field');
                bedroomInput.querySelector('input').classList.remove('required-field');
                furnitureInput.querySelector('input').classList.remove('required-field');
            }
        }

        function getCityNeighborhoods(cityID) {
            fetch(`/api/v1/city/${cityID}/neighborhood`)
                .then((response) => response.json())
                .then((data) => {
                    let attributes = data.data;
                    let options = '<option></option>';
                    attributes.forEach((attribute, index) => {
                        options += `<option value="${attribute.id}">${attribute.name}</option>`;
                    });
                    neighborhoodSelect.innerHTML = options;
                })

        }

        function generateRadioInput(attribute, index) {
            let options = "";
            attribute.values.forEach((value) => {
                options += `<option value="${value.id}">${value.name}</option>`;
            });
            return `<div class="col-md-6">
                <div class="first">
                        <label for="city-select" class="form-label">${attribute.name}</label>
                        <input type="hidden" name="details[${index}][attribute]" value="${attribute.id}" />
                        <select data-placeholder="اختر" data-title="${attribute.name}" name="details[${index}][value]" style="width: 100%"
                            class="tom-select w-full required-field custom-input"> ${options} </select>
                 <div class="invalid-feedback"></div>
                            </div>
                    </div>`;
        }

        function generateStringInput(attribute, index) {

            return `<div class="col-md-6">
                <div class="first">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
                            ${attribute.name}
                        </label>
                        <input type="hidden" name="details[${index}][attribute]" value="${attribute.id}" />
                        <input id="validation-form-1" data-length-min="3" data-length-max="120" data-title="${attribute.name}"
                        type="text" name="details[${index}][value]" class="form-control required-field length-field"
                            placeholder=""  required>
                             <div class="invalid-feedback"></div>
                    </div>
                    </div>
                    `;
        }

        function generateSelectInput(attribute, index) {
            let options = "";
            attribute.values.forEach((value) => {
                options += `<option value="${value.id}">${value.name}</option>`;
            });
            return `<div class="col-md-6">
                 <div class="first">
                        <label for="city-select" class="form-label">${attribute.name}</label>
                        <input type="hidden" name="details[${index}][attribute]" value="${attribute.id}" />
                        <select data-placeholder="اختر" name="details[${index}][value]" style="width: 100%"
                            class="tom-select w-full required-field custom-input" data-title="${attribute.name}"> ${options} </select>
                        <div class="invalid-feedback"></div>
                            </div>
                    </div>`;
        }

        function generateNumberInput(attribute, index) {
            return `<div class="col-md-6">
                 <div class="first">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
                            ${attribute.name}
                        </label>
                        <input type="hidden" name="details[${index}][attribute]" value="${attribute.id}" />
                        <input id="validation-form-1" type="number" name="details[${index}][value]" class="form-control required-field" data-title="${attribute.name}"
                            placeholder="" min="1" max="50" required>
                    <div class="invalid-feedback"></div>
                            </div>
                            </div>
                    `;
        }

        function changePriceType(type) {
            let isPricePerMeter = categorySelect.selectedOptions[0].dataset.isPrice;
            if (type == 'sell' && isPricePerMeter == '1') {
                label.innerText = "سعر المتر";
                input.dataset.title = "سعر المتر";

            } else {
                label.innerText = "السعر";
                input.dataset.title = "السعر";
            }
        }
    </script>
@endpush
