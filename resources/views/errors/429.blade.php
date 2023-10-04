@extends('guest.layouts.master')

@section('title')
    @lang('translation.Error_429')
@endsection

@section('body')
    <body data-topbar="dark" data-layout="horizontal">
    @endsection

    @section('content')

        <div class="account-pages my-5 pt-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mb-5">
                            <h1 class="display-2 fw-medium">4<i class="bx bx-comment-dots bx-flashing text-warning display-3"></i>9</h1>
                            <h4 class="text-uppercase">@lang('translation.too_many_requests')</h4>
                            <div class="mt-5 text-center">
                                <a class="btn btn-primary waves-effect waves-light" href="/">@lang('translation.back_to_dashboard')</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection
