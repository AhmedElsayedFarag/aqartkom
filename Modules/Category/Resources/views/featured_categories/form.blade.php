                <div class="input-form">
                    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
                        {{ __('validation.attributes.title') }}
                        {{-- <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, at least 3 characters</span> --}}
                    </label>
                    <input id="validation-form-1" type="text" name="title" class="form-control" placeholder="رياض"
                        minlength="3" maxlength="120" value="{{ $category->title ?? old('title') }}" required>
                    @error('title')
                        <div class="pristine-error text-danger mt-2">{{ $errors->first('title') }}</div>
                    @enderror
                </div>
                <div class="mt-3">
                    <label for="crud-form-2" class="form-label">{{ __('admin.category') }}</label>
                    <select data-placeholder="" name="category_id" class="tom-select w-full" id="crud-form-2">
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}"
                                @isset($category)
                                    {{ $category->category_id == $cat->id ? 'selected' : '' }}
                                @endisset>
                                {{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mt-3">
                    <label for="crud-form-2" class="form-label">{{ __('admin.city') }}</label>
                    <select data-placeholder="" name="city_id" class="tom-select w-full" id="crud-form-2">
                        @foreach ($cities as $city)
                            <option value="{{ $city->id }}"
                                @isset($category)
                                    {{ $category->city_id == $city->id ? 'selected' : '' }}
                                @endisset>
                                {{ $city->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mt-3">
                    <label for="crud-form-2" class="form-label">{{ __('admin.ad_type.main') }}</label>
                    <select data-placeholder="" name="type" class="tom-select w-full" id="crud-form-2">
                        <option value="sell"
                            @isset($category)
                                    {{ $category->type == 'sell' ? 'selected' : '' }}
                                @endisset>
                            {{ __('admin.ad_type.sell') }}
                        </option>
                        <option value="rent"
                            @isset($category)
                                    {{ $category->type == 'rent' ? 'selected' : '' }}
                                @endisset>
                            {{ __('admin.ad_type.rent') }}
                        </option>
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-2 permissions mt-4">
                    <div class="w-50">
                        @if (isset($category))
                            <div class="row">
                                <img src="{{ asset($category->background) }}" class="mb-3"
                                    style="width:200px;height:200px;" id="back_preview" />
                            </div>
                        @else
                            <div class="row">
                                <img src="#" class="mb-3" style="width:200px;height:200px;"
                                    id="back_preview" />
                            </div>
                        @endif

                        <div class="form-group row">
                            <label for="background"
                                class="col-md-2 col-form-label">{{ __('validation.attributes.background') }}</label>
                            <div class="col-md-10">
                                <input class="form-control @error('background') is-invalid @enderror" type="file"
                                    accept="image/*" id="back_input" name="background" required>
                                @error('background')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                @push('scriptsStack')
                    <script>
                        let backImg = document.getElementById('back_preview');
                        let backInp = document.getElementById('back_input');
                        backInp.onchange = evt => {
                            console.log(evt);
                            const [file] = backInp.files
                            if (file) {
                                backImg.src = URL.createObjectURL(file)
                            }
                        }
                    </script>
                @endpush
