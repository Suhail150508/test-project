<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title> @yield('title') | @lang('settings.website_title_short_4') </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="language" content="{{ config('app.locale') }}">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('assets/common/images/logo/logo-fsc-noc.ico') }}">

    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

    @include('admin.layouts.partial.header.head-css')
</head>

@section('body')
    <body data-sidebar="dark">
@show
    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('admin.layouts.partial.header.topbar')
        @include('admin.layouts.partial.sidebar.left-sidebar')
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">

                    <div class="mt-3">
                        @include('components.error_message')
                        @include('components.success_message')
                        @yield('content')
                    </div>

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            @include('admin.layouts.partial.footer.footer')
            {{--    loader--}}
            <div id="loader"></div>
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    <!-- Right Sidebar -->
    {{--@include('admin.layouts.partial.sidebar.right-sidebar')--}}
    <!-- /Right-bar -->

    <!-- JAVASCRIPT -->
    @include('admin.layouts.partial.footer.vendor-scripts')

    @if (config('app.env') =='Production' || config('app.env') == 'Development')
        <!-- START -------- Disable Right-Click + Inspection + Console --------- START -->
        @include('components.disable_inspection_script')
        <!-- END -------- Disable Right-Click + Inspection + Console --------- END -->
    @endif

    @yield('modal_lg_content')
    </body>

</html>
