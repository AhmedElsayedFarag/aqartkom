@extends('admin.layout.main')

@section('content')
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                <div class="w-56 relative text-slate-500">
                    <input id="search" type="text" class="form-control w-56 box pr-10" value="{{ request()->search }}"
                        placeholder="{{ __('admin.search') }}">
                    <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-feather="search"></i>

                </div>

            </div>
            <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0 mr-2">
                <div class="w-56 relative text-slate-500">
                    {{-- <input id="search" type="text" class="form-control w-56 box pr-10" value="{{ request()->search }}"
                        placeholder="{{ __('admin.search') }}"> --}}
                    <select class="form-control " name="status" id="status_input">
                        <option>{{ __('admin.select', ['attribute' => __('admin.active_status.main')]) }}</option>
                        <option value="1">{{ __('admin.licensed') }}</option>
                        <option value="0">{{ __('admin.not_licensed') }}</option>
                    </select>
                </div>
            </div>
            <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0 mr-2">
                <div class="w-56 relative text-slate-500">
                    {{-- <input id="search" type="text" class="form-control w-56 box pr-10" value="{{ request()->search }}"
                        placeholder="{{ __('admin.search') }}"> --}}
                    <select class="form-control " name="account" id="account_input">
                        <option>{{ __('admin.select', ['attribute' => __('admin.authorize_status')]) }}</option>
                        <option value="1">{{ __('admin.is_authorized') }}</option>
                        <option value="0">{{ __('admin.not_authorized') }}</option>
                    </select>
                </div>
            </div>
            <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0 mr-2">
                <a class=" flex items-center btn btn-primary" href="javascript:;" data-tw-toggle="modal"
                    data-tw-target="#send-message-modal">

                    {{ __('admin.send_message_to_all_customers') }}
                </a>
            </div>
            <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0 mr-2">
                <a class=" flex items-center btn btn-primary" href="{{ route('dashboard.owner.export') }}">

                    {{ __('admin.export') }}
                </a>
            </div>
        </div>
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto ">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="text-center whitespace-nowrap">{{ __('validation.attributes.id') }}</th>
                        <th class="text-center whitespace-nowrap">{{ __('validation.attributes.name') }}</th>
                        <th class="text-center whitespace-nowrap">{{ __('validation.attributes.phone') }}</th>
                        <th class="text-center whitespace-nowrap">{{ __('validation.attributes.email') }}</th>
                        <th class="text-center whitespace-nowrap">{{ __('admin.license_status') }}</th>
                        {{-- <th class="text-center whitespace-nowrap">{{ __('validation.attributes.status') }}</th> --}}
                        <th class="text-center whitespace-nowrap">
                            {{ __('validation.attributes.commercial_register_number') }}</th>
                        <th class="text-center whitespace-nowrap">
                            {{ __('validation.attributes.is_featured') }}</th>
                        <th class="text-center whitespace-nowrap">{{ __('admin.block_status.main') }}</th>
                        <th class="text-center whitespace-nowrap">{{ __('admin.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach ($companies as $index => $company)
                        <tr class="intro-x">
                            <td class="w-40">
                                <a href="{{ route('dashboard.company.show', $company->uuid) }}"
                                    class="font-medium whitespace-nowrap"
                                    style="word-break: break-all;">{{ $index + 1 }}</a>
                            </td>
                            <td class="w-40">
                                <a href="{{ route('dashboard.company.show', $company->uuid) }}"
                                    class="font-medium whitespace-nowrap"
                                    style="word-break: break-all;">{{ $company->name }}</a>
                            </td>
                            <td class="w-40">

                                {{ $company->phone }}
                            </td>
                            <td class="w-40">

                                <div class="flex items-center justify-center">
                                    {{ $company->email }}
                                </div>

                            </td>

                            <td class="w-40">

                                <div class="flex items-center justify-center">
                                    {{ $company->is_authorized == 1 ? __('admin.is_authorized') : __('admin.not_authorized') }}
                                </div>
                            </td>
                            {{-- <td class="w-40"></td> --}}
                            <td class="w-40">
                                <div class="flex items-center justify-center">
                                    {{ $company?->companyProfile?->commercial_register_number }}
                                </div>
                            </td>
                            <td class="w-40">
                                <div class="flex items-center justify-center">
                                    {{ __('admin.featured_status')[$company->is_featured] }}
                                </div>
                            </td>
                            <td class="w-40">
                                <div class="flex items-center justify-center">
                                    {{ __('admin.block_status')[$company->is_blocked] }}
                                </div>
                            </td>
                            <td class="table-report__action w-56">
                                <div class="flex justify-center items-center">
                                    <a class="btn btn-warning "
                                        href="{{ route('dashboard.company.show', $company->uuid) }}?ad-status=not-licensed"
                                        title="{{ __('admin.show', ['attribute' => __('admin.users.company')]) }}">
                                        <i data-feather="eye" class="w-4 h-4 mr-1"></i>
                                    </a>
                                    {{-- <a class="flex items-center mr-3"
                                        href="{{ route('dashboard.owner.edit', $company->uuid) }}"> <i
                                            data-feather="check-square" class="w-4 h-4 mr-1"></i>
                                        {{ __('admin.update', ['attribute' => '']) }}
                                    </a>
                                    <a class="sendMessageBtn flex items-center " href="javascript:;" data-tw-toggle="modal"
                                        data-tw-target="#send-user-message-modal" data-id="{{ $company->uuid }}">
                                        <i data-feather="send" class="w-4 h-4 mr-1"></i>
                                        {{ __('admin.send', ['attribute' => '']) }}
                                    </a>
                                    <a class="deleteBtn flex items-center text-danger" href="javascript:;"
                                        data-tw-toggle="modal" data-tw-target="#delete-confirmation-modal"
                                        data-id="{{ $company->uuid }}">
                                        <i data-feather="trash-2" class="w-4 h-4 mr-1"></i>
                                        {{ __('admin.delete', ['attribute' => '']) }}
                                    </a>
                                    <a class="blockBtn flex items-center @if (!$company->is_blocked) text-danger @else text-success @endif"
                                        href="javascript:;" data-tw-toggle="modal"
                                        data-tw-target="#block-confirmation-modal" data-id="{{ $company->uuid }}">
                                        @if (!$company->is_blocked)
                                            <i data-feather="slash" class="w-4 h-4 mr-1"></i>
                                            {{ __('admin.block', ['attribute' => '']) }}
                                        @else
                                            <i data-feather="check" class="w-4 h-4 mr-1"></i>
                                            {{ __('admin.unblock', ['attribute' => '']) }}
                                        @endif
                                    </a> --}}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div id="delete-confirmation-modal" class="modal" tabindex="-1" aria-hidden="true" style="padding-left: 0px;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body p-0">
                            <div class="p-5 text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round"
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
                                <form id="deleteForm" action="" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" data-tw-dismiss="modal"
                                        class="btn btn-outline-secondary w-24 mr-1">
                                        {{ __('admin.cancel') }}
                                    </button>
                                    <button type="submit" class="btn btn-danger w-32" data-id="">
                                        {{ __('admin.delete', ['attribute' => '']) }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="block-confirmation-modal" class="modal" tabindex="-1" aria-hidden="true"
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
                            </div>
                            <div class="px-5 pb-8 text-center">
                                <form id="blockForm" action="" method="POST">
                                    @csrf
                                    <button type="button" data-tw-dismiss="modal"
                                        class="btn btn-outline-secondary w-24 mr-1">
                                        {{ __('admin.cancel') }}
                                    </button>
                                    <button type="submit" class="btn btn-danger w-32" data-id="">
                                        {{ __('admin.yes') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="send-message-modal" class="modal" tabindex="-1" aria-hidden="true" style="padding-left: 0px;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body p-0">

                            <div class="px-5 pb-8 text-center">
                                <form id="sendForm" action="{{ route('dashboard.company.send-topic') }}"
                                    method="POST">
                                    @csrf
                                    <div class="input-form">
                                        <label for="validation-form-1"
                                            class="form-label w-full flex flex-col sm:flex-row">
                                            {{ __('validation.attributes.title') }}
                                            {{-- <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, at least 3 characters</span> --}}
                                        </label>
                                        <input id="validation-form-1" type="text" name="title" class="form-control"
                                            placeholder="John Legend" minlength="3" maxlength="120"
                                            value="{{ old('title') }}" required>
                                        @error('title')
                                            <div class="pristine-error text-danger mt-2">{{ $errors->first('title') }}</div>
                                        @enderror
                                    </div>
                                    <div class="input-form">
                                        <label for="validation-form-1"
                                            class="form-label w-full flex flex-col sm:flex-row">
                                            {{ __('validation.attributes.description') }}
                                            {{-- <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, at least 3 characters</span> --}}
                                        </label>
                                        <textarea id="validation-form-1" type="text" name="description" class="form-control" placeholder="John Legend"
                                            minlength="3" maxlength="2000" value="{{ old('description') }}" required rows="5"></textarea>
                                        @error('description')
                                            <div class="pristine-error text-danger mt-2">{{ $errors->first('description') }}
                                            </div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary w-24" data-id="">
                                        {{ __('admin.send') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{ $companies->links('vendor.pagination.tailwind') }}
    </div>
@endsection

@section('script')
    <script>
        $('#search').on('keyup', function(e) {
            if (e.keyCode === 13) {
                location.href = '?search=' + $('#search').val();
            }
        });
        $('#status_input').on('change', function() {
            location.href = '?status=' + $('#status_input').val();
        });

        $('#account_input').on('change', function() {
            location.href = '?account=' + $('#account_input').val();
        });
        $(".sendMessageBtn").on("click", function() {
            var customerID = $(this).data('id');
            $('#customer-id-message').val(customerID);
        });
        $(".deleteBtn").on("click", function() {
            var customerID = $(this).data('id');
            $('#deleteForm').attr('action', `/dashboard/owner/${customerID}`);
        });
        $(".blockBtn").on("click", function() {
            var customerID = $(this).data('id');
            $('#blockForm').attr('action', `/dashboard/user/${customerID}/toggle-block`);
        });
    </script>
@endsection
