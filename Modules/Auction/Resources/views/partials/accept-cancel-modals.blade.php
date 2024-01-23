 <div id="cancel-confirmation-modal" class="modal" tabindex="-1" aria-hidden="true" style="padding-left: 0px;">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-body p-0">
                 <div class="p-5 text-center">
                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                         stroke-linejoin="round" class="feather feather-x-circle w-16 h-16 text-danger mx-auto mt-3">
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
                     <form id="cancelForm" action="" method="POST">
                         @csrf
                         @method('put')
                         <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">
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
 <div id="accept-confirmation-modal" class="modal" tabindex="-1" aria-hidden="true" style="padding-left: 0px;">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-body p-0">
                 <div class="p-5 text-center">
                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                         stroke-linejoin="round" class="feather feather-x-circle w-16 h-16 text-danger mx-auto mt-3">
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
                     <form id="acceptForm" action="" method="POST">
                         @csrf
                         @method('put')
                         <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">
                             {{ __('admin.cancel') }}
                         </button>
                         <button type="submit" class="btn btn-danger w-32" data-id="">
                             {{ __('admin.yes', ['attribute' => '']) }}
                         </button>
                     </form>
                 </div>
             </div>
         </div>
     </div>
 </div>
