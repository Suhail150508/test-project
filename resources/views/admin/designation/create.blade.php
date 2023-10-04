@extends('admin.layouts.master')

@section('title') @lang('common.create',['model' => trans('designation.designation')]) @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1_link'){{route('designation.index')}}@endslot
        @slot('li_1')@lang('common.index',['model' => trans('designation.designation')])@endslot
        @slot('li_2')@lang('common.create',['model' => trans('designation.designation')])@endslot
        @slot('title')@lang('common.create',['model' => trans('designation.designation')])@endslot
    @endcomponent

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    {{ Form::open(['url' => route('designation.store'), 'method' => 'post','class' => 'custom-validation']) }}
                        @include('admin.designation.form')
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

@endsection


