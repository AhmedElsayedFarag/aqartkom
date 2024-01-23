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
            <div class=" mr-2 ml-2 w-56 pb-6">
                <label for="area-select" class="form-label">{{ __('validation.attributes.area') }}</label>
                <select data-placeholder="اختر" name="area" class="tom-select w-full" id="area">
                    <option value=""></option>
                    @foreach (__('mortgage.area') as $key => $value)
                        <option value="{{ $key }}" {{ request('area') == $key ? 'selected' : '' }}>
                            {{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div class=" mr-2 ml-2 w-56 pb-6">
                <label for="group-select" class="form-label">{{ __('validation.attributes.group') }}</label>
                <select data-placeholder="اختر" name="group" class="tom-select w-full" id="group">
                    <option value=""></option>
                    @foreach (__('mortgage.group') as $key => $value)
                        <option value="{{ $key }}" {{ request('group') == $key ? 'selected' : '' }}>
                            {{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-56 pb-6">
                <label for="bank" class="form-label">{{ __('validation.attributes.bank') }}</label>
                <select data-placeholder="اختر" name="bank" class="tom-select w-full" id="bank">
                    <option></option>
                    @foreach (__('mortgage.bank') as $key => $value)
                        <option value="{{ $key }}" {{ request('bank') == $key ? 'selected' : '' }}>
                            {{ $value }}</option>
                    @endforeach

                </select>
            </div>
            <button onclick="search()" class="btn btn-primary shadow-md mr-2">{{ __('admin.search') }}</button>
            <button onclick="reset()" class="btn btn-danger shadow-md mr-2">{{ __('admin.clear') }}</button>
            <a href="{{ route('dashboard.mortgage.export', request()->query->all()) }}"
                class="btn btn-primary shadow-md mr-2">{{ __('admin.export') }}</a>
        </div>
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto ">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="text-center whitespace-nowrap">{{ __('validation.attributes.name') }}</th>
                        <th class="text-center whitespace-nowrap">{{ __('validation.attributes.phone') }}</th>
                        <th class="text-center whitespace-nowrap">{{ __('validation.attributes.email') }}</th>
                        <th class="text-center whitespace-nowrap">{{ __('validation.attributes.gender') }}</th>
                        <th class="text-center whitespace-nowrap">{{ __('validation.attributes.age') }}</th>
                        <th class="text-center whitespace-nowrap">{{ __('validation.attributes.bank') }}</th>
                        <th class="text-center whitespace-nowrap">{{ __('validation.attributes.group') }}</th>
                        <th class="text-center whitespace-nowrap">{{ __('validation.attributes.salary') }}</th>
                        <th class="text-center whitespace-nowrap">{{ __('validation.attributes.area') }}</th>
                        <th class="text-center whitespace-nowrap">{{ __('validation.attributes.nationality') }}</th>
                        <th class="text-center whitespace-nowrap">{{ __('admin.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach ($records as $record)
                        <tr class="intro-x">

                            <td class="w-40">
                                {{ $record->name }}
                            </td>
                            <td class="w-40">
                                {{ $record->phone }}
                            </td>
                            <td class="w-40">
                                {{ $record->email }}
                            </td>
                            <td class="w-40">
                                {{ $record->gender == 'male' ? 'ذكر' : 'أنثى' }}
                            </td>
                            <td class="w-40">
                                {{ __('mortgage.age')[$record->age] }}
                            </td>
                            <td class="w-40">
                                {{ __('mortgage.bank')[$record->bank] }}
                            </td>
                            <td class="w-40">
                                {{ __('mortgage.group')[$record->group] }}
                            </td>
                            <td class="w-40">
                                {{ __('mortgage.salary')[$record->salary] }}
                            </td>
                            <td class="w-40">
                                {{ __('mortgage.area')[$record->area] }}
                            </td>
                            <td class="w-40">
                                {{ $record->nationality }}
                            </td>

                            <td class="table-report__action w-56">
                                <div class="flex justify-start items-center">
                                    <a class="deleteBtn flex items-center text-danger mr-3" href="javascript:;"
                                        data-tw-toggle="modal" data-tw-target="#delete-confirmation-modal"
                                        data-id="{{ $record->id }}"
                                        title="{{ __('admin.delete', ['attribute' => '']) }}">
                                        <i data-feather="trash-2" class="w-4 h-4 mr-1"></i>
                                    </a>
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
        </div>
        {{ $records->links('vendor.pagination.tailwind') }}
    </div>
@endsection

@section('script')
    <script>
        function reset() {
            $('#search').val(' ');
            $('#bank').val(' ');
            $('#group').val(' ');
            $('#area').val(' ');
            location.href = '{{ route('dashboard.mortgage.index') }}';
        }

        function search() {
            let searchValue = $('#search').val();
            let cityValue = $('#bank').val();
            let categoryValue = $('#group').val();
            let typeValue = $('#area').val();
            let queryBuilder = [];
            if (searchValue.length)
                queryBuilder.push(`search=${searchValue}`);
            if (cityValue)
                queryBuilder.push(`bank=${cityValue}`);
            if (categoryValue)
                queryBuilder.push(`group=${categoryValue}`);
            if (typeValue)
                queryBuilder.push(`area=${typeValue}`);
            let queryParams = '?';
            for (let index = 0; index < queryBuilder.length; index++) {
                if (index == queryBuilder.length - 1)
                    queryParams += `${queryBuilder[index]}`;
                else
                    queryParams += `${queryBuilder[index]}&`;
            }

            location.href = queryParams;
        }
        $('#search').on('keyup', function(e) {
            if (e.keyCode === 13) {
                location.href = '?search=' + $('#search').val();
            }
        });

        $(".deleteBtn").on("click", function() {
            var id = $(this).data('id');
            $('#deleteForm').attr('action', `/dashboard/mortgage/${id}`);
        });
    </script>
@endsection
