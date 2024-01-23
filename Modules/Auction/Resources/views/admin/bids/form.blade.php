<div class="input-form">
    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
        {{ __('validation.attributes.name') }}
        {{-- <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, at least 3 characters</span> --}}
    </label>
    <input id="validation-form-1" type="text" name="name" class="form-control" placeholder="" min="1"
        value="{{ $bid->name ?? old('name') }}" required>
    @error('name')
        <div class="pristine-error text-danger mt-2">{{ $errors->first('name') }}</div>
    @enderror
</div>
<div class="input-form">
    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
        {{ __('validation.attributes.phone') }}
        {{-- <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, at least 3 characters</span> --}}
    </label>
    <input id="validation-form-1" type="text" name="phone" class="form-control" placeholder=""
        placeholder="52345678" pattern="(5|0|3|6|4|9|1|8|7)([0-9]{7})"
        value="{{ \str_replace('+9665', '', $bid->phone) ?? old('phone') }}" required>
    @error('phone')
        <div class="pristine-error text-danger mt-2">{{ $errors->first('phone') }}</div>
    @enderror
</div>

<div class="input-form">
    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
        {{ __('validation.attributes.national_number') }}
        {{-- <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, at least 3 characters</span> --}}
    </label>
    <input id="validation-form-1" type="text" name="national_number" class="form-control" placeholder=""
        value="{{ $bid->national_number ?? old('national_number') }}" required>
    @error('national_number')
        <div class="pristine-error text-danger mt-2">{{ $errors->first('national_number') }}</div>
    @enderror
</div>

<div class="input-form">
    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
        {{ __('validation.attributes.price') }}
        {{-- <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, at least 3 characters</span> --}}
    </label>
    <input id="validation-form-1" type="number" name="amount" class="form-control" placeholder=""
        value="{{ $bid->amount ?? old('amount') }}" required>
    @error('amount')
        <div class="pristine-error text-danger mt-2">{{ $errors->first('amount') }}</div>
    @enderror
</div>
