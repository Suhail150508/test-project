<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ThanaRequest;
use App\Http\Resources\ThanaCollection;
use App\Http\Resources\ThanaResource;
use App\Interfaces\ThanaInterface;
use App\Models\Thana;

class ThanaController extends Controller
{
    protected $thana;

    public function __construct(ThanaInterface $thana)
    {
        $this->thana = $thana;
    }

    public function index() {
        if(request()->per_page) {
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;
    
            $query = Thana::query()
                ->where($fieldName, 'LIKE', "%$keyword%")
                ->orWhereHas('division', function($query) {
                    $keyword = request()->keyword;
                    $fieldName = request()->field_name;
                    $query->where($fieldName,'LIKE', "%$keyword%");
                })
                ->orWhereHas('district', function($query1) {
                    $keyword = request()->keyword;
                    $fieldName = request()->field_name;
                    $query1->where($fieldName,'LIKE', "%$keyword%");
                })
                ->orderBy('id', 'asc')
                ->paginate($perPage);
    
            return new ThanaCollection($query);
        }else{
       $thana  = $this->thana->get();
       return response()->json($thana);
        }
       


    }

    public function deletedListIndex(){
        $deleted_list = $this->thana->onlyTrashed();
        return response()->json($deleted_list);
    }

    public function store(ThanaRequest $request){
        $thana = $this->thana->create($request);
        return new ThanaResource($thana);
    }

    public function show(Thana $thana)
    {
        $thana = $this->thana->findOrFail($thana->id);
        return response()->json($thana);
    }

    public function edit($id)
    {
        $thana = $this->thana->findOrFail($id);
        // return response()->json($thana);
    }

    public function update(ThanaRequest $request, Thana $thana){
        $division = $this->thana->update($thana->id,$request);
        $request['update'] = "update";
        return new ThanaResource($thana);
    }

    public function destroy(Thana $thana){
        $thana = $this->thana->delete($thana->id);
        return response()->json($thana);
    }

    public function restore($id){
        $thana = $this->thana->restore($id);
        return response()->json($thana);
    }

    public function forceDelete($id){
        $thana =  $this->thana->forceDelete($id);
        return  response()->json($thana);
    }

    public function status(Request $request){
        return $this->thana->status($request->id);
    }

    public function district_thanas($id) {
        $district_thanas = Thana::where('district_id',$id)->get();
        return response()->json($district_thanas);
     }

}
