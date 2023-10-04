<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\MenuActionInterface;
use App\Models\MenuAction;
use Illuminate\Http\Request;

class MenuActionController extends Controller
{
    protected $menu_action;

    public function __construct(MenuActionInterface $menu_action)
    {
        $this->menu_action = $menu_action;
    }
    public function index()
    {
        $menuAction =  $this->menu_action->get();
        return response()->json($menuAction);
    }

    public function deletedListIndex()
    {
        $menu_action = $this->menu_action->onlyTrashed();
        return response()->json($menu_action);
    }

    public function store(Request $request)
    {
        return $this->menu_action->create($request);
    }


    public function show(MenuAction $menuAction)
    {
        $menu_action = $this->menu_action->findOrFail($menuAction->id);
        return response()->json($menu_action);
    }

    public function edit($id)
    {
        $menu_action = $this->menu_action->findOrFail($id);
        return response()->json($menu_action);
    }


    public function update(Request $request, MenuAction $menuAction)
    {
        return $this->menu_action->update($menuAction->id,$request);
    }


    public function destroy( MenuAction $menuAction)
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
