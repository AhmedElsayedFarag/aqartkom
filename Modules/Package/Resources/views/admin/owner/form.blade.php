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

                @foreach ($attributes as $attribute)
                    <div class="input-form">
                        @if ($attribute['type'] == 'normal_ads')
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
                                {{ $attribute['title'] }}
                            </label>
                            <input id="validation-form-1" type="number" name="{{ $attribute['type'] }}"
                                class="form-control mb-3 @isset($features['unlimited_normal_ads']) hidden @endisset"
                                placeholder="" min="1"
                                value="{{ $features[$attribute['type']]['value']['count'] ?? old($attribute['type'], 1) }}"
                                required>
                            <input type="checkbox" value="1" class="form-control w-5 ml-5" id="unlimited_ads"
                                placeholder="" value="" @isset($features['unlimited_normal_ads']) checked @endisset>عدد
                            الاعلانات غير محدود
                            @isset($features['unlimited_normal_ads'])
                                <input type="hidden" name="unlimited_ads" value="1">
                            @endisset
                            <input type="hidden" name="unlimited_ads" value="0">
                        @else
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
                                {{ $attribute['title'] }}
                            </label>
                            <input id="validation-form-1" type="number" name="{{ $attribute['type'] }}"
                                class="form-control mb-3" placeholder="" min="1"
                                value="{{ $features[$attribute['type']]['value']['count'] ?? old($attribute['type']) }}"
                                required>
                        @endif

                        @error($attribute['type'])
                            <div class="pristine-error text-danger mt-2">{{ $errors->first($attribute['type']) }}</div>
                        @enderror
                    </div>
                    @if ($attribute['type'] == 'ad_feature')
                        <div class="input-form">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
                                {{ __('features.ad_feature_ads_count') }}
                            </label>
                            <input id="validation-form-1" type="number" name="ad_feature_ads_count"
                                class="form-control" placeholder="" min="1"
                                value="{{ $features['ad_feature']['value']['days'] ?? old('ad_feature_ads_count') }}"
                                max="365" required>
                            @error('ad_feature_ads_count')
                                <div class="pristine-error text-danger mt-2">{{ $errors->first('ad_feature_ads_count') }}
                                </div>
                            @enderror
                        </div>
                    @endif
                @endforeach
                @push('scriptsStack')
                    <script>
                        document.querySelector('#unlimited_ads').onchange = function() {
                            if (this.checked) {
                                document.querySelector('input[name="normal_ads"]').value = 1;
                                document.querySelector('input[name="unlimited_ads"]').value = 1;

                                document.querySelector('input[name="normal_ads"]').classList.add('hidden');
                            } else {
                                document.querySelector('input[name="unlimited_ads"]').value = 0;
                                document.querySelector('input[name="normal_ads"]').classList.remove('hidden');
                            }
                        }
                    </script>
                @endpush
