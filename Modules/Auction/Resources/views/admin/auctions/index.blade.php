@extends('admin.layout.main')

@section('content')
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{ route('dashboard.auction.create') }}"
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
                        <th class="text-center whitespace-nowrap">{{ __('validation.attributes.title') }}</th>
                        <th class="text-center whitespace-nowrap">{{ __('validation.attributes.initial_price') }}</th>
                        <th class="text-center whitespace-nowrap">{{ __('validation.attributes.top_price') }}</th>
                        <th class="text-center whitespace-nowrap">{{ __('validation.attributes.end_at') }}</th>
                        <th class="text-center whitespace-nowrap">{{ __('admin.status') }}</th>
                        <th class="text-center whitespace-nowrap">{{ __('admin.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach ($auctions as $auction)
                        <tr class="intro-x">

                            <td class="w-40">
                                <a href="" class="font-medium whitespace-nowrap">{{ $auction->estate->title }}</a>
                            </td>
                            <td class="w-40">
                                <a href="" class="font-medium whitespace-nowrap">{{ $auction->initial_price }}</a>
                            </td>
                            <td class="w-40">
                                <a href="" class="font-medium whitespace-nowrap">{{ $auction->top_price }}</a>
                            </td>
                            <td class="w-40">
                                <a href="" class="font-medium whitespace-nowrap">{{ $auction->end_at }}</a>
                            </td>
                            <td class="w-40">
                                <a href="" class="font-medium whitespace-nowrap">{{ $auction->status }}</a>
                            </td>
                            <td class="table-report__action w-56">
                                <div class="flex justify-start items-center">

                                    <a class="flex items-center mr-3"
                                        href="{{ route('dashboard.bid.index', ['auction' => $auction->uuid]) }}">
                                        <i data-feather="check-square" class="w-4 h-4 mr-1"></i>
                                        {{ __('admin.bids') }}
                                    </a>
                                    <a class="flex items-center mr-3"
                                        href="{{ route('dashboard.media.index', $auction->estate->id) }}">
                                        <i data-feather="film" class="w-4 h-4 mr-1"></i>
                                        {{ __('validation.attributes.media') }}
                                    </a>
                                    <a class="flex items-center mr-3"
                                        href="{{ route('dashboard.auction.edit', $auction->uuid) }}">
                                        <i data-feather="check-square" class="w-4 h-4 mr-1"></i>
                                        {{ __('admin.update', ['attribute' => '']) }}
                                    </a>
                                    <a class="deleteBtn flex items-center text-danger" href="javascript:;"
                                        data-tw-toggle="modal" data-tw-target="#delete-confirmation-modal"
                                        data-id="{{ $auction->uuid }}">
                                        <i data-feather="trash-2" class="w-4 h-4 mr-1"></i>
                                        {{ __('admin.delete', ['attribute' => '']) }}
                                    </a>
                                    @if (!$auction->is_closed)
                                        <a class="terminateBtn flex items-center text-danger" href="javascript:;"
                                            data-tw-toggle="modal" data-tw-target="#terminate-confirmation-modal"
                                            data-id="{{ $auction->uuid }}">
                                            <i data-feather="x-circle" class="w-4 h-4 mr-1"></i>
                                            {{ __('admin.terminate', ['attribute' => '']) }}
                                        </a>
                                    @endif
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
            <div id="terminate-confirmation-modal" class="modal" tabindex="-1" aria-hidden="true"
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
                                <div class="text-slate-500 mt-2">
                                    <br>
                                    {{ __('messages.unable_to_redo') }}
                                </div>
                            </div>
                            <div class="px-5 pb-8 text-center">
                                <form id="terminateForm" action="" method="POST">
                                    @csrf
                                    <button type="button" data-tw-dismiss="modal"
                                        class="btn btn-outline-secondary w-24 mr-1">
                                        {{ __('admin.cancel') }}
                                    </button>
                                    <button type="submit" class="btn btn-danger w-32" data-id="">
                                        {{ __('admin.terminate', ['attribute' => '']) }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{ $auctions->links('vendor.pagination.tailwind') }}
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
            var id = $(this).data('id');
            $('#deleteForm').attr('action', `/dashboard/auction/${id}`);
        });
        $(".terminateBtn").on("click", function() {
            var id = $(this).data('id');
            $('#terminateForm').attr('action', `/dashboard/auction/${id}/terminate`);
        });
    </script>
@endsection
