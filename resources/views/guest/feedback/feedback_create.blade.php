@extends('guest.layouts.master-without-nav')

@section('title')
    @lang('login.label_login')
@endsection

@section('css')
    .application_rules{
        @if(config('app.locale') == 'en')
            list-style: decimal;
        @else
             list-style: bengali;
        @endif

        text-align: justify;
    }

    .left_side_part,.left_side_part h4{
        color: #fff;
    }

    .left_side_part a{
        color: #49f112;
    }
    .bg-fsc-blur{
        background: url(../assets/common/images/login-background-blurred.jpg);
        background-size: cover;
        background-repeat: no-repeat;
        background-position: 50%;
    }
@endsection

@section('body')


    <body class="auth-body-bg">

    <div class="bg-light">
        <div class="container-fluid">
            <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-center" id="topnav-menu-content">
                    <ul class="navbar-nav">

                        <li>
                            <a href="/" class="logo-dark">
                                <span class="logo-sm">
                                    <img src="{{ URL::asset('assets/common/images/logo/logo-fsc-noc.png') }}" alt="" height="35">
                                </span>
                            </a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="/" id="topnav-dashboard" role="button">
                                <i class="bx bx-home-circle me-2"></i><span key="t-dashboards">@lang('translation.dashboard')</span>
                            </a>
                        </li>

                        {{--<li class="nav-item dropdown">
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

    <div class="marquee font-size-15">
        <p style="margin-left: 35px;">
            @foreach($notices as $notice)
                {{ $notice->notice }}&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
            @endforeach
        </p>
    </div>

    @endsection

    @section('content')

        <div class="container-fluid p-0">

            <div class="row g-0 container-row">

                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 bg-fsc-blur">
                    {{ Form::open(['url' => route('feedback_store'), 'method' => 'post','class' => 'custom-validation']) }}
                        @include('guest.feedback.form')
                    {{ Form::close() }}

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif

                </div>
                <!-- end col -->

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 order-first order-sm-first order-md-last order-lg-last order-xl-last">
                    <div class="auth-full-page-content px-md-5 py-md-4 px-4 py-4">
                        <div class="w-100">

                            <div class="d-flex flex-column h-100">
                                <div class="mb-4 mb-md-5 text-center">
                                    <a href="/" class="d-block auth-logo">
                                        <img src="{{ URL::asset('assets/common/images/logo/logo-fsc-noc.png') }}" alt="" height="75">
                                    </a>
                                    <span class="mt-2 text-success font-size-16">
                                        @lang('settings.website_title')
                                    </span>
                                </div>
                                <div class="my-auto">

                                    {{--<div>
                                        <p class="text-muted">@lang('auth.header_info_1')  @lang('login.header_info_2')
                                            <a href="{{route('register')}}"><b>@lang('auth.header_registration_link_click')</b></a> @lang('login.header_registration_do')</p>
                                    </div>--}}

                                    @guest
                                        <div class="mt-4">
                                            <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="login" class="form-label">@lang('auth.label_email')</label>
                                                    <input name="login" type="text"
                                                           class="form-control {{ $errors->has('username') || $errors->has('email') ? ' is-invalid' : '' }}"
                                                           value="{{ old('username') ?: old('email') }}" id="username"
                                                           placeholder="@lang('auth.label_email_placeholder')" autocomplete="email" autofocus>
                                                    @if ($errors->has('username') || $errors->has('email'))
                                                        <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('username') ?: $errors->first('email') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>

                                                <div class="mb-3">
                                                    <div class="float-end">
                                                        @if (Route::has('password.request'))
                                                            <a href="{{ route('password.request') }}"
                                                               class="text-muted">@lang('auth.label_forgot_password')</a>
                                                        @endif
                                                    </div>
                                                    <label class="form-label">@lang('auth.label_password')</label>
                                                    <div
                                                            class="input-group auth-pass-inputgroup @error('password') is-invalid @enderror">
                                                        <input type="password" name="password"
                                                               class="form-control  @error('password') is-invalid @enderror"
                                                               id="userpassword" value="" placeholder="@lang('auth.label_password_placeholder')"
                                                               aria-label="Password" aria-describedby="password-addon">
                                                        <button class="btn btn-light " type="button" id="password-addon"><i
                                                                    class="mdi mdi-eye-outline"></i></button>
                                                        @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="remember"
                                                            {{ old('remember') ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="remember">
                                                        @lang('login.label_remember_me')
                                                    </label>
                                                </div>

                                                <div class="mt-3 d-grid">
                                                    <button class="btn btn-primary waves-effect waves-light"
                                                            type="submit">@lang('auth.label_login')</button>
                                                </div>

                                                {{--<div class="mt-4 text-center">
                                                    <h5 class="font-size-14 mb-3">Sign in with</h5>

                                                    <ul class="list-inline">
                                                        <li class="list-inline-item">
                                                            <a href="#"
                                                                class="social-list-item bg-primary text-white border-primary">
                                                                <i class="mdi mdi-facebook"></i>
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <a href="#"
                                                                class="social-list-item bg-info text-white border-info">
                                                                <i class="mdi mdi-twitter"></i>
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <a href="#"
                                                                class="social-list-item bg-danger text-white border-danger">
                                                                <i class="mdi mdi-google"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>--}}
                                            </form>
                                            <div class="mt-5 text-center">
                                                <p>{{--@lang('auth.label_no_account') --}}<a href="{{route('register')}}"
                                                                                             class="fw-medium text-primary"> @lang('login.label_create_new_account') </a> </p>
                                            </div>
                                        </div>
                                    @else
                                        <div class="text-center">
                                            @if(Auth::user()->user_type === 'admin')
                                                <a class="btn btn-info waves-effect" href="{{ route('dashboard') }}">@lang('dashboard.noc_dashboard')</a>
                                            @elseif(Auth::user()->user_type === 'user')
                                                <a class="btn btn-info waves-effect" href="{{ route('user-dashboard') }}">@lang('dashboard.user_dashboard')</a>
                                            @elseif(Auth::user()->user_type === 'safety_firm')
                                                <a class="btn btn-info waves-effect" href="{{ route('safety-firm-dashboard') }}">@lang('dashboard.safety_dashboard')</a>
                                        </div>
                                        @endif
                                    @endguest
                                </div>

                                <div class="mt-4 mt-md-5 text-center">
                                    <p class="mb-0">© <script>
                                            document.write(new Date().getFullYear())

                                        </script> @lang('settings.website_title').
                                        {{-- <br>
                                         <span>Crafted with <i class="mdi mdi-heart text-danger"></i> by
                                         Themesbrand</span>--}}
                                    </p>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container-fluid -->

        <!-- JAVASCRIPT -->
        @include('admin.layouts.partial.footer.vendor-scripts')

    @endsection

    @section('script')
        <!-- owl.carousel js -->
        <script src="{{ URL::asset('/assets/common/libs/owl.carousel/owl.carousel.min.js') }}"></script>
        <!-- auth-2-carousel init -->
        <script src="{{ URL::asset('/assets/common/js/pages/auth-2-carousel.init.js') }}"></script>

        <script>
            $(function() {
                // show the alert
                setTimeout(function() {
                    $(".close").alert('close');
                }, 5000);
            });
        </script>

    @endsection
