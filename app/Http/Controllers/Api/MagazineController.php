<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MagazineRequest;
use App\Http\Resources\MagazineCollection;
use App\Http\Resources\MagazineResource;
use App\Interfaces\MagazineInterface;
use App\Models\Magazine;


class MagazineController extends Controller
{
    protected $magazine;

    public function __construct(MagazineInterface $magazine){
        $this->magazine = $magazine;
    }
    public function index()
    {
        $perPage = request()->per_page;
        $fieldName = request()->field_name;
        $keyword = request()->keyword;

        $query = Magazine::query()
            ->where($fieldName, 'LIKE', "%$keyword%")
            ->orderBy('id', 'asc')
            ->paginate($perPage);

        return new MagazineCollection($query);
    }


    public function deletedListIndex()
    {
        $deleted_list = $this->magazine->onlyTrashed();
        return response()->json($deleted_list);
    }

    public function store(MagazineRequest $request)
    {
        
        $magazine = $this->magazine->create($request);
        return new MagazineResource($magazine);
    }

    public function edit($id)
    {
        $magazine = $this->magazine->findOrFail($id);
        return response()->json($magazine);
    }

    public function update(MagazineRequest $request, Magazine $magazine)
    {
        $magazine = $this->magazine->update($magazine->id,$request);
        $request['update'] = "update";
        return new MagazineResource($magazine);
    }

    public function destroy(Magazine $magazine)
    {
        $magazine = $this->magazine->delete($magazine->id);
        return response()->json($magazine);
    }

    public function restore($id)
    {
        $magazine = $this->magazine->restore($id);
        return response()->json($magazine);
    }

    public function forceDelete($id)
    {
        $magazine =  $this->magazine->forceDelete($id);
        return  response()->json($magazine);
    }

    public function status(Request $request)
    {
        return $this->magazine->status($request->id);
    }
}
