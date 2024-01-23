@extends('admin.layout.main')

@section('content')
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{ route('dashboard.attribute.create', ['category' => $category->id]) }}"
                class="btn btn-primary shadow-md mr-2">{{ __('admin.add', ['attribute' => '']) }}</a>
        </div>
        <!-- BEGIN: Data List -->

        <div class="intro-y col-span-12 overflow-auto ">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="text-center whitespace-nowrap">{{ __('validation.attributes.name') }}</th>
                        <th class="text-center whitespace-nowrap">{{ __('validation.attributes.attribute_type') }}</th>
                        <th class="text-center whitespace-nowrap">{{ __('admin.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <form action="{{ route('dashboard.attribute.store', ['category' => $category->id]) }}" class="w-100"
                        method="POST">
                        @csrf
                        @foreach ($attributes as $attribute)
                            <tr class="intro-x">

                                <td class="w-40">
                                    {{ $attribute->name }}
                                </td>
                                <td class="w-40">
                                    {{ __('admin.attribute_type')[$attribute->type] }}
                                    <input type="hidden" name="attribute[{{ $loop->index }}][id]"
                                        value="{{ $attribute->id }}" />
                                </td>

                                <td class="table-report__action w-20">
                                    <div class="flex justify-center items-center">
                                        <a class="flex items-center mr-3"
                                            href="{{ route('dashboard.attribute.edit', ['category' => $category->id, 'attribute' => $attribute->id]) }}">
                                            <i data-feather="check-square" class="w-4 h-4 mr-1"></i>
                                            {{ __('admin.update', ['attribute' => '']) }}
                                        </a>
                                        <a class="deleteBtn flex items-center text-danger" href="javascript:;"
                                            data-tw-toggle="modal" data-tw-target="#delete-confirmation-modal"
                                            data-id="{{ $attribute->id }}">
                                            <i data-feather="trash-2" class="w-4 h-4 mr-1"></i>
                                            {{ __('admin.delete', ['attribute' => '']) }}
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </form>
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
        </div>
        <button>Add</button>
    </div>
@endsection

@section('script')
    <script>
        $(".deleteBtn").on("click", function() {
            var id = $(this).data('id');
            $('#deleteForm').attr('action', `/dashboard/category/{{ $category->id }}/attribute/${id}`);
        });
        $('.attribute-type').on('change', function() {
            //attribute index , values-index,attribute-id
            let index = $(this).data('id');
            let attributeID = $(this).data('attribute-id');
            let valuesSection = $(`#values-${index}`)
            if ($(this).val() == 'select') {
                if (valuesSection.length) {
                    valuesSection.removeClass('hidden');
                } else
                    createValuesSection(index, attributeID);
                $(this).attr('checked', 'checked');
            }
            if (valuesSection)
                valuesSection.addClass('hidden');
        })
        $('.add-value').on("click", function() {

        });

        function createValuesSection(id, attributeID) {
            let attributeRow = document.getElementById(`attr-${id}`);
            let key = $(`#values- .attributes`).length;
            attributeRow.innerHTML += `<div class="attributes-container w-40 mt-5" id="values-${id}">
                                            <div class="flex justify-center items-center mb-2">
                                                <h1 class="">الخيارات</h1><a href="#"
                                                    class="btn btn-primary shadow-md mr-2 add-value"
                                                    data-id="${id}">{{ __('admin.add', ['attribute' => '']) }}</a>
                                            </div>
                                             <div class="attributes mb-2 flex justify-center items-center">
                                                    <input type="hidden"
                                                        name="attribute[${id}][values][${key}][id]"
                                                        value="${attributeID}" />
                                                    <input id="validation-form-1" type="text"
                                                        name="attribute[${id}][values][${key}][value]"
                                                        class="form-control" placeholder="" minlength="1" maxlength="120"
                                                        value="" required>
                                                    <a class="deleteBtn flex items-center text-danger" href="javascript:;"
                                                        data-tw-toggle="modal" data-tw-target="#delete-confirmation-modal"
                                                        data-id="${attributeID}">
                                                        <i data-feather="trash-2" class="w-4 h-4 mr-1"></i>
                                                        {{ __('admin.delete', ['attribute' => '']) }}
                                                    </a>
                                                </div>`

        }
    </script>
@endsection
