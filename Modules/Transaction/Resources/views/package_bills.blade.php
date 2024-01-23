@extends('admin.layout.main')
@push('stylesStack')
    <link rel="stylesheet" href="{{ asset('front-end/css/flatpicker.min.css') }}" />
@endpush

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
                <label for="status-select" class="form-label">{{ __('validation.attributes.status') }}</label>
                <select data-placeholder="اختر" name="status" class="w-full" id="status">
                    <option value="">الكل</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected=selected' : '' }}>
                        {{ __('admin.payment_statuses.pending') }}</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected=selected' : '' }}>
                        {{ __('admin.payment_statuses.approved') }}</option>
                    <option value="canceled" {{ request('status') == 'canceled' ? 'selected=selected' : '' }}>
                        {{ __('admin.payment_statuses.canceled') }}</option>
                </select>
            </div>
            <div class="w-56 relative text-slate-500">
                <input id="date" type="text" class="form-control w-56 box pr-10" value="{{ request()->date }}" />

            </div>

            <button onclick="search()" class="btn btn-primary shadow-md mr-2">{{ __('admin.search') }}</button>
            <button onclick="reset()" class="btn btn-danger shadow-md mr-2">{{ __('admin.clear') }}</button>
            <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0 mr-2">
                <a class=" flex items-center btn btn-primary"
                   href="{{ route('dashboard.transaction.export-excel', \request()->all()) }}">

                    {{ __('admin.export') }}
                </a>
            </div>
            {{--  --}}
        </div>
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto ">
            <table class="table table-report -mt-2">
                <thead>
                <tr>

                    <th class="text-center whitespace-nowrap">{{ __('validation.attributes.transaction_id') }}</th>
                    <th class="text-center whitespace-nowrap">{{ __('validation.attributes.date') }}</th>
                    <th class="text-center whitespace-nowrap">{{ __('validation.attributes.username') }}</th>
                    <th class="text-center whitespace-nowrap">{{ __('validation.attributes.payment_method') }}</th>
                    <th class="text-center whitespace-nowrap">{{ __('validation.attributes.payment_status') }}</th>
                    <th class="text-center whitespace-nowrap">{{ __('validation.attributes.account_type') }}</th>
                    <th class="text-center whitespace-nowrap">{{ __('validation.attributes.total_amount') }}</th>
                    <th class="text-center whitespace-nowrap">{{ __('validation.attributes.order_summery') }}</th>
                </tr>
                </thead>
                <tbody class="text-center">
                @foreach ($transactions as $transaction)
                    <tr class="intro-x">
                        <td class="w-40">
                            <a href=""
                               class="font-medium whitespace-nowrap">{{ $transaction->transaction_id }}</a>
                        </td>
                        <td class="w-40">
                            <a href=""
                               class="font-medium whitespace-nowrap">{{ $transaction->created_at->format('Y-m-d') }}</a>
                        </td>
                        <td class="w-40">
                            <a href=""
                               class="font-medium whitespace-nowrap">{{ $transaction->customer_name }}</a>
                        </td>
                        <td class="w-40">
                            <a href=""
                               class="font-medium whitespace-nowrap">{{ $transaction->getPaymentType()['name']??'' }}</a>
                        </td>
                        <td class="w-40">
                            <a href=""
                               class="font-medium whitespace-nowrap">{{ __('admin.payment_statuses')[$transaction->status] }}</a>
                        </td>
                        <td class="w-40">
                            <a href="" class="font-medium whitespace-nowrap">
                                {{ __('admin.service_types')[$transaction->service_type->value] }}
                            </a>
                        </td>
                        <td class="w-40">
                            <a href="" class="font-medium whitespace-nowrap">{{ $transaction->amount }}</a>
                        </td>
                        <td class="w-40">
                            <a href="" class="font-medium whitespace-nowrap">
                                <a class="flex items-center mr-3"
                                   href="{{ route('dashboard.package_bills.show', $transaction->id) }}">
                                    <i data-feather="file-text" class="w-4 h-4 mr-1"></i>
                                    {{ __('admin.attributes') }}
                                </a>
                                <a class="flex items-center mr-3"
                                   href="{{ route('dashboard.package_bills.edit', $transaction->id) }}">
                                    <i data-feather="check-square" class="w-4 h-4 mr-1"></i>
                                    {{ __('admin.update', ['attribute' => '']) }}
                                </a>
                            </a>
                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
        {{ $transactions->appends(request()->input())->links('vendor.pagination.tailwind') }}
    </div>
@endsection

@section('script')
    <script>
        $('#search').on('keyup', function(e) {
            if (e.keyCode === 13) {
                location.href = '?search=' + $('#search').val();
            }
        });

        function reset() {
            $('#search').val(' ');
            $('#status').val(' ');
            $('#date').val(' ');

            location.href = '{{ route('dashboard.transaction.index') }}';
        }

        function search() {
            let searchValue = $('#search').val();
            let statusValue = $('#status').val();
            let dateValue = $('#date').val();
            let queryBuilder = [];
            if (searchValue.length)
                queryBuilder.push(`search=${searchValue}`);
            if (statusValue)
                queryBuilder.push(`status=${statusValue}`);
            if (dateValue)
                queryBuilder.push(`date=${dateValue}`);
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
    </script>
    <script src="{{ asset('front-end/js/flatpicker.js') }}"></script>
    <script>
        flatpickr('#date', {
            mode: "range",
            dateFormat: 'Y-m-d',
        })
    </script>
@endsection
