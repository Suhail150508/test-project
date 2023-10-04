@extends('admin.layouts.master')

@section('title') @lang('user.edit_profile') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('title')@lang('user.edit_profile')@endslot

    @endcomponent

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    {{ Form::model($user,['url' => route('user.profile_update',$user->id), 'method' => 'post','class' => 'custom-validation','enctype' => 'multipart/form-data']) }}
                        @include('admin.user.profile_form')
                    {{ Form::close() }}

                </div>
            </div>


        </div> <!-- end col -->
    </div>
@endsection


