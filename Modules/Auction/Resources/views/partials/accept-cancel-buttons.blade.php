                                    <a class="acceptBtn flex items-center text-success" href="javascript:;"
                                        data-tw-toggle="modal" data-tw-target="#accept-confirmation-modal"
                                        data-id="{{ $request->id }}">
                                        <i data-feather="thumbs-up" class="w-4 h-4 ml-1"></i>
                                        {{ __('admin.approve') }}
                                    </a>
                                    <a class="cancelBtn flex items-center text-danger mr-2" href="javascript:;"
                                        data-tw-toggle="modal" data-tw-target="#cancel-confirmation-modal"
                                        data-id="{{ $request->id }}">
                                        <i data-feather="thumbs-down" class="w-4 h-4 ml-1"></i>
                                        {{ __('admin.cancel') }}
                                    </a>
