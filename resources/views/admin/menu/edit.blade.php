@extends('admin.layouts.master')

@section('title') @lang('menu/attribute.edit_title') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1_link'){{route('menu.index')}}@endslot
        @slot('li_1')@lang('menu/attribute.index_title')@endslot
        @slot('li_2')@lang('menu/attribute.edit_title')@endslot
        @slot('title')@lang('menu/attribute.edit_title')@endslot
    @endcomponent

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    {{ Form::model($menu,['url' => route('menu.update',$menu->id), 'method' => 'patch','class' => 'custom-validation']) }}
                        @include('admin.menu.form')
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

@endsection


