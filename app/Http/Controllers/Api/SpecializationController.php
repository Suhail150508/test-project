<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Specialization;
use App\Http\Requests\Admin\SpecializationRequest;

class SpecializationController extends Controller
{
    public function userSpecialization($resume_id)
    {
        $data = Specialization::where('resume_id',$resume_id)->orderBy('id','desc')->first();
        $data['skill_ids'] = json_decode($data->skill_ids);
        $data['learned'] = json_decode($data->learned);
        return response()->json($data);
    }
    public function specialization($resume_id)
    {
        $data = Specialization::where('resume_id',$resume_id)->orderBy('id','desc')->first();
        $data['skill_ids'] = json_decode($data->skill_ids);
        $data['learned'] = json_decode($data->learned);
        return response()->json($data);
    }

   
    public function store(SpecializationRequest $request)
    {
        $request['resume_id'] = $request->resume_id;
        $request['skill_ids'] = json_encode($request->skill_ids);
        $request['learned'] = json_encode($request->learned);
        $specialization = Specialization::create($request->all());
        return response()->json($specialization);
    }

    public function update(SpecializationRequest $request, $id)
    {
        $specialization = Specialization::where('id',$id)->first();
        $request['resume_id'] = $specialization->resume_id;
        $request['skill_ids'] = json_encode($request->skill_ids);
        $request['learned'] = json_encode($request->learned);
        $specialization->update($request->all());
        return response()->json('success');
    }

    public function destroy($id)
    {
        //
    }
}
