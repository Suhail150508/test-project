@if($menu_item->userMenuAction->count() > 0)
    <div class="menu_action_part {{$menu_item->name}}">
        <div class="row">
            @foreach(\App\Models\UserMenuAction::type() as $key=>$value)
                <div class="col-sm-12 col-md-3 my-2">
                    <h6 class="d-inline-block pb-1" style="border-bottom: 1px solid #d2d2d2;"><strong>{{$value}}</strong></h6>
                    @foreach($menu_item->userMenuAction->where('type',$key) as $userMenuAction)
                        <div class="ms-1">
                            <input type="checkbox" value="{{$userMenuAction->id}}" name="user_menu_action_id[]" class="common_menu parent_menu_{{$menu->id}} action_parent_{{$userMenuAction->parent_id}}" id="user_menu_action_{{$userMenuAction->id}}" {{in_array($userMenuAction->id,$menu_action_permission) ? 'checked' : ''}} onclick="ActionCheck({{$userMenuAction->id}})">
                            <label for="user_menu_action_{{$userMenuAction->id}}" class="menu_action_label">
                                {{$userMenuAction->bn_name ?? $userMenuAction->name}}
                            </label>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
@endif
