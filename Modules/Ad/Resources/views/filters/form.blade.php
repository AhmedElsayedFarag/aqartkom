@foreach ($filters as $key => $filter)
    <div class="intro-y box mt-5">
        <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
            <h2 class="font-medium text-base ml-auto">
                {{ $filter->name }}
            </h2>
        </div>
        <div id="header" class="p-5">
            <div class="preview">
                <select data-placeholder="اكتب القيم" name="values[{{ $key }}][]"
                    class="tom-select values-select w-full" multiple>
                    @foreach ($filter->values as $value)
                        <option value="{{ $value }}" selected>{{ $value }}</option>
                    @endforeach
                </select>
                @error("values.$filter->id.*")
                    <div class="pristine-error text-danger mt-2">{{ $errors->first("values.$filter->id.*") }}</div>
                @enderror
            </div>

        </div>
    </div>
@endforeach
@push('scriptsStack')
    <script>
        $('#tomselect-1-tomselected.dropdown-input').on('input', function(e) {
            $(this).val($(this).val().replace(/[^0-9]/g, ''));
        });
        $('#tomselect-2-tomselected.dropdown-input').on('input', function(e) {
            $(this).val($(this).val().replace(/[^0-9]/g, ''));
        });
    </script>
@endpush
