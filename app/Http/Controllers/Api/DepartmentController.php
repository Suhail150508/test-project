<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DepartmentRequest;
use App\Http\Resources\DepartmentResource;
use App\Interfaces\DepartmentInterface;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Resources\DepartmentCollection;

class DepartmentController extends Controller
{
    protected $department;

    public function __construct(DepartmentInterface $department)
    {
        $this->department = $department;
    }

    public function index()
    {
        if (request()->per_page) {
            // If more than 0
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;

            $query = Department::query()
                ->where($fieldName, 'LIKE', "%$keyword%")
                ->orderBy('id', 'asc')
                ->paginate($perPage);

            return new DepartmentCollection($query);
        } else {
            // If 0
            $query = $this->department->get();

            return new DepartmentCollection($query);
        }
    }

    public function deletedListIndex()
    {
        $deleted_list = $this->department->onlyTrashed();
        return response()->json($deleted_list);
    }

    public function store(DepartmentRequest $request)
    {
        $department = $this->department->create($request);
        return response()->json($department);
    }

    public function show(Department $department)
    {
        $department = $this->department->findOrFail($department->id);
        return response()->json($department);
    }

    public function edit($id)
    {
        $department = $this->department->findOrFail($id);
        return response()->json($department);
    }

    public function update(DepartmentRequest $request, Department $department)
    {
        $department = $this->department->update($request->department_id,$request);
        $request['update'] = "update";
        return new DepartmentResource($department);
    }

    public function destroy(Department $department)
    {
        $department = $this->department->delete($department->id);
        return response()->json($department);
    }

    public function restore($id)
    {
        return $this->department->restore($id);
    }

    public function forceDelete($id)
    {
        return $this->department->forceDelete($id);
    }

    public function status(Request $request)
    {
        return $this->department->status($request->id);
    }
}
