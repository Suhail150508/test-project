@extends('admin.layouts.master')

@section('title') @lang('common.edit',['model' => trans('designation.designation')]) @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1_link'){{route('designation.index')}}@endslot
        @slot('li_1')@lang('common.index',['model' => trans('designation.designation')])@endslot
        @slot('li_2')@lang('common.edit',['model' => trans('designation.designation')])@endslot
        @slot('title')@lang('common.edit',['model' => trans('designation.designation')])@endslot
    @endcomponent

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    {{ Form::model($designation,['url' => route('designation.update',$designation->id), 'method' => 'patch','class' => 'custom-validation']) }}
                        @include('admin.designation.form')
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

@endsection


