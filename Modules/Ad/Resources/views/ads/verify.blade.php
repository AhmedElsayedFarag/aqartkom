@extends('admin.layout.main')

@section('content')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium ml-auto">
            {{ __('admin.isLicensed', ['attribute' => '']) }}
        </h2>
    </div>

    <div class="grid grid-cols-12 gap-6 mt-5">

        <div class="intro-y col-span-12 lg:col-span-6">
            @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif
            <form id="admin-form" action="{{ route('dashboard.ad.verifyAd', ['ad' => $model->uuid]) }}" method="POST">
                @method('PUT')
                @csrf
                <div class="input-form mt-3">
                    <label for="validation-form-100" class="form-label w-full flex flex-col sm:flex-row">
                        {{ __('admin.licenceNumber') }}
                        {{-- <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, at least 3 characters</span> --}}
                    </label>
                    <input id="validation-form-100" type="text" name="licenceNumber" class="form-control" placeholder=""
                        value="{{ old('licenceNumber') }}">
                    @error('licenceNumber')
                        <div class="pristine-error text-danger mt-2">{{ $errors->first('licenceNumber') }}</div>
                    @enderror
                </div>
                <div class="input-form mt-3">
                    <label for="validation-form-101" class="form-label w-full flex flex-col sm:flex-row">
                        {{ __('validation.attributes.national_number') }}
                        {{-- <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, at least 3 characters</span> --}}
                    </label>
                    <input id="validation-form-101" type="text" name="advertiserId" class="form-control" placeholder=""
                        value="{{ old('advertiserId') }}">
                    @error('advertiserId')
                        <div class="pristine-error text-danger mt-2">{{ $errors->first('advertiserId') }}</div>
                    @enderror
                </div>
                <div class="input-form mt-3">
                    <label for="validation-form-101" class="form-label w-full flex flex-col sm:flex-row">
                        {{ __('validation.attributes.advertiser_relation') }}
                        {{-- <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, at least 3 characters</span> --}}
                    </label>
                    <select name="idType" id="idType" class="form-control" required>
                        <option value="1">{{ __('admin.users.marketer') }}</option>
                        <option value="2">{{ __('admin.users.company') }}</option>
                    </select>
                    @error('idType')
                        <div class="pristine-error text-danger mt-2">{{ $errors->first('idType') }}</div>
                    @enderror
                </div>
                <div class="input-form">
                    <button class="btn btn-primary mt-5">
                        {{ __('admin.verify_from_takamolat', ['attribute' => '']) }}
                    </button>
                </div>
            </form> <!-- END: Validation Form -->
        </div>

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
