<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title> @yield('title') | @lang('settings.website_title_short_4')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="language" content="{{ config('app.locale') }}">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('assets/common/images/logo/logo-fsc-noc.ico') }}">

    @yield('head_style')

    @include('user.layouts.head-css')
</head>

@section('body')
    <body data-topbar="dark" data-layout="horizontal">
@show

    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('user.layouts.horizontal')
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="marquee font-size-15">
                    <p style="margin-left: 35px;">
                        @foreach($notices as $notice)
                            {{ $notice->notice }}&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                        @endforeach
                    </p>
                </div>
                <!-- Start content -->
                <div class="container-fluid">
                    @include('components.error_message')
                    @include('components.success_message')

                    @if(@auth()->user()->company->id && @auth()->user()->company->status == 'Inactive')
                        @include('components.safety_firm_inactive_alert')
                    @endif
                    @yield('content')
                </div> <!-- content -->
            </div>
            @include('user.layouts.footer')
            {{--    loader--}}
            <div id="loader"></div>
        </div>
        <!-- ============================================================== -->
        <!-- End Right content here -->
        <!-- ============================================================== -->
    </div>
    <!-- END wrapper -->

    @include('user.layouts.vendor-scripts')

    @if (config('app.env') =='Production' || config('app.env') == 'Development')
        <!-- START -------- Disable Right-Click + Inspection + Console --------- START -->
        @include('user.components.disable_inspection_script')
        <!-- END -------- Disable Right-Click + Inspection + Console --------- END -->
    @endif

</body>

</html>
