@extends('admin.layout.main')

@section('content')
    <div class="intro-y col-span-12 overflow-auto ">
        <div class="col-span-12 lg:col-span-8 2xl:col-span-9">
            <!-- BEGIN: Change Password -->
            <div class="intro-y box lg:mt-5">
                <div class="flex items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base ml-auto">
                        {{ __('admin.change_password') }}
                    </h2>
                </div>
                <form action="{{ route('dashboard.change-password.store') }}" method="POST">
                    @csrf
                    <div class="p-5">
                        <div class="w-1/2">
                            <label for="change-password-form-1 "
                                class="form-label">{{ __('validation.attributes.old_password') }}</label>
                            <input id="change-password-form-1" type="password" name="old_password" class="form-control"
                                placeholder="" required>
                            @error('old_password')
                                <div class="pristine-error text-danger mt-2">{{ $errors->first('old_password') }}</div>
                            @enderror
                        </div>
                        <div class="mt-3 w-1/2">
                            <label for="change-password-form-2"
                                class="form-label">{{ __('validation.attributes.new_password') }}</label>
                            <input id="change-password-form-2" type="password" name="password" class="form-control"
                                placeholder="" required>
                            @error('password')
                                <div class="pristine-error text-danger mt-2">{{ $errors->first('password') }}</div>
                            @enderror
                        </div>
                        <div class="mt-3 w-1/2">
                            <label for="change-password-form-3"
                                class="form-label">{{ __('validation.attributes.new_password_confirmation') }}</label>
                            <input id="change-password-form-3" type="password" name="password_confirmation"
                                class="form-control" placeholder="" required>
                            @error('password_confirmation')
                                <div class="pristine-error text-danger mt-2">{{ $errors->first('password_confirmation') }}
                                </div>
                            @enderror
                        </div>
                        <button type="submit"
                            class="btn btn-primary mt-4">{{ __('admin.update', ['attribute' => '']) }}</button>
                    </div>
                </form>
            </div>
            <!-- END: Change Password -->
        </div>
    </div>
@endsection
