@extends('guest.layouts.master')

@section('title')
    @lang('translation.Error_404')
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
                        <h1 class="display-2 fw-medium">4<i class="bx bx-buoy bx-spin text-primary display-3"></i>4</h1>
                        <h4 class="text-uppercase">@lang('translation.not_found')</h4>
                        <div class="mt-5 text-center">
                            <a class="btn btn-primary waves-effect waves-light" href="/">@lang('translation.back_to_dashboard')</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
