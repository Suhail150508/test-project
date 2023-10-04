<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LanguageProficiency;
use App\Http\Requests\Admin\LanguageRequest;



class LanguageProficiencyController extends Controller
{

    public function index()
    {
        $LanguageProficiency = LanguageProficiency::get();
        return response()->json($LanguageProficiency);
    }

    public function store(LanguageRequest $request)
    {
        $LanguageProficiency = LanguageProficiency::where('resume_id',$request->resume_id)->get();
        if($LanguageProficiency){
            foreach($LanguageProficiency as $item){
                $item->delete();
            }
        }
            foreach($request->proficiencyDetails as $item) {
            $item = LanguageProficiency::create($item);
        }
        return response()->json('success');
    }

}
