@extends('admin.layouts.master')

@section('title') @lang('content.create_title') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1_link'){{route('content.index')}}@endslot
        @slot('li_1')@lang('content.index_title')@endslot
        @slot('li_2')@lang('content.create_title')@endslot
        @slot('title')@lang('content.create_title')@endslot

    @endcomponent

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    {{ Form::open(['url' => route('content.store'), 'method' => 'post','class' => 'custom-validation']) }}
                        @include('admin.content.form')
                    {{ Form::close() }}

                </div>
            </div>


        </div> <!-- end col -->
    </div>
@endsection


