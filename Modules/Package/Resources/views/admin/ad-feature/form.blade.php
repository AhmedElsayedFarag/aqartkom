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
                        {{ __('validation.attributes.days') }}
                        {{-- <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, at least 3 characters</span> --}}
                    </label>
                    <input id="validation-form-1" type="number" name="days" class="form-control" placeholder=""
                        min="1" max="365" value="{{ $package->days ?? old('days') }}" required>
                    @error('days')
                        <div class="pristine-error text-danger mt-2">{{ $errors->first('days') }}</div>
                    @enderror
                </div>

                <div class="input-form">
                    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
                        {{ __('validation.attributes.type') }}
                        {{-- <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, at least 3 characters</span> --}}
                    </label>
                    <select name="type" class="form-control" required>
                        <option value="">اختر</option>
                        <option value="owner" {{ ($package->type ?? old('type')) == 'owner' ? 'selected' : '' }}>
                            {{ __('admin.users.owner') }}</option>
                        <option value="marketer"
                            {{ ($package->type ?? old('type')) == 'marketer' ? 'selected' : '' }}>
                            {{ __('admin.users.marketer') }}</option>
                        <option value="company" {{ ($package->type ?? old('type')) == 'company' ? 'selected' : '' }}>
                            {{ __('admin.users.company') }}</option>
                    </select>
                    @error('type')
                        <div class="pristine-error text-danger mt-2">{{ $errors->first('type') }}</div>
                    @enderror
                </div>
