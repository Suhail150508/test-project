<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\InstituteCollection;
use Illuminate\Validation\Rule;
use App\Models\Institute;
use Illuminate\Http\Request;

class InstituteController extends Controller
{
    public function index()
    {
        if (request()->per_page) {
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;

            $query = Institute::query()
                ->where($fieldName, 'LIKE', "%$keyword%")
                ->orderBy('id', 'asc')
                ->paginate($perPage);

            return new InstituteCollection($query);
        } else {
            $query = Institute::query()->where('status', 'Active')->get();

            return new InstituteCollection($query);
        }
    }

    public function getSSC()
    {
        $institutes = Institute::query()->where('status','Active')->where('type','SSC')->orderBy('name')->get();

        return response()->json($institutes);
    }

    public function getHSC()
    {
        $institutes = Institute::query()->where('status','Active')->where('type','HSC')->orderBy('name')->get();

        return response()->json($institutes);
    }

    public function getGraduation()
    {
        $institutes = Institute::query()->where('status','Active')->where('type','Graduation')->orderBy('name')->get();

        return response()->json($institutes);
    }

    public function getMasters()
    {
        $institutes = Institute::query()->where('status','Active')->where('type','Masters')->orderBy('name')->get();

        return response()->json($institutes);
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:institutes,name,NULL,id,type,' . $request->input('type'),
            'type' => 'required',
        ]);

        $data = $request->all();
        Institute::query()->create($data);

        return response()->json('Institute Created Successfully');
    }


    public function show(Institute $institute)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Institute  $institute
     * @return \Illuminate\Http\Response
     */
    public function edit(Institute $institute)
    {
        //
    }


    public function update(Request $request,  Institute $institute)
    {
        $request->validate([
            'name' => [
                'required',
                Rule::unique('institutes', 'name')->ignore($institute->id)->where(function ($query) use ($request) {
                    return $query->where('type', $request->input('type'));
                }),
            ],
            'type' => 'required',
        ]);

        $institute->update($request->all());

        return response()->json('Institute Updated Successfully');

    }

    public function destroy(Institute $institute)
    {
        $institute->delete($institute->id);
        return response()->json([
            'message' => 'Institute Deleted Successfully',
        ], 200);
    }
}
