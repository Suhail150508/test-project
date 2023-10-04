<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">

            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="" class="logo logo-dark">
                    <span class="text-success font-size-14" style="align-self: center;">@lang('settings.website_title_short_3')</span>
                    <span class="logo-sm">
                        <img src="{{ asset('assets/common/images/logo/logo-fsc-noc.png') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('assets/common/images/logo/logo-fsc-noc.png') }}" alt="" height="50">
                    </span>
                </a>

                <a href="" class="logo logo-light">
                    <span class="text-success font-size-14" style="align-self: center;">@lang('settings.website_title_short_3')</span>
                    <span class="logo-sm">
                        <img src="{{ asset('assets/common/images/logo/logo-fsc-noc.png') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('assets/common/images/logo/logo-fsc-noc.png') }}" alt="" height="50">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 d-lg-none header-item waves-effect waves-light" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                <i class="fa fa-fw fa-bars"></i>
            </button>

        </div>

        <div class="d-flex">

            <div class="dropdown d-inline-block d-lg-none ml-2">
                <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="mdi mdi-magnify"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-search-dropdown">

                    <form class="p-3">
                        <div class="form-group m-0">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="@lang('translation.Search')" aria-label="Search input">

                                <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>s
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="dropdown d-inline-block">
                <a href="{{ route('login') }}" type="button" class="btn mt-2 header-item waves-effect">
                    <img class="rounded-circle header-profile-user" src="{{ isset(Auth::user()->avatar) ? asset(Auth::user()->avatar) : asset('/assets/common/images/users/avatar-1.png') }}" alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1" key="t-henry">
                        @auth
                            {{ Auth::user()->bn_name }} @lang('translation.dashboard')
                        @else
                            @lang('translation.Login')
                        @endauth
                    </span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </a>
<!--                <div class="dropdown-menu dropdown-menu-end">
                    &lt;!&ndash; item&ndash;&gt;
                    <a class="dropdown-item" href="{{ route('login') }}"><i class="bx bx-user font-size-16 align-middle me-1"></i> <span key="t-profile">@lang('translation.Login')</span></a>
                </div>-->
            </div>

        </div>
    </div>
</header>

<div class="topnav">
    <div class="container-fluid">
        <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

            <div class="collapse navbar-collapse justify-content-center" id="topnav-menu-content">
                <ul class="navbar-nav">

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="/" id="topnav-dashboard" role="button">
                            <i class="bx bx-home-circle me-2"></i><span key="t-dashboards">@lang('translation.dashboard')</span>
                        </a>
                    </li>

                    {{--<li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-dashboard" role="button">
                            <i class="bx bx-home-circle me-2"></i><span key="t-dashboards">@lang('translation.client_copy')</span>
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-pages" role="button">
                            <i class="bx bx-customize me-2"></i><span key="t-apps">@lang('translation.new_application')</span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-dashboard">
                            <a href="{{ route('application.create',['type' => 'proposed']) }}" class="dropdown-item" key="t-default">@lang('translation.new_application_proposed')</a>
                            <a href="{{ route('application.create',['type' => 'existing']) }}" class="dropdown-item" key="t-saas">@lang('translation.new_application_existing')</a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="{{ route('application.index') }}" id="topnav-more" role="button">
                            <i class="bx bx-file me-2"></i><span key="t-extra-pages">@lang('translation.application_list')</span>
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-components" role="button">
                            <i class="bx bx-collection me-2"></i><span key="t-components">@lang('translation.notice')</span>
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-pages" role="button">
                            <i class="bx bx-customize me-2"></i><span key="t-apps">@lang('translation.faq')</span>
                        </a>
                    </li>--}}



                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="{{ route('contact') }}" id="topnav-more" role="button">
                            <i class="bx bx-file me-2"></i><span key="t-extra-pages">@lang('translation.contact')</span>
                        </a>
                    </li>



                </ul>
            </div>
        </nav>
    </div>
</div>
