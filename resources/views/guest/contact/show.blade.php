@extends('guest.layouts.master')

@section('title')
    @lang('login.label_login')
@endsection

@section('css')

@endsection

@section('body')
    <body data-topbar="dark" data-layout="horizontal">
    @endsection

    @section('content')

        <!-- start container-fluid -->
        <div class="row mt-5" style="height: 90%; width: 100%; --bs-gutter-x: 0;">
            <div class="col-md-12">
                <div class="card mt-5">
                    <div class="card-body">
                        <div class="row mt-3" style="text-align: center;">
                            <div class="col-md-4">
                                <h3>@lang('settings.website_title_short_4')</h3>
                                {!!  $content->content_2 !!}
                            </div>
                            <div class="col-md-4" style="border-left: 1px solid gray; border-left-style: dashed; border-right: 1px solid gray; border-right-style: dashed;">
                                <h3>@lang('settings.website_title_short_3')</h3>
                                {!!  $content->content_1 !!}
                            </div>
                            <div class="col-md-4">
                                <h4>@lang('settings.perky_rabbit')</h4>
                                <a target="_blank" href="{{ url('https://www.perkyrabbit.com/') }}">
                                    <img src="{{ URL::asset('assets/common/images/logo/perkyrabbit.png') }}" alt="PR LOGO" height="85px;">
                                </a>
                                <h6 class="">@lang('settings.email') <span class="text-primary">@lang('settings.perky_rabbit_email')</span> </h6>
                                <h6>@lang('settings.phone') <strong class="text-danger">@lang('settings.perky_rabbit_phone')</strong> </h6>
                                <h6>@lang('settings.contact_time') <span class="text-success">@lang('settings.perky_rabbit_contact_time')</span> </h6>
                                <!--<div class="mt-2 font-size-15">
                                    <span>@lang('settings.emergency')<strong class="text-primary">{{ App\Helpers\ENTOBN::convert_to_bangla('+88 01971-212015') }}</strong></span>
                                </div>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end container-fluid -->

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
