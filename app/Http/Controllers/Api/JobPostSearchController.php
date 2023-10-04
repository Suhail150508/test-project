<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\JobPostCollection;
use Illuminate\Http\Request;
use App\Models\JobPost;

class JobPostSearchController extends Controller
{
    public function jobpostsearchlist($keyword = null) {

        $location = request()->input('location');

        $jobposts = JobPost::withFilters(
            request()->input('prices', []),
            request()->input('employment_status', []),
            $keyword,$location,
        )->get();

        return response()->json($jobposts);
    }


    // public function jobpostsearchlist($keyword = null) {

    //     $perPage = request()->per_page;
    //     $jobposts = JobPost::withFilters(
    //         request()->input('prices', []),
    //         request()->input('employment_status', []),
    //         $keyword,
    //     )->paginate($perPage);

    //     return new JobPostCollection($jobposts);
    // }

    
}

