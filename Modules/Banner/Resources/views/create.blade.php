@extends('admin.layout.main')

@section('content')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium ml-auto">
            {{ __('admin.add', ['attribute' => '']) }}
        </h2>
    </div>

    <div class="grid grid-cols-12 gap-6 mt-5">

        <div class="intro-y col-span-12 lg:col-span-6">
            <!-- BEGIN: Validation Form -->
            <form id="admin-form" action="{{ route('dashboard.banner.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <label for="ad-select" class="form-label">{{ __('validation.attributes.ad') }}</label>
                    <select data-placeholder="اختر" name="ad_id" class=" w-full ad-select" id="ad-select">
                        <option value=""></option>
                    </select> @error('ad_id')
                        <div class="pristine-error text-danger mt-2">{{ $errors->first('ad_id') }}</div>
                    @enderror
                </div>
                <div class="form-group row">
                    <label for="image" class="col-md-2 col-form-label">{{ __('validation.attributes.image') }}</label>
                    <div class="col-md-10">
                        <input class="form-control @error('image') is-invalid @enderror" type="file" accept="image/*"
                            id="back_input" name="image">
                        @error('image')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="input-form">
                    <button class="btn btn-primary mt-5">
                        {{ __('admin.add', ['attribute' => '']) }}
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
@endsection


@section('script')
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <script>
        console.log('test');
        new TomSelect('#ad-select', {
            valueField: 'id',
            labelField: 'title',
            searchField: 'title',
            // fetch remote dat
            load: function(query, callback) {

                var url = "{{ route('ad.search') }}?search=" + encodeURIComponent(query);
                fetch(url)
                    .then(response => response.json())
                    .then(json => {

                        callback(json);
                    }).catch(() => {
                        callback();
                    });

            },
        });
    </script>
@endsection
