<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleRequest;
use App\Interfaces\RoleInterface;
use App\Models\Menu;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\User;
use App\Models\UserMenuAction;
use App\Models\UserPermission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    protected $role;

    public function __construct(RoleInterface $role)
    {
        $this->role = $role;
        $this->middleware('auth');
    }

    protected function path(string $link)
    {
        return "admin.role.{$link}";
    }

    public function index()
    {

        if(request()->ajax()){
            $parameter_array = [];
            if(auth()->user()->role_id != $this->super_role){
                $parameter_array = [
                    'where' =>[['id','!=',$this->super_role]],
                ];
            }
            return $this->role->datatable($parameter_array);
        }
        return view($this->path('index'));

    }

    public function deletedListIndex()
    {
        if (request()->ajax()){
            $parameter_array = [];
            if(auth()->user()->role_id != $this->super_role){
                $parameter_array = [
                    'where' =>[['id','!=',$this->super_role]],
                ];
            }
            return $this->role->deletedDatatable($parameter_array);
        }
    }

    public function create()
    {
        $data['role'] = [];
        return view($this->path('create'),$data);
    }

    public function store(RoleRequest $request)
    {
        return $this->role->create($request);
    }

    public function show($id)
    {
        //
    }

    public function edit(Role $role)
    {
        $data['role'] = $role;
        return view($this->path('edit'))->with($data);
    }

    public function update(Role $role, RoleRequest $request)
    {
        return $this->role->update($role->id,$request);
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

    public function permission($id)
    {
        $data['role'] = Role::findOrFail($id);
        $data['menus'] = Menu::where('parent_id',null)->where('status',1)->get();
        $data['user_menu_action'] = UserMenuAction::where('status',1)->get();
        $data['menu_permission'] = RolePermission::where('permission_type','menu')->where('role_id',$id)->pluck('permission_id')->toArray();
        $data['menu_action_permission'] = RolePermission::where('permission_type','menu_action')->where('role_id',$id)->pluck('permission_id')->toArray();

        if(count(request()->all()) > 0 && request()->isMethod('POST')){
            return $this->role->permission($id);
        }else{
            return view($this->path('permission'))->with($data);
        }
    }

    public function getRolePermission(Request $request)
    {
        $role_id = $request->role_id;
        $data = [
            'menu_permission' => RolePermission::where('permission_type','menu')->where('role_id',$role_id)->pluck('permission_id')->toArray(),
            'menu_action_permission' => RolePermission::where('permission_type','menu_action')->where('role_id',$role_id)->pluck('permission_id')->toArray()
        ];

        return $data;
    }

    public function status(Request $request)
    {
        return $this->role->status($request->id);
    }
}
