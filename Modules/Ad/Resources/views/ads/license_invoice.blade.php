@extends('admin.layout.main')

@section('content')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            {{ __('admin.invoice') }}
        </h2>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            <button class="btn btn-primary shadow-md mr-2" onclick="print()">{{ __('admin.print') }}</button>
        </div>
    </div>
    <!-- BEGIN: Invoice -->
    <div class="intro-y box overflow-hidden mt-5">
        <div class="border-b border-slate-200/60 dark:border-darkmode-400 text-center sm:text-left">
            <div class="px-5 py-10 sm:px-20 sm:py-20 text-right">
                <div class="text-primary font-semibold text-3xl">{{ __('admin.invoice') }}</div>
                <div class="mt-2"> <span class="font-medium">#{{ $invoice->transaction_id }}</span> </div>
                <div class="mt-1">{{ __('validation.attributes.date') }} {{ $invoice->created_at }}</div>
                <div class="mt-1">{{ __('admin.payment_status') }}:
                    {{ $invoice->status == 'approved' ? 'مكتمل' : 'جاري المعالجة' }}</div>
            </div>
            <div class="flex flex-col lg:flex-row px-5 sm:px-20 pt-10 pb-10 sm:pb-20 text-right">
                <div>
                    <div class="text-base text-slate-500">{{ __('admin.client_detials') }}</div>
                    <div class="text-lg font-medium text-primary mt-2">
                        {{ __('validation.attributes.name') }}:{{ $invoice->customer_name }}</div>
                    <div class="mt-1">{{ __('validation.attributes.phone') }}:{{ $invoice->customer_phone }}</div>
                </div>
            </div>
        </div>
        <div class="px-5 sm:px-20 pb-10 sm:pb-20 flex flex-col-reverse sm:flex-row">
            <div class="text-center sm:text-right sm:ml-auto">
                <div class="text-base text-slate-500">{{ __('validation.attributes.subtotal') }} :
                    {{ $invoice->subtotal_before_discount }} ريال</div>
                <div class="text-xl text-primary font-medium mt-2">{{ __('validation.attributes.discount') }} :
                    {{ $invoice->coupon_discount }} ريال</div>
                <div class="text-xl text-primary font-medium mt-2">
                    {{ __('validation.attributes.subtotal_after_discount') }}
                    : {{ $invoice->subtotal_after_discount }} ريال</div>
                <div class="text-xl text-primary font-medium mt-2">{{ __('validation.attributes.vat') }} :
                    {{ $invoice->vat }} ريال</div>
                <div class="text-xl text-primary font-medium mt-2">{{ __('validation.attributes.total') }} :
                    {{ $invoice->amount }} ريال</div>
            </div>
        </div>
    </div>
@endsection

@push('scriptsStack')
    @include('partials.map-scripts')
    <script>
        function print() {
            window.print();
        }
    </script>
@endpush

@push('stylesStack')
    <style>
        @media print {

            .side-nav,
            .btn {
                display: none;
            }

            html,
            body {
                height: 100vh;
                margin: 0 !important;
                padding: 0 !important;
            }

            @page {
                size: A4;
                orientation: Landscape;
                margin: 0;
            }

            html,
            body,
            .content {
                height: 100vh;
                margin: 0 !important;
                padding: 0 !important;
            }

            .mt-2,
            .mt-5 {
                margin-top: 0 !important;
            }



            .content {
                margin: 0;
                height: 100vh;
            }


            .side-nav,
            .top-bar,
            #success-notification-toggle {
                display: none;
            }
        }
    </style>
