<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PermissionCollection;
use App\Http\Resources\RoleCollection;
use App\Http\Resources\RoleResource;
use App\Interfaces\RoleInterface;
use App\Models\Menu;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\User;
use App\Models\UserMenuAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{
    protected $role;

    public function __construct(RoleInterface $role)
    {
        $this->role = $role;
    }

    public function index()
    {
        if (request()->per_page) {
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;

            $query = Role::query()
                ->where($fieldName, 'LIKE', "%$keyword%")
                ->orderBy('id', 'asc')
                ->paginate($perPage);

            return new RoleCollection($query);
        } else {
            $query = $this->role->get();

            return new RoleCollection($query);
        }
    }

    public function deletedListIndex()
    {
        $deleted_list = $this->role->onlyTrashed();
        return response()->json($deleted_list);
    }

    public function store(Request $request)
    {
        $role = $this->role->create($request);
        return new RoleResource($role);
    }


    public function show(Role $role)
    {
        $role = $this->role->findOrFail($role->id);
        return response()->json($role);
    }

    public function edit($id)
    {
        $role = $this->role->findOrFail($id);
        return response()->json($role);
    }

    public function update(Request $request, $id)
    {
        $role =  $this->role->update($id,$request);
        $request['update'] = "update";
        return new RoleResource($role);
    }

    public function destroy(Role $role)
    {
        return $this->role->delete($role->id);
    }

    public function restore($id)
    {
        return $this->role->restore($id);
    }

    public function forceDelete($id)
    {
        return $this->role->forceDelete($id);
    }

    /*public function permission($id)
    {
        $data['role'] = Role::findOrFail($id);
        $data['menus'] = Menu::where('parent_id',null)->where('status',1)->get();
        $data['user_menu_action'] = UserMenuAction::where('status',1)->get();
        $data['menu_permission'] = RolePermission::where('permission_type','menu')->where('role_id',$id)->pluck('permission_id')->toArray();
        $data['menu_action_permission'] = RolePermission::where('permission_type','menu_action')->where('role_id',$id)->pluck('permission_id')->toArray();

        if(count(request()->all()) > 0 && request()->isMethod('POST')){
            return $this->role->permission($id);
        }else{
           return  response()->json($data);
        }
    }*/

    public function permission($id)
    {
        $data['assigned_permissions'] = RolePermission::query()->where('role_id',$id)->pluck('permission_id')->toArray();

        if(count(request()->all()) > 0 && request()->isMethod('POST')){
            $permission_ids = request()->user_menu_action_id;
            RolePermission::query()->where('role_id',$id)->delete();
            foreach ($permission_ids as $permission_id) {
                $role_permission = new RolePermission();
                $role_permission->role_id = $id;
                $role_permission->permission_id = $permission_id;
                $role_permission->route_name = '';
                $role_permission->permission_name = Permission::query()->find($permission_id)->name;
                $role_permission->permission_type = '';
                $role_permission->save();
            }
            /*if(request()->user_menu_action_id) {
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
            }*/
            return response()->json($data);
//            return $this->role->permission($id);
        }else{
           return response()->json($data);
        }
    }

    public function status(Request $request)
    {
        return $this->role->status($request->id);
    }


    //permission new

    public function permissionList(Request $request)
    {
        if (request()->per_page) {
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;

            $query = Permission::query()
                ->where($fieldName, 'LIKE', "%$keyword%")
                ->orderBy('parent', 'asc')
                ->paginate($perPage);

            return new PermissionCollection($query);
        } else {
            $query = $this->role->get();

            return new PermissionCollection($query);
        }
    }

    public function permissionAll()
    {
        $data = [
//            'all_permissions' => Permission::query()->get(),
            'permission_groups' => Permission::query()->orderBy('parent', 'asc')->groupBy('parent')->pluck('parent','id'),
            'permissions' => Permission::query()->orderBy('parent', 'asc')->select('name','parent','id')->get(),
            /*'rolePermissions' => DB::table("role_has_permissions")->where("role_has_permissions.role_id", $role->id)
                ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
                ->all(),*/
        ];

        return response()->json($data);
    }

    public function addPermission(Request $request)
    {
        $request->validate([
            'name'=>'required|unique:permissions',
            'parent'=>'required'
        ]);

        $permission = new Permission();
        $permission->name = $request->name;
        $permission->parent = $request->parent;
        $permission->guard_name = $request->guard_name;
        $permission->save();

        return response()->json([
            'data' => $permission,
            'message' => 'Permission Created Successfully',
        ], 200);
    }

    public function updatePermission(Request $request, $id)
    {
        $request->validate([
            'name'=>'required|unique:permissions',
            'parent'=>'required'
        ]);

        $permission = new Permission();
        $permission->name = $request->name;
        $permission->parent = $request->parent;
        $permission->guard_name = $request->guard_name;
        $permission->save();

        return response()->json([
            'data' => $permission,
            'message' => 'Permission Created Successfully',
        ], 200);
    }

    public function checkPermission(Request $request)
    {
        $permissionsToUpdate = $request->input('permissionKeys');
        $user = User::query()->find($request->authId);
        $role_permissions = RolePermission::query()->where('role_id',$user->role_id)->pluck('permission_name')->toArray();

        foreach ($permissionsToUpdate as $key => &$value) {
            if (in_array($value, $role_permissions)) {
                $value = true;
            } else{
                $value = false;
            }
        }

        return response()->json($permissionsToUpdate);

       /*$user = User::query()->find($request->authId);
       $role_permissions = RolePermission::query()->where('role_id',$user->role_id)->pluck('permission_name')->toArray();
//       $role_permissions_routes = $role_permissions[0]->menus->pluck('route_name')->toArray();
       $permission = $request->input('permission');
       $can = in_array($permission,$role_permissions);
       return response()->json(['can' => $can]);*/
    }
}
