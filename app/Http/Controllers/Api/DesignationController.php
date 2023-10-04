<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DesignationRequest;
use App\Http\Resources\DesignationResource;
use App\Interfaces\DesignationInterface;
use App\Models\Designation;
use Illuminate\Http\Request;
use App\Http\Resources\DesignationCollection;

class DesignationController extends Controller
{
    protected $designation;

    public function __construct(DesignationInterface $designation)
    {
        $this->designation = $designation;
    }

    public function index()
    {
        if (request()->per_page){
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;

            $query = Designation::query()
                ->where($fieldName, 'LIKE', "%$keyword%")
                ->orderBy('id', 'asc')
                ->paginate($perPage);

            return new DesignationCollection($query);

        } else{
            $designation = $this->designation->get();

            return new DesignationCollection($designation);
        }


    }

    public function deletedListIndex()
    {
        $designations = $this->designation->onlyTrashed();
        return response()->json($designations);
    }

    public function store(DesignationRequest $request)
    {
        $designation = $this->designation->create($request);
        return response()->json($designation);
    }

    public function show(Designation $designation)
    {
        $designation = $this->designation->findOrFail($designation->id);
        return response()->json($designation);
    }

    public function edit($id)
    {
        $designation = $this->designation->findOrFail($id);
        return response()->json($designation);
    }

    public function update(DesignationRequest $request, Designation $designation)
    {
        $designation = $this->designation->update($designation->id, $request);
        $designation['update'] = "update";
        return new DesignationResource($designation);
    }

    public function destroy(Designation $designation)
    {
        $designation = $this->designation->delete($designation->id);
        return response()->json($designation);
    }

    public function restore($id)
    {
        $designation = $this->designation->restore($id);
        return response()->json($designation);
    }

    public function forceDelete($id)
    {
        $designation = $this->designation->forceDelete($id);
        return response()->json($designation);
    }

    public function status(Request $request)
    {
        $designation = $this->designation->status($request->id);
        return response()->json($designation);
    }
}
