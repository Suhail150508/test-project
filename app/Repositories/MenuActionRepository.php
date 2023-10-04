<?php


namespace App\Repositories;


use App\Helpers\MenuHelper;
use App\Interfaces\MenuActionInterface;
use App\Models\MenuAction;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;


class MenuActionRepository extends BaseRepository implements MenuActionInterface
{
    public function __construct(MenuAction $model)
    {
        $this->model = $model;
    }


    protected function path(string $link){
        return "admin.menu-action.{$link}";
    }

    public function datatable(array $relations = null, $make_true = null){
        $menu_list = $this->model::query();
        if(request()->ajax()){
            return \Datatables::of($menu_list)
                ->addIndexColumn()
                ->addColumn('status', function($data){
                    $status = '';
                    $status .= MenuHelper::status($data->id, $data->status);
                    return $status;
                })
                ->addColumn('action', function($data){
                    $action = '';
                    $action .= '<a class="btn btn-info btn-sm" href="'.route('menu_action.edit',$data->id).'"><i class="fa fa-edit"></i></a>';
                    $action .= '<a class="btn btn-danger btn-sm destroy" href="'.route('menu_action.destroy',$data->id).'"><i class="fa fa-trash-alt"></i></a>';
                    return $action;
                })
                ->rawColumns(['parent','status','action'])
                ->make(true);
        }else{
            return view($this->path('index'));
        }
    }

    public function deletedDatatable(array $relations = null, $make_true = null){
        $menu_list = $this->model::query()->onlyTrashed();
        if(request()->ajax()){
            return \Datatables::of($menu_list)
                ->addIndexColumn()
                ->addColumn('status', function($data){
                    $status = '';
                    $status .= MenuHelper::status($data->id, $data->status);
                    return $status;
                })
                ->addColumn('action', function($data){
                    $action = '';
                    $action .= '<a class="btn btn-warning btn-sm restore mb-1" href="'.route('menu_action.restore',$data->id).'"><i class="fa fa-undo"></i></a>';
                    $action .= '<a class="btn btn-danger btn-sm destroy" href="'.route('menu_action.force_destroy',$data->id).'"><i class="fa fa-trash-alt"></i></a>';
                    return $action;
                })
                ->rawColumns(['parent','status','action'])
                ->make(true);
        }
    }
}
