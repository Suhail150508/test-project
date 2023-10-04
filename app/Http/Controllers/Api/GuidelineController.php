<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\GuidelineInterface;


class GuidelineController extends Controller
{
    protected $guideline;

    public function __construct(GuidelineInterface $guideline)
    {
        $this->guideline=$guideline;
    }

    public function index()
    {
        if (request()->per_page) {
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;

            $query = Guideline::query()
                ->where($fieldName, 'LIKE', "%$keyword%")
                ->orderBy('id', 'asc')
                ->paginate($perPage);

            return new GuidelineCollection($query);
        } else {
            $query = Guideline::query()->where('status','Active')->paginate(10);

            return new GuidelineCollection($query);
        }
    }


    public function store(GuidelineRequest $request)
    {
        $guideline = $this->guideline->create($request);

        return response()->json($guideline);
    }

    public function show($id)
    {
        $guideline = $this->guideline->findOrFail($id);
        return response()->json($guideline);
    }

    public function guidelineKeyword($keyword)
    {

        // $query = Guideline::query()
        // ->where()
        // ->orderBy('id', 'asc')
        // ->paginate($perPage);

        // return response()->json($guideline);
    }

    

    public function edit(Guideline $guideline)
    {
        $guideline = $this->guideline->findOrFail($guideline->id);

        return response()->json($guideline);
    }

    public function update(GuidelineRequest $request, Guideline $guideline)
    {
        $guideline = $this->guideline->update($guideline->id,$request);
        $request['update'] = 'update';

        return response()->json($guideline);
    }

    public function destroy(Guideline $guideline)
    {
        $this->guideline->delete($guideline->id);

        return response()->json([
            'message' => trans('guideline.deleted'),
        ], 200);
    }

    public function restore($id)
    {
        $this->guideline->restore($id);

        return response()->json([
            'message' => trans('guideline.restored'),
        ], 200);
    }

    public function forceDelete($id)
    {
        $this->guideline->forceDelete($id);

        return response()->json([
            'message' => trans('guideline.permanent_deleted'),
        ], 200);
    }

    public function status(Request $request)
    {
        $this->guideline->status($request->id);

        return response()->json([
            'message' => trans('guideline.status_updated'),
        ], 200);
    }  
}
