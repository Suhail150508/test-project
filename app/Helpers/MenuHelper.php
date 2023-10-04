<?php

namespace App\Helpers;

use App\Models\RolePermission;
use App\Models\User;
use App\Models\Menu;
use App\Models\UserMenuAction;
use App\Models\UserPermission;
use Auth;
use Spatie\Activitylog\Models\Activity;
use URL;

class MenuHelper
{
    public static function Menu(){
        $menu_permission = UserPermission::where('permission_type','menu')->where('user_id',auth()->user()->id)->pluck('permission_id')->toArray();
        /*if(!@$menu_permission){
            $menu_permission = RolePermission::where('permission_type','menu')->where('role_id',auth()->user()->role_id)->pluck('permission_id')->toArray();
        }*/
        $menu_list = Menu::with(['children' => function($q) use($menu_permission)
                        {
                            $q->where('status','=', 1);
                            $q->whereIn('id', $menu_permission);

                        }])
                        ->where('parent_id',NULL)
                        ->where('status',1)
                        ->whereIn('id',$menu_permission)
                        ->where('is_hidden','No')
                        ->orderBy('order_by','asc')
                        ->get();
        return $menu_list;
    }

    public static function MenuElement($menu){
        if(count($menu->children) > 0){
            $menu_link = 'javascript:';
            $has_arrow = 'has-arrow ';
        }else{
            if($menu->route_name){
                if(!\Route::has($menu->route_name)){
                    $menu_link = 'route-not-exist';
                }else{
                    $menu_link = route($menu->route_name);
                }
            }else{
                $menu_link = 'javascript:';
            }

            $has_arrow = '';
        }

        if($menu->icon){
            $menu_icon = $menu->icon;
        }else{
            $menu_icon = 'fas fa-th-list';
        }

       $data['menu_link'] = $menu_link;
       $data['has_arrow'] = $has_arrow;
       $data['menu_icon'] = $menu_icon;

        return $data;
    }

    public static function menuName($menu){
        if(@$menu->bn_name){
            return $menu->bn_name;
        }else{
            return $menu->name;
        }
    }

    public static function TableActionButton(array $action_array = null, $subject = null){
        $id = $action_array['id'];
        $subject = @$action_array['subject'];
        $status = @$action_array['status'] ? $action_array['status'] : null;
        $action_type = @$action_array['action_type'] ? $action_array['action_type'] : null;

        $url_param = '';
        if(request('status')){
            $url_param .= '&status='. request('status');
        }
        if(request('type')){
            $url_param .= '&type='. request('type');
        }
        $menu_action_permission = UserPermission::where('permission_type','menu_action')->where('user_id',auth()->user()->id)->pluck('permission_id')->toArray();
        /*if(!@$menu_action_permission){
            $menu_action_permission = RolePermission::where('permission_type','menu_action')->where('role_id',auth()->user()->role_id)->pluck('permission_id')->toArray();
        }*/
        $routeName = \Route::currentRouteName();
        //if any index route match in user menu action table
        $user_menu_action_check = UserMenuAction::where('status', '=', 1)
                                ->where('route_name',$routeName)->first();

        if(@$user_menu_action_check){
            $get_user_menu_actions = UserMenuAction::where('show_in_table', '=', 1)
                ->where('status', '=', 1)
                ->where('parent_id',$user_menu_action_check->id)
                ->whereIn('id', $menu_action_permission)
                ->orderBy('order_by', 'asc')
                ->get();
        }
        if(@$user_menu_action_check && $get_user_menu_actions){
            $user_menu_actions = $get_user_menu_actions;
        }else{
            $menu = Menu::with(['userMenuAction' => function ($query) use($menu_action_permission, $action_type){
                    $query->where('show_in_table', '=', 1);
                    $query->where('status', '=', 1);
                    $query->where('parent_id', null);
                    $query->whereIn('id', $menu_action_permission);
                    if($action_type){
                        $query->where('type', $action_type);
                    }
                },'userMenuAction.menuAction']
            )
                ->where('route_name',$routeName)->first();
            $user_menu_actions = $menu->userMenuAction;
        }

        $button = '';
        foreach ($user_menu_actions as $action) {
            if($action->route_name){
                $link = route($action->route_name,[$id,$url_param]);
                $route = $action->route_name;
            }else{
                $link = 'javascript:';
                $route = ':';
            }
            if($action->class){
                $action_class = ' '.$action->class;
            }else{
                $action_class = '';
            }
            if($action->menuAction->button_class){
                $button_class = $action->menuAction->button_class.$action_class;
            }else{
                $button_class = 'btn btn-primary btn-sm'. $action_class;
            }
            if($action->menuAction->icon){
                $icon_class = $action->menuAction->icon;
                $button_name = '';
            }else{
                $icon_class = 'fas fa-radiation';
                $button_name = $action->name;
            }

            if($action->new_tab == 1){
                $target = 'target=_blank';
            }else{
                $target = '';
            }

            if ($action->slug == 'edit_history'){
                $button .=
                '<a 
                    href="javascript:"
                    class="'.$button_class.' mb-1" 
                    data-bs-toggle="modal" 
                    data-bs-target="#edit_history'.$id.'"
                    data-id="'.$id.'">
                    <i class="'.$icon_class.'"></i> '.$button_name.'
                </a>' .view('admin.layouts.edit_history',['model' => Activity::query()
                    ->with('causer')
                    ->whereNotNull('causer_id')
                    ->where('subject_type',get_class($subject))
                    ->where('subject_id',$id)
                    ->get(),'id' => $id]);

            } else {
                $button .=
                    '<a class="'.$button_class.' mb-1"
                    href="'.$link.'"
                    data-id="'.$id.'"
                    data-route="'.$route.'"
                    data-status="'.$status.'"
                    '.$target.' /*data-toggle="tooltip" data-placement="top"*/ title="'.$action->name.'">
                    <i class="'.$icon_class.'"></i> '.$button_name.'
                </a>';
            }
        }
        return $button;

    }

    public static function CustomElementPermission($slug){
        $routeName = \Route::currentRouteName();
        $menu = Menu::where('status',1)->where('route_name',$routeName)->first();
        $user_menu_action = UserMenuAction::where('status',1)->where('menu_id',$menu->id)->where('slug',$slug)->first();
        if(@$user_menu_action){
            $permission = UserPermission::where('user_id',auth()->user()->id)->where('permission_type','menu_action')->where('permission_id',$user_menu_action->id)->first();
            /*if(!@$permission){
                $permission = RolePermission::where('role_id',auth()->user()->role_id)->where('permission_type','menu_action')->where('permission_id',$user_menu_action->id)->first();
            }*/

            if(@$permission){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public static function status($id = null,$status = null) {

        $data_status = '';
        if($status === 'Active' || $status === 1 ){
            $checked = 'checked';
        }else{
            $checked = '';
        }

        $data_status .= '<div class="form-check form-switch form-switch-md status_'.$id.'" dir="ltr">
                            <input class="form-check-input" type="checkbox" onchange="statusChange('.$id.')" '.$checked.'>
                        </div>';

        return $data_status;
    }
}
