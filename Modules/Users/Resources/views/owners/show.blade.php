@extends('admin.layout.main')

@section('content')
    <div class="intro-y d-flex align-items-center mt-8">
        <h2 class="fs-lg fw-medium me-auto">
            {{ __('admin.show', ['attribute' => $user->name]) }}
        </h2>
    </div>
    <div class="intro-y box px-5 pt-5 mt-5">
        <div class="flex flex-col lg:flex-row border-b border-slate-200/60 dark:border-darkmode-400 pb-5 -mx-5">
            <div class="flex flex-1 px-5 items-center justify-center lg:justify-start">
                <div class="w-20 h-20 sm:w-24 sm:h-24 flex-none lg:w-32 lg:h-32 image-fit relative">
                    <img class="rounded-full" src="{{ $user->formattedProfile }}">
                </div>
                <div class="ml-5">
                    <div class="w-24 sm:w-40 truncate sm:whitespace-normal font-medium text-lg">{{ $user->name }}</div>
                    <div class="text-slate-500">{{ $user->email }}</div>
                    <div class="text-slate-500"># {{ $user->id }}</div>
                </div>
            </div>
            <div
                class="mt-6 lg:mt-0 flex-1 px-5 border-l border-r border-slate-200/60 dark:border-darkmode-400 border-t lg:border-t-0 pt-5 lg:pt-0">
                {{-- <div class="font-medium text-center lg:text-left lg:mt-3">بيانات التواصل</div> --}}
                <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                    <div class="truncate sm:whitespace-normal flex items-center">
                        {{ $user->email }} <i data-feather="mail" class="w-4 h-4 mr-2"></i>
                    </div>
                    <div class="truncate sm:whitespace-normal flex items-center mt-3">
                        {{ $user->phone }} <i data-feather="phone" class="w-4 h-4 mr-2"></i>
                    </div>
                    @if ($user->nationality_id)
                        <div class="truncate sm:whitespace-normal flex items-center mt-3">
                            {{ $user->nationality_id }} <i data-feather="credit-card" class="w-4 h-4 mr-2"></i>
                        </div>
                    @endif

                </div>
            </div>

            <div
                class="mt-6 lg:mt-0 flex-1 px-5 border-l border-r border-slate-200/60 dark:border-darkmode-400 border-t lg:border-t-0 pt-5 lg:pt-0">
                {{-- <div class="font-medium text-center lg:text-left lg:mt-3">بيانات التواصل</div> --}}
                <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                    <div class="truncate sm:whitespace-normal flex items-center">
                        {{ $user->created_at->format('d/m/Y h:i') }} <i data-feather="calendar" class="w-4 h-4 mr-2"></i>
                    </div>
                    <div class="truncate sm:whitespace-normal flex items-center mt-3">
                        {{ $user->is_authorized ? __('admin.is_authorized') : __('admin.not_authorized') }}
                        <i data-feather="{{ $user->is_authorized ? 'user-check' : 'user-x' }}" class="w-4 h-4 mr-2"></i>
                    </div>
                    <div class="truncate sm:whitespace-normal flex items-center mt-3">
                        {{ __('admin.block_status')[$user->is_blocked] }}
                        <i data-feather="{{ $user->is_blocked ? 'user-x' : 'user-check' }}" class="w-4 h-4 mr-2"></i>
                    </div>
                    <div class="truncate sm:whitespace-normal flex items-center mt-3">

                    </div>
                </div>
            </div>
        </div>
        <ul class="nav nav-link-tabs flex-col sm:flex-row justify-center lg:justify-start text-center pb-3 pt-3"
            role="tablist">
            <li class="nav-item" role="presentation">
                <a class="btn btn-primary items-center mr-3" href="{{ route('dashboard.owner.edit', $user->uuid) }}">
                    <i data-feather="check-square" class="w-4 h-4 mr-1"></i>
                    {{ __('admin.update', ['attribute' => '']) }}
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="btn btn-success sendMessageBtn items-center mr-2" style="color : white" href="javascript:;"
                    data-tw-toggle="modal" data-tw-target="#send-user-message-modal" data-id="{{ $user->uuid }}">
                    <i data-feather="send" class="w-4 h-4 mr-1"></i>
                    {{ __('admin.send', ['attribute' => '']) }}
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="deleteBtn btn btn-danger items-center mr-2" href="javascript:;" data-tw-toggle="modal"
                    data-tw-target="#delete-confirmation-modal" data-id="{{ $user->uuid }}">
                    <i data-feather="trash-2" class="w-4 h-4 mr-1"></i>
                    {{ __('admin.delete', ['attribute' => '']) }}
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="blockBtn items-center mr-2 btn @if (!$user->is_blocked) btn-danger @else btn-success @endif"
                    href="javascript:;" data-tw-toggle="modal" data-tw-target="#block-confirmation-modal"
                    data-id="{{ $user->uuid }}">
                    @if (!$user->is_blocked)
                        <i data-feather="slash" class="w-4 h-4 mr-1"></i>
                        {{ __('admin.block', ['attribute' => '']) }}
                    @else
                        <i data-feather="check" class="w-4 h-4 mr-1"></i>
                        {{ __('admin.unblock', ['attribute' => '']) }}
                    @endif
                </a>
            </li>
        </ul>
        <ul class="nav nav-link-tabs flex-col sm:flex-row justify-center lg:justify-start text-center" role="tablist">
            <li class="nav-item" role="presentation">
                <a href="{{ route('dashboard.owner.show', ['user' => $user->uuid]) }}?ad-status=not-licensed"
                    class="nav-link py-4 {{ request()->get('ad-status') == 'not-licensed' ? 'active' : '' }}">
                    {{ __('admin.notLicensedAds') }}
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ route('dashboard.owner.show', ['user' => $user->uuid]) }}?ad-status=licensed"
                    class="nav-link py-4 {{ request()->get('ad-status') == 'licensed' ? 'active' : '' }}">
                    {{ __('admin.licensedAds') }}
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ route('dashboard.owner.show', ['user' => $user->uuid]) }}?ad-status=request"
                    class="nav-link py-4 {{ request()->get('ad-status') == 'request' ? 'active' : '' }}">
                    {{ __('admin.licensingRequest') }} </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ route('dashboard.owner.show', ['user' => $user->uuid]) }}?ad-status=featured"
                    class="nav-link py-4 {{ request()->get('ad-status') == 'featured' ? 'active' : '' }}">
                    {{ __('admin.featuredAds') }} </a>
            </li>

            <li class="nav-item" role="presentation">
                <a href="{{ route('dashboard.owner.show', ['user' => $user->uuid]) }}?status=packages"
                    class="nav-link py-4 {{ request()->get('status') == 'packages' ? 'active' : '' }}">
                    {{ __('admin.packages') }} </a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ route('dashboard.owner.show', ['user' => $user->uuid]) }}?status=payments"
                    class="nav-link py-4 {{ request()->get('status') == 'payments' ? 'active' : '' }}">
                    {{ __('admin.payments') }} </a>
            </li>
        </ul>
    </div>
    <div class="intro-y box px-5 pt-5 mt-5">
        @if (request()->has('ad-status'))
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="text-center whitespace-nowrap">{{ __('validation.attributes.id') }}</th>
                        <th class="text-center whitespace-nowrap">{{ __('admin.created_at') }}</th>
                        <th class="text-center whitespace-nowrap">{{ __('validation.attributes.title') }}</th>
                        <th class="text-center whitespace-nowrap">{{ __('admin.ad_type.main') }}</th>
                        @if (request()->get('ad-status') == 'not-licensed')
                            <th class="text-center whitespace-nowrap">{{ __('admin.city') }}</th>
                            <th class="text-center whitespace-nowrap">{{ __('admin.publisher') }}</th>
                        @endif
                        <th class="text-center whitespace-nowrap">{{ __('admin.isLicensed') }}</th>
                        {{-- <th class="text-center whitespace-nowrap">{{ __('admin.status') }}</th> --}}
                        <th class="text-center whitespace-nowrap">{{ __('admin.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach ($ads as $index => $ad)
                        <tr class="intro-x">

                            <td class="w-40">
                                {{ $index + 1 }}
                            </td>
                            <td class="w-40">
                                {{ $ad->accepted_at->format('d-m-Y h:i') }}
                            </td>
                            <td class="w-40">
                                {{ request()->get('ad-status') == 'not-licensed' ? $ad->estate->address : $ad->estate->title }}
                            </td>
                            <td class="w-40">
                                {{ __('admin.ad_type')[$ad->type->value] }}
                            </td>
                            @if (request()->get('ad-status') == 'not-licensed')
                                <td class="w-40">
                                    {{ $ad->estate->city->name }}
                                </td>
                                <td class="w-40">
                                    {{ $ad->owner_name }}
                                </td>
                            @endif
                            <td class="w-40">
                                {{ $ad->is_licensed == 1 ? __('admin.licensed') : __('admin.not_licensed') }}
                            </td>
                            {{-- <td class="w-40">
                                {{ __('admin.approved_statuses')[$ad->status->value] }}
                            </td> --}}
                            <td class="table-report__action w-56">
                                <div class="flex justify-start items-center">
                                    <a class="btn btn-warning items-center mr-3"
                                        title="{{ __('admin.show', ['attribute' => $ad->title]) }}"
                                        href="{{ route('dashboard.ad.show', $ad->uuid) }}"> <i data-feather="eye"
                                            class="w-4 h-4 mr-1"></i>

                                    </a>
                                    <a class="btn btn-primary items-center mr-3"
                                        href="{{ route('dashboard.ad.edit', $ad->uuid) }}"
                                        title="{{ __('admin.update', ['attribute' => '']) }}">
                                        <i data-feather="check-square" class="w-4 h-4 mr-1"></i>
                                    </a>
                                    @if ($ad->is_licensed == 0)
                                        <a class="btn btn-success items-center mr-3"
                                            href="{{ route('dashboard.ad.verify', $ad->uuid) }}"
                                            title="{{ __('admin.isLicensed', ['attribute' => '']) }}">
                                            <i data-feather="lock" class="w-4 h-4 mr-1"></i>
                                        </a>
                                    @endif
                                    {{-- <a class="btn btn-warning items-center mr-3"
                                    href="{{ route('dashboard.admin.show', $ad->uuid) }}"
                                    title="{{ __('admin.show', ['attribute' => '']) }}">
                                    <i data-feather="eye" class="w-4 h-4 mr-1"></i>
                                </a> --}}
                                    {{-- accept and decline --}}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @include('auction::partials.accept-cancel-modals')
            {{ $ads->links('vendor.pagination.tailwind') }}
        @elseif (request()->has('status') && request()->status == 'packages')
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="text-center whitespace-nowrap">{{ __('validation.attributes.id') }}</th>
                        <th class="text-center whitespace-nowrap">{{ __('validation.attributes.title') }}</th>
                        <th class="text-center whitespace-nowrap">{{ __('admin.filters.prices') }}</th>
                        <th class="text-center whitespace-nowrap">{{ __('admin.start_date') }}</th>
                        <th class="text-center whitespace-nowrap">{{ __('admin.end_date') }}</th>
                        <th class="text-center whitespace-nowrap">{{ __('admin.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @if ($subscription)
                        <tr class="intro-x">

                            <td class="w-40">
                                {{ $subscription->id }}
                            </td>
                            <td class="w-40">
                                {{ $subscription->package_name }}
                            </td>
                            <td class="w-40">
                                {{ $subscription->package->price }}
                            </td>
                            <td class="w-40">
                                {{ \Carbon\Carbon::parse($subscription->start_at)->format('d/m/Y h:i') }}
                            </td>
                            <td class="w-40">
                                {{ \Carbon\Carbon::parse($subscription->start_at)->format('d/m/Y h:i') }}
                            </td>
                            <td class="table-report__action w-56">
                                <div class="flex justify-start items-center">


                                    <a class="btn btn-warning items-center mr-3"
                                        href="{{ route('dashboard.owner-package.index') }}"
                                        title="{{ __('admin.show', ['attribute' => '']) }}">
                                        <i data-feather="eye" class="w-4 h-4 mr-1"></i>
                                    </a>
                                    {{-- accept and decline --}}
                                </div>
                            </td>
                        </tr>
                    @endif

                </tbody>
            </table>
        @elseif (request()->has('status') && request()->status == 'payments')
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="text-center whitespace-nowrap">{{ __('validation.attributes.id') }}</th>
                        <th class="text-center whitespace-nowrap">{{ __('admin.transaction_no') }}</th>
                        <th class="text-center whitespace-nowrap">{{ __('validation.attributes.date') }}</th>
                        <th class="text-center whitespace-nowrap">تفاصيل الطلب</th>
                        <th class="text-center whitespace-nowrap">{{ __('validation.attributes.coupon.amount') }}</th>
                        <th class="text-center whitespace-nowrap">{{ __('admin.discount_type.amount') }}</th>
                        <th class="text-center whitespace-nowrap">{{ __('validation.attributes.vat') }}</th>
                        <th class="text-center whitespace-nowrap">{{ __('admin.total') }}</th>
                        <th class="text-center whitespace-nowrap">{{ __('admin.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach ($transactions as $index => $transaction)
                        <tr class="intro-x">

                            <td class="w-40">
                                {{ $index + 1 }}
                            </td>
                            <td class="w-40">
                                {{ $transaction->transaction_id }}
                            </td>
                            <td class="w-40">
                                {{ $transaction->created_at->format('d/m/Y h:i') }}
                            </td>
                            <td class="w-40">
                                {{ $transaction->service_type }}
                            </td>
                            <td class="w-40">
                                {{ number_format($transaction->amount, 2) }}
                            </td>
                            <td class="w-40">
                                {{ $transaction->coupon_discount }}
                            </td>
                            <td class="w-40">
                                {{ $transaction->vat }}
                            </td>
                            <td class="w-40">
                                {{ $transaction->subtotal_after_discount }}
                            </td>
                            <td class="table-report__action w-56">
                                <div class="flex justify-start items-center">

                                    {{-- <a class="btn btn-primary items-center mr-3"
                                        href="{{ route('dashboard.ad.edit', $ad->uuid) }}"
                                        title="{{ __('admin.update', ['attribute' => '']) }}">
                                        <i data-feather="check-square" class="w-4 h-4 mr-1"></i>
                                    </a> --}}
                                    {{-- <a class="btn btn-warning items-center mr-3"
                                    href="{{ route('dashboard.admin.show', $ad->uuid) }}"
                                    title="{{ __('admin.show', ['attribute' => '']) }}">
                                    <i data-feather="eye" class="w-4 h-4 mr-1"></i>
                                </a> --}}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $transactions->links('vendor.pagination.tailwind') }}
        @endif

    </div>

    <div class="intro-y col-span-12 overflow-auto ">
        <div id="delete-confirmation-modal" class="modal" tabindex="-1" aria-hidden="true"
            style="padding-left: 0px;">
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
        <div id="block-confirmation-modal" class="modal" tabindex="-1" aria-hidden="true" style="padding-left: 0px;">
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
                            <form id="sendForm" action="{{ route('dashboard.owner.send-topic') }}" method="POST">
                                @csrf
                                <div class="input-form">
                                    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
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
                                    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
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
        <div id="send-user-message-modal" class="modal" tabindex="-1" aria-hidden="true" style="padding-left: 0px;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body p-0">

                        <div class="px-5 pb-8 text-center">
                            <form id="sendForm" action="{{ route('dashboard.send-message') }}" method="POST">
                                @csrf
                                <div class="input-form">
                                    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
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
                                <input type="hidden" name="user_id" value="" id="customer-id-message">
                                <div class="input-form">
                                    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
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
@endsection

@section('script')
    <script>
        $('#search').on('keyup', function(e) {
            if (e.keyCode === 13) {
                location.href = '?search=' + $('#search').val();
            }
        });
        $(".sendMessageBtn").on("click", function() {
            var customerID = $(this).data('id');
            $('#customer-id-message').val(customerID);
        });
        $(".deleteBtn").on("click", function() {
            var customerID = $(this).data('id');
            $('#deleteForm').attr('action', `/dashboard/customer/${customerID}`);
        });
        $(".blockBtn").on("click", function() {
            var customerID = $(this).data('id');
            $('#blockForm').attr('action', `/dashboard/user/${customerID}/toggle-block`);
        });
    </script>
@endsection
