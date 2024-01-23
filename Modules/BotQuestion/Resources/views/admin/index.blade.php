@extends('admin.layout.main')

@section('content')
    <div class="grid grid-cols-12 gap-6 mt-5">

        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto ">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="text-center whitespace-nowrap">{{ __('validation.attributes.name') }}</th>
                        <th class="text-center whitespace-nowrap">{{ __('admin.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach ($questions as $question)
                        <tr class="intro-x">

                            <td class="w-40">
                                <a href="" class="font-medium whitespace-nowrap">{{ $question->question }}</a>
                            </td>
                            <td class="table-report__action w-56">
                                <div class="flex justify-center items-center">
                                    <a class="flex items-center mr-3"
                                        href="{{ route('dashboard.bot-question.edit', $question->id) }}">
                                        <i data-feather="check-square" class="w-4 h-4 mr-1"></i>
                                        {{ __('admin.update', ['attribute' => '']) }}
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

    </div>
@endsection
