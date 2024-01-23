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
        </div>
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto ">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="text-center whitespace-nowrap">{{ __('validation.attributes.phone') }}</th>
                        <th class="text-center whitespace-nowrap">{{ __('validation.attributes.otp') }}</th>
                        <th class="text-center whitespace-nowrap"></th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach ($otps as $otp)
                        <tr class="intro-x">
                            <td class="w-40">
                                <div class="flex items-center justify-center">
                                    {{ $otp->phone }}
                                </div>
                            </td>

                            <td class="w-40">
                                <div class="flex items-center justify-center">
                                    {{ $otp->otp }}
                                </div>
                            </td>
                            <td class="w-40">
                                <div class="flex items-center justify-center">
                                    {{ $otp->expire_at }}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $otps->links('vendor.pagination.tailwind') }}
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
@endsection
