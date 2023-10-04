<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title> @yield('title') | @lang('settings.website_title_short_4')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('assets/common/images/logo/logo-fsc-noc.ico') }}">

    @yield('head_style')

    @include('guest.layouts.head-css')
</head>

@section('body')
    <body data-topbar="dark" data-layout="horizontal">
@show

    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('guest.layouts.horizontal')
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content-left-0">
            <div class="page-content">
                <!-- Start content -->
                <div class="container-fluid">
                    @include('components.error_message')
                    @include('components.success_message')
                    @yield('content')
                </div> <!-- content -->
            </div>
            @include('guest.layouts.footer')
        </div>
        <!-- ============================================================== -->
        <!-- End Right content here -->
        <!-- ============================================================== -->
    </div>
    <!-- END wrapper -->

    @include('guest.layouts.vendor-scripts')

    @if (config('app.env') =='Production' || config('app.env') == 'Development')
        <!-- START -------- Disable Right-Click + Inspection + Console --------- START -->
        {{--@include('guest.components.disable_inspection_script')--}}
        <!-- END -------- Disable Right-Click + Inspection + Console --------- END -->
    @endif

</body>

</html>
