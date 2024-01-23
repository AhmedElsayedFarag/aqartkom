@extends('admin.layout.main')

@section('content')
    <div class="col-span-12 2xl:col-span-9">
        <div class="grid grid-cols-12 gap-6">
            <!-- BEGIN: General Report -->
            <div class="col-span-12 mt-8">
                <div class="intro-y flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">
                        {{ __('sidebar.users') }}
                    </h2>
                </div>
                <div class="grid grid-cols-12 gap-6 mt-5">

                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <a href="{{ route('dashboard.customer.index') }}" class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <i data-feather="user" class="report-box__icon text-primary"></i>
                                </div>
                                <div class="text-3xl font-medium leading-8 mt-6">{{ $userTypeDto->customersCount }}</div>
                                <div class="text-base text-slate-500 mt-1">{{ __('admin.customers') }}</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <a href="{{ route('dashboard.owner.index') }}" class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <i data-feather="user" class="report-box__icon text-primary"></i>
                                </div>
                                <div class="text-3xl font-medium leading-8 mt-6">{{ $userTypeDto->ownersCount }}</div>
                                <div class="text-base text-slate-500 mt-1">{{ __('admin.users.owner') }}</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <a href="{{ route('dashboard.marketer.index') }}" class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <i data-feather="user" class="report-box__icon text-primary"></i>
                                </div>
                                <div class="text-3xl font-medium leading-8 mt-6">{{ $userTypeDto->marketersCount }}</div>
                                <div class="text-base text-slate-500 mt-1">{{ __('admin.marketers_count') }}</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <a href="{{ route('dashboard.company.index') }}" class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <i data-feather="user" class="report-box__icon text-primary"></i>
                                </div>
                                <div class="text-3xl font-medium leading-8 mt-6">{{ $userTypeDto->companiesCount }}</div>
                                <div class="text-base text-slate-500 mt-1">{{ __('admin.companies_count') }}</div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="intro-y flex items-center h-10 mt-3">
                    <h2 class="text-lg font-medium truncate mr-5">
                        {{ __('sidebar.ads') }}
                    </h2>
                </div>
                <div class="grid grid-cols-12 gap-6 mt-5">
                    <div class="col-span-12 sm:col-span-6 xl:col-span-4 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <i data-feather="map-pin" class="report-box__icon text-primary"></i>
                                </div>
                                <div class="text-3xl font-medium leading-8 mt-6">{{ $adDto->licensedAdsCount }}</div>
                                <div class="text-base text-slate-500 mt-1">{{ __('admin.licensedAdsCount') }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 xl:col-span-4 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <i data-feather="map-pin" class="report-box__icon text-primary"></i>

                                </div>
                                <div class="text-3xl font-medium leading-8 mt-6">{{ $adDto->licensedRequestCount }}</div>
                                <div class="text-base text-slate-500 mt-1">{{ __('admin.licensedRequestCount') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-span-12 sm:col-span-8 lg:col-span-4 mt-8">
                <div class="intro-y flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">
                        {{ __('admin.ad_type.main') }}
                    </h2>
                </div>
                <div class="intro-y box p-5 mt-5">
                    <canvas class="mt-3" id="ad-type" height="300"></canvas>
                    <div class="mt-8">
                        <div class="flex items-center">
                            <div class="w-2 h-2 bg-primary rounded-full mr-3"></div>
                            <span class="truncate">{{ __('admin.ad_type.rent') }}</span> <span
                                class="font-medium xl:ml-auto">{{ round(($adTypeDto->rentAdsCount / $adDto->adsCount) * 100) }}%</span>
                        </div>
                        <div class="flex items-center mt-4">
                            <div class="w-2 h-2 bg-pending rounded-full mr-3"></div>
                            <span class="truncate">{{ __('admin.ad_type.sell') }}</span> <span
                                class="font-medium xl:ml-auto">{{ round(($adTypeDto->sellAdsCount / $adDto->adsCount) * 100) }}%</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-span-12 sm:col-span-8 lg:col-span-4 mt-8">
                <div class="intro-y flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">
                        انواع اعلانات البيع
                    </h2>
                </div>
                <div class="intro-y box p-5 mt-5">
                    <canvas class="mt-3" id="ad-type-sell" height="300"></canvas>
                    <div class="mt-8">
                        @foreach ($categories as $category)
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-secondary rounded-full mr-3"></div>
                                <span class="truncate">{{ $category->name }}</span>
                                @isset($sellAds[$category->id])
                                    <span
                                        class="font-medium xl:ml-auto">{{ round(($sellAds[$category->id]['ads_count'] / $adTypeDto->sellAdsCount) * 100) }}%</span>
                                @else
                                    <span class="font-medium xl:ml-auto">0%</span>
                                @endisset

                            </div>
                        @endforeach


                    </div>
                </div>
            </div>
            <div class="col-span-12 sm:col-span-8 lg:col-span-4 mt-8">
                <div class="intro-y flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">
                        انواع اعلانات الايجار
                    </h2>
                </div>
                <div class="intro-y box p-5 mt-5">
                    <canvas class="mt-3" id="ad-type-rent" height="300"></canvas>
                    <div class="mt-8">
                        @foreach ($categories as $category)
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-secondary rounded-full mr-3"></div>

                                <span class="truncate">{{ $category->name }}</span>
                                @isset($rentAds[$category->id])
                                    <span
                                        class="font-medium xl:ml-auto">{{ round(($rentAds[$category->id]['ads_count'] / $adTypeDto->rentAdsCount) * 100) }}%</span>
                                @else
                                    <span class="font-medium xl:ml-auto">0%</span>
                                @endisset

                            </div>
                        @endforeach


                    </div>
                </div>
            </div>
            <!-- END: Weekly Top Seller -->
            <!-- BEGIN: General Report -->
            <div class="col-span-12 mt-8">
                <div class="intro-y flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">
                        {{ __('admin.profits') }}
                    </h2>
                </div>
                <div class="grid grid-cols-12 gap-6 mt-5">

                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <i data-feather="user" class="report-box__icon text-primary"></i>
                                </div>
                                <div class="text-3xl font-medium leading-8 mt-6">{{ $NumberOfSubscribtions }}</div>
                                <div class="text-base text-slate-500 mt-1">{{ __('admin.NumberOfSubscribtions') }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    ريال
                                </div>
                                <div class="text-3xl font-medium leading-8 mt-6">{{ $profits }}</div>
                                <div class="text-base text-slate-500 mt-1">{{ __('admin.profits') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: General Report -->

        </div>
    </div>
@endsection

@push('scriptsStack')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.1.1/chart.min.js"
        integrity="sha512-MC1YbhseV2uYKljGJb7icPOjzF2k6mihfApPyPhEAo3NsLUW0bpgtL4xYWK1B+1OuSrUkfOTfhxrRKCz/Jp3rQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" type="module"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.1.1/chart.umd.js"
        integrity="sha512-+Aecf3QQcWkkA8IUdym4PDvIP/ikcKdp4NCDF8PM6qr9FtqwIFCS3JAcm2+GmPMZvnlsrGv1qavSnxL8v+o86w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" type="module"></script>
    <script>
        let ctx = $("#ad-type")[0].getContext("2d");
        let myPieChart = new Chart(ctx, {
            type: "doughnut",
            data: {
                labels: [
                    "ايجار",
                    "بيع",
                ],
                datasets: [{
                    data: [{{ $adTypeDto->rentAdsCount }},
                        {{ $adTypeDto->sellAdsCount }}
                    ],
                    backgroundColor: [
                        "#1E40AF",
                        "#F9802C",
                    ],
                    hoverBackgroundColor: [
                        "#1E40AF",
                        "#F9802C",
                    ],
                    borderWidth: 5,
                    borderColor: "#FFFFFF",
                }, ],
            },
            options: {
                legend: {
                    display: false,
                },
            },
        });
        ctx = $("#ad-type-sell")[0].getContext("2d");
        myPieChart = new Chart(ctx, {
            type: "doughnut",
            data: {
                labels: [
                    @foreach ($categories as $category)
                        "{{ $category->name }}",
                    @endforeach
                ],
                datasets: [{
                    data: [
                        @foreach ($categories as $category)
                            @if (isset($sellAds[$category->id]))

                                {{ $sellAds[$category->id]['ads_count'] }},
                            @else
                                0,
                            @endif
                        @endforeach
                    ],
                    backgroundColor: [
                        "#1E40AF",
                        "#F9802C",
                        "#FAD12B",
                        "#1E40AF",
                        "#F9802C",
                        "#FAD12B",
                        "#1E40AF",
                        "#F9802C",
                        "#FAD12B",
                    ],
                    hoverBackgroundColor: [
                        "#1E40AF",
                        "#F9802C",
                        "#FAD12B",
                        "#1E40AF",
                        "#F9802C",
                        "#FAD12B",
                        "#1E40AF",
                        "#F9802C",
                        "#FAD12B",
                    ],
                    borderWidth: 5,
                    borderColor: "#FFFFFF",
                }, ],
            },
            options: {
                legend: {
                    display: false,
                },
            },
        });
        ctx = $("#ad-type-rent")[0].getContext("2d");
        myPieChart = new Chart(ctx, {
            type: "doughnut",
            data: {
                labels: [
                    @foreach ($categories as $category)
                        "{{ $category->name }}",
                    @endforeach
                ],
                datasets: [{
                    data: [
                        @foreach ($categories as $category)
                            @if (isset($rentAds[$category->id]))

                                {{ $rentAds[$category->id]['ads_count'] }},
                            @else
                                0,
                            @endif
                        @endforeach
                    ],
                    backgroundColor: [
                        "#1E40AF",
                        "#F9802C",
                        "#FAD12B",
                        "#1E40AF",
                        "#F9802C",
                        "#FAD12B",
                        "#1E40AF",
                        "#F9802C",
                        "#FAD12B",
                    ],
                    hoverBackgroundColor: [
                        "#1E40AF",
                        "#F9802C",
                        "#FAD12B",
                        "#1E40AF",
                        "#F9802C",
                        "#FAD12B",
                        "#1E40AF",
                        "#F9802C",
                        "#FAD12B",
                    ],
                    borderWidth: 5,
                    borderColor: "#FFFFFF",
                }, ],
            },
            options: {
                legend: {
                    display: false,
                },
            },
        });
    </script>
@endpush
