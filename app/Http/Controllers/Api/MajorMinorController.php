<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\MajorMinorInterface;
use App\Http\Resources\MajorMinorResource;
use App\Http\Requests\Admin\MajorMinorRequest;
use App\Http\Resources\MajorMinorCollection;


use Illuminate\Http\Request;
use App\Models\MajorMinor;

class MajorMinorController extends Controller
{
    protected $majorminor;

    public function __construct(MajorMinorInterface $majorminor){
        $this->majorminor = $majorminor;
    }
    public function index()
    {
        if(request()->per_page) {
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;
    
            $query = MajorMinor::query()
                ->where($fieldName, 'LIKE', "%$keyword%")
                ->orderBy('id', 'asc')
                ->paginate($perPage);
    
            return new MajorMinorCollection($query);
        } else{
            $query = MajorMinor::query()
            ->orderBy('id', 'asc')->get();
            return response()->json($query);
    
        }
      
        // $majorminors  = MajorMinor::select(['id','title','description','status','created_by','updated_by'])->get();
        // return response()->json($majorminors);
    }

    public function deletedListIndex()
    {
        $major_minor = $this->majorminor->onlyTrashed();
        return response()->json($major_minor);
    }

    public function show($id)
    {
        $major_minor = $this->majorminor->findOrFail($id);
        return response()->json($major_minor);
    }

    public function store(MajorMinorRequest $request)
    {
        $majorminor = $this->majorminor->create($request);
        return new MajorMinorResource($majorminor);
    }

    public function edit($id)
    {
        $majorminor = $this->majorminor->findOrFail($id);
        return response()->json($majorminor);
    }

    public function update(MajorMinorRequest $request, MajorMinor $major_minor)
    {
        $majorminor = $this->majorminor->update($major_minor->id,$request);
        $request['update'] = "update";
        return new MajorMinorResource($majorminor);
    }

    public function destroy(MajorMinor $major_minor)
    {
        $majorminor = $this->majorminor->delete($major_minor->id);
        return response()->json([
            'message' => trans('majorminor.deleted'),
        ], 200);
    }

    public function forceDelete($id)
    {
        $major_minor =  $this->majorminor->forceDelete($id);
        return response()->json([
            'message' => trans('majorminor.permanent_deleted'),
        ], 200);
    }

    public function restore($id)
    {
        $major_minor = $this->majorminor->restore($id);
        return response()->json([
            'message' => trans('majorminor.restored'),
        ], 200);
    }

    public function status(Request $request)
    {
        $this->majorminor->status($request->id);
        return response()->json([
            'message' => trans('majorminor.status_updated'),
        ], 200);
    }
}
