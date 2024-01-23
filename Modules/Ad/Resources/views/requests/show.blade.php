@extends('admin.layout.main')

@section('content')
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{ route('dashboard.ad-request.edit', ['request' => $request->uuid]) }}"
                class="btn btn-primary shadow-md mr-2">{{ __('admin.update', ['attribute' => '']) }}</a>
        </div>
        <!-- BEGIN: Data List -->

    </div>
    <div class="intro-y grid grid-cols-11 gap-5 mt-5"
        style="display: grid;
grid-template-columns: repeat(11, minmax(0, 1fr));">
        <div class="col-span-12 lg:col-span-4 2xl:col-span-3">
            <div class="box p-5 rounded-md">
                <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                    <div class="font-medium text-base truncate">صاحب طلب العقار</div>

                </div>

                <div class="flex items-center mt-3"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" icon-name="user" data-lucide="user"
                        class="lucide lucide-user w-4 h-4 text-slate-500 mr-2">
                        <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg> {{ __('validation.attributes.name') }}: <a href="#"
                        class="underline decoration-dotted ml-1">{{ $request->owner_name }}</a> </div>
                <div class="flex items-center mt-3"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" icon-name="calendar" data-lucide="calendar"
                        class="lucide lucide-calendar w-4 h-4 text-slate-500 mr-2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2">
                        </rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg> {{ __('validation.attributes.phone') }}: {{ $request->owner_phone }} </div>
            </div>
            <div class="box p-5 rounded-md mt-5">
                <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                    <div class="font-medium text-base truncate">تفاصيل العقار</div>
                </div>
                <div class="flex items-center"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" icon-name="clipboard" data-lucide="clipboard"
                        class="lucide lucide-clipboard w-4 h-4 text-slate-500 mr-2">
                        <path d="M16 4h2a2 2 0 012 2v14a2 2 0 01-2 2H6a2 2 0 01-2-2V6a2 2 0 012-2h2"></path>
                        <rect x="8" y="2" width="8" height="4" rx="1" ry="1">
                        </rect>
                    </svg>ID: <a href="" class="underline decoration-dotted ml-1">{{ $request->uuid }}</a>
                </div>
                <div class="flex items-center mt-3"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" icon-name="shopping-bag" data-lucide="shopping-bag"
                        class="lucide lucide-shopping-bag w-4 h-4 text-slate-500 mr-2">
                        <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"></path>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <path d="M16 10a4 4 0 01-8 0"></path>
                    </svg> {{ __('validation.attributes.name') }}: {{ $request->estate->title }} </div>

                <div class="flex items-center mt-3"> <svg xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" icon-name="shopping-bag"
                        data-lucide="shopping-bag" class="lucide lucide-shopping-bag w-4 h-4 text-slate-500 mr-2">
                        <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"></path>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <path d="M16 10a4 4 0 01-8 0"></path>
                    </svg> {{ __('validation.attributes.price') }}: {{ $request->price }} ريال</div>
                <div class="flex items-center mt-3"> <svg xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" icon-name="map-pin" data-lucide="map-pin"
                        class="lucide lucide-map-pin w-4 h-4 text-slate-500 mr-2">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg> {{ __('validation.attributes.category') }}: {{ $request->estate->category->name }} </div>

                <div class="flex items-center mt-3"> <svg xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" icon-name="map-pin" data-lucide="map-pin"
                        class="lucide lucide-map-pin w-4 h-4 text-slate-500 mr-2">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg> {{ __('validation.attributes.city') }}: {{ $request->estate->city->name }} </div>

                <div class="flex items-center mt-3"> <svg xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" icon-name="map-pin" data-lucide="map-pin"
                        class="lucide lucide-map-pin w-4 h-4 text-slate-500 mr-2">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg> {{ __('validation.attributes.address') }}: {{ $request->estate->address }} </div>
                <div class="flex items-center mt-3"> <svg xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" icon-name="calendar" data-lucide="calendar"
                        class="lucide lucide-calendar w-4 h-4 text-slate-500 mr-2">
                        <rect x="3" y="4" width="18" height="18" rx="2"
                            ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg> {{ __('admin.status') }}: <span
                        class="bg-success/20 text-success rounded px-2 ml-1">{{ __('admin.approved_statuses')[$request->status->value] }}</span>
                </div>
                <div class="flex items-center mt-3"> <svg xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" icon-name="calendar" data-lucide="calendar"
                        class="lucide lucide-calendar w-4 h-4 text-slate-500 mr-2">
                        <rect x="3" y="4" width="18" height="18" rx="2"
                            ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg> {{ __('admin.ad_type.main') }}: <span
                        class="bg-success/20 text-success rounded px-2 ml-1">{{ __('admin.ad_type')[$request->type->value] }}</span>
                </div>

            </div>
            <div class="box p-5 rounded-md mt-5">
                <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                    <div class="font-medium text-base truncate">تفاصيل اكثر عن العقار</div>
                </div>
                @foreach ($request->details as $detail)
                    <div class="flex items-center mt-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" icon-name="clipboard" data-lucide="clipboard"
                            class="lucide lucide-clipboard w-4 h-4 text-slate-500 mr-2">
                            <path d="M16 4h2a2 2 0 012 2v14a2 2 0 01-2 2H6a2 2 0 01-2-2V6a2 2 0 012-2h2"></path>
                            <rect x="8" y="2" width="8" height="4" rx="1"
                                ry="1"></rect>
                        </svg> {{ $detail['title'] }}:
                        <div class="ml-auto">{{ $detail['value'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script></script>
@endsection
