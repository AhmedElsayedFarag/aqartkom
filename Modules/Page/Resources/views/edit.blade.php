@extends('admin.layout.main')

@section('content')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium ml-auto">
            {{ __('admin.update', ['attribute' => __('pages')[$page->slug]]) }}
        </h2>
    </div>

    <div class="grid grid-cols-12 gap-6 mt-5">

        <div class="intro-y col-span-12 lg:col-span-6">
            <!-- BEGIN: Validation Form -->
            <form id="admin-form" action="{{ route('dashboard.page.update', ['page' => $page->slug]) }}" method="POST">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">{{ __('pages')[$page->slug] }}</label>
                            <textarea name="content">
                {{ $page->content }}
             </textarea>

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
        tinymce.init({
            selector: 'textarea',
            // toolbar: 'ltr rtl',
            plugins: 'advlist autolink lists link image charmap preview anchor pagebreak directionality',
            toolbar_mode: 'floating',
        });
    </script>
@endpush

@push('stylesStack')
    <script src="https://cdn.tiny.cloud/1/nod6du7iyuvpdzuxyqgraz11mlwq1i7mxnmw9q2sl60zckod/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
@endpush
