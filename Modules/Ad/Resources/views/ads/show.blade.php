@extends('admin.layout.main')

@section('content')
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{ route('dashboard.ad.edit', ['ad' => $ad->uuid]) }}"
                class="btn btn-primary shadow-md mr-2">{{ __('admin.update', ['attribute' => '']) }}</a>
            @if ($ad->is_license_request)
                <a href="{{ route('dashboard.ad.show-invoice', ['ad' => $ad->uuid]) }}"
                    class="btn btn-primary shadow-md mr-2">{{ __('admin.show-invoice', ['attribute' => '']) }}</a>
            @endif
        </div>
        <!-- BEGIN: Data List -->

    </div>
    <div class="intro-y grid grid-cols-11 gap-5 mt-5"
        style="display: grid;grid-template-columns: repeat(11, minmax(0, 1fr));">
        <div class="col-span-12 lg:col-span-4 2xl:col-span-3">
            <div class="box p-5 rounded-md">
                <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                    <div class="font-medium text-base truncate">صاحب الاعلان</div>

                </div>

                <div class="flex items-center mt-3" onclick="copyToClipboard('{{ $ad->owner_name }}')"> <svg
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        icon-name="user" data-lucide="user" class="lucide lucide-user w-4 h-4 text-slate-500 mr-2">
                        <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg> {{ __('validation.attributes.name') }}:
                    <a href="#" class="underline decoration-dotted ml-1">{{ $ad->owner_name }}</a>
                </div>
                <div class="flex items-center mt-3" onclick="copyToClipboard('{{ $ad->owner?->email }}')"> <svg
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        icon-name="user" data-lucide="user" class="lucide lucide-user w-4 h-4 text-slate-500 mr-2">
                        <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg> {{ __('validation.attributes.email') }}:
                    <a href="#" class="underline decoration-dotted ml-1">{{ $ad->owner?->email }}</a>
                </div>

                <div class="flex items-center mt-3" onclick="copyToClipboard('{{ $ad->owner_phone }}')"> <svg
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        icon-name="calendar" data-lucide="calendar"
                        class="lucide lucide-calendar w-4 h-4 text-slate-500 mr-2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2">
                        </rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg> {{ __('validation.attributes.phone') }}: {{ $ad->owner_phone }} </div>
                <div class="flex items-center mt-3" onclick="copyToClipboard('{{ $ad->owner?->nationality_id }}')"> <svg
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        icon-name="user" data-lucide="user" class="lucide lucide-user w-4 h-4 text-slate-500 mr-2">
                        <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg> {{ __('validation.attributes.nationality_id') }}:
                    <a href="#" class="underline decoration-dotted ml-1">{{ $ad->owner?->nationality_id }}</a>
                </div>
            </div>

            @if ($ad->license_number != null)
                <div class="box p-5 rounded-md mt-5">

                    <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                        <div class="font-medium text-base truncate">رخصة الإعلان</div>
                    </div>
                    <div class="flex items-center mt-3" onclick="copyToClipboard('{{ $ad->license_number }}')"> <svg
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" icon-name="user" data-lucide="user"
                            class="lucide lucide-user w-4 h-4 text-slate-500 mr-2">
                            <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg> رقم الترخيص: <a href="#"
                            class="underline decoration-dotted ml-1">{{ $ad->license_number }}</a>
                    </div>
                    <div class="flex items-center mt-3"> <svg xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" icon-name="calendar" data-lucide="calendar"
                            class="lucide lucide-calendar w-4 h-4 text-slate-500 mr-2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2">
                            </rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg> تاريخ نشر الإعلان: {{ $ad->accepted_at->format('d/m/Y h:i') }}
                    </div>
                    <div class="flex items-center mt-3"> <svg xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" icon-name="calendar" data-lucide="calendar"
                            class="lucide lucide-calendar w-4 h-4 text-slate-500 mr-2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2">
                            </rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg> رقم الهوية: {{ $ad?->owner?->nationality_id }}
                    </div>

                </div>
            @endif

            <div class="box p-5 rounded-md mt-5">

                <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                    <div class="font-medium text-base truncate">حالة التميز</div>
                </div>
                <div class="flex items-center mt-3"> <svg xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" icon-name="user" data-lucide="user"
                        class="lucide lucide-user w-4 h-4 text-slate-500 mr-2">
                        <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg> {{ $ad->is_featured == 1 ? 'مميز' : 'غير مميز' }}
                </div>
                @if ($ad->is_featured == 1)
                    <div class="flex items-center mt-3"> <svg xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" icon-name="calendar" data-lucide="calendar"
                            class="lucide lucide-calendar w-4 h-4 text-slate-500 mr-2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2">
                            </rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg> مدة التميز :
                        {{ \Carbon\Carbon::parse($ad->featured_expires_at)->diffInDays(\Carbon\Carbon::parse($ad->featured_at)) }}
                        يوم
                    </div>
                @endif
            </div>

            <div class="box p-5 rounded-md mt-5">
                <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                    <div class="font-medium text-base truncate">تفاصيل العقار</div>
                </div>
                <div class="flex items-center"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" icon-name="clipboard" data-lucide="clipboard"
                        class="lucide lucide-clipboard w-4 h-4 text-slate-500 mr-2">
                        <path d="M16 4h2a2 2 0 012 2v14a2 2 0 01-2 2H6a2 2 0 01-2-2V6a2 2 0 012-2h2"></path>
                        <rect x="8" y="2" width="8" height="4" rx="1" ry="1">
                        </rect>
                    </svg>ID: <a href="" class="underline decoration-dotted ml-1">{{ $ad->uuid }}</a>
                </div>
                <div class="flex items-center mt-3" onclick="copyToClipboard('{{ $ad->estate->title }}')"> <svg
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" icon-name="shopping-bag" data-lucide="shopping-bag"
                        class="lucide lucide-shopping-bag w-4 h-4 text-slate-500 mr-2">
                        <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"></path>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <path d="M16 10a4 4 0 01-8 0"></path>
                    </svg> {{ __('validation.attributes.name') }}: {{ $ad->estate->title }} </div>
                <div class="flex items-center mt-3" onclick="copyToClipboard('{{ $ad->estate->description }}')"> <svg
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" icon-name="shopping-bag" data-lucide="shopping-bag"
                        class="lucide lucide-shopping-bag w-4 h-4 text-slate-500 mr-2">
                        <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"></path>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <path d="M16 10a4 4 0 01-8 0"></path>
                    </svg> {{ __('validation.attributes.desc') }}: {{ $ad->estate->description }}
                </div>
                <div class="flex items-center mt-3"> <svg xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" icon-name="calendar" data-lucide="calendar"
                        class="lucide lucide-calendar w-4 h-4 text-slate-500 mr-2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg> {{ __('admin.ad_type.main') }}: <span
                        class="bg-success/20 text-success rounded px-2 ml-1">{{ __('admin.ad_type')[$ad->type->value] }}</span>
                </div>
                <div class="flex items-center mt-3" onclick="copyToClipboard('{{ $ad->estate->category->name }}')"> <svg
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" icon-name="map-pin" data-lucide="map-pin"
                        class="lucide lucide-map-pin w-4 h-4 text-slate-500 mr-2">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg> {{ __('validation.attributes.category') }}: {{ $ad->estate->category->name }}
                </div>
                <div class="flex items-center mt-3" onclick="copyToClipboard('{{ $ad->estate->city->name }}')"> <svg
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" icon-name="map-pin" data-lucide="map-pin"
                        class="lucide lucide-map-pin w-4 h-4 text-slate-500 mr-2">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg> {{ __('validation.attributes.city') }}: {{ $ad->estate->city->name }}
                </div>

                <div class="flex items-center mt-3" onclick="copyToClipboard('{{ $ad->price }}')"> <svg
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" icon-name="shopping-bag" data-lucide="shopping-bag"
                        class="lucide lucide-shopping-bag w-4 h-4 text-slate-500 mr-2">
                        <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"></path>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <path d="M16 10a4 4 0 01-8 0"></path>
                    </svg> {{ __('validation.attributes.price') }}: {{ $ad->price }} ريال</div>




                <div class="flex items-center mt-3"
                    onclick="copyToClipboard('{{ __('admin.advertiser_relation')[$ad->advertiser_relation->value] }}')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" icon-name="map-pin" data-lucide="map-pin"
                        class="lucide lucide-map-pin w-4 h-4 text-slate-500 mr-2">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg> {{ __('validation.attributes.advertiser_relation') }}:
                    {{ __('admin.advertiser_relation')[$ad->advertiser_relation->value] }} </div>

                <div class="flex items-center mt-3" onclick="copyToClipboard('{{ $ad->estate->address }}')"> <svg
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" icon-name="map-pin" data-lucide="map-pin"
                        class="lucide lucide-map-pin w-4 h-4 text-slate-500 mr-2">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg> {{ __('validation.attributes.address') }}: {{ $ad->estate->address }} </div>
                <div class="flex items-center mt-3"> <svg xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" icon-name="calendar" data-lucide="calendar"
                        class="lucide lucide-calendar w-4 h-4 text-slate-500 mr-2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg> {{ __('admin.status') }}: <span
                        class="bg-success/20 text-success rounded px-2 ml-1">{{ __('admin.approved_statuses')[$ad->status->value] }}</span>
                </div>
                @if ($ad->is_license_request)
                    <div class="flex items-center mt-3" onclick="copyToClipboard('{{ $ad->building_number }}')"> <svg
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" icon-name="map-pin" data-lucide="map-pin"
                            class="lucide lucide-map-pin w-4 h-4 text-slate-500 mr-2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg> {{ __('validation.attributes.building_number') }}: {{ $ad->building_number }}
                    </div>
                    <div class="flex items-center mt-3" onclick="copyToClipboard('{{ $ad->additional_number }}')"> <svg
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" icon-name="map-pin" data-lucide="map-pin"
                            class="lucide lucide-map-pin w-4 h-4 text-slate-500 mr-2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg> {{ __('validation.attributes.additional_number') }}: {{ $ad->additional_number }}
                    </div>
                    <div class="flex items-center mt-3" onclick="copyToClipboard('{{ $ad->postal_number }}')"> <svg
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" icon-name="map-pin" data-lucide="map-pin"
                            class="lucide lucide-map-pin w-4 h-4 text-slate-500 mr-2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg> {{ __('validation.attributes.postal_number') }}: {{ $ad->postal_number }}
                    </div>
                    <div class="flex items-center mt-3" onclick="copyToClipboard('{{ $ad->nationality_id }}')"> <svg
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" icon-name="map-pin" data-lucide="map-pin"
                            class="lucide lucide-map-pin w-4 h-4 text-slate-500 mr-2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg> {{ __('validation.attributes.nationality_id') }}: {{ $ad->nationality_id }}
                    </div>
                    <div class="flex items-center mt-3" onclick="copyToClipboard('{{ $ad->instrument_number }}')"> <svg
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" icon-name="map-pin" data-lucide="map-pin"
                            class="lucide lucide-map-pin w-4 h-4 text-slate-500 mr-2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg> {{ __('validation.attributes.instrument_number') }}: {{ $ad->instrument_number }}
                    </div>
                @endif
            </div>
            <div class="box p-5 rounded-md mt-5">
                <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                    <div class="font-medium text-base truncate">مواصفات العقار</div>
                </div>
                @foreach ($ad->details as $detail)
                    <div class="flex items-center mt-3" onclick="copyToClipboard('{{ $detail['value'] }}')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" icon-name="clipboard" data-lucide="clipboard"
                            class="lucide lucide-clipboard w-4 h-4 text-slate-500 mr-2">
                            <path d="M16 4h2a2 2 0 012 2v14a2 2 0 01-2 2H6a2 2 0 01-2-2V6a2 2 0 012-2h2"></path>
                            <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                        </svg> {{ $detail['title'] }}:
                        <div class="ml-auto">{{ $detail['value'] }}</div>
                    </div>
                @endforeach
            </div>

        </div>
        <div class="col-span-12 lg:col-span-7 2xl:col-span-8"
            style="grid-column: span 7 / span 7;grid-column-start: span 7;grid-column-end: span 7;">
            <div class="grid grid-cols-12 gap-5">
                @foreach ($ad->estate->media as $media)
                    <div class="intro-y col-span-12 sm:col-span-6 2xl:col-span-4">
                        <div class="box">
                            <div class="p-5">
                                <div
                                    class="h-40 2xl:h-56 image-fit rounded-md overflow-hidden before:block before:absolute before:w-full before:h-full before:top-0 before:left-0 before:z-10 before:bg-gradient-to-t before:from-black before:to-black/10">
                                    @if ($media->type == 'image')
                                        <img alt="image" class="rounded-md" src="{{ $media->formattedUrl }}">
                                    @else
                                        <video src="{{ $media->formattedUrl }}"></video>
                                    @endif

                                </div>

                            </div>

                        </div>
                    </div>
                @endforeach
                <div class="intro-y col-span-12 sm:col-span-12 2xl:col-span-12">
                    <input type="hidden" id="lat" name="{{ $coordinate->latName }}"
                        value="{{ $coordinate->lat }}" />
                    <input type="hidden" id="long" name="{{ $coordinate->longName }}"
                        value="{{ $coordinate->long }}" />

                    <div class="row" style="height:400px">
                        <input id="pac-input" class="controls" type="text" placeholder="Search Box" />
                        <div id="map" style="height:100%"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scriptsStack')
    @include('partials.map-scripts')
@endpush
