<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MenuRequest;
use App\Http\Resources\MenuCollection;
use App\Http\Resources\MenuResource;
use App\Interfaces\MenuInterface;
use App\Models\Menu;
use App\Models\UserMenuAction;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    protected $menu;
    protected $deleted_relation;

    public function __construct(MenuInterface $menu)
    {
        $this->menu = $menu;
//        $this->deleted_relation = ['userMenuAction'];
    }

/*    public function index()
    {
        $menu  = $this->menu->with(['parent'])->get();
        return response()->json($menu);
    }*/

    public function index()
    {
        if (request()->per_page) {
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;

            $query = Menu::query()
                ->with('parent')
                ->where($fieldName, 'LIKE', "%$keyword%")
                ->orderBy('id', 'asc')
                ->paginate($perPage);

            return new MenuCollection($query);
        } else {
            $query = $this->menu->with(['parent'])->get();

            return new MenuCollection($query);
        }
    }

    public function deletedListIndex()
    {
        $deleted_list = $this->menu->onlyTrashed();
        return response()->json($deleted_list);
//        $parameter_array = [
//            'relations' =>['parent']
//        ];
    }

    public function store(MenuRequest $request)
    {
//        $menu = $this->menu->create($request);
//        return new MenuResource($menu);

        try {
            $menu = New Menu();
            $menu = $menu->create($request->all());

            $parent_id = '';

            if ($request->checkedItems != null){
                foreach ($request->checkedItems as $key => $value){
                    $user_menu_action = new UserMenuAction();
                    $user_menu_action->menu_id = $menu->id;
                    $user_menu_action->menu_action_id = $value;
                    $user_menu_action->save();
                }
            }

            return new MenuResource($menu);
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function show(Menu $menu)
    {
        $menu = $this->menu->findOrFail($menu->id);
        return response()->json($menu);
    }

    public function edit($id)
    {
        $menu = $this->menu->findOrFail($id);
        return response()->json($menu);
    }

    public function update(MenuRequest $request, Menu $menu)
    {
        $menu =  $this->menu->update($menu->id,$request);
        $request['update'] = "update";
        return new MenuResource($menu);
    }

    public function destroy(Menu $menu)
    {
        return $this->menu->delete($menu->id);
    }

    public function restore($id)
    {
        return $this->menu->restore($id);
    }

    public function forceDelete($id)
    {
        return $this->menu->forceDelete($id);
    }

    public function status(Request $request)
    {
        return $this->menu->status($request->id);
    }

    Public function multipleDelete(Request $request)
    {
        return $this->menu->multipleDelete($request);
    }

    Public function multipleRestore(Request $request)
    {
        return $this->menu->multipleRestore($request);
    }
}
