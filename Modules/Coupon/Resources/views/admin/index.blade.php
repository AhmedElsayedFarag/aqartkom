@extends('admin.layout.main')

@section('content')
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{ route('dashboard.coupon.create') }}"
                class="btn btn-primary shadow-md mr-2">{{ __('admin.coupon.add', ['attribute' => '']) }}</a>
        </div>
        <!-- BEGIN: Data List -->
        <div class="intro-y box col-span-12 overflow-auto ">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="text-center whitespace-nowrap">{{ __('validation.attributes.name') }}</th>
                        <th class="text-center whitespace-nowrap">{{ __('admin.coupon.code') }}</th>
                        <th class="text-center whitespace-nowrap">{{ __('admin.coupon.value') }}</th>
                        <th class="text-center whitespace-nowrap">{{ __('admin.coupon.use') }}</th>
                        <th class="text-center whitespace-nowrap">{{ __('admin.coupon.validity') }}</th>
                        <th class="text-center whitespace-nowrap">{{ __('admin.coupon.commission') }}</th>
                        <th class="text-center whitespace-nowrap">{{ __('admin.coupon.status') }}</th>
                        <th class="text-center whitespace-nowrap">{{ __('admin.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach ($coupons as $coupon)
                        <tr class="intro-x">

                            <td class="w-40">
                                <a href="" class="font-medium whitespace-nowrap">{{ $coupon->name }}</a>
                            </td>
                            <td class="w-40">
                                <a href="" class="font-medium whitespace-nowrap">{{ $coupon->code }}</a>
                            </td>
                            <td class="w-40">
                                <a href="" class="font-medium whitespace-nowrap">{{ $coupon->value }}</a>
                            </td>
                            <td class="w-40">
                                <a href=""
                                    class="font-medium whitespace-nowrap">{{ $coupon->usage == 'packages' ? __('admin.coupon.packages') : __('admin.coupon.services') }}</a>
                            </td>
                            <td class="w-40">
                                <a href="" class="font-medium whitespace-nowrap">
                                    {{ \Carbon\Carbon::createFromFormat('Y-m-d', $coupon->expire_at)->diffInDays(\Carbon\Carbon::createFromFormat('Y-m-d', $coupon->start_at)) }}
                                    يوم
                                </a>
                            </td>
                            <td class="w-40">
                                <a href="" class="font-medium whitespace-nowrap">
                                    {{ $coupon->commission == 'optional' ? __('admin.coupon.optional') : __('admin.coupon.fixed') }}
                                </a>
                            </td>
                            <td class="w-40">
                                <a href=""
                                    class="font-medium whitespace-nowrap">{{ $coupon->is_active ? __('admin.subscription_statuses.active') : __('admin.not_licensed') }}</a>
                            </td>
                            <td class="table-report__action w-56">
                                <div class="flex justify-center items-center">
                                    <a class="btn btn-primary items-center mr-3"
                                        href="{{ route('dashboard.coupon.edit', $coupon->id) }}"
                                        title="{{ __('admin.update', ['attribute' => '']) }}">
                                        <i data-feather="check-square" class="w-4 h-4 mr-1"></i>

                                    </a>
                                    @if ($coupon->is_active)
                                        <a class="deactivateBtn btn btn-warning items-center mr-2" href="javascript:;"
                                            data-tw-toggle="modal" data-tw-target="#deactivate-confirmation-modal"
                                            data-id="{{ $coupon->id }}"
                                            title="{{ __('admin.deactivate', ['attribute' => '']) }}">
                                            <i data-feather="slash" class="w-4 h-4 mr-1"></i>

                                        </a>
                                    @endif

                                    <a class="deleteBtn btn btn-danger items-center  mr-2" href="javascript:;"
                                        data-tw-toggle="modal" data-tw-target="#delete-confirmation-modal"
                                        data-id="{{ $coupon->id }}"
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
            <div id="deactivate-confirmation-modal" class="modal" tabindex="-1" aria-hidden="true"
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
                                <div class="text-3xl mt-5">{{ __('admin.deactivate') }} ؟</div>
                                <div class="text-slate-500 mt-2">
                                    {{ __('messages.unable_to_redo') }}
                                </div>
                            </div>
                            <div class="px-5 pb-8 text-center">
                                <form id="deactivateForm" action="" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="button" data-tw-dismiss="modal"
                                        class="btn btn-outline-secondary w-24 mr-1">
                                        {{ __('admin.cancel') }}
                                    </button>
                                    <button type="submit" class="btn btn-danger w-32" data-id="">
                                        {{ __('admin.deactivate', ['attribute' => '']) }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{ $coupons->links('vendor.pagination.tailwind') }}
    </div>
@endsection

@section('script')
    <script>
        $(".deleteBtn").on("click", function() {
            var id = $(this).data('id');
            $('#deleteForm').attr('action', `/dashboard/coupon/${id}`);
        });
        $(".deactivateBtn").on("click", function() {
            var id = $(this).data('id');
            $('#deactivateForm').attr('action', `/dashboard/coupon/deactivate/${id}`);
        });
    </script>
@endsection
