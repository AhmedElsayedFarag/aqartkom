@extends('admin.layout.main')

@section('content')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium ml-auto">
            {{ __('admin.update', ['attribute' => __('admin.package')]) }}
        </h2>
    </div>

    <div class="grid grid-cols-12 gap-6 mt-5">

        <div class="intro-y col-span-12 lg:col-span-6">
            <!-- BEGIN: Validation Form -->
            <form id="admin-form" action="{{ route('dashboard.owner-package.update', ['package' => $package->id]) }}"
                method="POST">
                @method('PUT')
                @csrf
                @include('package::admin.owner.form')
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
