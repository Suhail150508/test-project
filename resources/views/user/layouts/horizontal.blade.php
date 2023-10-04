<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">

            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="/" class="logo logo-dark">
                    <span class="text-success font-size-14" style="align-self: center;">@lang('settings.website_title_short_3')</span>
                    <span class="logo-sm">
                        <img src="{{ URL::asset('assets/common/images/logo/logo-fsc-noc.png') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ URL::asset('assets/common/images/logo/logo-fsc-noc.png') }}" alt="" height="50">
                    </span>
                </a>

                <a href="/" class="logo logo-light">
                    <span class="text-success font-size-14" style="align-self: center;">@lang('settings.website_title_short_3')</span>
                    <span class="logo-sm">
                        <img src="{{ URL::asset('assets/common/images/logo/logo-fsc-noc.png') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ URL::asset('assets/common/images/logo/logo-fsc-noc.png') }}" alt="" height="50">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 d-lg-none header-item waves-effect waves-light" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                <i class="fa fa-fw fa-bars"></i>
            </button>

        </div>

        <div class="d-flex align-items-center">

            @if(Auth::user()->user_type == 'admin')
                <div class="dropdown d-lg-inline-block ms-1 mt-2">
                    {{--module toggle switch--}}
                    <label class="switch">
                        <input type="checkbox" id="togBtn">
                        <div class="slider round">
                            <!--ADDED HTML -->
                            <span class="on">User <i class="fa fa-arrow-right fa-1x"></i></span>
                            <span class="off">Admin <i class="fa fa-arrow-right fa-1x"></i></span>
                            <!--END-->
                        </div>
                    </label>
                </div>
            @endif

{{--            @if(Auth::user()->user_type == 'safety_firm')--}}
{{--                <div class="dropdown d-lg-inline-block ms-1 mt-2">--}}
{{--                    --}}{{--module toggle switch--}}
{{--                    <label class="switch">--}}
{{--                        <input type="checkbox" id="safety_btn">--}}
{{--                        <div class="slider round">--}}
{{--                            <!--ADDED HTML -->--}}
{{--                            <span class="on">User <i class="fa fa-arrow-right fa-1x"></i></span>--}}
{{--                            <span class="off">Firm <i class="fa fa-arrow-right fa-1x"></i></span>--}}
{{--                            <!--END-->--}}
{{--                        </div>--}}
{{--                    </label>--}}
{{--                </div>--}}
{{--            @endif--}}

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
                <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="bx bx-bell @if(Auth::user()->unreadNotifications->count() > 0) bx-tada @endif"></i>
                    @if(Auth::user()->unreadNotifications->count() > 0)
                        <span class="badge bg-success rounded-pill">{{ Auth::user()->unreadNotifications->count() }}</span>
                    @elseif(Auth::user()->notifications->count() > 0)
                        <span class="badge bg-secondary rounded-pill">{{ Auth::user()->notifications->count() }}</span>
                    @endif
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                     aria-labelledby="page-header-notifications-dropdown">
                    <div class="p-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0" key="t-notifications"> @lang('translation.Notifications') </h6>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('user-notification-mark-all-as-read') }}" class="small" key="t-view-all">@lang('translation.mark_all_as_read')</a>
                            </div>
                        </div>
                    </div>
                    <div data-simplebar style="max-height: 230px;">
                        @foreach($notifications as $key => $notification)
                            <a href="{{ route('user-notification-show',$notification->id) }}" class="text-reset notification-item">
                                <div class="media @if($notification->read_at == null) bg-success @endif" style="margin: 2px; border: solid lightblue 1px;">
                                    <div class="avatar-xs me-3">
                                    <span class="avatar-title bg-primary rounded-circle font-size-16">
                                        <i class="bx bx-alarm"></i>
                                    </span>
                                    </div>
                                    <div class="media-body">
                                        <h6 class="mt-0 mb-1" key="t-your-order">{{ $notification->data['text'] }}</h6>
                                        <div class="font-size-12 @if($notification->read_at == null) text-white @endif">
                                            <p class="mb-1" key="t-grammer">{{ $notification->data['body'] }}</p>
                                            <p class="mb-0 text-muted"><i class="mdi mdi-clock-outline"></i> <span key="t-min-ago">{{ $notification->created_at->format('d-m-Y H-i-s a') }}</span></p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    <div class="p-2 border-top d-grid">
                        <a class="btn btn-sm btn-link font-size-14 text-center" href="{{ route('user-notifications') }}">
                            <i class="mdi mdi-arrow-right-circle me-1"></i> <span key="t-view-more">@lang('translation.View_All')</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="{{ URL::asset('/assets/common/images/users/avatar-1.png') }}"
                        alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1" key="t-henry">{{ Auth::user()->bn_name }}</span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="{{ route('user-profile') }}">
                        <i class="bx bx-user font-size-16 align-middle me-1"></i>
                        <span key="t-profile">@lang('translation.Profile')</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="javascript:void(0);" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span key="t-logout">@lang('translation.Logout')</span></a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>

        </div>
    </div>
</header>

@if(auth()->user()->safety_firm_id)
    @include('user.layouts.safety_firm_nav')
@else
    @include('user.layouts.user_nav')
@endif

