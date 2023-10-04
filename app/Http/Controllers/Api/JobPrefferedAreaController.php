<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobPrefferedArea;
use App\Http\Requests\Admin\JobPrefferedRequest;

class JobPrefferedAreaController extends Controller
{

    public function userJobPrefferedArea($resume_id)
    {
        $data = JobPrefferedArea::where('resume_id',$resume_id)->orderBy('id','desc')->first();
        if($data) {
            $data['job_category_ids'] = json_decode($data->job_category_ids);
            $data['job_area_districts'] = json_decode($data->job_area_districts);
            $data['organization_types'] = json_decode($data->organization_types);
            $data['personal_interest'] = json_decode($data->personal_interest);
        }
        return response()->json($data);
    }

    public function store(JobPrefferedRequest $request)
    {

        $data['resume_id'] = $request->resume_idd;
        $data['job_category_ids'] = json_encode($request->job_category_ids);
        $data['job_area_districts'] = json_encode($request->job_area_districts);
        $data['organization_types'] = json_encode($request->organization_types);
        $data['personal_interest'] = json_encode($request->personal_interest);
        $job_prefferd_area = JobPrefferedArea::create($data);
        return response()->json($job_prefferd_area);
    }

    public function update(JobPrefferedRequest $request, $id)
    {
        $data['job_category_ids'] = json_encode($request->job_category_ids);
        $data['job_area_districts'] = json_encode($request->job_area_districts);
        $data['organization_types'] = json_encode($request->organization_types);
        $data['personal_interest'] = json_encode($request->personal_interest);
        $job_prefferd_area = JobPrefferedArea::findOrFail($id)->update($data);
        return response()->json($job_prefferd_area);
    }

}
