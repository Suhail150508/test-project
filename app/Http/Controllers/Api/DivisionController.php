<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DivisionRequest;
use App\Http\Resources\DivisionResource;
use App\Interfaces\DivisionInterface;
use App\Models\Division;
use Illuminate\Http\Request;
use App\Http\Resources\DivisionCollection;

class DivisionController extends Controller
{
    protected $division;

    public function __construct(DivisionInterface $division)
    {
        $this->division = $division;
    }

    protected function path(string $link)
    {
        return "admin.division.{$link}";
    }

    public function index()
    {
        if(request()->per_page) {
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;
    
            $query = Division::query()
                ->where($fieldName, 'LIKE', "%$keyword%")
                ->orderBy('id', 'asc')
                ->paginate($perPage);
    
            return new DivisionCollection($query);
        }else{
            $division = Division::get();
            return response()->json($division);
        }
       
    }

    public function deletedListIndex()
    {
        $deleted_list = $this->division->onlyTrashed();
        return response()->json($deleted_list);
    }

    public function show(Division $division)
    {
        $division = Division::findOrFail($division->id);
        return response()->json($division);
    }

    public function store(DivisionRequest $request)
    {
        $division = $this->division->create($request);
        return new DivisionResource($division);
    }

    public function edit($id)
    {
        $division = $this->division->findOrFail($id);
        return response()->json($division);
    }


    public function update(DivisionRequest $request, Division $division)
    {
        $division = $this->division->update($division->id,$request);
        $request['update'] = "update";
        return new DivisionResource($division);
    }

    public function destroy(Division $division)
    {
        $division = $this->division->delete($division->id);
        return response()->json($division);
    }

    public function restore($id)
    {
        $division = $this->division->restore($id);
        return response()->json($division);
    }

    public function forceDelete($id)
    {
        $division =  $this->division->forceDelete($id);
        return  response()->json($division);
    }

    public function status(Request $request)
    {
        return $this->division->status($request->id);
    }

}
