@extends('admin.layouts.master')

@section('title') @lang('common.create',['model' => trans('country.country')]) @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1_link'){{route('country.index')}}@endslot
        @slot('li_1')@lang('common.index',['model' => trans('country.country')])@endslot
        @slot('li_2')@lang('common.create',['model' => trans('country.country')])@endslot
        @slot('title')@lang('common.create',['model' => trans('country.country')])@endslot
    @endcomponent

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    {{ Form::open(['url' => route('country.store'), 'method' => 'post','class' => 'custom-validation']) }}
                        @include('admin.country.form')
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

@endsection


