<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\MenuInterface;
use App\Models\MenuAction;
use App\Models\Role;
use App\Models\UserMenuAction;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\MenuRequest;

use App\Models\Menu;

class MenuController extends Controller
{
    protected $menu;
    protected $deleted_relation;

    public function __construct(MenuInterface $menu)
    {
        $this->menu = $menu;
        $this->deleted_relation = ['userMenuAction'];
        $this->middleware('auth');
    }

    protected function path(string $link)
    {
        return "admin.menu.{$link}";
    }

    public function index()
    {
        $parameter_array = [
            'relations' =>['parent']
        ];
        return $this->menu->datatable($parameter_array);
    }

    public function deletedListIndex()
    {
        $parameter_array = [
            'relations' =>['parent']
        ];
        return $this->menu->deletedDatatable($parameter_array);
    }

    public function create()
    {
        $data['menus'] = Menu::query()->pluck('bn_name','id');
        $data['roles'] = Role::query()->pluck('bn_name','id');
        $actions_array_to_ignore = ['permission','order','check','restore','custom_element'];
        $data['actions'] = MenuAction::query()->whereNotIn('slug',$actions_array_to_ignore)->get();
        return view($this->path('create'))->with($data);
    }

    public function store(MenuRequest $request)
    {
        return $this->menu->create($request);
    }

    public function show(Menu $menu)
    {
        //
    }

    public function edit(Menu $menu)
    {
        $data['menu'] = $menu;
        $data['menus'] = Menu::query()->pluck('name','id');
        $data['roles'] = Role::query()->pluck('name','id');
        $actions_array_to_ignore = ['permission','order','check','restore','custom_element'];

        foreach ($menu->userMenuAction as $action){
            if ($action->slug != null){
                array_push($actions_array_to_ignore,$action->slug);
            }
        }

        $data['actions'] = MenuAction::query()->whereNotIn('slug',$actions_array_to_ignore)->get();
        return view($this->path('edit'))->with($data);
    }

    public function update(MenuRequest $request, Menu $menu)
    {
        return $this->menu->update($menu->id,$request);
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
