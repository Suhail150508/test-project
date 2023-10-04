<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\ActivityLogInterface;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    protected $activity_log;

    public function __construct(ActivityLogInterface $activity_log)
    {
        $this->activity_log = $activity_log;
        $this->middleware('auth');
    }

    protected function path(string $link)
    {
        return "admin.activity_log.{$link}";
    }

    public function index()
    {
        if(request()->ajax()){
            return $this->activity_log->datatable();
        }
        return view($this->path('index'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $activity = Activity::findorfail($id);
        return view($this->path('view'),compact('activity'));
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy(Activity $activity_log)
    {
        return $this->activity_log->delete($activity_log->id);
    }
}
