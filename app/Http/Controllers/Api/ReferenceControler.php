<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reference;
use App\Http\Requests\Admin\ReferenceRequest;


class ReferenceControler extends Controller
{

    public function userReference($resume_id)
    {
        $Reference = Reference::where('resume_id',$resume_id)->first();
        return response()->json($Reference);
    }


    public function store(ReferenceRequest $request)
    {
       $reference = Reference::create($request->all());
       return response()->json('success');
    }


    public function update(ReferenceRequest $request, $id)
    {
        $reference = Reference::where('id',$request->id)->update($request->all());
        return response()->json('success');
    }

}
