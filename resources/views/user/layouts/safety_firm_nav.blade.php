
<div class="topnav">
    <div class="container-fluid">
        <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

            <div class="collapse navbar-collapse justify-content-center" id="topnav-menu-content">
                <ul class="navbar-nav">

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="{{ route('safety-firm-dashboard') }}" id="topnav-dashboard" role="button">
                            <i class="bx bx-home-circle me-2"></i><span key="t-dashboards">@lang('safety_firm.dashboard')</span>
                        </a>
                    </li>

                    @if(@auth()->user()->company->id)
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="{{ route('safety-firm-owner') }}" id="topnav-dashboard" role="button">
                                <i class="bx bx-home-circle me-2"></i><span key="t-company">@lang('safety_firm.company')</span>
                            </a>
                        </li>

                        @if(@auth()->user()->company->status == 'Active')
                            <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown"  id="topnav-pages" role="button">
                                <i class="bx bx-customize me-2"></i><span >@lang('safety_firm.tools')</span>
                                <div class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="topnav-dashboard">
                                <a href="{{ route('safety_firm_users.index') }}" class="dropdown-item" key="t-engineer">@lang('safety_firm.user')</a>
                                <a href="{{ route('safety_firm_inactive_users') }}" class="dropdown-item" key="t-iengineer">@lang('safety_firm.inactive_user')</a>
                            </div>
                        </li>
                        @endif
                    @endif

                    @if(@auth()->user()->company->status == 'Active' || @auth()->user()->safety_firm->status == 'Active' )
                        <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" id="topnav-pages" role="button">
                            <i class="bx bx-customize me-2"></i><span key="t-apps">@lang('safety_firm.application')</span>
                            <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-dashboard">
                            <a href="{{ route('application.create',['type' => 'proposed']) }}" class="dropdown-item" key="t-proposed">@lang('safety_firm.proposed')</a>
                            <a href="{{ route('application.create',['type' => 'existing']) }}" class="dropdown-item" key="t-existing">@lang('safety_firm.existing')</a>
                            <a class="dropdown-item" href="{{ route('application.index') }}">
                                <span key="t-applicatiopn-history">@lang('safety_firm.application_list')</span>
                            </a>
                            <a class="dropdown-item" href="{{route('safety_firm.pending_application')}}">
                                <span key="t-par">@lang('safety_firm.pending_application_request')</span>
                            </a>
                        </div>
                    </li>
                    @endif
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="{{route('customer_copy.index')}}" id="topnav-dashboard" role="button">
                            <i class="bx bx-home-circle me-2"></i><span key="t-customer-copy">@lang('translation.client_copy')</span>
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="javascript:" id="topnav-more" role="button">
                            <i class="bx bx-file me-2"></i><span key="t-about">@lang('safety_firm.about')</span>
                        </a>
                    </li>

                    {{--<li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#faq" id="topnav-pages" role="button">
                            <i class="bx bx-customize me-2"></i><span key="t-apps">FAQ</span>
                        </a>
                    </li>--}}

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="{{ route('feedback_create') }}" id="topnav-components" role="button">
                            <i class="bx bx-collection me-2"></i><span key="t-feedback">@lang('translation.feedback')</span>
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="{{ route('contact') }}" id="topnav-more" role="button">
                            <i class="bx bx-file me-2"></i><span key="t-contact">@lang('translation.contact')</span>
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="{{ route('noc_verify') }}" id="topnav-layout" role="button">
                            <i class="bx bx-layout me-2"></i><span key="t-noc-verify">@lang('translation.noc_verify')</span>
                        </a>
                    </li>

                </ul>
            </div>
        </nav>
    </div>
</div>
