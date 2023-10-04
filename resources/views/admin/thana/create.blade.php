@extends('admin.layouts.master')

@section('title') @lang('thana.create_title') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1_link'){{route('thana.index')}}@endslot
        @slot('li_1')@lang('thana.index_title')@endslot
        @slot('li_2')@lang('thana.create_title')@endslot
        @slot('title')@lang('thana.create_title')@endslot

    @endcomponent

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    {{ Form::open(['url' => route('thana.store'), 'method' => 'post','class' => 'custom-validation']) }}
                        @include('admin.thana.form')
                    {{ Form::close() }}

                </div>
            </div>
        </div> <!-- end col -->
    </div>
@endsection


