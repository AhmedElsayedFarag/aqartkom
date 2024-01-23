@extends('admin.layout.main')

@section('content')
    <div class="grid grid-cols-12 gap-6 mt-5">

        <div class="intro-y col-span-12 lg:col-span-6">
            <!-- BEGIN: Validation Form -->
            <form id="admin-form" action="{{ route('dashboard.ad-filter-age.update') }}" method="POST"
                enctype="multipart/form-data">
                @method('PUT')
                @csrf

                <h2>{{ $filter->name }}</h2> <button type="button" id="addBtn" class="btn btn-primary mt-5">
                    {{ __('admin.add', ['attribute' => '']) }}
                </button>
                <div id="values-container">
                    @foreach (old('values') ?? $filter->values as $key => $value)
                        <div id="value-{{ $key }}" class="values">

                            <div class="input-form">

                                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
                                    {{ __('validation.attributes.name') }}
                                    <a class="deleteBtn flex items-center text-danger mr-auto" href="javascript:;"
                                        data-tw-toggle="modal" data-tw-target="#delete-confirmation-modal"
                                        data-id="{{ $key }}">
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
                                    {{-- <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, at least 3 characters</span> --}}
                                </label>
                                <input id="validation-form-1" type="text" name="values[{{ $key }}][name]"
                                    class="form-control" placeholder="رياض" minlength="3" maxlength="120"
                                    value="{{ $value['name'] }}" required>
                                @error("values.$key.name")
                                    <div class="pristine-error text-danger mt-2">{{ $errors->first("values.$key.name") }}</div>
                                @enderror
                            </div>
                            <div class="input-form">
                                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
                                    {{ __('validation.attributes.min') }}

                                    {{-- <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, at least 3 characters</span> --}}
                                </label>
                                <input name="values[{{ $key }}][values][0]" value="{{ $value['values'][0] }}"
                                    class="form-control" type="number" required />
                                @error("values.$key.values.0")
                                    <div class="pristine-error text-danger mt-2">{{ $errors->first("values.$key.values.0") }}
                                    </div>
                                @enderror
                            </div>
                            <div class="input-form">
                                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
                                    {{ __('validation.attributes.max') }}
                                    {{-- <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, at least 3 characters</span> --}}
                                </label>
                                <input name="values[{{ $key }}][values][1]" value="{{ $value['values'][1] }}"
                                    class="form-control"type="number" required />
                                @error("values.$key.values.1")
                                    <div class="pristine-error text-danger mt-2">{{ $errors->first("values.$key.values.1") }}
                                    </div>
                                @enderror
                            </div>

                            <hr class="mt-4 mb-4 border border-black">
                        </div>
                    @endforeach
                </div>
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
                                    <button type="submit" id="confirmDelete" class="btn btn-danger w-32 confirmDelete"
                                        data-id="">
                                        {{ __('admin.delete', ['attribute' => '']) }}
                                    </button>
                                    {{-- </form> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="input-form">
                    <button class="btn btn-primary mt-5">
                        {{ __('admin.update', ['attribute' => '']) }}
                    </button>
                </div>
        </div>
        </form> <!-- END: Validation Form -->
        <!-- BEGIN: Failed Notification Content -->
        <div id="failed-notification-content" class="toastify-content hidden flex"> <i class="text-danger"
                data-feather="x-circle"></i>
            <div class="ml-4 mr-4">
                <div class="font-medium">{{ __('messages.something_happened') }}</div>
            </div>
        </div> <!-- END: Failed Notification Content -->
    </div>
    </div>
@endsection

@push('scriptsStack')
    <script>
        let container = document.getElementById('values-container');

        $('.deleteBtn').on('click', deleteValue)
        $(".confirmDelete").on("click", function() {
            var id = $(this).data('id');
            // console.log(id);
            document.getElementById(`value-${id}`).remove();
            const el = document.getElementById('delete-confirmation-modal');
            const modal = tailwind.Modal.getOrCreateInstance(el);
            modal.hide();
        });

        function deleteValue() {
            var id = $(this).data('id');
            document.getElementById('confirmDelete').dataset.id = id;
            const el = document.getElementById('delete-confirmation-modal');
            const modal = tailwind.Modal.getOrCreateInstance(el);
            modal.show();
        }
        $('#addBtn').on('click', function() {
            let index = $('.values').length - 1;
            let newValue = document.createElement('div');
            newValue.classList.add('values');
            newValue.id = `value-${index}`;

            newValue.innerHTML = ` <div id="value-${index}" class="values">

                            <div class="input-form">
                                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
                                    {{ __('validation.attributes.name') }}
                                     <a class="deleteBtn flex items-center text-danger mr-auto" href="javascript:;" data-tw-toggle="modal"
                                data-tw-target="#delete-confirmation-modal" data-id="${index}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-trash-2 w-4 h-4 mr-1">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path
                                        d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                    </path>
                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                </svg>
                                {{ __('admin.delete', ['attribute' => '']) }}
                            </a>
                                    {{-- <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, at least 3 characters</span> --}}
                                </label>
                                <input id="validation-form-1" type="text" name="values[${index}][name]"
                                    class="form-control" placeholder="الاسم" minlength="3" maxlength="120"
                                    value="" required>
                            </div>
                            <div class="input-form">
                                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
                                    {{ __('validation.attributes.min') }}

                                    {{-- <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, at least 3 characters</span> --}}
                                </label>
                                <input name="values[${index}][values][0]" value=""
                                    class="form-control" type="number" required />
                            </div>
                            <div class="input-form">
                                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
                                    {{ __('validation.attributes.max') }}
                                    {{-- <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, at least 3 characters</span> --}}
                                </label>
                                <input name="values[${index}][values][1]" value=""
                                    class="form-control"type="number" required />
                            </div>

                            <hr class="mt-4 mb-4 border border-black">
                        </div>`
            container.append(newValue);
            $('.deleteBtn').on('click', deleteValue)
        });
    </script>
@endpush
