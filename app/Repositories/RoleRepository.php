<?php


namespace App\Repositories;

use App\Helpers\ImageHelper;
use App\Interfaces\RoleInterface;
use App\Interfaces\UserInterface;
use App\Models\File;
use App\Models\Menu;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use App\Models\RolePermission;
use App\Models\User;
use App\Models\UserMenuAction;
use App\Models\UserPermission;

class RoleRepository extends BaseRepository implements RoleInterface
{
    public function __construct(Role $model)
    {
        $this->model = $model;
    }

    public function permission($id)
    {
//        DB::beginTransaction();
        try {
            RolePermission::where('role_id',$id)->delete();
            $last_id = RolePermission::max('id');
            if($last_id){
                DB::statement("ALTER TABLE role_permissions AUTO_INCREMENT =  $last_id");
            }else{
                DB::statement("ALTER TABLE role_permissions AUTO_INCREMENT =  1");
            }

            if(request()->menu_id) {
                $countMenu = count(request()->menu_id);
                for ($i = 0; $i < $countMenu; $i++) {
                    $menu = Menu::findOrFail(request()->menu_id[$i]);
                    $role_permission = new RolePermission();
                    $role_permission->role_id = $id;
                    $role_permission->permission_id = request()->menu_id[$i];
                    $role_permission->route_name = $menu->route_name;
                    $role_permission->permission_name = $menu->route_name.'_menu';
                    $role_permission->permission_type = 'menu';
                    $role_permission->save();
                }
            }

            if(request()->user_menu_action_id) {
                $countUserMenuAction = count(request()->user_menu_action_id);
                for ($j = 0; $j < $countUserMenuAction; $j++) {
                    $user_menu_action = UserMenuAction::findOrFail(request()->user_menu_action_id[$j]);
                    $role_permission = new RolePermission();
                    $role_permission->role_id = $id;
                    $role_permission->permission_id = request()->user_menu_action_id[$j];
                    $role_permission->route_name = $user_menu_action->route_name;
                    $role_permission->permission_name = $menu->route_name.'_menu_action';
                    $role_permission->permission_type = 'menu_action';
                    $role_permission->save();
                }
            }

            $users = User::where('role_id',$id)->where('permission_as_role','Yes')->get();
            $this->permissionUpdateFroUser($users);
//            DB::commit();

            return response()->json('Permission added Successfully');
        }catch (\Exception $e) {
//            DB::rollBack();
            return $e->getMessage();
//            return back()->withInput()->with('error', $e->getMessage());
        }
    }
    public function permissionUpdateFroUser($users){
        foreach ($users as $user){
            UserPermission::where('user_id',$user->id)->delete();
            $role_permissions = RolePermission::where('role_id',$user->role_id)->get();
            foreach ($role_permissions as $permission){
                $user_permission = new UserPermission();
                $user_permission->user_id = $user->id;
                $user_permission->permission_id = $permission->permission_id;
                $user_permission->route_name = $permission->route_name;
                $user_permission->permission_type = $permission->permission_type;
                $user_permission->save();
            }
        }
    }
}
