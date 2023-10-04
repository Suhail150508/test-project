@extends('admin.layouts.master')
@section('title') @lang('user.permission_title') @endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1_link'){{route('user.index')}}@endslot
        @slot('li_1')@lang('user.index_title')@endslot
        @slot('li_2')@lang('user.permission_title')@endslot
        @slot('title')@lang('user.permission_title')@endslot

    @endcomponent
    <div class="row">
        <div class="col-xl-12">
            <h4 class="border-bottom pb-1">{{$user->bn_name}}</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            {{ Form::model($user,['url' => route('user.permission_update',$user->id), 'method' => 'post','class' => 'custom-validation']) }}
                <div class="row">
                    <div class="col-sm-2">
                        @if($menus)
                        @endif
                        <input type="checkbox" id="select_all" {{count($menus)+count($user_menu_action) == count($menu_permission)+count($menu_action_permission) ? 'checked':''}}> <label for="select_all" class="menu_label" >Select All</label>
                    </div>
                    <div class="col-sm-4">
                        <input type="checkbox" id="permission_as_role" name="permission_as_role" {{$user->permission_as_role == 'Yes' && @$user->role? 'checked':''}}> <label for="permission_as_role" class="menu_label" >Same as Role Permission(
                            @if(@$user->role)
                                {{@$user->role->name}}
                            @else
                                {!! '<span class="text-danger">No Role Selected</span>' !!}
                            @endif
                            )
                        </label>
                    </div>
                </div>
                @include('admin.permission.permission_item')
            {{ Form::close() }}
        </div> <!-- end col -->
    </div>
@endsection

@push('script')
    <script>
        @if($user->permission_as_role == 'Yes')
            $(".common_menu").attr("disabled", true);
           /* $(window).on('load', function(){
                SameAsRole()
            });*/
        @endif

        $("#permission_as_role").click(function(){
            if ($(this).is(':checked')) {
                $(".common_menu").attr("disabled", true);
                $('.common_menu').each(function () {
                    this.checked = false;
                });
                SameAsRole()
            }else{
                $(".common_menu").attr("disabled", false);
            }
        });

        function SameAsRole(){
            $('#loader').show();
            $("#select_all").prop('checked',false);
            var role_id = {{$user->role_id}};
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: "{{route('get_role_permission')}}",
                data: {role_id: role_id},
                success: function (response) {
                    for (var menu_permission_id of response.menu_permission) {
                        $('#menu_' + menu_permission_id).each(function () {
                            this.checked = true;

                        });
                    }
                    for (var menu_action_permission_id of response.menu_action_permission) {
                        $('#user_menu_action_' + menu_action_permission_id).each(function () {
                            this.checked = true;
                        });
                    }
                },
                error: function (response) {
                },
                complete: function(){
                    setTimeout(function(){
                        $('#loader').hide();
                    }, 300);
                }
            });
        }
    </script>
@endpush



