<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CareerApplication;
use App\Http\Requests\Admin\CareerApplicationRequest;


class CareerApplicationController extends Controller
{
    public function index() {
        $careerApplication = CareerApplication::first();
        return response()->json($careerApplication);
    }

    public function userCareerApplication($resume_id) {

        // dd($resume_id);
        $careerApplication = CareerApplication::where('resume_id',$resume_id)->first();
        return response()->json($careerApplication);
    }

    public function show($id) {

    }

    
    public function store(CareerApplicationRequest $request) {
        $careerApplication = CareerApplication::create($request->all());
        return response()->json( $careerApplication);
    }

    public function update(CareerApplicationRequest $request, $id)
    {
        $careerApplication = CareerApplication::where('id',$id)->update($request->all());
        return response()->json($careerApplication);
    }
}
