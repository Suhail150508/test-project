@extends('admin.layouts.master')

@section('title') @lang('division.edit_title') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1_link'){{route('division.index')}}@endslot
        @slot('li_1')@lang('division.index_title')@endslot
        @slot('li_2')@lang('division.edit_title')@endslot
        @slot('title')@lang('division.edit_title')@endslot

    @endcomponent

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    {{ Form::model($division,['url' => route('division.update',$division->id), 'method' => 'patch','class' => 'custom-validation']) }}
                        @include('admin.division.form')
                    {{ Form::close() }}

                </div>
            </div>


        </div> <!-- end col -->
    </div>
@endsection


