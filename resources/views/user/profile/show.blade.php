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
                                            <a href="{{ route('user_profile.edit',auth()->user()->id) }}" class="btn btn-primary waves-effect waves-light btn-sm"><i class="fa fa-edit"></i> Edit Profile <i class="mdi mdi-arrow-right ms-1"></i></a>
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
                    <table class="table table-bordered {{--table-borderless--}}">
                        <thead>

                        </thead>
                        <tbody>
                            <th>@lang('profile.name')</th>
                            <th>@lang('profile.mobile')</th>
                            <th>@lang('profile.email')</th>
                            <th>@lang('profile.nid')</th>
                        </tbody>
                        <tbody>
                            <td>{{ $user->bn_name }}</td>
                            <td>{{ $user->mobile }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->nid }}</td>
                        </tbody>
                        <tbody>
                            <th>@lang('profile.username')</th>
                            <th>@lang('profile.created')</th>
                            <th>@lang('profile.address')</th>
                            <th>@lang('profile.signature')</th>
                        </tbody>
                        <tbody>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->created_at->format('d-m-Y') }}</td>
                            <td>{{ $user->address }}</td>
                            <td>{{ $user->signature }}</td>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <img src="{{ asset('assets') }}" alt="signature">
            </div>
        </div>
    </div>
    <!-- end row -->

@endsection
@section('script')
    <!-- apexcharts -->{{--
    <script src="{{ URL::asset('/assets/common/libs/apexcharts/apexcharts.min.js') }}"></script>--}}

    <!-- dashboard init -->{{--
    <script src="{{ URL::asset('/assets/common/js/pages/dashboard.init.js') }}"></script>--}}
@endsection
