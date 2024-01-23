                                <div class="input-form">
                                    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
                                        {{ __('validation.attributes.image') }}
                                        {{-- <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, at least 3 characters</span> --}}
                                    </label>
                                    <input id="validation-form-1" type="file" name="profile_image" class="form-control"
                                        accept="image/*">
                                    @error('profile_image')
                                        <div class="pristine-error text-danger mt-2">{{ $errors->first('profile_image') }}
                                        </div>
                                    @enderror
                                    <img src="{{ $user->formatted_profile }}" class="w-1/4 mb-4 mt-4" />
                                </div>
                                <div class="input-form">
                                    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
                                        {{ __('validation.attributes.name') }}
                                        {{-- <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, at least 3 characters</span> --}}
                                    </label>
                                    <input id="validation-form-1" type="text" name="name" class="form-control"
                                        placeholder="John Legend" minlength="3"
                                        value="{{ $user->name ?? old('name') }}" required>
                                    @error('name')
                                        <div class="pristine-error text-danger mt-2">{{ $errors->first('name') }}</div>
                                    @enderror
                                </div>
                                <div class="input-form mt-3">
                                    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
                                        {{ __('validation.attributes.email') }}
                                        {{-- <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, valid email</span> --}}
                                    </label>
                                    <input id="validation-form-1" type="email" name="email" class="form-control"
                                        placeholder="hello@example.com" minlength="3"
                                        value="{{ $user->email ?? old('email') }}" required>
                                    @error('email')
                                        <div class="pristine-error text-danger mt-2">{{ $errors->first('email') }}</div>
                                    @enderror
                                </div>
                                <div class="input-form mt-3">
                                    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
                                        {{ __('validation.attributes.phone') }}
                                        {{-- <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, valid phone number</span> --}}
                                    </label>
                                    <div class="input-group">
                                        <input id="validation-form-1" type="text" name="phone" class="form-control"
                                            placeholder="52345678" pattern="(5|0|3|6|4|9|1|8|7)([0-9]{7})"
                                            aria-describedby="input-group-2"
                                            value="{{ isset($user) ? \str_replace('+9665', '', $user->phone) : old('phone') }}"
                                            required>

                                        <div id="input-group-3" class="input-group-text">9665+</div>
                                        @error('phone')
                                            <div class="pristine-error text-danger mt-2">{{ $errors->first('phone') }}
                                            </div>
                                        @enderror
                                    </div>

                                </div>
