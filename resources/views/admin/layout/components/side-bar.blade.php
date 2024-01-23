<nav class="side-nav">
    <a href="" class="intro-x flex items-center pl-5 pt-4">
        <img alt="Logo" class="w-100" src="{{ asset('default/logo.png') }}">
    </a>
    <div class="side-nav__devider my-6"></div>
    <ul>
        <li>
            <a href="{{ route('dashboard') }}" @class([
            'side-menu',
            'side-menu--active' => request()->routeIs('dashboard'),
            ])>
            <div class="side-menu__icon"><i data-feather="home"></i></div>
            <div class="side-menu__title">
                {{ __('sidebar.dashboard') }}
            </div>
            </a>
        </li>
        <li>
            <a href="javascript:;" @class([
            'side-menu',
            'side-menu--active' =>
            request()->routeIs('dashboard.owner.*') ||
            request()->routeIs('dashboard.customer.*') ||
            request()->routeIs('dashboard.marketer.*') ||
            request()->routeIs('dashboard.company.*'),
            ' side-menu--open' =>
            request()->routeIs('dashboard.owner.*') ||
            request()->routeIs('dashboard.customer.*') ||
            request()->routeIs('dashboard.marketer.*') ||
            request()->routeIs('dashboard.company.*'),
            ])>
            <div class="side-menu__icon">
                <i data-feather="users"></i>
            </div>
            <div class="side-menu__title">
                {{ __('sidebar.users') }}
                <div class="side-menu__sub-icon ">
                    <i data-feather="chevron-down"></i>
                </div>
            </div>
            </a>
            <ul @class([
            'side-menu__sub-open' =>
            request()->routeIs('dashboard.owner.*') ||
            request()->routeIs('dashboard.customer.*') ||
            request()->routeIs('dashboard.marketer.*') ||
            request()->routeIs('dashboard.company.*'),
            ])>

        <li>
            <a href="{{ route('dashboard.customer.index') }}" @class([
            'side-menu',
            'side-menu--active' => request()->routeIs('dashboard.customer.index'),
            ])>
            <div class="side-menu__icon"><i data-feather="user"></i></div>
            <div class="side-menu__title"> {{ __('sidebar.customers') }} </div>
            </a>
        </li>
        <li>
            <a href="{{ route('dashboard.owner.index') }}" @class([
            'side-menu',
            'side-menu--active' => request()->routeIs('dashboard.owner.index'),
            ])>
            <div class="side-menu__icon"><i data-feather="user"></i></div>
            <div class="side-menu__title"> {{ __('sidebar.owners') }} </div>
            </a>
        </li>

        <li>
            <a href="{{ route('dashboard.marketer.index') }}" @class([
            'side-menu',
            'side-menu--active' => request()->routeIs('dashboard.marketer.index'),
            ])>
            <div class="side-menu__icon"><i data-feather="user"></i></div>
            <div class="side-menu__title"> {{ __('sidebar.marketers') }} </div>
            </a>
        </li>
        <li>
            <a href="{{ route('dashboard.company.index') }}" @class([
            'side-menu',
            'side-menu--active' => request()->routeIs('dashboard.company.index'),
            ])>
            <div class="side-menu__icon"><i data-feather="user"></i></div>
            <div class="side-menu__title"> {{ __('sidebar.companies') }} </div>
            </a>
        </li>

    </ul>
    </li>
    <li>
        <a href="javascript:;" @class([
        'side-menu',
        'side-menu--active' =>
        request()->routeIs('dashboard.admin.*') ||
        request()->routeIs('dashboard.role.*'),
        ' side-menu--open' =>
        request()->routeIs('dashboard.admin.*') ||
        request()->routeIs('dashboard.role.*'),
        ])>
        <div class="side-menu__icon">
            <i data-feather="users"></i>
        </div>
        <div class="side-menu__title">
            {{ __('sidebar.admin') }}
            <div class="side-menu__sub-icon ">
                <i data-feather="chevron-down"></i>
            </div>
        </div>
        </a>
        <ul @class([
        'side-menu__sub-open' =>
        request()->routeIs('dashboard.admin.*') ||
        request()->routeIs('dashboard.customers-otps.*') ||
        request()->routeIs('dashboard.role.*'),
        ])>

    <li>
        <a href="{{ route('dashboard.customers-otps.index') }}" @class([
        'side-menu',
        'side-menu--active' => request()->routeIs('dashboard.customers-otps.index'),
        ])>
        <div class="side-menu__icon"><i data-feather="user"></i></div>
        <div class="side-menu__title"> {{ __('sidebar.customers-otps') }} </div>
        </a>
    </li>

    <li>
        <a href="{{ route('dashboard.admin.index') }}" @class([
        'side-menu',
        'side-menu--active' => request()->routeIs('dashboard.admin.*'),
        ])>
        <div class="side-menu__icon"><i data-feather="user"></i></div>
        <div class="side-menu__title"> {{ __('sidebar.admins') }} </div>
        </a>
    </li>
    <li>
        <a href="{{ route('dashboard.role.index') }}" @class([
        'side-menu',
        'side-menu--active' => request()->routeIs('dashboard.role.*'),
        ])>
        <div class="side-menu__icon"><i data-feather="lock"></i></div>
        <div class="side-menu__title"> {{ __('sidebar.roles') }} </div>
        </a>
    </li>

    </ul>
    </li>

    <li>
        <a href="{{ route('dashboard.city.index') }}" @class([
        'side-menu',
        'side-menu--active' =>
        request()->routeIs('dashboard.city.*') ||
        request()->routeIs('dashboard.neighborhood.*'),
        ])>
        <div class="side-menu__icon"><i data-feather="map-pin"></i></div>
        <div class="side-menu__title">
            {{ __('sidebar.cities') }}
        </div>
        </a>
    </li>
    <li>
        <a href="javascript:;" @class([
        'side-menu',
        'side-menu--active' =>
        request()->routeIs('dashboard.category.*') ||
        request()->routeIs('dashboard.featured-category.*'),
        ' side-menu--open' =>
        request()->routeIs('dashboard.category.*') ||
        request()->routeIs('dashboard.featured-category.*'),
        ])>
        <div class="side-menu__icon">
            <i data-feather="bookmark"></i>
        </div>
        <div class="side-menu__title">
            {{ __('sidebar.categories') }}
            <div class="side-menu__sub-icon ">
                <i data-feather="chevron-down"></i>
            </div>
        </div>
        </a>
        <ul @class([
        'side-menu__sub-open' =>
        request()->routeIs('dashboard.category.*') ||
        request()->routeIs('dashboard.featured-category.*'),
        ])>
    <li>
        <a href="{{ route('dashboard.category.index') }}" @class([
        'side-menu',
        'side-menu--active' => request()->routeIs('dashboard.category.*'),
        ])>
        <div class="side-menu__icon"><i data-feather="bookmark"></i></div>
        <div class="side-menu__title"> {{ __('sidebar.categories') }} </div>
        </a>
    </li>
    <li>
        <a href="{{ route('dashboard.featured-category.index') }}" @class([
        'side-menu',
        'side-menu--active' => request()->routeIs('dashboard.featured-category.*'),
        ])>
        <div class="side-menu__icon"><i data-feather="bookmark"></i></div>
        <div class="side-menu__title"> {{ __('sidebar.featured_categories') }} </div>
        </a>
    </li>
    </ul>
    </li>
    <li>
        <a href="javascript:;" @class([
        'side-menu',
        'side-menu--active' =>
        request()->routeIs('dashboard.ad.unlicensed') ||
        request()->routeIs('dashboard.ad.*'),
        ' side-menu--open' =>
        request()->routeIs('dashboard.ad.unlicensed') ||
        request()->routeIs('dashboard.ad.*'),
        ])>
        <div class="side-menu__icon">
            <i data-feather="map-pin"></i>
        </div>
        <div class="side-menu__title">
            {{ __('sidebar.ads') }}
            <div class="side-menu__sub-icon ">
                <i data-feather="chevron-down"></i>
            </div>
        </div>
        </a>
        <ul @class([
        'side-menu__sub-open' =>
        request()->routeIs('dashboard.ad.unlicensed') ||
        request()->routeIs('dashboard.ad.*'),
        ])>

    <li>
        <a href="{{ route('dashboard.ad.index') }}" @class([
        'side-menu',
        'side-menu--active' => request()->routeIs('dashboard.ad.*'),
        ])>
        <div class="side-menu__icon"><i data-feather="map-pin"></i></div>
        <div class="side-menu__title"> {{ __('sidebar.estates') }} </div>
        </a>
    </li>
    <li>
        <a href="{{ route('dashboard.ad.unlicensed') }}" @class([
        'side-menu',
        'side-menu--active' => request()->routeIs('dashboard.ad.unlicensed'),
        ])>
        <div class="side-menu__icon"><i data-feather="map-pin"></i></div>
        <div class="side-menu__title"> {{ __('sidebar.unlicensed-ads') }} </div>
        </a>
    </li>
    </ul>
    </li>
    <li>
        {{--
--}}
        <a href="javascript:;" @class([
        'side-menu',
        'side-menu--active' =>
        request()->routeIs('dashboard.ad-license-requests-completed.index') ||
        request()->routeIs('dashboard.ad-license-requests-pending.index'),
        ' side-menu--open' =>
        request()->routeIs('dashboard.ad-license-requests-completed.index') ||
        request()->routeIs('dashboard.ad-license-requests-pending.index'),
        ])>
        <div class="side-menu__icon">
            <i data-feather="map-pin"></i>
        </div>
        <div class="side-menu__title">
            {{ __('sidebar.ad-license-requests') }}
            <div class="side-menu__sub-icon ">
                <i data-feather="chevron-down"></i>
            </div>
        </div>
        </a>
        <ul @class([
        'side-menu__sub-open' =>
        request()->routeIs('dashboard.ad-license-requests-completed.index') ||
        request()->routeIs('dashboard.ad-license-requests-pending.index'),
        ])>
    {{-- completed
pending --}}
    <li>
        <a href="{{ route('dashboard.ad-license-requests-pending.index') }}" @class([
        'side-menu',
        'side-menu--active' => request()->routeIs(
        'dashboard.ad-license-requests-pending.index'),
        ])>
        <div class="side-menu__icon"><i data-feather="map-pin"></i></div>
        <div class="side-menu__title"> {{ __('sidebar.pending') }} </div>
        </a>
    </li>
    <li>
        <a href="{{ route('dashboard.ad-license-requests-completed.index') }}"
           @class([
        'side-menu',
        'side-menu--active' => request()->routeIs(
        'dashboard.ad-license-requests-completed.*'),
        ])>
        <div class="side-menu__icon"><i data-feather="x-circle"></i></div>
        <div class="side-menu__title"> {{ __('sidebar.completed') }} </div>
        </a>
    </li>
    </ul>
    </li>
    <li>
        <a href="javascript:;" @class([
        'side-menu',
        'side-menu--active' =>
        request()->routeIs('dashboard.ad-visit.*') ||
        request()->routeIs('dashboard.ad-report.*') ||
        request()->routeIs('dashboard.ad-filter.*') ||
        request()->routeIs('dashboard.ad-request.*'),
        ' side-menu--open' =>
        request()->routeIs('dashboard.ad-visit.*') ||
        request()->routeIs('dashboard.ad-report.*') ||
        request()->routeIs('dashboard.ad-filter.*') ||
        request()->routeIs('dashboard.ad-request.*'),
        ])>
        <div class="side-menu__icon">
            <i data-feather="map-pin"></i>
        </div>
        <div class="side-menu__title">
            {{ __('sidebar.other-ads-settings') }}
            <div class="side-menu__sub-icon ">
                <i data-feather="chevron-down"></i>
            </div>
        </div>
        </a>
        <ul @class([
        'side-menu__sub-open' =>
        request()->routeIs('dashboard.ad-visit.*') ||
        request()->routeIs('dashboard.ad-report.*') ||
        request()->routeIs('dashboard.ad-filter.*') ||
        request()->routeIs('dashboard.ad-request.*'),
        ])>
    {{-- <li>
        <a href="{{ route('dashboard.ad-request.index') }}" @class([
            'side-menu',
            'side-menu--active' => request()->routeIs('dashboard.ad-request.*'),
        ])>
            <div class="side-menu__icon"> <i data-feather="map-pin"></i> </div>
            <div class="side-menu__title"> {{ __('sidebar.ad-request') }} </div>
        </a>
    </li> --}}
    {{-- <li>
        <a href="{{ route('dashboard.ad-report.index') }}" @class([
            'side-menu',
            'side-menu--active' => request()->routeIs('dashboard.ad-report.*'),
        ])>
            <div class="side-menu__icon"> <i data-feather="x-circle"></i> </div>
            <div class="side-menu__title"> {{ __('sidebar.reports') }} </div>
        </a>
    </li> --}}
    <li>
        <a href="{{ route('dashboard.ad-visit.index') }}" @class([
        'side-menu',
        'side-menu--active' => request()->routeIs('dashboard.ad-visit.*'),
        ])>
        <div class="side-menu__icon"><i data-feather="file-text"></i></div>
        <div class="side-menu__title"> {{ __('sidebar.visits') }} </div>
        </a>
    <li>
        <a href="{{ route('dashboard.ad-filter.index') }}" @class([
        'side-menu',
        'side-menu--active' => request()->routeIs('dashboard.ad-filter.*'),
        ])>
        <div class="side-menu__icon"><i data-feather="file-text"></i></div>
        <div class="side-menu__title"> {{ __('sidebar.ad-filters') }} </div>
        </a>
    </li>


    </ul>
    </li>
    <li>
        <a href="{{ route('dashboard.mortgage.index') }}" @class([
        'side-menu',
        'side-menu--active' => request()->routeIs('dashboard.mortgage.*'),
        ])>
        <div class="side-menu__icon">
            <i data-feather="box"></i>
        </div>
        <div class="side-menu__title">
            {{ __('breadcrumbs.mortgage') }}
        </div>
        </a>
    </li>
    <li>
        <a href="javascript:;" @class([
        'side-menu',
        'side-menu--active' =>
        request()->routeIs('dashboard.package.*') ||
        request()->routeIs('dashboard.owner-package.*') ||
        request()->routeIs('dashboard.company-package.*') ||
        request()->routeIs('dashboard.marketer-package.*'),
        ' side-menu--open' =>
        request()->routeIs('dashboard.package.*') ||
        request()->routeIs('dashboard.owner-package.*') ||
        request()->routeIs('dashboard.company-package.*') ||
        request()->routeIs('dashboard.marketer-package.*'),
        ])>
        <div class="side-menu__icon">
            <i data-feather="map-pin"></i>
        </div>
        <div class="side-menu__title">
            {{ __('sidebar.packages') }}
            <div class="side-menu__sub-icon ">
                <i data-feather="chevron-down"></i>
            </div>
        </div>
        </a>
        <ul @class([
        'side-menu__sub-open' =>
        request()->routeIs('dashboard.package.*') ||
        request()->routeIs('dashboard.owner-package.*') ||
        request()->routeIs('dashboard.company-package.*') ||
        request()->routeIs('dashboard.marketer-package.*'),
        ])>

    {{-- <li>
        <a href="{{ route('dashboard.package.index') }}" @class([
            'side-menu',
            'side-menu--active' => request()->routeIs('dashboard.package.*'),
        ])>
            <div class="side-menu__icon"> <i data-feather="map-pin"></i> </div>
            <div class="side-menu__title"> {{ __('sidebar.packages') }} </div>
        </a>
    </li> --}}
    <li>
        <a href="{{ route('dashboard.owner-package.index') }}" @class([
        'side-menu',
        'side-menu--active' => request()->routeIs('dashboard.owner-package.*'),
        ])>
        <div class="side-menu__icon"><i data-feather="map-pin"></i></div>
        <div class="side-menu__title"> {{ __('sidebar.owner-packages') }} </div>
        </a>
    </li>
    <li>
        <a href="{{ route('dashboard.marketer-package.index') }}" @class([
        'side-menu',
        'side-menu--active' => request()->routeIs('dashboard.marketer-package.*'),
        ])>
        <div class="side-menu__icon"><i data-feather="map-pin"></i></div>
        <div class="side-menu__title"> {{ __('sidebar.marketer-packages') }} </div>
        </a>
    </li>
    <li>
        <a href="{{ route('dashboard.company-package.index') }}" @class([
        'side-menu',
        'side-menu--active' => request()->routeIs('dashboard.company-package.*'),
        ])>
        <div class="side-menu__icon"><i data-feather="map-pin"></i></div>
        <div class="side-menu__title"> {{ __('sidebar.company-packages') }} </div>
        </a>
    </li>
    <li>
        <a href="{{ route('dashboard.ad-feature-package.index') }}" @class([
        'side-menu',
        'side-menu--active' => request()->routeIs('dashboard.ad-feature-package.*'),
        ])>
        <div class="side-menu__icon"><i data-feather="map-pin"></i></div>
        <div class="side-menu__title"> {{ __('sidebar.ad-feature-package') }} </div>
        </a>
    </li>

    </ul>
    </li>


    <li>
        <a href="{{ route('dashboard.coupon.index') }}" @class([
        'side-menu',
        'side-menu--active' => request()->routeIs('dashboard.coupon.*'),
        ])>
        <div class="side-menu__icon"><i data-feather="box"></i></div>
        <div class="side-menu__title">
            {{ __('breadcrumbs.coupon') }}
        </div>
        </a>
    </li>
    <li>
        <a href="{{ route('dashboard.transaction.index') }}" @class([
        'side-menu',
        'side-menu--active' => request()->routeIs('dashboard.transaction.*'),
        ])>
        <div class="side-menu__icon"><i data-feather="box"></i></div>
        <div class="side-menu__title">
            {{ __('sidebar.transactions') }}
        </div>
        </a>
    </li>
    <li>
        <a href="{{ route('dashboard.package_bills.index') }}" @class([
        'side-menu',
        'side-menu--active' => request()->routeIs('dashboard.package_bills.*'),
        ])>
        <div class="side-menu__icon"><i data-feather="box"></i></div>
        <div class="side-menu__title">
            {{ __('sidebar.package_bills') }}
        </div>
        </a>
    </li>
    <li>
        <a href="{{ route('dashboard.banner.index') }}" @class([
        'side-menu',
        'side-menu--active' => request()->routeIs('dashboard.banner.*'),
        ])>
        <div class="side-menu__icon"><i data-feather="box"></i></div>
        <div class="side-menu__title">
            {{ __('sidebar.banners') }}
        </div>
        </a>
    </li>
    <li>
        <a href="{{ route('dashboard.customer-message.index') }}" @class([
        'side-menu',
        'side-menu--active' => request()->routeIs('dashboard.customer-message.*'),
        ])>
        <div class="side-menu__icon"><i data-feather="box"></i></div>
        <div class="side-menu__title">
            {{ __('sidebar.customer-messages') }}
        </div>
        </a>
    </li>
    <li>
        <a href="{{ route('dashboard.bot-question.index') }}" @class([
        'side-menu',
        'side-menu--active' => request()->routeIs('dashboard.bot-question.*'),
        ])>
        <div class="side-menu__icon"><i data-feather="inbox"></i></div>
        <div class="side-menu__title">
            {{ __('sidebar.bot-question') }}
        </div>
        </a>
    </li>
    <li>
        <a href="javascript:;" @class([
        'side-menu',
        'side-menu--active' => request()->routeIs('dashboard.page.*'),
        ' side-menu--open' => request()->routeIs('dashboard.page.*'),
        ])>
        <div class="side-menu__icon">
            <i data-feather="layout"></i>
        </div>
        <div class="side-menu__title">
            {{ __('sidebar.pages') }}
            <div class="side-menu__sub-icon ">
                <i data-feather="chevron-down"></i>
            </div>
        </div>
        </a>
        <ul @class([
        'side-menu__sub-open' => request()->routeIs('dashboard.page.*'),
        ])>
    @foreach (__('pages') as $page => $value)
        <li>
            <a href="{{ route('dashboard.page.edit', ['page' => $page]) }}" @class([
            'side-menu',
            'side-menu--active' => request()->routeIs('dashboard.page.*'),
            ])>
            <div class="side-menu__icon"><i data-feather="layout"></i></div>
            <div class="side-menu__title"> {{ $value }} </div>
            </a>
        </li>
        @endforeach
        </ul>
        </li>

        <li>
            <a href="javascript:;" @class([
            'side-menu',
            'side-menu--active' =>
            request()->routeIs('dashboard.settings-apis.*') ||
            request()->routeIs('dashboard.settings-app.*') ||
            request()->routeIs('dashboard.settings-contact-us.*') ||
            request()->routeIs('dashboard.settings-auction.*') ||
            request()->routeIs('dashboard.settings-free-package.*') ||
            request()->routeIs('dashboard.settings-ad-feature.*'),
            ' side-menu--open' =>
            request()->routeIs('dashboard.settings-apis.*') ||
            request()->routeIs('dashboard.settings-app.*') ||
            request()->routeIs('dashboard.settings-contact-us.*') ||
            request()->routeIs('dashboard.settings-auction.*') ||
            request()->routeIs('dashboard.settings-free-package.*') ||
            request()->routeIs('dashboard.settings-ad-feature.*'),
            ])>
            <div class="side-menu__icon">
                <i data-feather="layout"></i>
            </div>
            <div class="side-menu__title">
                {{ __('sidebar.settings') }}
                <div class="side-menu__sub-icon ">
                    <i data-feather="chevron-down"></i>
                </div>
            </div>
            </a>
            <ul @class([
            'side-menu__sub-open' =>
            request()->routeIs('dashboard.settings-apis.*') ||
            request()->routeIs('dashboard.settings-app.*') ||
            request()->routeIs('dashboard.settings-contact-us.*') ||
            request()->routeIs('dashboard.settings-auction.*') ||
            request()->routeIs('dashboard.settings-free-package.*') ||
            request()->routeIs('dashboard.settings-ad-license.*'),
            ])>

        <li>
            <a href="{{ route('dashboard.settings-apis.index') }}" @class([
            'side-menu',
            'side-menu--active' => request()->routeIs('dashboard.settings-apis.*'),
            ])>
            <div class="side-menu__icon"><i data-feather="settings"></i></div>
            <div class="side-menu__title"> {{ __('breadcrumbs.settings-apis') }} </div>
            </a>
        </li>
        <li>
            <a href="{{ route('dashboard.settings-contact-us.index') }}" @class([
            'side-menu',
            'side-menu--active' => request()->routeIs(
            'dashboard.settings-contact-us.*'),
            ])>
            <div class="side-menu__icon"><i data-feather="settings"></i></div>
            <div class="side-menu__title"> {{ __('breadcrumbs.settings-contact-us') }} </div>
            </a>
        </li>
        <li>
            <a href="{{ route('dashboard.settings-auction.index') }}" @class([
            'side-menu',
            'side-menu--active' => request()->routeIs('dashboard.settings-auction.*'),
            ])>
            <div class="side-menu__icon"><i data-feather="settings"></i></div>
            <div class="side-menu__title"> {{ __('breadcrumbs.settings-auction') }} </div>
            </a>
        </li>
        <li>
            <a href="{{ route('dashboard.settings-app.index') }}" @class([
            'side-menu',
            'side-menu--active' => request()->routeIs('dashboard.settings-app.*'),
            ])>
            <div class="side-menu__icon"><i data-feather="settings"></i></div>
            <div class="side-menu__title"> {{ __('breadcrumbs.settings-app') }} </div>
            </a>
        </li>
        <li>
            <a href="{{ route('dashboard.settings-ad-license.index') }}" @class([
            'side-menu',
            'side-menu--active' => request()->routeIs(
            'dashboard.settings-ad-license.*'),
            ])>
            <div class="side-menu__icon"><i data-feather="settings"></i></div>
            <div class="side-menu__title"> {{ __('breadcrumbs.settings-ad-license') }} </div>
            </a>
        </li>
        <li>
            <a href="{{ route('dashboard.settings-free-package.index') }}" @class([
            'side-menu',
            'side-menu--active' => request()->routeIs(
            'dashboard.settings-free-package.*'),
            ])>
            <div class="side-menu__icon"><i data-feather="settings"></i></div>
            <div class="side-menu__title"> {{ __('breadcrumbs.settings-free-package') }} </div>
            </a>
        </li>
        </ul>
        </li>
        <li>
            <a href="{{ route('dashboard.seo.index') }}" @class([
            'side-menu',
            'side-menu--active' => request()->routeIs('dashboard.seo.*'),
            ])>
            <div class="side-menu__icon"><i data-feather="box"></i></div>
            <div class="side-menu__title">
                {{ __('sidebar.seo') }}
            </div>
            </a>
        </li>
        </ul>
</nav>
