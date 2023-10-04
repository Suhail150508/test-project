@extends('admin.layouts.master')

@section('title') @lang('common.edit',['model' => trans('employee.employee')]) @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1_link'){{route('employee.index')}}@endslot
        @slot('li_1')@lang('common.index',['model' => trans('employee.employee')])@endslot
        @slot('li_2')@lang('common.edit',['model' => trans('employee.employee')])@endslot
        @slot('title')@lang('common.edit',['model' => trans('employee.employee')])@endslot
    @endcomponent

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    {{ Form::model($employee,['url' => route('employee.update',$employee->id), 'method' => 'patch', 'class' => 'custom-validation', 'id' => 'employee_form', 'files' => true]) }}
                        @include('admin.employee.form')
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

@endsection


