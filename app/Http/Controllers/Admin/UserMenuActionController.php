<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\MenuHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MenuActionRequest;
use App\Http\Requests\Admin\UserMenuActionRequest;
use App\Models\Menu;
use App\Models\MenuAction;
use App\Models\UserMenuAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserMenuActionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function path(string $link){
        return "admin.user-menu-action.{$link}";
    }

    public function index($menu_id)
    {
        $menu = Menu::findOrFail($menu_id);
        $user_menu_action = UserMenuAction::with('menu')->where('menu_id',$menu_id);
        if(request()->ajax()){
            return \Datatables::of($user_menu_action)
                ->addIndexColumn()
                ->addColumn('parent_menu', function($data){
                    $parent_menu = '';
                    $parent_menu .= $data->menu->name;
                    return $parent_menu;
                })
                ->addColumn('type_name', function($data){
                    $type = '';
                    $type .= UserMenuAction::getType($data->type);
                    return $type;
                })
                ->addColumn('status', function($data){
                    $status = '';
                    $status .= MenuHelper::status($data->id, $data->status);
                    return $status;
                })
                ->addColumn('action', function($data){
                    $action = '';
                    $action .= '<a class="btn btn-info btn-sm" href="'.route('user_menu_action.edit',['menu_id' => $data->menu_id,'id' => $data->id]).'"><i class="fa fa-edit"></i></a>';
                    $action .= '<a class="btn btn-danger btn-sm destroy" href="'.route('user_menu_action.destroy',['menu_id' => $data->menu_id,'id' => $data->id]).'"><i class="fa fa-trash-alt"></i></a>';
                    return $action;
                })
                ->rawColumns(['parent_menu','status','action'])
                ->make(true);
        }else{
            return view($this->path('index'))->with(compact('menu'));
        }
    }

    public function deletedListIndex($menu_id){
        $menu = Menu::findOrFail($menu_id);

        $user_menu_action = UserMenuAction::with('menu')->where('menu_id',$menu_id)->onlyTrashed();
        if(request()->ajax()){
            return \Datatables::of($user_menu_action)
                ->addIndexColumn()
                ->addColumn('parent_menu', function($data){
                    $parent_menu = '';
                    $parent_menu .= $data->menu->name;
                    return $parent_menu;
                })
                ->addColumn('type_name', function($data){
                    $type = '';
                    $type .= UserMenuAction::getType($data->type);
                    return $type;
                })
                ->addColumn('status', function($data){
                    $status = '';
                    $status .= MenuHelper::status($data->id, $data->status);
                    return $status;
                })
                ->addColumn('action', function($data){
                    $action = '';
                    $action .= '<a class="btn btn-warning btn-sm restore mb-1" href="'.route('user_menu_action.restore',$data->id).'"><i class="fa fa-undo"></i></a>';
                    $action .= '<a class="btn btn-danger btn-sm destroy" href="'.route('user_menu_action.force_destroy',$data->id).'"><i class="fa fa-trash-alt"></i></a>';
                    return $action;
                })
                ->rawColumns(['parent_menu','status','action'])
                ->make(true);
        }
    }

    public function create($menu_id)
    {
        $data['menu'] = Menu::findOrFail($menu_id);
        $data['menu_action_list'] = MenuAction::pluck('name','id');
        $data['parent_user_menu_actions'] = UserMenuAction::where('menu_id',$menu_id)->pluck('name','id');
        return view($this->path('create'))->with($data);
    }

    public function store(UserMenuActionRequest $request,$menu_id)
    {
        try {
            $data = $request->all();
            $user_menu_action = New UserMenuAction();
            $data['menu_id'] = $menu_id;
            $user_menu_action->create($data);

            \Toastr::success('User Menu Action Created', 'Success');
            return redirect(route('user_menu_action.index',$menu_id));
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function edit($menu_id,$id)
    {
        $data['menu'] = Menu::findOrFail($menu_id);
        $data['menu_action_list'] = MenuAction::pluck('name','id');
        $data['user_menu_action'] = UserMenuAction::findOrFail($id);
        $data['parent_user_menu_actions'] = UserMenuAction::where('menu_id',$menu_id)->pluck('name','id');
        return view($this->path('edit'))->with($data);
    }

    public function update(UserMenuActionRequest $request,$menu_id,$id)
    {
        try {
            $data = $request->all();
            $user_menu_action = UserMenuAction::findOrFail($id);
            $data['menu_id'] = $menu_id;
            $user_menu_action->update($data);

            \Toastr::success('User Menu Action Updated', 'Success');
            return redirect(route('user_menu_action.index',$menu_id));
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function destroy($menu_id,$id)
    {
        $user_menu_action = UserMenuAction::findOrFail($id);
        $user_menu_action->delete();
        return response()->json([
            'message' => 'Data deleted'
        ]);
    }

    public function restore($id){
        try {
            $data = UserMenuAction::withTrashed()->find($id);
            $data->restore();
            return true;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function forceDelete($id){
        try {
            $data = UserMenuAction::withTrashed()->find($id);
            $data->forceDelete($id);
            return true;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function status(Request $request){
        DB::beginTransaction();
        try {
            $data =  UserMenuAction::find($request->id);
            if($data == null){
                $data =  $this->model::withTrashed()->find($request->id);
            }
            if($data->status === 'Active'){
                $data->status = 'Inactive';
            }elseif ($data->status ==='Inactive'){
                $data->status = 'Active';
            }elseif ($data->status === 1){
                $data->status = 0;
            }elseif ($data->status === 0){
                $data->status = 1;
            }
            $data->update();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
