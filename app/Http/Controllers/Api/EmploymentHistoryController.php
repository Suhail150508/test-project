<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmploymentHistory;
use App\Http\Requests\Admin\EmploymentHistoryRequest;


class EmploymentHistoryController extends Controller
{

    public function userEmploymentHistory($resume_id)
    {
        $EmploymentHistory = EmploymentHistory::where('resume_id',$resume_id)->get();
        foreach($EmploymentHistory as $item){
            $item['skill_ids'] = json_decode($item->skill_ids);
        }
        return response()->json($EmploymentHistory);
    }

    public function create()
    {
        //
    }


    public function store(EmploymentHistoryRequest $request)
    {
        $ExistingEmploymentHistory = EmploymentHistory::where('resume_id',$request->resume_id)->get();
        if($ExistingEmploymentHistory){
            foreach($ExistingEmploymentHistory as $item){
                $item->delete();
            }
        }
            foreach($request->EmploymentHistory as $history) {
            $history['skill_ids'] = json_encode($history['skill_ids']);
            $history['resume_id'] = $request->resume_id;
            $history = EmploymentHistory::updateOrCreate($history);
        }
        return response()->json('success');
    }

  
    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
