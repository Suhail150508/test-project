@if($menu_item->children)
    @foreach($menu_item->children as $menu)
        @php
            if($menu->role_id != null && $menu->role_id != $role->id){
                unset($menu);
            }
        @endphp
        @if(@$menu)
            <div class="row ">
            <div class="col-sm-12 my-2">
                <div class="menu_part p-2 rounded-2" style="border: 1px solid #dfdfdf;">
                    <input type="checkbox" name="menu_id[]" value="{{$menu->id}}" class="menu common_menu parent_menu_{{$menu->parent_id}}" id="menu_{{$menu->id}}" {{in_array($menu->id,$menu_permission) ? 'checked' : ''}}>
                    <label for="menu_{{$menu->id}}" class="menu_label">{{$menu->bn_name}}</label>
                    @if($menu->children)
                        @include('admin.permission.child_menu',['menu_item' => $menu])
                    @endif
                    @if($menu->userMenuAction)
                        @include('admin.permission.menu_action',['menu_item' => $menu])
                    @endif
                </div>
            </div>
        </div>
        @endif
    @endforeach
@endif
