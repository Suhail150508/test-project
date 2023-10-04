<div class="row mb-3">
    @foreach($menus as $menu)
        @php
            if($menu->role_id != null && $menu->role_id != $role->id){
                unset($menu);
            }
        @endphp
        @if(@$menu)
            <div class="col-sm-12 col-md-12 my-2}">
                <div class="card menu_block">
                    <div class="card-body">
                        <div class="menu_part">
                            <input type="checkbox" name="menu_id[]" value="{{$menu->id}}" class="menu common_menu" id="menu_{{$menu->id}}" {{in_array($menu->id,$menu_permission) ? 'checked' : ''}}>
                            <label for="menu_{{$menu->id}}" class="menu_label">{{$menu->bn_name}}</label>
                            @include('admin.permission.child_menu',['menu_item' => $menu])
                            @include('admin.permission.menu_action',['menu_item' => $menu])
                        </div>

                    </div>
                </div>
            </div>
        @endif
    @endforeach
</div>
<div class="row mb-1">
    <div class="col-md-12 text-right">
        <button type="submit" class="btn btn-primary waves-effect waves-light">
            <i class="fa fa-save"></i> @lang('role.label_submit_button')
        </button>
    </div>
</div>

@section('script')
    <script>
        $('#select_all').click(function(event) {
            $("#permission_as_role").prop('checked',false);
            $(".common_menu").attr("disabled", false);
            if(this.checked) {
                $('.common_menu').each(function() {
                    this.checked = true;
                });
            }else{
                $('.common_menu').each(function() {
                    this.checked = false;
                });
            }
        });
        $('.menu').click(function(event) {
            var menu_id = $(this).val();
            ChildMenuCheck(menu_id)
        });

        function ChildMenuCheck(menu_id) {
            let parent_menu = $("#menu_"+menu_id);
            let child_menu = $(".parent_menu_"+menu_id);
            if(parent_menu.is(":checked")) {
                $(child_menu).each(function() {
                    this.checked = true;
                    ChildMenuCheck($(this).val())
                });
            }else{
                $(child_menu).each(function() {
                    this.checked = false;
                    ChildMenuCheck($(this).val())
                });
            }
        }

        function ActionCheck(action_id) {
            let child_action = $(".action_parent_"+action_id);
            if(event.currentTarget.checked == true) {
                $(child_action).each(function() {
                    this.checked = true;
                });
            }else{
                $(child_action).each(function() {
                    this.checked = false;
                });
            }
        }
    </script>
@endsection
