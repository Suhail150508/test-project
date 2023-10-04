<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\DistrictInterface;
use App\Http\Resources\DistrictResource;
use App\Http\Requests\Admin\DistrictRequest;
use App\Models\District;
use App\Models\Division;

use App\Http\Resources\DistrictCollection;

class DistrictController extends Controller
{
    protected $district;

    public function __construct(DistrictInterface $district)
    {
        $this->district = $district;
    }

    public function index()
    {
        if (!empty(request()->all())) {
            // If more than 0
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;

            $query = District::with(['division'])
            ->where($fieldName, 'LIKE', "%$keyword%")
            ->orderBy('id', 'asc')
            ->paginate($perPage);

            return new DistrictCollection($query);
        } else {
            // If 0
            $query = $this->district->with(['division'])->get();

            return new DistrictCollection($query);
        }
    }

    public function deletedListIndex()
    {
        $district = $this->district->onlyTrashed();
        return response()->json($district);
    }

    public function create() {
        $divisions = Division::all();
        return response()->json($divisions);
    }

    public function store(DistrictRequest $request)
    {
        $district = $this->district->create($request);
        return new DistrictResource($district);
    }

    public function show(District $district) {
        $district = $this->district->findOrFail($district->id);
        return response()->json($district);
    }

    public function edit($id)
    {
        $district = $this->district->findOrFail($id);
        return response()->json($district);
    }

    public function update(DistrictRequest $request, District $district)
    {
        $district = $this->district->update($district->id, $request);
        $district['update'] = "update";
        return new DistrictResource($district);
    }

    public function destroy(District $district)
    {
        $district = $this->district->delete($district->id);
        return response()->json($district);
    }

    public function restore($id)
    {
        $district = $this->district->restore($id);
        return response()->json($district);
    }

    public function forceDelete($id)
    {
        $district = $this->district->forceDelete($id);
        return response()->json($district);
    }

    public function status(Request $request)
    {
        $district = $this->district->status($request->id);
        return response()->json($district);
    }


    public function division_districts($id) {
        $division_districts = District::where('division_id',$id)->get();
        return response()->json($division_districts);
     }

}
