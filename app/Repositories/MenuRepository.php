<?php


namespace App\Repositories;

use App\Helpers\MenuHelper;
use App\Interfaces\MenuInterface;
use App\Models\Menu;
use App\Models\UserMenuAction;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;
use function Symfony\Component\HttpKernel\DataCollector\getMessage;


class MenuRepository extends BaseRepository implements MenuInterface
{
    public function __construct(Menu $model)
    {
        $this->model = $model;
    }


    protected function path(string $link){
        return "admin.menu.{$link}";
    }

    public function datatable(array $relations = null, $make_true = null){
        $menu_list = $this->model::with('parent','children');
        if(request()->ajax()){
            return \Datatables::of($menu_list)
                ->addIndexColumn()
                ->addColumn('multi_checkbox', function($data){
                    $checkbox = '<input type="checkbox" name="multi_checkbox[]" class="multi_checkbox" value="'.$data->id.'" />';
                    return $checkbox;
                })
                ->addColumn('parent', function($data){
                    $parent = '';
                    if(@$data->parent->bn_name){
                        $parent .= @$data->parent->bn_name;
                    }else{
                        $parent .= @$data->parent->name;
                    }
                    return $parent;
                })
                ->addColumn('status', function($data){
                    $status = '';
                    $status .= MenuHelper::status($data->id, $data->status);
                    return $status;
                })
                ->addColumn('action', function($data){
                    $action = '';
                    $action .= '<a class="btn btn-primary btn-sm" href="'.route('user_menu_action.index',$data->id).'"><i class="fa fa-eye"></i></a>';
                    $action .= '<a class="btn btn-info btn-sm" href="'.route('menu.edit',$data->id).'"><i class="fa fa-edit"></i></a>';
                    $action .= '<a class="btn btn-danger btn-sm destroy" href="'.route('menu.destroy',$data->id).'"><i class="fa fa-trash-alt"></i></a>';
                    return $action;
                })
                ->rawColumns(['multi_checkbox','parent','status','action'])
                ->make(true);
        }else{
            return view($this->path('index'));
        }
    }

    public function deletedDatatable(array $relations = null, $make_true = null){
        $menu_list = $this->model::with('parent','children')->onlyTrashed();
        if(request()->ajax()){
            return \Datatables::of($menu_list)
                ->addIndexColumn()
                ->addColumn('multi_checkbox', function($data){
                    $checkbox = '<input type="checkbox" name="multi_checkbox[]" class="multi_checkbox" value="'.$data->id.'" />';
                    return $checkbox;
                })
                ->addColumn('parent', function($data){
                    $parent = '';
                    $parent .= @$data->parent->name;
                    return $parent;
                })
                ->addColumn('status', function($data){
                    $status = '';
                    $status .= MenuHelper::status($data->id, $data->status);
                    return $status;
                })
                ->addColumn('action', function($data){
                    $action = '';
                    $action .= '<a class="btn btn-warning btn-sm restore mb-1" href="'.route('menu.restore',$data->id).'"><i class="fa fa-undo"></i></a>';
                    $action .= '<a class="btn btn-danger btn-sm destroy" href="'.route('menu.force_destroy',$data->id).'"><i class="fa fa-trash-alt"></i></a>';
                    return $action;
                })
                ->rawColumns(['multi_checkbox','parent','status','action'])
                ->make(true);
        }
    }

    public function create(object $data, array $parameters = null){
        try {
            $menu = New Menu();
            $menu = $menu->create($data->all());

            $parent_id = '';
            if(@$data->actions != null){
                foreach ($data->actions as $action => $value){
                    $user_menu_action = $this->actionBuilder($action,$menu->id,$menu->route_name);
                    $user_menu_action->save();
                    if ($action == 'deleted_list'){
                        $parent_id = $user_menu_action->id;
                    } elseif ($action == 'restore' || $action == 'permanent_delete'){
                        $user_menu_action->update(['parent_id' => $parent_id]);
                    }
                }
            }

            \Toastr::success('Menu Created', 'Success');
//            return redirect(route('menu.index'));
            return $menu;
        } catch (\Exception $e) {
            dd($e->getMessage());
//            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function update($id, object $data, array $parameters = null){
        try {
            $menu = $this->model::find($id);
            $menu->update($data->all());
            if(@$data->actions != null){
                foreach ($data->actions as $action => $value){
                    $user_menu_action = $this->actionBuilder($action,$menu->id,$menu->route_name);
                    $user_menu_action->save();
                    if ($action == 'deleted_list'){
                        $parent_id = $user_menu_action->id;
                    } elseif ($action == 'restore' || $action == 'permanent_delete'){
                        $user_menu_action->update(['parent_id' => $parent_id]);
                    }
                }
            }

            \Toastr::success('Menu Updated', 'Success');
            return $menu;
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    private function actionBuilder($action,$menu_id,$route = null){
        if ($action == 'add'){
            return new UserMenuAction([
                'menu_id' => $menu_id,
                'menu_action_id' => 1,
                'name' => 'Add',
                'bn_name' => 'সংযোজন',
                'route_name' => $route ? explode('.',$route)[0].'.create' : null,
                'type' => 'action',
                'order_by' => 1,
                'is_hidden' => 'No',
                'show_in_table' => 0,
                'new_tab' => 0,
                'status' => 1,
            ]);
        } elseif ($action == 'edit'){
            return new UserMenuAction([
                'menu_id' => $menu_id,
                'menu_action_id' => 2,
                'name' => 'Edit',
                'bn_name' => 'পরিমার্জন',
                'route_name' => $route ? explode('.',$route)[0].'.edit' : null,
                'type' => 'action',
                'order_by' => 2,
                'is_hidden' => 'No',
                'show_in_table' => 1,
                'new_tab' => 0,
                'status' => 1,
            ]);
        } elseif ($action == 'delete'){
            return new UserMenuAction([
                'menu_id' => $menu_id,
                'menu_action_id' => 3,
                'name' => 'Delete',
                'bn_name' => 'ডিলেট',
                'route_name' => $route ? explode('.',$route)[0].'.destroy' : null,
                'type' => 'action',
                'order_by' => 4,
                'is_hidden' => 'No',
                'show_in_table' => 1,
                'new_tab' => 0,
                'status' => 1,
            ]);
        } elseif ($action == 'view'){
            return new UserMenuAction([
                'menu_id' => $menu_id,
                'menu_action_id' => 4,
                'name' => 'View',
                'bn_name' => 'ভিউ',
                'route_name' => $route ? explode('.',$route)[0].'.show' : null,
                'type' => 'action',
                'order_by' => 3,
                'is_hidden' => 'No',
                'show_in_table' => 1,
                'new_tab' => 0,
                'status' => 1,
            ]);
        } elseif ($action == 'print'){
            return new UserMenuAction([
                'menu_id' => $menu_id,
                'menu_action_id' => 9,
                'name' => 'Print',
                'bn_name' => 'প্রিন্ট',
                'route_name' => $route ? explode('.',$route)[0].'.print' : null,
                'type' => 'action',
                'order_by' => 5,
                'is_hidden' => 'No',
                'show_in_table' => 1,
                'new_tab' => 1,
                'status' => 1,
            ]);
        } elseif ($action == 'deleted_list'){
            return new UserMenuAction([
                'menu_id' => $menu_id,
                'name' => 'Trash',
                'bn_name' => 'ডিলেটেড লিস্ট',
                'route_name' => $route ? explode('.',$route)[0].'.deleted_list' : null,
                'type' => 'tab',
                'slug' => 'deleted_list',
                'order_by' => 6,
                'is_hidden' => 'No',
                'show_in_table' => 0,
                'new_tab' => 0,
                'status' => 1,
            ]);
        } elseif ($action == 'restore'){
            return new UserMenuAction([
                'menu_id' => $menu_id,
                'menu_action_id' => 10,
                'name' => 'Restore',
                'bn_name' => 'পুনরুদ্ধার',
                'route_name' => $route ? explode('.',$route)[0].'.restore' : null,
                'type' => 'action',
                'slug' => 'restore',
                'order_by' => 7,
                'is_hidden' => 'No',
                'show_in_table' => 1,
                'new_tab' => 0,
                'status' => 1,
            ]);
        } elseif ($action == 'permanent_delete'){
            return new UserMenuAction([
                'menu_id' => $menu_id,
                'menu_action_id' => 3,
                'name' => 'Delete Permanently',
                'bn_name' => 'স্থায়ীভাবে ডিলেট',
                'route_name' => $route ? explode('.',$route)[0].'.force_destroy' : null,
                'type' => 'action',
                'slug' => 'force_destroy',
                'order_by' => 8,
                'is_hidden' => 'No',
                'show_in_table' => 1,
                'new_tab' => 0,
                'status' => 1,
            ]);
        } elseif ($action == 'edit_history'){
            return new UserMenuAction([
                'menu_id' => $menu_id,
                'menu_action_id' => 11,
                'name' => 'Edit History',
                'bn_name' => 'পরিমার্জনের ইতিহাস',
                'route_name' => null,
                'type' => 'action',
                'slug' => 'edit_history',
                'order_by' => 9,
                'is_hidden' => 'No',
                'show_in_table' => 1,
                'new_tab' => 0,
                'status' => 1,
            ]);
        }
    }
}
