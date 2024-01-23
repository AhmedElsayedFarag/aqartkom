<div class="input-form">
    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
        {{ __('validation.attributes.question') }}
        {{-- <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, at least 3 characters</span> --}}
    </label>
    <input id="validation-form-1" type="text" name="question" class="form-control" placeholder="رياض" minlength="3"
        maxlength="120" value="{{ $question->question ?? old('question') }}" required>
    @error('question')
        <div class="pristine-error text-danger mt-2">{{ $errors->first('question') }}</div>
    @enderror
</div>
