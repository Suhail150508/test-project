<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\JobInterestedAreaRequest;
use App\Http\Resources\JobInterestedAreaCollection;
use App\Http\Resources\JobInterestedAreaResource;
use App\Interfaces\JobInterestedAreaInterface;
use App\Models\JobInterestedArea;
use Illuminate\Http\Request;
use App\Models\Department;

class JobInterestedAreaController extends Controller
{
    protected $jobInterestedArea;

    public function __construct(JobInterestedAreaInterface $jobInterestedArea)
    {
        $this->jobInterestedArea = $jobInterestedArea;
    }

    public function index()
    {
        $perPage = request()->per_page;
        $fieldName = request()->field_name;
        $keyword = request()->keyword;

        $query = JobInterestedArea::with(['department'])
            ->where($fieldName, 'LIKE', "%$keyword%")
            ->orderBy('id', 'asc')
            ->paginate($perPage);
            
        return new JobInterestedAreaCollection($query);
    }

    public function deletedListIndex()
    {
        $jobInterestedArea = $this->jobInterestedArea->onlyTrashed();
        return response()->json($jobInterestedArea);
    }

    public function create() {
        $departments = Department::all();
        return response()->json($departments);
    }

    public function store(JobInterestedAreaRequest $request)
    {
        $jobInterestedArea = $this->jobInterestedArea->create($request);
        return new JobInterestedAreaResource($jobInterestedArea);
    }

    public function show(JobInterestedArea $jobInterestedArea)
    {
        $jobInterestedArea = $this->jobInterestedArea->findOrFail($jobInterestedArea->id);
        return response()->json($jobInterestedArea);
    }

    public function edit($id)
    {
        $jobInterestedArea = $this->jobInterestedArea->findOrFail($id);
        return response()->json($jobInterestedArea);
    }

    public function update(JobInterestedAreaRequest $request, JobInterestedArea $jobInterestedArea)
    {
        $jobInterestedArea = $this->jobInterestedArea->update($jobInterestedArea->id,$request);
        $request['update'] = 'update';
        return new JobInterestedAreaResource($jobInterestedArea);
    }

    public function destroy(JobInterestedArea $jobInterestedArea)
    {
        $this->jobInterestedArea->delete($jobInterestedArea->id);
        return response()->json([
            'message' => trans('jobInterestedArea.deleted'),
        ], 200);
    }

    public function restore($id)
    {
        $this->jobInterestedArea->restore($id);
        return response()->json([
            'message' => trans('jobInterestedArea.restored'),
        ], 200);
    }

    public function forceDelete($id)
    {
        $this->jobInterestedArea->forceDelete($id);
        return response()->json([
            'message' => trans('jobInterestedArea.permanent_deleted'),
        ], 200);
    }

    public function status(Request $request)
    {
        $this->jobInterestedArea->status($request->id);
        return response()->json([
            'message' => trans('jobInterestedArea.status_updated'),
        ], 200);
    }
}
