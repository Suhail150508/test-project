<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TrainingSummary;
use App\Http\Requests\Admin\TrainingSummaryResuest;

class TrainingSummaryController extends Controller
{

    public function user_training_summary($resume_id)
    {
        $TrainingSummaries = TrainingSummary::with('training')->where('resume_id',$resume_id)->get();
        return response()->json($TrainingSummaries);
    }
    
    public function store(TrainingSummaryResuest $request)
    {
       
        $TrainingSummaries = TrainingSummary::create($request->all());
        return response()->json($TrainingSummaries);
    }

    public function update(TrainingSummaryResuest $request, $id)
    {
        $TrainingSummaries = TrainingSummary::where('id',$id)->update($request->all());
        return response()->json($TrainingSummaries);
    }


    public function destroy($id)
    {
        TrainingSummary::findOrFail($id)->delete();
        return response()->json('success');
    }
}
