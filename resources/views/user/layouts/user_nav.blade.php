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

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="{{route('customer_copy.index')}}" id="topnav-dashboard" role="button">
                            <i class="bx bx-home-circle me-2"></i><span key="t-dashboards">@lang('translation.client_copy')</span>
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" id="topnav-pages" role="button">
                            <i class="bx bx-customize me-2"></i><span key="t-apps">@lang('translation.new_application')</span>
                            <div class="arrow-down"></div>
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

                    {{--<li class="nav-item dropdown">
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
                        <a class="nav-link dropdown-toggle arrow-none" href="{{ route('feedback_create') }}" id="topnav-components" role="button">
                            <i class="bx bx-collection me-2"></i><span key="t-components">@lang('translation.feedback')</span>
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="{{ route('contact') }}" id="topnav-more" role="button">
                            <i class="bx bx-file me-2"></i><span key="t-extra-pages">@lang('translation.contact')</span>
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="{{ route('noc_verify') }}" id="topnav-layout" role="button">
                            <i class="bx bx-layout me-2"></i><span key="t-layouts">@lang('translation.noc_verify')</span>
                        </a>
                    </li>

                </ul>
            </div>
        </nav>
    </div>
</div>
