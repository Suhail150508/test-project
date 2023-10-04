<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\CoCurricularActivityInterface;
use App\Http\Resources\CoCurricularActivityResource;
use App\Http\Requests\Admin\CoCurricularActivityRequest;
use Illuminate\Http\Request;
use App\Models\CoCurricularActivity;
use App\Http\Resources\CoCurricularActivityCollection;


class CoCurricularActivityController extends Controller
{
    protected $CoCurricularActivity;

    public function __construct(CoCurricularActivityInterface $CoCurricularActivity){
        $this->CoCurricularActivity = $CoCurricularActivity;
    }
    public function index()
    {
        $perPage = request()->per_page;
        $fieldName = request()->field_name;
        $keyword = request()->keyword;

        $query = CoCurricularActivity::query()
            ->where($fieldName, 'LIKE', "%$keyword%")
            ->orderBy('id', 'asc')
            ->paginate($perPage);

        return new CoCurricularActivityCollection($query);
    }

    public function deletedListIndex()
    {
        $CoCurricularActivity = $this->CoCurricularActivity->onlyTrashed();
        return response()->json($CoCurricularActivity);
    }

    public function store(CoCurricularActivityRequest $request)
    {
        $CoCurricularActivity = $this->CoCurricularActivity->create($request);
        return new CoCurricularActivityResource($CoCurricularActivity);
    }

    public function show(CoCurricularActivity $co_curricular_activity)
    {
        $CoCurricularActivity = $this->CoCurricularActivity->findOrFail($co_curricular_activity->id);
        return response()->json($CoCurricularActivity);
    }

    public function edit($id)
    {
        $CoCurricularActivity = $this->CoCurricularActivity->findOrFail($id);
        return response()->json($CoCurricularActivity);
    }

    public function update(CoCurricularActivityRequest $request, CoCurricularActivity $co_curricular_activity)
    {
        $CoCurricularActivity = $this->CoCurricularActivity->update($co_curricular_activity->id,$request);
        $CoCurricularActivity['update'] = 'update';
        return new CoCurricularActivityResource($CoCurricularActivity);
    }

 
    public function destroy(CoCurricularActivity $co_curricular_activity)
    {
        $CoCurricularActivity = $this->CoCurricularActivity->delete($co_curricular_activity->id);
        return response()->json($CoCurricularActivity);
    }

    public function restore($id)
    {
        $this->CoCurricularActivity->restore($id);
        return response()->json([
            'message' => trans('cocurricularactivity.restored'),
        ], 200);
    }

    public function forceDelete($id)
    {
        $this->CoCurricularActivity->forceDelete($id);
        return response()->json([
            'message' => trans('cocurricularactivity.permanent_deleted'),
        ], 200);
    }

    public function status(Request $request)
    {
        $this->CoCurricularActivity->status($request->id);
        return response()->json([
            'message' => trans('cocurricularactivity.status_updated'),
        ], 200);
    }
}
