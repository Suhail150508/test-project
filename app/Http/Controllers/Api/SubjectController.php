<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SubjectCollection;
use App\Models\Subject;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class SubjectController extends Controller
{

    public function index()
    {
        if (request()->per_page) {
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;

            $query = Subject::query()
                ->where($fieldName, 'LIKE', "%$keyword%")
                ->orderBy('id', 'asc')
                ->paginate($perPage);

            return new SubjectCollection($query);
        } else {
            $query = Subject::query()->where('status', 'Active')->get();

            return new SubjectCollection($query);
        }
    }

    public function getSSC()
    {
        $subjects = Subject::query()->where('status','Active')->where('type','SSC')->orderBy('name')->get();

        return response()->json($subjects);
    }

    public function getHSC()
    {
        $subjects = Subject::query()->where('status','Active')->where('type','HSC')->orderBy('name')->get();

        return response()->json($subjects);
    }

    public function getGraduation()
    {
        $subjects = Subject::query()->where('status','Active')->where('type','Graduation')->orderBy('name')->get();

        return response()->json($subjects);
    }

    public function getMasters()
    {
        $subjects = Subject::query()->where('status','Active')->where('type','Masters')->orderBy('name')->get();

        return response()->json($subjects);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:subjects,name,NULL,id,type,' . $request->input('type'),
            'type' => 'required',
        ]);

        $data = $request->all();
        Subject::query()->create($data);

        return response()->json('Subject Created Successfully');
    }


    public function show(Subject $subject)
    {
        //
    }


    public function edit(Subject $subject)
    {
        //
    }

    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'name' => [
                'required',
                Rule::unique('subjects', 'name')->ignore($subject->id)->where(function ($query) use ($request) {
                    return $query->where('type', $request->input('type'));
                }),
            ],
            'type' => 'required',
        ]);

        $subject->update($request->all());

        return response()->json('Subject Updated Successfully');

    }

    public function destroy(Subject $subject)
    {
        $subject->delete($subject->id);
        return response()->json([
            'message' => 'Subject Deleted Successfully',
        ], 200);
    }
}
