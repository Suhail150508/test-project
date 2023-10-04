@extends('admin.layouts.master')

@section('title') @lang('district.create_title') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1_link'){{route('district.index')}}@endslot
        @slot('li_1')@lang('district.index_title')@endslot
        @slot('li_2')@lang('district.create_title')@endslot
        @slot('title')@lang('district.create_title')@endslot

    @endcomponent

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    {{ Form::open(['url' => route('district.store'), 'method' => 'post','class' => 'custom-validation']) }}
                        @include('admin.district.form')
                    {{ Form::close() }}

                </div>
            </div>
        </div> <!-- end col -->
    </div>
@endsection


