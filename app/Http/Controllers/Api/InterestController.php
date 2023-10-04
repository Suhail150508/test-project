<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\InterestCollection;
use App\Models\Interest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\InterestInterface;
use App\Http\Resources\InterestResource;
use App\Http\Requests\Admin\InterestRequest;



class InterestController extends Controller
{
    protected $interest;

    public function __construct(InterestInterface $interest){
        $this->interest = $interest;
    }
    public function index()
    {
        $perPage = request()->per_page;
        $fieldName = request()->field_name;
        $keyword = request()->keyword;

        $query = Interest::query()
            ->where($fieldName, 'LIKE', "%$keyword%")
            ->orderBy('id', 'asc')
            ->paginate($perPage);

        return new InterestCollection($query);

        /*$interest  = $this->interest->all();
        return response()->json($interest);*/
    }

    public function deletedListIndex()
    {
        $interests = $this->interest->onlyTrashed();

        return response()->json($interests);
    }

    public function store(InterestRequest $request)
    {
        $interest = $this->interest->create($request);

        return new InterestResource($interest);
    }

    public function show(Interest $interest)
    {
        $interest = $this->interest->findOrFail($interest->id);

        return response()->json($interest);
    }

    public function edit($id)
    {
        $interest = $this->interest->findOrFail($id);
        return response()->json($interest);
    }

    public function update(InterestRequest $request, Interest $interest)
    {
        $interest = $this->interest->update($interest->id,$request);
        $request['update'] = "update";

        return new InterestResource($interest);
    }

    public function destroy(Interest $interest)
    {
        $this->interest->delete($interest->id);

        return response()->json([
            'message' => trans('Interest deleted successfully'),
        ], 200);
    }

    public function restore($id)
    {
        $this->interest->restore($id);

        return response()->json([
            'message' => trans('Interest restored successfully'),
        ], 200);
    }

    public function forceDelete($id)
    {
        $this->interest->forceDelete($id);

        return response()->json([
            'message' => trans('Interest deleted permanently'),
        ], 200);
    }

    public function status(Request $request)
    {
        $this->interest->status($request->id);

        return response()->json([
            'message' => trans('Interest status updated successfully'),
        ], 200);
    }
}
