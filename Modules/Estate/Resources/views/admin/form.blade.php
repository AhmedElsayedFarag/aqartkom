        <div class="form-group row">
            <label for="media" class="col-md-2 col-form-label">{{ __('validation.attributes.media') }}</label>
            <div class="col-md-10">
                <input class="form-control @error('media') is-invalid @enderror" type="file" accept="image/*"
                    id="media_input" name="media[]">
                @error('media')
                    <span class="invalid-feedback" role="alert">
                        {{ $message }}
                    </span>
                @enderror
            </div>
        </div>
