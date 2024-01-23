<div class="input-form">
    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
        {{ __('validation.attributes.name') }}
        {{-- <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, at least 3 characters</span> --}}
    </label>
    <input id="validation-form-1" type="text" name="name" class="form-control" placeholder="رياض" minlength="3"
        maxlength="120" value="{{ $category->name ?? old('name') }}" required>
    @error('name')
        <div class="pristine-error text-danger mt-2">{{ $errors->first('name') }}</div>
    @enderror
</div>
<div class="grid grid-cols-3 gap-2 permissions mt-4">
    <div class="w-40">
        <label>{{ __('admin.is_building') }}</label>
        <div class="form-switch mt-2">
            <input type="hidden" name="is_building" value="0" />
            <input type="checkbox" name="is_building" class="form-check-input" value="1"
                @isset($category)
                                     {{ $category->is_building ? 'checked' : '' }}
                                @endisset>
        </div>
    </div>
</div>
<div class="grid grid-cols-3 gap-2 permissions mt-4">
    <div class="w-40">
        <label>{{ __('admin.is_price_per_meter') }}</label>
        <div class="form-switch mt-2">
            <input type="hidden" name="is_price_per_meter" value="0" />
            <input type="checkbox" name="is_price_per_meter" class="form-check-input" value="1"
                @isset($category)
                                     {{ $category->is_price_per_meter ? 'checked' : '' }}
                                @endisset>
        </div>
    </div>
</div>
<div class="grid grid-cols-3 gap-2 permissions mt-4">
    <div class="w-40">
        <label>{{ __('admin.is_bedroom') }}</label>
        <div class="form-switch mt-2">
            <input type="hidden" name="is_bedroom_enable" value="0" />
            <input type="checkbox" name="is_bedroom_enable" class="form-check-input" value="1"
                @isset($category)
                                     {{ $category->is_bedroom_enable ? 'checked' : '' }}
                                @endisset>
        </div>
    </div>
</div>
<div class="grid grid-cols-2 gap-2 permissions mt-4">
    <div class="w-50">
        @if (isset($category))
            <div class="row">
                <img src="{{ asset($category->icon) }}" class="mb-3" style="width:200px;height:200px;"
                    id="icon_preview" />
            </div>
        @else
            <div class="row">
                <img src="" class="mb-3" style="width:200px;height:200px;" id="icon_preview" />
            </div>
        @endif
        <div class="form-group row">
            <label for="icon" class="col-md-2 col-form-label">{{ __('validation.attributes.icon') }}</label>
            <div class="col-md-10">
                <input class="form-control @error('icon') is-invalid @enderror" type="file" accept="image/*"
                    id="icon_input" name="icon">
                @error('icon')
                    <span class="invalid-feedback" role="alert">
                        {{ $message }}
                    </span>
                @enderror
            </div>
        </div>
    </div>
    <div class="w-50">
        @if (isset($category))
            <div class="row">
                <img src="{{ asset($category->background) }}" class="mb-3" style="width:200px;height:200px"
                    id="back_preview" />
            </div>
        @else
            <div class="row">
                <img src="" class="mb-3" style="width:200px;height:200px" id="back_preview" />
            </div>
        @endif
        <div class="form-group row">
            <label for="background"
                class="col-md-2 col-form-label">{{ __('validation.attributes.background') }}</label>
            <div class="col-md-10">
                <input class="form-control @error('background') is-invalid @enderror" type="file" accept="image/*"
                    id="back_input" name="background">
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
        let iconImg = document.getElementById('icon_preview');
        let iconInp = document.getElementById('icon_input');
        let backImg = document.getElementById('back_preview');
        let backInp = document.getElementById('back_input');

        iconInp.onchange = evt => {
            console.log(evt);
            const [file] = iconInp.files
            if (file) {
                iconImg.src = URL.createObjectURL(file)
            }
        }

        backInp.onchange = evt => {
            console.log(evt);
            const [file] = backInp.files
            if (file) {
                backImg.src = URL.createObjectURL(file)
            }
        }
    </script>
@endpush
