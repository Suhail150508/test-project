<?php


namespace App\Repositories;

use App\Helpers\ImageHelper;
use App\Interfaces\UserInterface;
use App\Models\File;
use App\Models\Menu;
use App\Models\RolePermission;
use App\Models\User;
use App\Models\UserMenuAction;
use App\Models\UserPermission;


class UserRepository extends BaseRepository implements UserInterface
{
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function permissionUpdate(object $data, $id)
    {
        $user = User::findOrFail($id);
        $last_id = UserPermission::max('id');
        if($last_id){
            \DB::statement("ALTER TABLE user_permissions AUTO_INCREMENT =  $last_id");
        }else{
            \DB::statement("ALTER TABLE user_permissions AUTO_INCREMENT =  1");
        }

        if($data->permission_as_role){
            $this->permissionUpdateFromRole($user);
            $user->update([
                'permission_as_role' => 'Yes'
            ]);
        }else{
            $this->permissionUpdateFromInput($user,$data->all());
            $user->update([
                'permission_as_role' => 'No'
            ]);
        }

        \Toastr::success('User Permission Updated', 'Success');
        return redirect(route('user.index'));

    }

    public function permissionUpdateFromRole($user){
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

    public function permissionUpdateFromInput($user,$data){
        UserPermission::where('user_id',$user->id)->delete();
        if($data['menu_id']) {
            $countMenu = count($data['menu_id']);
            for ($i = 0; $i < $countMenu; $i++) {
                $menu = Menu::findOrFail($data['menu_id'][$i]);

                $user_permission = new UserPermission();
                $user_permission->user_id = $user->id;
                $user_permission->permission_id = $data['menu_id'][$i];
                $user_permission->route_name = $menu->route_name;
                $user_permission->permission_type = 'menu';
                $user_permission->save();
            }
        }

        if($data['user_menu_action_id']) {
            $countUserMenuAction = count($data['user_menu_action_id']);
            for ($j = 0; $j < $countUserMenuAction; $j++) {
                $user_menu_action = UserMenuAction::findOrFail($data['user_menu_action_id'][$j]);
                $user_permission = new UserPermission();
                $user_permission->user_id = $user->id;
                $user_permission->permission_id = $data['user_menu_action_id'][$j];
                $user_permission->route_name = $user_menu_action->route_name;
                $user_permission->permission_type = 'menu_action';
                $user_permission->save();
            }
        }
    }

    public function profileUpdate(object $data, $id){
        $user = User::find($id);
        try {
            if($data->password){
                $data->request->add(['password' => bcrypt($data->password)]);
                $user->update($data->all());
            }else{
                $user->update($data->except('password'));
            }

            if (@$data->image) {
                $image = $data->image;
                $image_parameters = [
                    'image' => $image,
                    'directory' => 'user',
                    'width' =>'',
                    'height' => '',
                ];
                $source = ImageHelper::Image($image_parameters);
                $file_parameter = [
                    'source' => $source,
                    'created_by' => $user->created_by,
                    'updated_by' => $user->updated_by,
                ];
                $file = new File($file_parameter);
                $user->files()->save($file);
            }

            \Toastr::success('Profile Updated', 'Success');
            return back();
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }
}
