<?php

namespace App\Http\Controllers\Api;

use App\Models\Menu;
use App\Models\MenuAction;
use App\Helpers\MenuHelper;
use Illuminate\Http\Request;
use App\Models\UserMenuAction;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserMenuActionResource;
use App\Http\Requests\Admin\UserMenuActionRequest;

class UserMenuActionController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index($menu_id)
    {
        $user_menu_actions = UserMenuAction::with('menu')->where('menu_id', $menu_id)->get();
        return response()->json($user_menu_actions);
    }

    public function getActions()
    {
        $user_menu_actions = UserMenuAction::with('menu','menuAction')->get();
        return response()->json($user_menu_actions);
    }

    public function deletedListIndex($menu_id){
        $user_menu_actions = UserMenuAction::with('menu')->where('menu_id', $menu_id)->onlyTrashed()->get();
        return response()->json($user_menu_actions);
    }

    public function store(UserMenuActionRequest $request, $menu_id)
    {
        try {
            $data = $request->all();
            $user_menu_action = New UserMenuAction();
            $data['menu_id'] = $menu_id;
            $user_menu_action_create = $user_menu_action->create($data);

            return response()->json([
                'data' => $user_menu_action_create,
                'message' => trans('user_menu_action/attribute.user_menu_created_successfully'),
            ], 200);

            // return new UserMenuActionResource($user_menu_action_create);
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function update(UserMenuActionRequest $request, $menu_id, $id)
    {
        try {
            $data = $request->all();
            $user_menu_action = UserMenuAction::findOrFail($id);
            $data['menu_id'] = $menu_id;
            $user_menu_action->update($data);

            $updatedData = UserMenuAction::findOrFail($id);
            return response()->json([
                'data' => $updatedData,
                'message' => trans('user_menu_action/attribute.user_menu_updated_successfully'),
            ], 200);

            // $updatedData['update'] = "update";
            // return new UserMenuActionResource($updatedData);
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function destroy($menu_id,$id)
    {
        $user_menu_action = UserMenuAction::findOrFail($id);
        $user_menu_action->delete();

        return response()->json([
            'message' => trans('user_menu_action/attribute.user_menu_deleted_successfully'),
        ], 200);
    }

    public function restore($id){
        try {
            $data = UserMenuAction::withTrashed()->find($id);
            $data->restore();

            return response()->json([
                'message' => trans('user_menu_action/attribute.user_menu_restored_successfully'),
            ], 200);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function forceDelete($id){
        try {
            $data = UserMenuAction::withTrashed()->find($id);
            $data->forceDelete($id);

            return response()->json([
                'message' => trans('user_menu_action/attribute.user_menu_deleted_permanently'),
            ], 200);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function status(Request $request){
        DB::beginTransaction();
        try {
            $data =  UserMenuAction::find($request->id);
            if($data == null){
                $data =  UserMenuAction::withTrashed()->find($request->id);
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

            return response()->json([
                'message' => trans('user_menu_action/attribute.user_menu_status_updated_successfully'),
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
