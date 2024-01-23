                <div class="input-form">
                    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
                        {{ __('validation.attributes.title') }}
                        {{-- <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, at least 3 characters</span> --}}
                    </label>
                    <input id="validation-form-1" type="text" name="title" class="form-control" placeholder=""
                        minlength="3" maxlength="120" value="{{ $package->title ?? old('title') }}" required>
                    @error('title')
                        <div class="pristine-error text-danger mt-2">{{ $errors->first('title') }}</div>
                    @enderror
                </div>
                <div class="input-form">
                    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
                        {{ __('validation.attributes.price') }}
                        {{-- <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, at least 3 characters</span> --}}
                    </label>
                    <input id="validation-form-1" type="number" name="price" class="form-control" placeholder=""
                        min="1" value="{{ $package->price ?? old('price') }}" required>
                    @error('price')
                        <div class="pristine-error text-danger mt-2">{{ $errors->first('price') }}</div>
                    @enderror
                </div>
                <div class="input-form">
                    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
                        {{ __('validation.attributes.package_months') }}
                        {{-- <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, at least 3 characters</span> --}}
                    </label>
                    <input id="validation-form-1" type="number" name="months" class="form-control" placeholder=""
                        min="1" max="12" value="{{ $package->months ?? old('months') }}" required>
                    @error('months')
                        <div class="pristine-error text-danger mt-2">{{ $errors->first('months') }}</div>
                    @enderror
                </div>
