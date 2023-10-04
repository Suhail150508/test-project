<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProfileRequest;
use App\Http\Requests\Admin\UserRequest;
use App\Interfaces\UserInterface;
use App\Models\District;
use App\Models\Division;
use App\Models\Employee;
use App\Models\Menu;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\UserPermission;
use App\Models\User;
use App\Models\UserMenuAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $user;

    public function __construct(UserInterface $user)
    {
        $this->user = $user;
        $this->middleware('auth');
    }

    protected function path(string $link)
    {
        return "admin.user.{$link}";
    }

    public function index(Request $request)
    {
        if(request()->ajax()){
            $parameter_array = [];
            if(auth()->user()->role_id != $this->super_role){
                $parameter_array = [
                    'where' =>[['role_id','!=',$this->super_role]],
                    'relations' =>['role']
                ];
            }
            return $this->user->datatable($parameter_array);
        }
        return view($this->path('index'));

    }

    public function deletedListIndex()
    {
        if (request()->ajax()){
            $parameter_array = [];
            if(auth()->user()->role_id != $this->super_role){
                $parameter_array = [
                    'where' =>[['role_id','!=',$this->super_role]],
                    'relations' =>['role']
                ];
            }
            return $this->user->deletedDatatable($parameter_array);
        }
    }

    public function create()
    {
        if(auth()->user()->role_id != $this->super_role){
            $roles = Role::query()->where('status','Active')->where('id','!=',$this->super_role)->pluck('name','id');
        }else{
            $roles = Role::query()->where('status','Active')->pluck('name','id');
        }
        $data = array(
            'roles' => $roles,
        );
        return view($this->path('create'))->with($data);
    }

    public function store(UserRequest $request)
    {
        return $this->user->create($request);
    }

    public function show($id)
    {
        //
    }

    public function edit(User $user)
    {
        if(auth()->user()->role_id != $this->super_role){
            $roles = Role::query()->where('status','Active')->where('id','!=',$this->super_role)->pluck('name','id');
        }else{
            $roles = Role::query()->where('status','Active')->pluck('name','id');
        }

        $data = array(
            'roles' => $roles,
            'user' => $user,
        );

        return view($this->path('edit'))->with($data);
    }

    public function update(UserRequest $request, User $user)
    {
        if($request->password != null){
            $request['password'] = Hash::make($request->password);
        }else{
            $request['password'] = $user->password;
        }
        return $this->user->update($user->id,$request);
    }

    public function destroy(User $user)
    {
        return $this->user->delete($user->id);
    }

    public function restore($id)
    {
        return $this->user->restore($id);
    }

    public function forceDelete($id)
    {
        return $this->user->forceDelete($id);
    }

    public function permission($id)
    {
        $data['user'] = User::findOrFail($id);
        $data['role'] = $data['user']->role;
        $data['menus'] = Menu::where('parent_id',null)->where('status',1)->get();
        $data['user_menu_action'] = UserMenuAction::where('status',1)->get();
        $data['menu_permission'] = UserPermission::where('permission_type','menu')->where('user_id',$id)->pluck('permission_id')->toArray();
        $data['menu_action_permission'] = UserPermission::where('permission_type','menu_action')->where('user_id',$id)->pluck('permission_id')->toArray();
        return view($this->path('permission'))->with($data);
    }

    public function permissionUpdate(Request $request, $id)
    {
        return $this->user->permissionUpdate($request,$id);

    }

    public function profile()
    {
        $id = auth()->user()->id;
        $user = User::find($id);
        $data = array(
            'user' => $user,
        );
        return view($this->path('profile'))->with($data);
    }

    public function profileUpdate(ProfileRequest $request, $id)
    {
        return $this->user->profileUpdate($request,$id);
    }

    public function status(Request $request)
    {
        return $this->user->status($request->id);
    }
}
