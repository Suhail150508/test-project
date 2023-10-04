<nav class="navbar navbar-light navbar-expand-lg topnav-menu">

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-center" id="topnav-menu-content">
        <ul class="navbar-nav">

            <li>
                <a href="/" class="logo-dark">
                    <span class="logo-sm">
                        <img src="{{ asset('assets/common/images/logo/logo-fsc-noc.png') }}" alt="" height="35">
                    </span>
                </a>
            </li>

            {{--<li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-pages" role="button">
                    <i class="bx bx-customize me-2"></i><span key="t-apps">@lang('translation.faq')</span>
                </a>
            </li>--}}

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle arrow-none" href="{{ route('email_verify') }}" id="topnav-components" role="button">
                    <i class="fa fa-envelope"></i><span key="t-components"> @lang('translation.email_verify')</span>
                </a>
            </li>

            {{--<li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle arrow-none" href="{{ route('contact') }}" id="topnav-more" role="button">
                    <i class="bx bx-file me-2"></i><span key="t-extra-pages">@lang('translation.contact')</span>
                </a>
            </li>--}}


        </ul>
    </div>
</nav>
