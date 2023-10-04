@extends('admin.layouts.master')

@section('title') @lang('menu/attribute.create_title') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1_link'){{route('menu.index')}}@endslot
        @slot('li_1')@lang('menu/attribute.index_title')@endslot
        @slot('li_2')@lang('menu/attribute.create_title')@endslot
        @slot('title')@lang('menu/attribute.create_title')@endslot
    @endcomponent

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    {{ Form::open(['url' => route('menu.store'), 'method' => 'post','class' => 'custom-validation']) }}
                        @include('admin.menu.form')
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

@endsection


