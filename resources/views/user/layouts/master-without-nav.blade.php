<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title> @yield('title') | @lang('settings.website_title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="language" content="{{ config('app.locale') }}">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('assets/common/images/logo/logo-fsc-noc.ico') }}">
    @include('admin.layouts.partial.header.head-css')
</head>
{{--@section('body')
    <body data-sidebar="dark">
@show--}}
    @yield('body')

    @include('components.error_message')
    @include('components.success_message')
    @yield('content')

@include('admin.layouts.partial.footer.vendor-scripts')
    </body>
</html>
