<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\JobSeekerRequest;
use App\Http\Resources\JobSeekerResource;
use App\Interfaces\JobSeekerInterface;
use App\Models\JobSeeker;
use Illuminate\Http\Request;

class JobSeekerController extends Controller
{
    protected $jobSeeker;

    public function __construct(JobSeekerInterface $jobSeeker)
    {
        $this->jobSeeker=$jobSeeker;
    }

    public function store(JobSeekerRequest $request)
    // public function store(Request $request)

    {

        // dd($request->all());
       
        $data = $request;
        // $addresses = $request->addresses;
        // $academics = $request->academics;
        // $familyInfos = $request->familyInfos;
        // $experiences = $request->experiences;
        // $parameters = [
        //     'create_many' => [
        //         [
        //             'relation' => 'addresses',
        //             'data' => $addresses
        //         ],
        //         [
        //             'relation' => 'academics',
        //             'data' => $academics
        //         ],
        //         [
        //             'relation' => 'familyInformations',
        //             'data' => $familyInfos
        //         ],
        //         [
        //             'relation' => 'experiences',
        //             'data' => $experiences
        //         ],
        //     ],
        //     'image_info' => [
        //         [
        //             'type' => 'profile_picture',
        //             'images' => $data->profile_picture,
        //             'directory' => 'profile_pictures',
        //             'input_field' => 'profile_picture',
        //             'width' => '',
        //             'height' => '',
        //         ],
        //     ],
        //     'file_info' => [
        //         [
        //             'type' => 'resume_doc',
        //             'files' => $data->resume_doc,
        //             'directory' => 'resume_doc',
        //             'input_field' => 'resume_doc',
        //         ],
        //         [
        //             'type' => 'resume_video',
        //             'files' => $data->resume_video,
        //             'directory' => 'resume_video',
        //             'input_field' => 'resume_video',
        //         ],
        //     ]
        // ];
        // $jobSeeker = $this->jobSeeker->create($data,$parameters);
        // $jobSeeker = $this->jobSeeker->create($data);


        // $jobSeeker['addresses'] = $addresses;
        // $jobSeeker['academics'] = $academics;
        // $jobSeeker['familyInfos'] = $familyInfos;
        // $jobSeeker['experiences'] = $experiences;
        // return new JobSeekerResource($jobSeeker);

        /*$jobSeeker = $this->jobSeeker->create($request);
        return new JobSeekerResource($jobSeeker);*/



        try {

            $jobSeeker = $this->jobSeeker->create($data);
            return response()->json($jobSeeker);
          
          } catch (\Exception $e) {
          
            return $e->getMessage();
          }

       
    }

    public function update(JobSeekerRequest $request, JobSeeker $jobSeeker)
    {
        $jobSeeker = $this->jobSeeker->update($jobSeeker->id,$request);
        $request['update'] = 'update';
        return new JobSeekerResource($jobSeeker);
    }


}
