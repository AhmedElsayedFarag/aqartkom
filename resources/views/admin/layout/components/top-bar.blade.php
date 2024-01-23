<!-- BEGIN: Top Bar -->
<div class="top-bar">
    <!-- BEGIN: Breadcrumb -->
    <nav aria-label="breadcrumb" class="-intro-x ml-auto hidden sm:flex">
        <ol class="breadcrumb">
            @php
                $breadCrumbs = App\Services\BreadCrumbGenerator::generate();
            @endphp
            @foreach ($breadCrumbs as $breadCrumb)
                @if ($breadCrumb->route)
                    <li class="breadcrumb-item " aria-current="page"><a
                            href="{{ $breadCrumb->route != '#' ? route($breadCrumb->route) : '#' }}">{{ $breadCrumb->name }}</a>
                    </li>
                @else
                    <li class="breadcrumb-item
                @if ($loop->last) active @endif
                "
                        aria-current="page">{{ $breadCrumb->name }} </li>
                @endif
            @endforeach

        </ol>
    </nav>
    <!-- END: Breadcrumb -->
    <!-- BEGIN: Search -->
    {{-- <div class="intro-x relative mr-3 sm:mr-6">
        <div class="search hidden sm:block">
            <input type="text" class="search__input form-control border-transparent" placeholder="Search...">
            <i data-feather="search" class="search__icon dark:text-slate-500"></i>
        </div>
        <a class="notification sm:hidden" href="">
            <i data-feather="search" class="notification__icon dark:text-slate-500"></i>
        </a>
        <div class="search-result">
            <div class="search-result__content">
                <div class="search-result__content__title">Pages</div>
                <div class="mb-5">
                    <a href="" class="flex items-center">
                        <div
                            class="w-8 h-8 bg-success/20 dark:bg-success/10 text-success flex items-center justify-center rounded-full">
                            <i class="w-4 h-4" data-feather="inbox"></i>
                        </div>
                        <div class="ml-3">Mail Settings</div>
                    </a>
                    <a href="" class="flex items-center mt-2">
                        <div class="w-8 h-8 bg-pending/10 text-pending flex items-center justify-center rounded-full">
                            <i class="w-4 h-4" data-feather="users"></i>
                        </div>
                        <div class="ml-3">Users & Permissions</div>
                    </a>
                    <a href="" class="flex items-center mt-2">
                        <div
                            class="w-8 h-8 bg-primary/10 dark:bg-primary/20 text-primary/80 flex items-center justify-center rounded-full">
                            <i class="w-4 h-4" data-feather="credit-card"></i>
                        </div>
                        <div class="ml-3">Transactions Report</div>
                    </a>
                </div>
                <div class="search-result__content__title">Users</div>
                <div class="mb-5">
                    <a href="" class="flex items-center mt-2">
                        <div class="w-8 h-8 image-fit">
                            <img alt="Rubick Tailwind HTML Admin Template" class="rounded-full" src="#">
                        </div>
                        <div class="ml-3">Name</div>
                        <div class="ml-auto w-48 truncate text-slate-500 text-xs text-right">Email</div>
                    </a>
                </div>
                <div class="search-result__content__title">Products</div>
                <a href="" class="flex items-center mt-2">
                    <div class="w-8 h-8 image-fit">
                        <img alt="Rubick Tailwind HTML Admin Template" class="rounded-full" src="#">
                    </div>
                    <div class="ml-3">Name</div>
                    <div class="ml-auto w-48 truncate text-slate-500 text-xs text-right">Category</div>
                </a>
            </div>
        </div>
    </div> --}}
    <!-- END: Search -->
    <!-- BEGIN: Notifications -->
    <div class="intro-x dropdown mr-auto ml-5 sm:mr-6">
        <div class="dropdown-toggle notification notification--bullet cursor-pointer" role="button"
            aria-expanded="false" data-tw-toggle="dropdown">
            <i data-feather="bell" class="notification__icon dark:text-slate-500"></i>
        </div>
        {{-- get all notifications from user and make read functionality --}}
        <div class="notification-content pt-2 dropdown-menu">
            <div class="notification-content__box dropdown-content">
                <div class="notification-content__title">الاشعارات</div>
                <div class="cursor-pointer relative block items-center">
                    @foreach (auth()->user()->latestNotifications as $notification)
                        <div class="ml-2 overflow-hidden">
                            <div class="flex items-center">
                                <div class="text-xs text-slate-400 ml-auto whitespace-nowrap">
                                    {{ $notification->created_at }}</div>
                            </div>
                            <div class="w-full truncate text-slate-500 mt-0.5">{{ $notification->data['body'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- END: Notifications -->
    <!-- BEGIN: Account Menu -->
    <div class="intro-x dropdown w-8 h-8">
        <div class="dropdown-toggle w-8 h-8 rounded-full overflow-hidden shadow-lg image-fit zoom-in" role="button"
            aria-expanded="false" data-tw-toggle="dropdown">
            <img alt="Rubick Tailwind HTML Admin Template" src="{{ auth()->user()->formattedProfile }}">
        </div>
        <div class="dropdown-menu w-56">
            <ul class="dropdown-content bg-primary text-white">
                <li class="p-2">
                    <div class="font-medium">{{ auth()->user()->name }}</div>
                </li>
                <li>
                    <hr class="dropdown-divider border-white/[0.08]">
                </li>
                <li>
                    <a href="{{ route('dashboard.change-profile.index') }}" class="dropdown-item hover:bg-white/5"> <svg
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" icon-name="user" data-lucide="user"
                            class="lucide lucide-user w-4 h-4 mr-2">
                            <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg> {{ __('admin.profile') }} </a>
                </li>

                <li>
                    <a href="{{ route('dashboard.change-password.index') }}" class="dropdown-item hover:bg-white/5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" icon-name="lock" data-lucide="lock"
                            class="lucide lucide-lock w-4 h-4 ml-2">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0110 0v4"></path>
                        </svg> {{ __('admin.change_password') }} </a>
                </li>

                <li>
                    <hr class="dropdown-divider border-white/[0.08]">
                </li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="dropdown-item hover:bg-white/5 w-full"> <svg xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="toggle-right"
                                data-lucide="toggle-right" class="lucide lucide-toggle-right w-4 h-4 ml-2">
                                <rect x="1" y="5" width="22" height="14" rx="7" ry="7"></rect>
                                <circle cx="16" cy="12" r="3"></circle>
                            </svg>{{ __('admin.logout') }}</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
    <!-- END: Account Menu -->
</div>
<!-- END: Top Bar -->
