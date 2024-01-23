                <div class="input-form">
                    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
                        {{ __('validation.attributes.name') }}
                        {{-- <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, at least 3 characters</span> --}}
                    </label>
                    <input id="validation-form-1" type="text" name="name" class="form-control"
                        placeholder="John Legend" minlength="3" value="{{ $role->name ?? old('name') }}" required>
                    @error('name')
                        <div class="pristine-error text-danger mt-2">{{ $errors->first('name') }}</div>
                    @enderror
                </div>
                <div class="grid grid-cols-3 gap-2 permissions mt-4">
                    @foreach ($permissions as $permission)
                        <div class="w-40">
                            <label>{{ __('permissions.names')[$permission->name] }}</label>
                            <div class="form-switch mt-2">
                                <input type="checkbox" name="permissions[]" class="form-check-input"
                                    value="{{ $permission->id }}"
                                    @isset($role)
                                        {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}
                                    @endisset>
                            </div>
                        </div>
                    @endforeach
                    @error('permissions')
                        <div class="pristine-error text-danger mt-2">{{ $errors->first('permissions') }}</div>
                    @enderror
                </div>
                {{-- <div class="input-form mt-3">
                    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
                        Password
                        <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, at least 8 characters</span>
                    </label>
                    <input id="validation-form-1" type="text" name="password" class="form-control"
                        placeholder="***********" minlength="8" required value="{{ old('password') ?: 'userPa$$w0rd' }}">
                    @error('password')
                        <div class="pristine-error text-danger mt-2">{{ $errors->first('password') }}</div>
                    @enderror
                </div> --}}
