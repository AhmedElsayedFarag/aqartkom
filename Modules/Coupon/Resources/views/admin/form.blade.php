<div class="input-form col-6">
    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
        {{ __('validation.attributes.name') }}
        {{-- <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">, at least 3 characters</span> --}}
    </label>
    <input id="validation-form-1" type="text" name="name" class="form-control" minlength="3" maxlength="120"
        value="{{ $coupon->name ?? old('name') }}">
    @error('name')
        <div class="pristine-error text-danger mt-2">{{ $errors->first('name') }}</div>
    @enderror
</div>
<div class="input-form mt-3 col-6">
    <label for="validation-form-2" class="form-label w-full flex flex-col sm:flex-row">
        {{ __('validation.attributes.coupon.code') }}
        {{-- <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">, at least 3 characters</span> --}}
    </label>
    <input id="validation-form-2" type="text" name="code" class="form-control" minlength="3" maxlength="120"
        value="{{ $coupon->code ?? old('code') }}">
    @error('code')
        <div class="pristine-error text-danger mt-2">{{ $errors->first('code') }}</div>
    @enderror
</div>

<div class="input-form mt-3">
    <label for="validation-form-3" class="form-label w-full flex flex-col sm:flex-row">
        {{ __('validation.attributes.coupon.type') }}
        {{-- <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">, at least 3 characters</span> --}}
    </label>
    <select id="validation-form-3" name="type" class="form-control">
        <option value="percentage" {{ isset($coupon) ? ($coupon->type == 'percentage' ? 'selected' : '') : '' }}>
            {{ __('validation.attributes.coupon.percentage') }}</option>
        <option value="amount"{{ isset($coupon) ? ($coupon->type == 'amount' ? 'selected' : '') : '' }}>
            {{ __('validation.attributes.coupon.amount') }}</option>
    </select>
</div>

<div class="input-form mt-3">
    <label for="validation-form-4" class="form-label w-full flex flex-col sm:flex-row">
        {{ __('validation.attributes.coupon.value') }}
        {{-- <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">, at least 3 characters</span> --}}
    </label>
    <input id="validation-form-4" type="text" name="value" class="form-control"
        value="{{ $coupon->value ?? old('value') }}">
    @error('value')
        <div class="pristine-error text-danger mt-2">{{ $errors->first('value') }}</div>
    @enderror
</div>

<div class="input-form mt-3">
    <label for="validation-form-5" class="form-label w-full flex flex-col sm:flex-row">
        {{ __('validation.attributes.coupon.max_use') }}
        {{-- <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">, at least 3 characters</span> --}}
    </label>
    <input id="validation-form-5" type="text" name="max_use" class="form-control"
        value="{{ $coupon->max_use ?? old('max_use') }}">
    @error('max_use')
        <div class="pristine-error text-danger mt-2">{{ $errors->first('max_use') }}</div>
    @enderror
</div>

<div class="input-form mt-3">
    <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row">
        {{ __('validation.attributes.coupon.start_at') }}
        {{-- <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">, at least 3 characters</span> --}}
    </label>
    <input id="validation-form-6" type="date" name="start_at" class="form-control"
        value="{{ $coupon->start_at ?? old('start_at') }}">
    @error('start_at')
        <div class="pristine-error text-danger mt-2">{{ $errors->first('start_at') }}</div>
    @enderror
</div>

<div class="input-form mt-3">
    <label for="validation-form-7" class="form-label w-full flex flex-col sm:flex-row">
        {{ __('validation.attributes.coupon.expire_at') }}
        {{-- <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">, at least 3 characters</span> --}}
    </label>
    <input id="validation-form-7" type="date" name="expire_at" class="form-control"
        value="{{ $coupon->expire_at ?? old('expire_at') }}">
    @error('expire_at')
        <div class="pristine-error text-danger mt-2">{{ $errors->first('expire_at') }}</div>
    @enderror
</div>

<div class="input-form mt-3">
    <label for="validation-form-7" class="form-label w-full flex flex-col sm:flex-row">
        {{ __('validation.attributes.coupon.usage') }}
        {{-- <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">, at least 3 characters</span> --}}
    </label>
    <select name="usage" class="form-control">
        <option value="0">إختر</option>
        <option value="services" {{ isset($coupon) ? ($coupon->usage == 'services' ? 'selected' : '') : '' }}>
            {{ __('admin.coupon.services') }}</option>
        <option value="packages" {{ isset($coupon) ? ($coupon->usage == 'packages' ? 'selected' : '') : '' }}>
            {{ __('admin.coupon.packages') }}</option>
    </select>
    @error('usage')
        <div class="pristine-error text-danger mt-2">{{ $errors->first('usage') }}</div>
    @enderror
</div>

<div class="input-form mt-3">
    <label for="validation-form-7" class="form-label w-full flex flex-col sm:flex-row">
        {{ __('validation.attributes.coupon.commission') }}
        {{-- <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">, at least 3 characters</span> --}}
    </label>
    <select name="commission" class="form-control">
        <option value="0">إختر</option>
        <option value="fixed" {{ isset($coupon) ? ($coupon->commission == 'fixed' ? 'selected' : '') : '' }}>
            {{ __('admin.coupon.fixed') }}</option>
        <option value="optional" {{ isset($coupon) ? ($coupon->commission == 'optional' ? 'selected' : '') : '' }}>
            {{ __('admin.coupon.optional') }}</option>
    </select>
    @error('commission')
        <div class="pristine-error text-danger mt-2">{{ $errors->first('commission') }}</div>
    @enderror
</div>
@isset($coupon)
    <div class="input-form mt-3">
        <label for="validation-form-7" class="form-label w-full flex flex-col sm:flex-row">
            {{ __('admin.coupon.status') }}
            {{-- <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">, at least 3 characters</span> --}}
        </label>
        <select name="is_active" class="form-control">
            <option value="1" {{ $coupon->is_active == '1' ? 'selected' : '' }}>
                {{ __('admin.subscription_statuses.active') }}</option>
            <option value="0" {{ $coupon->is_active == '0' ? 'selected' : '' }}>
                {{ __('admin.not_licensed') }}</option>
        </select>
    </div>
@endisset
