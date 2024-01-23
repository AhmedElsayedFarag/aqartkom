@extends('admin.layout.main')

@section('content')
    <div class="grid grid-cols-12 gap-6 mt-5">

        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-6 overflow-auto ">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="text-center whitespace-nowrap">{{ __('validation.attributes.title') }}</th>
                        <th class="text-center whitespace-nowrap">{{ __('admin.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach ($filters as $filter)
                        <tr class="intro-x">

                            <td class="w-40">
                                <a href=""
                                    class="font-medium whitespace-nowrap">{{ __('admin.filters')[$filter->group] }}</a>
                            </td>
                            <td class="table-report__action w-56">
                                <div class="flex justify-start items-center">
                                    @if ($filter->group == 'age')
                                        <a class="flex items-center mr-3"
                                            href="{{ route('dashboard.ad-filter-age.index') }}">
                                            <i data-feather="check-square" class="w-4 h-4 mr-1"></i>
                                            {{ __('admin.update', ['attribute' => '']) }}
                                        </a>
                                    @else
                                        <a class="flex items-center mr-3"
                                            href="{{ route('dashboard.ad-filter.edit', $filter->group) }}">
                                            <i data-feather="check-square" class="w-4 h-4 mr-1"></i>
                                            {{ __('admin.update', ['attribute' => '']) }}
                                        </a>
                                    @endif

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
@endsection
