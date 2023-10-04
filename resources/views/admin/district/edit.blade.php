@extends('admin.layouts.master')

@section('title') @lang('district.edit_title') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1_link'){{route('district.index')}}@endslot
        @slot('li_1')@lang('district.index_title')@endslot
        @slot('li_2')@lang('district.edit_title')@endslot
        @slot('title')@lang('district.edit_title')@endslot

    @endcomponent

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    {{ Form::model($district,['url' => route('district.update',$district->id), 'method' => 'patch','class' => 'custom-validation']) }}
                        @include('admin.district.form')
                    {{ Form::close() }}

                </div>
            </div>
        </div> <!-- end col -->
    </div>
@endsection


