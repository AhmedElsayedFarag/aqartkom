@extends('admin.layout.main')

@section('content')
    <div class="grid grid-cols-12 gap-6 mt-5">
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto ">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="text-center whitespace-nowrap">{{ __('validation.attributes.name') }}</th>
                        <th class="text-center whitespace-nowrap">{{ __('sidebar.settings') }}</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <form action="{{ route('dashboard.seo.update') }}" class="w-100" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        {{--  --}}
                        @foreach ($seoSettings as $setting)
                            <tr class="intro-x">
                                <td class="w-40">
                                    {{ $setting->key }}
                                </td>
                                <td class="w-40">

                                    @if ($setting->type == 'image')
                                        <input id="validation-form-1" type="file" name="{{ $setting->key }}"
                                            class="form-control" placeholder="" accept="image/*">
                                        <img src="{{ $setting->value }}" width="100" height=100 />
                                    @else
                                        <input id="validation-form-1" type="text" name="{{ $setting->key }}"
                                            class="form-control" placeholder="" required value="{{ $setting->value }}">
                                    @endif
                                    @error($setting->key)
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </td>
                            </tr>
                        @endforeach
                        <tr class="intro-x">
                            <td colspan="2"><button class="btn btn-primary">
                                    {{ __('admin.update', ['attribute' => '']) }}
                                </button></td>
                        </tr>

                    </form>
                </tbody>
            </table>

        </div>
    </div>
@endsection
