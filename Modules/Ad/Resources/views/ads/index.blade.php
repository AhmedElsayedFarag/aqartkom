@extends('admin.layout.main')

@section('content')
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{ route('dashboard.ad.create') }}"
                class="btn btn-primary shadow-md mr-2">{{ __('admin.add', ['attribute' => '']) }}</a>
            <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                <div class="w-56 relative text-slate-500">
                    <input id="search" type="text" class="form-control w-56 box pr-10" value="{{ request()->search }}"
                        placeholder="{{ __('admin.search') }}">
                    <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-feather="search"></i>

                </div>

            </div>
            <div class=" mr-2 ml-2 w-56 pb-6">
                <label for="category-select" class="form-label">{{ __('validation.attributes.category') }}</label>
                <select data-placeholder="اختر" name="category" class="tom-select w-full" id="category">
                    <option value=""></option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" data-check="{{ $category->is_building }}"
                            {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class=" mr-2 ml-2 w-56 pb-6">
                <label for="category-select" class="form-label">{{ __('validation.attributes.city') }}</label>
                <select data-placeholder="اختر" name="city" class="tom-select w-full" id="city">
                    <option value=""></option>
                    @foreach ($cities as $city)
                        <option value="{{ $city->id }}" data-check="{{ $city->is_building }}"
                            {{ request('city') == $city->id ? 'selected' : '' }}>
                            {{ $city->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-56 pb-6">
                <label for="type" class="form-label">{{ __('admin.ad_type.main') }}</label>
                <select data-placeholder="اختر" name="type" class="tom-select w-full" id="type">
                    <option></option>
                    <option value="sell"{{ request('type') == 'sell' ? 'selected' : '' }}>{{ __('admin.ad_type.sell') }}
                    </option>
                    <option value="rent"{{ request('type') == 'rent' ? 'selected' : '' }}>{{ __('admin.ad_type.rent') }}
                    </option>

                </select>
            </div>
            <button onclick="search()" class="btn btn-primary shadow-md mr-2">{{ __('admin.search') }}</button>
            <button onclick="reset()" class="btn btn-danger shadow-md mr-2">{{ __('admin.clear') }}</button>

        </div>
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto ">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="text-center whitespace-nowrap">{{ __('validation.attributes.id') }}</th>
                        <th class="text-center whitespace-nowrap">{{ __('admin.created_at') }}</th>
                        <th class="text-center whitespace-nowrap">{{ __('validation.attributes.title') }}</th>
                        <th class="text-center whitespace-nowrap">{{ __('admin.ad_type.main') }}</th>
                        <th class="text-center whitespace-nowrap">{{ __('admin.city') }}</th>
                        <th class="text-center whitespace-nowrap">{{ __('admin.publisher') }}</th>
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
                                {{ $ad->estate->title }}
                            </td>
                            <td class="w-40">
                                {{ __('admin.ad_type')[$ad->type->value] }}
                            </td>

                            <td class="w-40">
                                {{ $ad->estate->city->name }}
                            </td>
                            <td class="w-40">
                                {{ $ad->owner_name }}
                            </td>

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
            @include('auction::partials.accept-cancel-modals')
        </div>
        {{ $ads->links('vendor.pagination.tailwind') }}
    </div>
@endsection

@section('script')
    <script>
        function reset() {
            $('#search').val(' ');
            $('#city').val(' ');
            $('#category').val(' ');
            $('#type').val(' ');
            location.href = '{{ route('dashboard.ad.index') }}';
        }

        function search() {
            let searchValue = $('#search').val();
            let cityValue = $('#city').val();
            let categoryValue = $('#category').val();
            let typeValue = $('#type').val();
            let queryBuilder = [];
            if (searchValue.length)
                queryBuilder.push(`search=${searchValue}`);
            if (cityValue)
                queryBuilder.push(`city=${cityValue}`);
            if (categoryValue)
                queryBuilder.push(`category=${categoryValue}`);
            if (typeValue)
                queryBuilder.push(`type=${typeValue}`);
            let queryParams = '?';
            for (let index = 0; index < queryBuilder.length; index++) {
                if (index == queryBuilder.length - 1)
                    queryParams += `${queryBuilder[index]}`;
                else
                    queryParams += `${queryBuilder[index]}&`;
            }
            console.log(queryParams);
            location.href = queryParams;
        }
        $('#search').on('keyup', function(e) {
            if (e.keyCode === 13) {
                location.href = '?search=' + $('#search').val();
            }
        });

        $(".deleteBtn").on("click", function() {
            var id = $(this).data('id');
            $('#deleteForm').attr('action', `/dashboard/ad/${id}`);
        });
        $(".terminateBtn").on("click", function() {
            var id = $(this).data('id');
            $('#terminateForm').attr('action', `/dashboard/ad/${id}/terminate`);
        });
        $(".cancelBtn").on("click", function() {
            var id = $(this).data('id');
            $('#cancelForm').attr('action', `/dashboard/ad/${id}/cancel`);
        });
        $(".acceptBtn").on("click", function() {
            var id = $(this).data('id');
            $('#acceptForm').attr('action', `/dashboard/ad/${id}/accept`);
        });
    </script>
@endsection
