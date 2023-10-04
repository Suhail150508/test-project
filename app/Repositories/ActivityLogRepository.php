<?php


namespace App\Repositories;

use Spatie\Activitylog\Models\Activity;
use App\Interfaces\ActivityLogInterface;

class ActivityLogRepository extends BaseRepository implements ActivityLogInterface
{
    public function __construct(Activity $activity)
    {
        $this->model = $activity;
    }

    public function datatable(array $relations = null, $make_true = null){
        return \Datatables::of($relations? $this->model->with($relations) : $this->query())
            ->addIndexColumn()
            ->addColumn('action', function($data){
                $action_array = [
                    'id' => $data->id
                ];
                $action = \App\Helpers\MenuHelper::TableActionButton($action_array);
                return $action;
            })
            ->addColumn('created_by', function($data){
                $created_by = $data->causer->bn_name ;
                return $created_by;
            })
            ->addColumn('date_time', function($data){
                $date_time = date('d-m-Y  h:i a', strtotime($data->created_at));
                return $date_time;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

}
