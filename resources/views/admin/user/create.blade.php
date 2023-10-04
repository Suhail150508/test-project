@extends('admin.layouts.master')

@section('title') @lang('user.create_title') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1_link'){{route('user.index')}}@endslot
        @slot('li_1')@lang('user.index_title')@endslot
        @slot('li_2')@lang('user.create_title')@endslot
        @slot('title')@lang('user.create_title')@endslot

    @endcomponent

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    {{ Form::open(['url' => route('user.store'), 'method' => 'post','class' => 'custom-validation','enctype' => 'multipart/form-data']) }}
                        @include('admin.user.form')
                    {{ Form::close() }}

                </div>
            </div>


        </div> <!-- end col -->
    </div>
@endsection


