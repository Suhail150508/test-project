@extends('admin.layouts.master')

@section('title') @lang('role.permission_title') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1_link'){{route('role.index')}}@endslot
        @slot('li_1')@lang('role.index_title')@endslot
        @slot('li_2')@lang('role.permission_title')@endslot
        @slot('title')@lang('role.permission_title')@endslot

    @endcomponent
    <div class="row">
        <div class="col-xl-12">
            <h4 class="border-bottom pb-1">{{$role->name}}</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            {{ Form::model($role,['url' => route('role.permission',$role->id), 'method' => 'post','class' => 'custom-validation']) }}
                <div class="row">
                    <div class="col-sm-4">
                        @if($menus)
                        @endif
                        <input type="checkbox" id="select_all" {{count($menus)+count($user_menu_action) == count($menu_permission)+count($menu_action_permission) ? 'checked':''}}> <label for="select_all" class="menu_label" >Select All</label>
                    </div>
                </div>
                @include('admin.permission.permission_item')
            {{ Form::close() }}
        </div> <!-- end col -->
    </div>
@endsection



