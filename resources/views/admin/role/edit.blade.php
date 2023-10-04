@extends('admin.layouts.master')

@section('title') @lang('role.edit_title') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1_link'){{route('role.index')}}@endslot
        @slot('li_1')@lang('role.index_title')@endslot
        @slot('li_2')@lang('role.edit_title')@endslot
        @slot('title')@lang('role.edit_title')@endslot

    @endcomponent

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    {{ Form::model($role,['url' => route('role.update',$role->id), 'method' => 'patch','class' => 'custom-validation']) }}
                        @include('admin.role.form')
                    {{ Form::close() }}

                </div>
            </div>


        </div> <!-- end col -->
    </div>
@endsection


