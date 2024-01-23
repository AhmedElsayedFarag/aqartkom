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
                    <form action="{{ route("dashboard.settings-$type.update") }}" class="w-100" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        @foreach ($settings as $key => $setting)
                            <tr class="intro-x">
                                <td class="w-40">
                                    {{ __('settings')[$key] }}
                                </td>
                                <td class="w-40">
                                    @if ($key == 'auction_document')
                                        <input id="validation-form-1" type="file" name="{{ $key }}"
                                            class="form-control" placeholder="" required accept="application/pdf">
                                        <a href="{{ asset($setting['value']) }}"class="btn btn-primary">الملف</a>
                                    @elseif($key == 'image')
                                        <input id="validation-form-1" type="file" name="{{ $key }}"
                                            class="form-control" placeholder="" accept="image/*">
                                        <img src="{{ asset($setting['value']) }}" width="100" height=100 />
                                    @elseif($key == 'app_popup')
                                        <input id="validation-form-1" type="file" name="{{ $key }}"
                                            class="form-control" placeholder="" accept="image/*">
                                        <img src="{{ asset($setting['value']) }}" width="100" height=100 />
                                    @elseif($type == 'ad-feature')
                                        <input id="validation-form-1" type="number" name="{{ $key }}"
                                            class="form-control" placeholder="" min="0" required
                                            value="{{ $setting['value'] }}">
                                    @elseif($type == 'ad-license')
                                        <input id="validation-form-1" type="number" name="{{ $key }}"
                                            class="form-control" placeholder="" min="0" required
                                            value="{{ $setting['value'] }}">
                                    @elseif($type == 'app_popup_link')
                                        <input id="validation-form-1" type="url" name="{{ $key }}"
                                            class="form-control" placeholder="" value="{{ $setting['value'] }}">
                                    @else
                                        <input id="validation-form-1" type="text" name="{{ $key }}"
                                            class="form-control" placeholder="" minlength="3" maxlength="120" required
                                            value="{{ $setting['value'] }}">
                                    @endif
                                    @error($key)
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
