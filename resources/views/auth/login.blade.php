@extends('user.layouts.master-without-nav')

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
        margin: 10px 20px;
    }

    .left_side_part,.left_side_part h4{
        color: #fff;
    }

    .left_side_part a{
        color: #49f112;
    }
@endsection

    @section('body')
        <body class="auth-body-bg">

        <div class="bg-light">
            <div class="container-fluid">
                @include('auth.partials.topnav')
            </div>
        </div>
    @endsection

    @section('content')

        <div class="container-fluid p-0">

            <div class="row g-0 container-row">

                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 font-size-17">
                    @include('auth.partials.application_rules')
                </div>
                <!-- end col -->

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 order-first order-sm-first order-md-last order-lg-last order-xl-last">
                    <div class="auth-full-page-content p-md-3 p-3">
                        <div class="w-100">

                            <div class="d-flex flex-column h-100">
                                <div class="mb-2 mb-md-2 text-center">
                                    <a href="/" class="d-block auth-logo">
                                        <img src="{{ URL::asset('assets/common/images/logo/logo-fsc-noc.png') }}" alt="" height="75">
                                    </a>
                                    <span class="font-size-14 font-weight-semibold mt-2 text-success">
                                        @lang('settings.website_title_short_3')
                                    </span>
                                </div>
                                <div class="mb-1 mt-1 my-auto">

                                    <div>
                                        <p class="font-size-15 text-center text-muted">@lang('login.header_info_1')</p>
                                    </div>

                                    <div class="mt-1">
                                        <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="login" class="font-size-12 form-label">@lang('auth.label_email')</label>
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
                                                <label class="font-size-12 form-label">@lang('auth.label_password')</label>
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
                                                <input name="remember" class="form-check-input" type="checkbox" id="remember"
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
                                        {{--<div class="mt-3 text-center">
                                            <p class="mb-1">--}}{{--@lang('auth.label_no_account') --}}{{--<a href="{{route('register')}}"
                                                    class="fw-medium text-primary"> @lang('login.label_create_new_account') </a> </p>
                                        </div>--}}
                                    </div>
                                </div>

                                <div class="{{--mt-2 mt-md-2--}} text-center">
                                    <p class="font-size-12 mb-0">
                                        @lang('settings.copyright',['year' => \Illuminate\Support\Facades\Date::now()->format('Y')]).
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

    @endsection
    @section('script')
        <!-- owl.carousel js -->
        <script src="{{ URL::asset('/assets/common/libs/owl.carousel/owl.carousel.min.js') }}"></script>
        <!-- auth-2-carousel init -->
        <script src="{{ URL::asset('/assets/common/js/pages/auth-2-carousel.init.js') }}"></script>
    @endsection
