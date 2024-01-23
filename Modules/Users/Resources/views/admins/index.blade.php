@extends('admin.layout.main')

@section('content')
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{ route('dashboard.admin.create') }}"
                class="btn btn-primary shadow-md mr-2">{{ __('admin.add', ['attribute' => '']) }}</a>
            <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                <div class="w-56 relative text-slate-500">
                    <input id="search" type="text" class="form-control w-56 box pr-10" value="{{ request()->search }}"
                        placeholder="{{ __('admin.search') }}">
                    <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-feather="search"></i>
                </div>
            </div>
        </div>
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto ">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="text-center whitespace-nowrap">{{ __('validation.attributes.image') }}</th>
                        <th class="text-center whitespace-nowrap">{{ __('validation.attributes.name') }}</th>
                        <th class="text-center whitespace-nowrap">{{ __('validation.attributes.email') }}</th>
                        <th class="text-center whitespace-nowrap">{{ __('validation.attributes.phone') }}</th>
                        <th class="text-center whitespace-nowrap">{{ __('admin.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach ($admins as $admin)
                        <tr class="intro-x">
                            <td class="w-20">
                                <div class="flex">
                                    <div class="w-10 h-10 image-fit zoom-in">
                                        <img alt="logo" class="tooltip rounded-full"
                                            src="{{ asset('dist/images/preview-7.jpg') }}"
                                            title="Uploaded at 13 August 2021">
                                    </div>
                                </div>
                            </td>
                            <td class="w-40">
                                <a href="" class="font-medium whitespace-nowrap">{{ $admin->name }}</a>
                                <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">Admin</div>
                            </td>
                            <td class="w-40">
                                <div class="flex items-center justify-center">
                                    {{ $admin->email }}
                                </div>
                            </td>
                            <td class="w-40">
                                <div class="flex items-center justify-center">
                                    {{ $admin->phone }}
                                </div>
                            </td>
                            <td class="table-report__action w-56">
                                <div class="flex justify-center items-center">
                                    <a class="flex items-center mr-3"
                                        href="{{ route('dashboard.admin.edit', $admin->uuid) }}"> <i
                                            data-feather="check-square" class="w-4 h-4 mr-1"></i>
                                        {{ __('admin.update', ['attribute' => '']) }}
                                    </a>
                                    <a class="deleteBtn flex items-center text-danger" href="javascript:;"
                                        data-tw-toggle="modal" data-tw-target="#delete-confirmation-modal"
                                        data-id="{{ $admin->uuid }}">
                                        <i data-feather="trash-2" class="w-4 h-4 mr-1"></i>
                                        {{ __('admin.delete', ['attribute' => '']) }}
                                    </a>
                                    <a class="blockBtn flex items-center @if (!$admin->is_blocked) text-danger @else text-success @endif"
                                        href="javascript:;" data-tw-toggle="modal"
                                        data-tw-target="#block-confirmation-modal" data-id="{{ $admin->uuid }}">
                                        @if (!$admin->is_blocked)
                                            <i data-feather="slash" class="w-4 h-4 mr-1"></i>
                                            {{ __('admin.block', ['attribute' => '']) }}
                                        @else
                                            <i data-feather="check" class="w-4 h-4 mr-1"></i>
                                            {{ __('admin.unblock', ['attribute' => '']) }}
                                        @endif
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
            <div id="block-confirmation-modal" class="modal" tabindex="-1" aria-hidden="true"
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
        </div>
        {{ $admins->links('vendor.pagination.tailwind') }}
    </div>
@endsection

@section('script')
    <script>
        $('#search').on('keyup', function(e) {
            if (e.keyCode === 13) {
                location.href = '?search=' + $('#search').val();
            }
        });

        $(".deleteBtn").on("click", function() {
            var adminId = $(this).data('id');
            $('#deleteForm').attr('action', `/dashboard/admin/${adminId}`);
        });
        $(".blockBtn").on("click", function() {
            var customerID = $(this).data('id');
            $('#blockForm').attr('action', `/dashboard/user/${customerID}/toggle-block`);
        });
    </script>
@endsection
