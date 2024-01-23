@extends('admin.layout.main')
@push('stylesStack')
@endpush

@section('content')
    <!-- BEGIN: Invoice -->
    <div class="intro-y box overflow-hidden mt-5">
        <div class="border-b border-slate-200/60 dark:border-darkmode-400 text-center sm:text-left">
            <div class="px-5 py-10 sm:px-20 sm:py-20 text-right">
                <div class="text-primary font-semibold text-3xl">INVOICE</div>
                <div class="mt-2"> Receipt <span class="font-medium">#1923195</span> </div>
                <div class="mt-1">Jan 02, 2021</div>
            </div>
            <div class="flex flex-col lg:flex-row px-5 sm:px-20 pt-10 pb-10 sm:pb-20">
                <div>
                    <div class="text-base text-slate-500">Client Details</div>
                    <div class="text-lg font-medium text-primary mt-2">Arnold Schwarzenegger</div>
                    <div class="mt-1">arnodlschwarzenegger@gmail.com</div>
                    <div class="mt-1">260 W. Storm Street New York, NY 10025.</div>
                </div>
                <div class="lg:text-left mt-10 lg:mt-0 lg:mr-auto">
                    <div class="text-base text-slate-500">Payment to</div>
                    <div class="text-lg font-medium text-primary mt-2">Left4code</div>
                    <div class="mt-1">left4code@gmail.com</div>
                </div>
            </div>
        </div>
        <div class="px-5 sm:px-16 py-10 sm:py-20">
            <div class="overflow-x-auto">
                <table class="table" style="text-align: right !important;">
                    <thead>
                    <tr>
                        <th class="border-b-2 dark:border-darkmode-400 whitespace-nowrap">DESCRIPTION</th>
                        <th class="border-b-2 dark:border-darkmode-400 text-right whitespace-nowrap">QTY</th>
                        <th class="border-b-2 dark:border-darkmode-400 text-right whitespace-nowrap">PRICE</th>
                        <th class="border-b-2 dark:border-darkmode-400 text-right whitespace-nowrap">SUBTOTAL</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="border-b dark:border-darkmode-400">
                            <div class="font-medium whitespace-nowrap">Midone HTML Admin Template</div>
                            <div class="text-slate-500 text-sm mt-0.5 whitespace-nowrap">Regular License</div>
                        </td>
                        <td class="text-right border-b dark:border-darkmode-400 w-32">2</td>
                        <td class="text-right border-b dark:border-darkmode-400 w-32">$25</td>
                        <td class="text-right border-b dark:border-darkmode-400 w-32 font-medium">$50</td>
                    </tr>
                    <tr>
                        <td class="border-b dark:border-darkmode-400">
                            <div class="font-medium whitespace-nowrap">Vuejs Admin Template</div>
                            <div class="text-slate-500 text-sm mt-0.5 whitespace-nowrap">Regular License</div>
                        </td>
                        <td class="text-right border-b dark:border-darkmode-400 w-32">1</td>
                        <td class="text-right border-b dark:border-darkmode-400 w-32">$25</td>
                        <td class="text-right border-b dark:border-darkmode-400 w-32 font-medium">$25</td>
                    </tr>
                    <tr>
                        <td class="border-b dark:border-darkmode-400">
                            <div class="font-medium whitespace-nowrap">React Admin Template</div>
                            <div class="text-slate-500 text-sm mt-0.5 whitespace-nowrap">Regular License</div>
                        </td>
                        <td class="text-right border-b dark:border-darkmode-400 w-32">1</td>
                        <td class="text-right border-b dark:border-darkmode-400 w-32">$25</td>
                        <td class="text-right border-b dark:border-darkmode-400 w-32 font-medium">$25</td>
                    </tr>
                    <tr>
                        <td>
                            <div class="font-medium whitespace-nowrap">Laravel Admin Template</div>
                            <div class="text-slate-500 text-sm mt-0.5 whitespace-nowrap">Regular License</div>
                        </td>
                        <td class="text-right w-32">3</td>
                        <td class="text-right w-32">$25</td>
                        <td class="text-right w-32 font-medium">$75</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="px-5 sm:px-20 pb-10 sm:pb-20 flex flex-col-reverse sm:flex-row">
            <div class="text-center sm:text-left mt-10 sm:mt-0">
                <div class="text-base text-slate-500">Bank Transfer</div>
                <div class="text-lg text-primary font-medium mt-2">Elon Musk</div>
                <div class="mt-1">Bank Account : 098347234832</div>
                <div class="mt-1">Code : LFT133243</div>
            </div>
            <div class="text-center sm:text-right sm:mr-auto">
                <div class="text-base text-slate-500">Total Amount</div>
                <div class="text-xl text-primary font-medium mt-2">$20.600.00</div>
                <div class="mt-1">Taxes included</div>
            </div>
        </div>
    </div>
    <!-- END: Invoice -->
@endsection

@section('script')

@endsection


