@extends('admin.layout.main')

@section('content')
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                {{-- <div class="w-56 relative text-slate-500">
                    <input id="search" type="text" class="form-control w-56 box pr-10" value="{{ request()->search }}"
                        placeholder="{{ __('admin.search') }}">
                    <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-feather="search"></i>
                </div> --}}
            </div>
        </div>
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto ">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="text-center whitespace-nowrap">{{ __('admin.auction') }}</th>
                        <th class="text-center whitespace-nowrap">{{ __('validation.attributes.name') }}</th>
                        <th class="text-center whitespace-nowrap">{{ __('validation.attributes.phone') }}</th>
                        <th class="text-center whitespace-nowrap">{{ __('validation.attributes.national_number') }}</th>
                        <th class="text-center whitespace-nowrap">{{ __('admin.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach ($requests as $request)
                        <tr class="intro-x">
                            <td class="w-40">
                                {{ $request->auction->estate->title }}
                            </td>
                            <td class="w-40">
                                {{ $request->name }}
                            </td>
                            <td class="w-40">
                                {{ $request->phone }}
                            </td>
                            <td class="w-40">
                                {{ $request->national_number }}
                            </td>
                            <td class="table-report__action w-56">
                                <div class="flex justify-center items-center">
                                    @include('auction::partials.accept-cancel-buttons')
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @include('auction::partials.accept-cancel-modals')
        </div>
        {{ $requests->links('vendor.pagination.tailwind') }}
    </div>
@endsection

@section('script')
    <script>
        $('#search').on('keyup', function(e) {
            if (e.keyCode === 13) {
                location.href = '?search=' + $('#search').val();
            }
        });
    </script>
    @include('auction::partials.accept-cancel-scripts')
@endsection
