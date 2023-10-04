<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MenuActionRequest;
use App\Interfaces\MenuActionInterface;
use App\Models\MenuAction;
use Illuminate\Http\Request;

class MenuActionController extends Controller
{
    protected $menu_action;

    public function __construct(MenuActionInterface $menu_action)
    {
        $this->menu_action = $menu_action;
        $this->middleware('auth');
    }

    protected function path(string $link)
    {
        return "admin.menu-action.{$link}";
    }

    public function index()
    {
        return $this->menu_action->datatable();
    }

    public function deletedListIndex()
    {
        return $this->menu_action->deletedDatatable();
    }

    public function create()
    {
        return view($this->path('create'));
    }

    public function store(MenuActionRequest $request)
    {
        return $this->menu_action->create($request);
    }

    public function show(MenuAction $menuAction)
    {

    }

    public function edit(MenuAction $menuAction)
    {
        $data['menuAction'] = $menuAction;
        return view($this->path('edit'))->with($data);
    }

    public function update(MenuActionRequest $request, MenuAction $menuAction)
    {
        return $this->menu_action->update($menuAction->id,$request);
    }

    public function destroy(MenuAction $menuAction)
    {

        return $this->menu_action->delete($menuAction->id);
    }

    public function restore($id)
    {
        return $this->menu_action->restore($id);
    }

    public function forceDelete($id)
    {
        return $this->menu_action->forceDelete($id);
    }

    public function status(Request $request)
    {
        return $this->menu_action->status($request->id);
    }
}
