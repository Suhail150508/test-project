@extends('user.layouts.master')

@section('title') @lang('translation.dashboard') @endsection

@section('content')

    @component('user.components.breadcrumb')
        @slot('li_1') @lang('translation.dashboard') @endslot
        @slot('title') @lang('translation.Profile') @endslot
        @slot('li_1_link') / @endslot
    @endcomponent

    <div class="row">
        <div class="col-xl-4">
            <div class="card overflow-hidden">
                <div class="bg-primary bg-soft">
                    <div class="row">
                        <div class="col-9">
                            <div class="text-primary p-3 text-right">
                                <h5 class="text-primary">@lang('profile.welcome',['user' => auth()->user()->name])!</h5>
                                <p>@lang('profile.profile')</p>
                            </div>
                        </div>
                        <div class="col-5 align-self-end">
                            {{--<img src="{{ URL::asset('/assets/common/images/profile-img.png') }}" alt="" class="img-fluid">--}}
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="avatar-md profile-user-wid mb-4">
                                <img src="{{ isset(Auth::user()->avatar) ? asset(Auth::user()->avatar) : asset('/assets/common/images/users/avatar-1.png') }}" alt="" class="img-thumbnail rounded-circle">
                            </div>
                            <h5 class="font-size-15 text-truncate">{{ Str::ucfirst(Auth::user()->username) }}</h5>
                        </div>

                        <div class="col-sm-8">
                            <div class="pt-4">

                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="font-size-15">{{ Auth::user()->mobile }}</h5>
                                        <p class="text-muted mb-0">{{ Auth::user()->email }}</p>
                                    </div>
                                    <div class="col-12">
                                        <div class="mt-4">
                                            <a href="{{ route('user-profile') }}" class="btn btn-primary waves-effect waves-light btn-sm"><i class="fa fa-eye"></i> View Profile <i class="mdi mdi-arrow-right ms-1"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4">

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-xl-8">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            {{ Form::model($user,['url' => route('user_profile.edit',$user->id), 'method' => 'patch','class' => 'custom-validation','enctype' => 'multipart/form-data']) }}
                            <div class="row my-2">
                                <div class="col-sm-12 col-md-6 my-2">
                                    @php $error_class = $errors->has('bn_name') ? 'parsley-error ' : ''; @endphp
                                    <label for="bn_name" class="form-label">@lang('profile.name')</label>
                                    <sup class="text-danger">*</sup>
                                    <div class="form-group">
                                        {{ Form::text('bn_name', null, ['class' => $error_class.'form-control', 'id' => 'bn_name', 'required' => 1]) }}
                                        @if ($errors->has('bn_name'))
                                            <p class="text-danger">{{$errors->first('bn_name')}}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 my-2">
                                    @php $error_class = $errors->has('mobile') ? 'parsley-error ' : ''; @endphp
                                    <label for="mobile" class="form-label">@lang('profile.mobile')</label>
                                    <sup class="text-danger">*</sup>
                                    <div class="form-group">
                                        {{ Form::text('mobile',null, ['class' => $error_class.'form-control', 'id' => 'mobile', 'required' => 1]) }}
                                        @if ($errors->has('mobile'))
                                            <p class="text-danger">{{$errors->first('mobile')}}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 my-2">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 my-2">
                                            @php $error_class = $errors->has('email') ? 'parsley-error ' : ''; @endphp
                                            <label for="email" class="form-label">@lang('profile.email')</label>
                                            <sup class="text-danger">*</sup>
                                            <div class="form-group">
                                                {{ Form::text('email',null, ['class' => $error_class.'form-control', 'id' => 'email', 'required' => 1]) }}
                                                @if ($errors->has('email'))
                                                    <p class="text-danger">{{$errors->first('email')}}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12 my-2">
                                            @php $error_class = $errors->has('username') ? 'parsley-error ' : ''; @endphp
                                            <label for="username" class="form-label">@lang('profile.username')</label>
                                            <sup class="text-danger">*</sup>
                                            <div class="form-group">
                                                {{ Form::text('username', null, ['class' => $error_class.'form-control', 'id' => 'username', 'required' => 1]) }}
                                                @if ($errors->has('username'))
                                                    <p class="text-danger">{{$errors->first('username')}}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12my-2">
                                            @php $error_class = $errors->has('nid') ? 'parsley-error ' : ''; @endphp
                                            <label for="nid" class="form-label">@lang('profile.nid')</label>
                                            <div class="form-group">
                                                {{ Form::text('nid', null, ['class' => $error_class.'form-control', 'id' => 'nid']) }}
                                                @if ($errors->has('nid'))
                                                    <p class="text-danger">{{$errors->first('nid')}}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    @php $error_class = $errors->has('address') ? 'parsley-error ' : ''; @endphp
                                    <label for="address" class="form-label">@lang('profile.address')</label>
                                    <sup class="text-danger">*</sup>
                                    <div class="form-group">
                                        {{ Form::textarea('address', null, ['class' => $error_class.'form-control', 'id' => 'address','rows' => 9, 'required' => 1]) }}
                                        @if ($errors->has('address'))
                                            <p class="text-danger">{{$errors->first('address')}}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">
                                        <i class="fa fa-save"></i> @lang('user.label_submit_button')
                                    </button>
                                </div>
                            </div>
                            {{ Form::close() }}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

@endsection
@section('script')

    <script src="{{ URL::asset('/assets/common/libs/parsleyjs/parsleyjs.min.js') }}"></script>

    <script src="{{ URL::asset('/assets/common/js/pages/form-validation.init.js') }}"></script>
@endsection
