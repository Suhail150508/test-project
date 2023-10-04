@extends('admin.layouts.master')

@section('title') @lang('user_menu_action/attribute.create_title') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1_link'){{route('menu.index')}}@endslot
        @slot('li_2_link'){{route('user_menu_action.index',$menu->id)}}@endslot
        @slot('li_1')@lang('menu/attribute.index_title')@endslot
        @slot('li_2')@lang('user_menu_action/attribute.index_title')@endslot
        @slot('li_3')@lang('user_menu_action/attribute.create_title')@endslot
        @slot('title')@lang('user_menu_action/attribute.create_title') ({{$menu->name}})@endslot

    @endcomponent

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    {{ Form::open(['url' => route('user_menu_action.store',$menu->id), 'method' => 'post','class' => 'custom-validation']) }}
                        @include('admin.user-menu-action.form')
                    {{ Form::close() }}

                </div>
            </div>


        </div> <!-- end col -->
    </div>
@endsection


