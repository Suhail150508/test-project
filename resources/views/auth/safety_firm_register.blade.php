@extends('user.layouts.master-without-nav')

@section('title')
    @lang('registration.label_register_safety_firm')
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

    <div class="marquee font-size-15">
        <p style="margin-left: 35px;">
            @foreach($notices as $notice)
                {{ $notice->notice }}&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
            @endforeach
        </p>
    </div>
@endsection

    @section('content')
        <div>
            <div class="container-fluid">
                <div class="row g-0 container-row">

                    <div class="col-xl-8">
                        <div class="auth-full-page-content p-md-2 p-4">
                            <div class="w-100">

                                <div class="d-flex flex-column h-100">

                                    <div class="my-auto">

                                        <div>
                                            <h5 class="text-primary text-center">@lang('registration.header_info_1_safety_firm')</h5>
                                            <p class="text-muted text-center">@lang('registration.header_info_2_safety_firm')</p>
                                        </div>

                                        <div class="mt-2">
                                            <form method="POST" class="form-horizontal" action="{{ route('safety_firm.register') }}" enctype="multipart/form-data">
                                                @csrf
                                                {{-- Basic information for safety_firm admin --}}
                                                <div class="card">
                                                    <div class="card-header">
                                                        <span>@lang('registration.label_basic_information_safety_firm')</span>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-sm-6 mb-3">
                                                                <label for="bn_name" class="form-label">@lang('registration.label_bn_name_safety_firm') <span class="text-danger font-weight-semibold">*</span></label>
                                                                <input type="text" class="bn_language form-control @error('bn_name') is-invalid @enderror"
                                                                       value="{{ old('bn_name') }}" id="bn_name" name="bn_name" autofocus required>
                                                                @error('bn_name')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>

                                                            <div class="col-sm-6 mb-3">
                                                                <label for="owner_name" class="form-label">@lang('registration.label_safety_firm_owner_name') <span class="text-danger font-weight-semibold">*</span></label>
                                                                <input type="text" class="bn_language form-control @error('owner_name') is-invalid @enderror"
                                                                       value="{{ old('owner_name') }}" id="owner_name" name="owner_name" autofocus required>
                                                                @error('owner_name')
                                                                <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>

                                                            <div class="col-sm-6">
                                                                <label for="address" class="form-label">@lang('registration.label_address_safety_firm') <span class="text-danger font-weight-semibold">*</span></label>
                                                                <textarea class="bn_language form-control @error('address') is-invalid @enderror" id="address" name="address" autofocus required rows="9">{{ old('address') }}</textarea>
                                                                @error('address')
                                                                <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>

                                                            <div class="col-sm-6">
                                                                <div class="col-sm-12 mb-3">
                                                                    <label for="contact_person" class="form-label">@lang('registration.label_contact_person_safety_firm') <span class="text-danger font-weight-semibold">*</span></label>
                                                                    <input type="text" class="bn_language form-control @error('contact_person') is-invalid @enderror"
                                                                           value="{{ old('contact_person') }}" id="contact_person" name="contact_person" autofocus required>
                                                                    @error('contact_person')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>

                                                                <div class="col-sm-12 mb-3">
                                                                    <label for="designation" class="form-label">@lang('registration.label_designation_safety_firm') <span class="text-danger font-weight-semibold">*</span></label>
                                                                    <input type="text" class="bn_language form-control @error('designation') is-invalid @enderror"
                                                                           value="{{ old('designation') }}" id="designation" name="designation" autofocus required>
                                                                    @error('designation')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>

                                                                <div class="col-sm-12">
                                                                    <label for="mobile" class="form-label">@lang('registration.label_mobile_safety_firm') <span class="text-danger font-weight-semibold">*</span></label>
                                                                    <input type="text" class="bn_language form-control @error('mobile') is-invalid @enderror"
                                                                           value="{{ old('mobile') }}" id="mobile" name="mobile" autofocus required>
                                                                    @error('mobile')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="card">
                                                    <div class="card-header">
                                                        <span>@lang('registration.label_login_information')</span>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-sm-6 mb-3">
                                                                <label for="email" class="form-label">@lang('registration.label_email_safety_firm')  <span class="text-danger font-weight-semibold">*</span></label>
                                                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                                                       value="{{ old('email') }}" name="email" autofocus required>
                                                                @error('email')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>

                                                            <div class="col-sm-6 mb-3">
                                                                <label for="username" class="form-label">@lang('registration.label_username_safety_firm') <span class="text-danger font-weight-semibold">*</span></label>
                                                                <input type="text" class="form-control @error('username') is-invalid @enderror"
                                                                       value="{{ old('username') }}" id="username" name="username" autocomplete="false" autofocus required>
                                                                @error('username')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>

                                                            <div class="col-sm-6 mb-3">
                                                                <label for="password" class="form-label">@lang('registration.label_password') <span class="text-danger font-weight-semibold">*</span></label>
                                                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" autocomplete="new-password" autofocus required>
                                                                @error('password')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>

                                                            <div class="col-sm-6 mb-3">
                                                                <label for="confirmpassword" class="form-label">@lang('registration.label_password_confirmation') <span class="text-danger font-weight-semibold">*</span></label>
                                                                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="confirmpassword"
                                                                       name="password_confirmation" autofocus required>
                                                                @error('password_confirmation')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-sm-12 {{--d-grid--}}">
                                                                <button class="btn btn-primary waves-effect waves-light"  type="submit" style="float: right">@lang('registration.label_register')</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{--<div class="mt-4 text-center">
                                                    <p class="mb-0">By registering you agree to the FSC NOC <a href="#"
                                                            class="text-primary">Terms of Use</a></p>
                                                </div>--}}

                                            </form>

                                            <div class="text-center">
                                                <p>@lang('registration.label_already_have_an_account') ? <a href="{{ url('login') }}"
                                                        class="fw-medium text-primary"> @lang('registration.label_do_login')</a> </p>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="mt-4 mt-md-3 text-center">
                                        <p class="mb-0">© <script>
                                                document.write(new Date().getFullYear())

                                            </script> @lang('settings.website_title')</p>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                    <!-- end col -->

                    <div class="col-xl-4 font-size-16">
                        @include('auth.partials.application_rules')
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container-fluid -->
        </div>

    @endsection
    @section('script')
        <script src="{{ URL::asset('/assets/common/libs/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
        <!-- owl.carousel js -->
        <script src="{{ URL::asset('/assets/common/libs/owl.carousel/owl.carousel.min.js') }}"></script>
        <!-- auth-2-carousel init -->
        <script src="{{ URL::asset('/assets/common/js/pages/auth-2-carousel.init.js') }}"></script>
        <script src="{{ URL::asset('assets/common/js/phonetic/driver.phonetic.js')}}"></script>
        <script src="{{ URL::asset('assets/common/js/phonetic/engine.js')}}"></script>
    @endsection
