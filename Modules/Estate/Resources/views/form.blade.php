<div class="input-form mt-3">
    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
        {{ __('validation.attributes.name') }}
        {{-- <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, at least 3 characters</span> --}}
    </label>
    <input id="validation-form-1" type="text" name="estate[title]" class="form-control" placeholder="" minlength="3"
        maxlength="120" value="{{ isset($model) ? $model->estate->title : old('estate.title') }}" required>
    @error('estate.title')
        <div class="pristine-error text-danger mt-2">{{ $errors->first('estate.title') }}</div>
    @enderror
</div>
<div class="input-form mt-3">
    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
        {{ __('validation.attributes.address') }}
        {{-- <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, at least 3 characters</span> --}}
    </label>
    <input id="validation-form-1" type="text" name="estate[address]" class="form-control" placeholder=""
        minlength="3" maxlength="120" value="{{ isset($model) ? $model->estate->address : old('estate.address') }}"
        required>
    @error('estate.address')
        <div class="pristine-error text-danger mt-2">{{ $errors->first('estate.address') }}</div>
    @enderror
</div>
@if (request()->routeIs('dashboard.ad.*'))
    <div class="input-form mt-3">
        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
            {{ __('validation.attributes.price') }}
            {{-- <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, at least 3 characters</span> --}}
        </label>
        <input id="validation-form-1" type="number" name="price" class="form-control" placeholder="" min="1"
            value="{{ isset($model) ? $model->price : old('price') }}" required>
        @error('price')
            <div class="pristine-error text-danger mt-2">{{ $errors->first('price') }}</div>
        @enderror
    </div>

    <div class="input-form mt-3 mt-3">
        <label for="type" class="form-label">{{ __('admin.ad_type.main') }}</label>
        <select name="type" class="form-control" id="type" required>
            <option value="sell"{{ isset($model) ? ($model->type->value == 'sell' ? 'selected' : '') : '' }}>
                {{ __('admin.ad_type.sell') }}
            </option>
            <option value="rent"{{ isset($model) ? ($model->type->value == 'rent' ? 'selected' : '') : '' }}>
                {{ __('admin.ad_type.rent') }}
            </option>

        </select>
        @error('type')
            <div class="pristine-error text-danger mt-2">{{ $errors->first('type') }}</div>
        @enderror
    </div>
@endif
<div class="input-form mt-3">
    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
        {{ __('validation.attributes.area') }}
        {{-- <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, at least 3 characters</span> --}}
    </label>
    <input id="validation-form-1" type="number" name="estate[area]" class="form-control" placeholder="" min="1"
        value="{{ isset($model) ? $model->estate->area : old('estate.area') }}" required>
    @error('estate.area')
        <div class="pristine-error text-danger mt-2">{{ $errors->first('estate.area') }}</div>
    @enderror
</div>
@if (request()->routeIs('dashboard.auction.create'))
    <div class="input-form mt-3">
        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
            {{ __('validation.attributes.initial_price') }}
            {{-- <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, at least 3 characters</span> --}}
        </label>
        <input id="validation-form-1" type="number" name="initial_price" class="form-control" placeholder=""
            min="1" value="{{ isset($model) ? $model->initial_price : old('initial_price') }}" required>
        @error('initial_price')
            <div class="pristine-error text-danger mt-2">{{ $errors->first('initial_price') }}</div>
        @enderror
    </div>

    <div class="input-form mt-3">
        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
            {{ __('validation.attributes.end_at') }}
            {{-- <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, at least 3 characters</span> --}}
        </label>
        <input id="validation-form-1" type="date" name="end_at" class="form-control" placeholder="" min="1"
            value="{{ isset($model) ? $model->end_at : old('end_at') }}" required>
        @error('end_at')
            <div class="pristine-error text-danger mt-2">{{ $errors->first('end_at') }}</div>
        @enderror
    </div>
@endif
<div class="input-form mt-3">
    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
        {{ __('validation.attributes.description') }}
        {{-- <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, at least 3 characters</span> --}}
    </label>
    <textarea id="update-profile-form-5" name="estate[description]" class="form-control" placeholder="" required>{{ isset($model) ? $model->estate->description : old('estate.description') }}</textarea>
    @error('estate.description')
        <div class="pristine-error text-danger mt-2">{{ $errors->first('estate.description') }}</div>
    @enderror
</div>
@if (request()->routeIs('dashboard.auction.create') || request()->routeIs('dashboard.ad.create'))
    <div class="input-form mt-3">
        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
            {{ __('validation.attributes.media') }}
            {{-- <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, at least 3 characters</span> --}}
        </label>
        <input id="validation-form-1" type="file" name="media[]" class="form-control"
            accept="image/jpg,image/png,image/jpeg,video/mp4,video/ogg,video/mpeg" multiple required>
        @error('media')
            <div class="pristine-error text-danger mt-2">{{ $errors->first('media') }}</div>
        @enderror
        @error('media.*')
            <div class="pristine-error text-danger mt-2">{{ $errors->first('media.*') }}</div>
        @enderror
    </div>
@endif

<div class="mt-3">
    <label for="category-select" class="form-label">{{ __('validation.attributes.category') }}</label>
    <select name="estate[category]" class="form-control" id="category-select">
        @foreach ($categories as $category)
            <option value="{{ $category->id }}" data-check="{{ $category->is_building }}"
                @isset($model){{ $model->estate->category_id == $category->id ? 'selected' : '' }}@endisset>
                {{ $category->name }}</option>
        @endforeach
    </select>
    @error('estate.category')
        <div class="pristine-error text-danger mt-2">{{ $errors->first('estate.category') }}</div>
    @enderror
</div>
<div class="mt-3">
    <label for="city-select" class="form-label">{{ __('validation.attributes.city') }}</label>
    <select data-placeholder="اختر" name="estate[city]" class="form-control" id="city-select">
        <option value=""></option>
        @foreach ($cities as $city)
            <option value="{{ $city->id }}"
                @isset($model){{ $model->estate->city_id == $city->id ? 'selected' : '' }}@endisset>
                {{ $city->name }}</option>
        @endforeach
    </select>
    @error('estate.city')
        <div class="pristine-error text-danger mt-2">{{ $errors->first('estate.city') }}</div>
    @enderror
</div>


<div class="mt-3 hidden" id="neighborhood">

</div>

<div class="mt-3">
    <label for="category-select" class="form-label">{{ __('validation.attributes.advertiser_relation') }}</label>
    <select name="advertiser_relation" class="form-control" id="category-select">
        @foreach (['marketer', 'owner', 'agent'] as $relation)
            <option value="{{ $relation }}"
                @isset($model){{ $model->advertiser_relation == $relation ? 'selected' : '' }}@endisset>
                {{ __('admin.advertiser_relation')[$relation] }}</option>
        @endforeach
    </select>
    @error('advertiser_relation')
        <div class="pristine-error text-danger mt-2">{{ $errors->first('advertiser_relation') }}</div>
    @enderror
</div>
<div class="input-form mt-3">
    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
        {{ __('validation.attributes.instrument_number') }}
        {{-- <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, at least 3 characters</span> --}}
    </label>
    <input id="validation-form-1" type="number" name="instrument_number" class="form-control" placeholder=""
        min="1" value="{{ isset($model) ? $model->instrument_number : old('instrument_number') }}" required>
    @error('instrument_number')
        <div class="pristine-error text-danger mt-2">{{ $errors->first('instrument_number') }}</div>
    @enderror
</div>
<input type="hidden" name="is_building" id="is_building" />
@if (isset($model) && $model->estate->is_building)
    <div class="input-form mt-3 " id="bedroom-input">
        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
            {{ __('validation.attributes.bedroom') }}
            {{-- <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, at least 3 characters</span> --}}
        </label>
        <input id="validation-form-1" type="number" name="estate[bedroom]" class="form-control" placeholder=""
            min="1" value="{{ isset($model) ? $model->estate->bedroom : old('estate.bedroom') }}">
        @error('estate.bedroom')
            <div class="pristine-error text-danger mt-2">{{ $errors->first('estate.bedroom') }}</div>
        @enderror
    </div>
    <div class="grid grid-cols-3 gap-2 permissions mt-4 " id="furniture-input">
        <div class="w-40">
            <label>{{ __('validation.attributes.is_furniture') }}</label>
            <div class="form-switch mt-2">
                <input type="hidden" name="estate[is_furniture]" value="0" />
                <input type="checkbox" name="estate[is_furniture]" class="form-check-input" value="1"
                    @isset($model)
                                        {{ $model->estate->is_furniture ? 'checked' : '' }}
                                    @endisset>
            </div>
        </div>
    </div>
    <div class="input-form mt-3 " id="age-input">
        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
            {{ __('validation.attributes.age') }}
            {{-- <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, at least 3 characters</span> --}}
        </label>
        <input id="validation-form-1" type="number" name="estate[age]" class="form-control" placeholder=""
            min="0" value="{{ isset($model) ? $model->estate->age : old('estate.age') }}">
        @error('estate.age')
            <div class="pristine-error text-danger mt-2">{{ $errors->first('estate.age') }}</div>
        @enderror
    </div>
@else
    <div class="input-form mt-3 hidden" id="bedroom-input">
        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
            {{ __('validation.attributes.bedroom') }}
            {{-- <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, at least 3 characters</span> --}}
        </label>
        <input id="validation-form-1" type="number" name="estate[bedroom]" class="form-control" placeholder=""
            min="1" value="{{ isset($model) ? $model->estate->bedroom : old('estate.bedroom') }}">
        @error('estate.bedroom')
            <div class="pristine-error text-danger mt-2">{{ $errors->first('estate.bedroom') }}</div>
        @enderror
    </div>
    <div class="grid grid-cols-3 gap-2 permissions mt-4 hidden" id="furniture-input">
        <div class="w-40">
            <label>{{ __('validation.attributes.is_furniture') }}</label>
            <div class="form-switch mt-2">
                <input type="hidden" name="estate[is_furniture]" value="0" />
                <input type="checkbox" name="estate[is_furniture]" class="form-check-input" value="1"
                    @isset($model)
                                        {{ $model->estate->is_furniture ? 'checked' : '' }}
                                    @endisset>
            </div>
        </div>
    </div>
    <div class="input-form mt-3 hidden" id="age-input">
        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
            {{ __('validation.attributes.age') }}
            {{-- <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, at least 3 characters</span> --}}
        </label>
        <input id="validation-form-1" type="number" name="estate[age]" class="form-control" placeholder=""
            min="0" value="{{ isset($model) ? $model->estate->age : old('estate.age') }}">
        @error('estate.age')
            <div class="pristine-error text-danger mt-2">{{ $errors->first('estate.age') }}</div>
        @enderror
    </div>
@endif
<div id="details">
    @isset($model)
        @foreach ($model->estate->details as $key => $detail)
            @if ($detail->attribute->type == 'number')
                <div class="input-form mt-3 ">
                    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
                        {{ $detail->attribute->name }}
                    </label>
                    <input type="hidden" name="details[{{ $key }}][attribute]"
                        value="{{ $detail->attribute->id }}" />
                    <input id="validation-form-1" type="number" name="details[{{ $key }}][value]"
                        class="form-control" placeholder="" min="1" value="{{ $detail->value['value'] }}"
                        required>
                </div>
            @endif
            @if ($detail->attribute->type == 'string')
                <div class="input-form mt-3 ">
                    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
                        {{ $detail->attribute->name }}
                    </label>
                    <input type="hidden" name="details[{{ $key }}][attribute]"
                        value="{{ $detail->attribute->id }}" />
                    <input id="validation-form-1" type="text" name="details[{{ $key }}][value]"
                        class="form-control" placeholder="" min="1" value="{{ $detail->value['value'] }}"
                        required>
                </div>
            @endif
            @if ($detail->attribute->type == 'radio' || $detail->attribute->type == 'select')
                <div class="mt-3">
                    <label for="city-select" class="form-label"> {{ $detail->attribute->name }}</label>
                    <input type="hidden" name="details[{{ $key }}][attribute]"
                        value="{{ $detail->attribute->id }}" />
                    <select data-placeholder="اختر" name="details[{{ $key }}][value]" class="form-control">

                        @foreach ($detail->attribute->values as $value)
                            <option value="{{ $value->id }}"
                                {{ $value->id == $detail->estate_attribute_value_id ? 'selected' : '' }}>
                                {{ $value->value }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
        @endforeach
    @endisset
</div>
