                <div class="input-form">
                    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
                        {{ __('validation.attributes.name') }}
                        {{-- <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, at least 3 characters</span> --}}
                    </label>
                    <input id="validation-form-1" type="text" name="name" class="form-control" placeholder="رياض"
                        minlength="3" maxlength="120" value="{{ isset($attribute) ? $attribute->name : old('name') }}"
                        required>
                    @error('name')
                        <div class="pristine-error text-danger mt-2">{{ $errors->first('name') }}</div>
                    @enderror
                </div>
                <div class="input-form">
                    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
                        {{ __('validation.attributes.unit') }}
                        {{-- <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, at least 3 characters</span> --}}
                    </label>
                    <input id="validation-form-1" type="text" name="unit" class="form-control" placeholder="رياض"
                        minlength="3" maxlength="120" value="{{ isset($attribute) ? $attribute->unit : old('unit') }}">
                    @error('unit')
                        <div class="pristine-error text-danger mt-2">{{ $errors->first('unit') }}</div>
                    @enderror
                </div>
                <div class="input-form mt-3">
                    <label for="type" class="form-label">{{ __('validation.attributes.type') }}</label>
                    <select data-placeholder="اختر" name="type" class="tom-select w-full" id="type" required>
                        <option></option>
                        <option value="number"
                            {{ isset($attribute) ? ($attribute->type == 'number' ? 'selected' : '') : old('type') == 'number' }}>
                            {{ __('admin.attribute_type.number') }}
                        </option>
                        <option value="string"
                            {{ isset($attribute) ? ($attribute->type == 'string' ? 'selected' : '') : old('type') == 'string' }}>
                            {{ __('admin.attribute_type.string') }}
                        </option>
                        <option value="radio"
                            {{ isset($attribute) ? ($attribute->type == 'radio' ? 'selected' : '') : old('type') == 'radio' }}>
                            {{ __('admin.attribute_type.radio') }}
                        </option>
                        <option value="select"
                            {{ isset($attribute) ? ($attribute->type == 'select' ? 'selected' : '') : old('type') == 'select' }}>
                            {{ __('admin.attribute_type.select') }}
                        </option>
                    </select>
                    @error('type')
                        <div class="pristine-error text-danger mt-2">{{ $errors->first('type') }}</div>
                    @enderror
                </div>
                @if (isset($attribute) && $attribute->type == 'select')
                    <div class="values mt-10" id="values-container">

                        <div class="flex justify-start items-center mb-4">
                            <h1 class="">الخيارات</h1>
                            <button type="button" class="btn btn-primary shadow-md mr-2 add-value"
                                onclick="addValues()">{{ __('admin.add', ['attribute' => '']) }}</button>
                        </div>
                        @foreach ($attribute->values as $value)
                            <div class="attributes mb-2 flex justify-center items-center"
                                id="values-{{ $loop->index }}">
                                <input id="validation-form-1" type="text" name="values[]" class="form-control"
                                    placeholder="" minlength="1" maxlength="120" value="{{ $value->value }}" required>
                                <a class="deleteBtn flex items-center text-danger" href="javascript:;"
                                    data-tw-toggle="modal" data-tw-target="#delete-confirmation-modal"
                                    data-id="{{ $loop->index }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-trash-2 w-4 h-4 mr-1">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path
                                            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                        </path>
                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                    </svg>
                                    {{ __('admin.delete', ['attribute' => '']) }}
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="values mt-10" id="values-container">
                    </div>
                @endif

                @error('values')
                    <div class="pristine-error text-danger mt-2">{{ $errors->first('values') }}</div>
                @enderror
                <div id="delete-confirmation-modal" class="modal" tabindex="-1" aria-hidden="true"
                    style="padding-left: 0px;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body p-0">
                                <div class="p-5 text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-x-circle w-16 h-16 text-danger mx-auto mt-3">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <line x1="15" y1="9" x2="9" y2="15"></line>
                                        <line x1="9" y1="9" x2="15" y2="15"></line>
                                    </svg>
                                    <div class="text-3xl mt-5">{{ __('messages.are_you_sure') }}</div>
                                    <div class="text-slate-500 mt-2">
                                        {{ __('messages.delete_records_modal') }}
                                        <br>
                                        {{ __('messages.unable_to_redo') }}
                                    </div>
                                </div>
                                <div class="px-5 pb-8 text-center">
                                    {{-- <form id="deleteForm" action="" method="POST"> --}}
                                    {{-- @csrf
                                    @method('DELETE') --}}
                                    <button type="button" data-tw-dismiss="modal"
                                        class="btn btn-outline-secondary w-24 mr-1">
                                        {{ __('admin.cancel') }}
                                    </button>
                                    <button type="submit" id="confirmDelete"
                                        class="btn btn-danger w-32 confirmDelete" data-id="">
                                        {{ __('admin.delete', ['attribute' => '']) }}
                                    </button>
                                    {{-- </form> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @push('scriptsStack')
                    <script>
                        let counter = 1;
                        let valuesContainer = document.getElementById('values-container');
                        let selectType = document.getElementById('type');
                        let modal = document.getElementById('delete-confirmation-modal');
                        selectType.onchange = function() {
                            let type = selectType.selectedOptions[0].value
                            if (type == 'select') {
                                counter = 0;
                                valuesContainer.innerHTML = `                    <div class="flex justify-start items-center mb-4">
                        <h1 class="">الخيارات</h1>
                        <button type="button" class="btn btn-primary shadow-md mr-2 add-value"
                            onclick="addValues()">{{ __('admin.add', ['attribute' => '']) }}</button>
                    </div>
                    <div class="attributes mb-2 flex justify-center items-center" id="values-0">
                        <input id="validation-form-1" type="text" name="values[]" class="form-control" placeholder=""
                            minlength="1" maxlength="120" value="" required>
                        <a class="deleteBtn flex items-center text-danger" href="javascript:;" data-tw-toggle="modal"
                            data-tw-target="#delete-confirmation-modal" data-id="0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 w-4 h-4 mr-1"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                            {{ __('admin.delete', ['attribute' => '']) }}
                        </a>
                    </div>`;
                            }
                            $('.deleteBtn').on('click', deleteValue)
                        };
                        $('.deleteBtn').on('click', deleteValue)
                        $(".confirmDelete").on("click", function() {
                            var id = $(this).data('id');
                            document.getElementById(`values-${id}`).remove();
                            const el = document.getElementById('delete-confirmation-modal');
                            const modal = tailwind.Modal.getOrCreateInstance(el);
                            modal.hide();
                            // $('#deleteForm').attr('action', `/dashboard/category/{{ $category->id }}/attribute/${id}`);
                        });

                        function addValues() {
                            let newValue = document.createElement('div');
                            newValue.classList.add('attributes', 'mb-2', 'flex', 'justify-center', 'items-center');
                            newValue.id = `values-${counter}`;
                            newValue.innerHTML = `<input id="validation-form-1" type="text" name="values[]" class="form-control" placeholder=""
                            minlength="1" maxlength="120" value="" required>
                        <a class="deleteBtn flex items-center text-danger" href="javascript:;" data-tw-toggle="modal"
                            data-tw-target="#delete-confirmation-modal" data-id="${counter}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 w-4 h-4 mr-1"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                            {{ __('admin.delete', ['attribute' => '']) }}
                        </a>`
                            valuesContainer.append(newValue);
                            counter++;
                            $('.deleteBtn').on('click', deleteValue)
                        };

                        function deleteValue() {
                            var id = $(this).data('id');
                            document.getElementById('confirmDelete').dataset.id = id;
                            const el = document.getElementById('delete-confirmation-modal');
                            const modal = tailwind.Modal.getOrCreateInstance(el);
                            modal.show();
                        }
                    </script>
                @endpush
