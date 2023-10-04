<?php

namespace App\Http\Controllers\Api;

use File;
use Carbon\Carbon;
use App\Models\Skill;
use App\Models\Resume;
use GuzzleHttp\Client;
use App\Models\Address;




use App\Models\MajorMinor;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use App\Interfaces\ResumeInterface;

use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use App\Http\Requests\Admin\ResumeRequest;

class ResumeController extends Controller
{

    protected $resume;

    public function __construct(ResumeInterface $resume){
        $this->resume = $resume;
    }

    public function index()
    {
      return "hello";
    }

    public function userResume($user_id)
    {

        $personaldetails = Resume::where('user_id',$user_id)->with(['career_application','educations','jobPreferredArea','resumeImage','specialization','employmenthistory','trainingSummary','professionalCertificaion','addresses','trainingSummary.training','jobPreferredArea.jobCategories','languages'])->first();
        // $personaldetails = Resume::where('user_id',$user_id)->first();
        if(isset($personaldetails->resumeImage)) {
            $imageString = $personaldetails->resumeImage->source;
            $explodeImageString = explode("uploads", $imageString)[1];
            // $imagePath = public_path('uploads'. $explodeImageString);
            // $imagePath = base_path('uploads'. $explodeImageString);
            $imagePath = 'uploads'. $explodeImageString;

            // dd($imagePath);
            $imageData = File::get($imagePath);
            $base64 = base64_encode($imageData);

            $personaldetails['resume_base64_image'] = $base64;
            $personaldetails['resume_images'] = $personaldetails->resumeImage->source;
            $test_image =  $personaldetails->resumeImage->source;
        }

        // dd($personaldetails['resume_image']);
        if(isset($personaldetails->addresses)) {
            foreach($personaldetails->addresses as $item) {
                $personaldetails['presentAddress'] = Address::where('user_id',$user_id)->where('type','present')->with(['division','district','thana'])->first();
                $personaldetails['permanentAddress'] = Address::where('user_id',$user_id)->where('type','permanent')->with(['division','district','thana'])->first();
            }

        }
        if(isset($personaldetails->specialization)) {
            $specializations = json_decode($personaldetails->specialization->skill_ids);
            $personaldetails['specializeSkills'] = Skill::whereIn('id',$specializations)->get();
        }
        return response()->json($personaldetails);
    }

    public function store(ResumeRequest $request)
    {
        $parameters = [
            'image_info' => [
                [
                    'type' => 'resume_image',
                    'images' => $request->resume_image,
                    'directory' => 'resumeImage',
                    'input_field' => 'resume_image',
                    'width' => '',
                    'height' => '',
                ],
            ],
            'file_info' => [
                [
                    'type' => 'resumeFile',
                    'files' => $request->resume_file,
                    'directory' => 'resumeFile',
                    'input_field' => 'resume_file',
                    'width' => '',
                    'height' => '',
                ],
            ],
        ];
        $resume = $this->resume->create($request, $parameters);
        return response()->json($resume);
    }

    public function update(ResumeRequest $request, Resume $resume)
    {
    //     $file = $request->resume_image;
    //  if ($file) {
    //     $file_parts = explode(";base64,", $file);
    //     $file_base64 = $file_parts[1];
    //     $filename = Str::random(10) . '_' . uniqid() . '.' . explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];
    //     $path = 'uploads/attachment/resume_images/'. $filename;
    //     \Storage::disk('custom')->put($path, base64_decode($file_base64));
    //     $request['resume_image'] = $path;
    // }

    $file = $request->resume_image;
    // if ($file) {
        $parameters = [
            'image_info' => [
                [
                    'type' => 'resume_image',
                    'images' => $request->resume_image,
                    'directory' => 'resumeImage',
                    'input_field' => 'resume_image',
                    'width' => '',
                    'height' => '',
                ],
            ],
        ];
//    }
    // $resume =  $resume->update($request->all());
    $resume = $this->resume->update($resume->id, $request, $parameters);
    return response()->json($resume);

        // $originalfile = $request->resume_image;
        // $file_name=hexdec(uniqid()).'.'.$originalfile->getClientOriginalName();
        // $originalfile->move(public_path('/uploads/attachment/jobapplications'), $file_name);


        //   $request->validate([
        //     'full_name' => 'required',
        //     'email' => 'required|email|unique:job_applications',
        //     'cover_letter' => 'required',
        //     'file' =>'required|mimes:pdf'

        // ]);
        // $jobapplication = new JobApplication();
        // $originalfile = $request->file;
        // $file_name=hexdec(uniqid()).'.'.$originalfile->getClientOriginalName();
        // $originalfile->move(public_path('/uploads/attachment/jobapplications'), $file_name);
        // $jobapplication->file=$file_name;
        // $jobapplication->full_name = $request->full_name;
        // $jobapplication->email = $request->email;
        // $jobapplication->cover_letter = $request->cover_letter;
        // $jobapplication->job_post_id = $request->job_post_id;
        // $jobapplication->save();


            $parameters = [
                'image_info' => [
                    [
                        'type' => 'resume_image',
                        'images' => $request->resume_image,
                        'directory' => 'resumeImage',
                        'input_field' => 'resume_image',
                        'width' => '',
                        'height' => '',
                    ],
                ],
                'file_info' => [
                    [
                        'type' => 'resumeFile',
                        'files' => $request->resume_file,
                        'directory' => 'resumeFile',
                        'input_field' => 'resume_file',
                        'width' => '',
                        'height' => '',
                    ],
                ],
            ];
        $resume = $this->resume->update($resume->id, $request, $parameters);
        return response()->json($resume);
    }

    public function destroy($id)
    {
        $personaldetails = Resume::where('id',$id)->delete();
        return response()->json('success');
    }

    // public function downloadResumeFile($ids)
    // {
    //     $resumeIds = explode(',', $ids);

    //     $resumeFilePaths = Resume::query()
    //         ->whereIn('resumes.id', $resumeIds)
    //         ->leftJoin('resume_files', 'resumes.id', '=', 'resume_files.resume_id')
    //         ->leftJoin('files as cv_files', function ($join) {
    //             $join->on('resume_files.id', '=', 'cv_files.fileable_id')
    //             ->where('cv_files.type', '=', 'resume_cv')
    //             ->where('cv_files.fileable_type', '=', 'App\Models\ResumeFile');
    //         })
    //         ->leftJoin('files as video_files', function ($join) {
    //             $join->on('resume_files.id', '=', 'video_files.fileable_id')
    //             ->where('video_files.type', '=', 'resume_video')
    //             ->where('video_files.fileable_type', '=', 'App\Models\ResumeFile');
    //         })
    //         ->select([
    //             'cv_files.source as resume_cv',
    //             'video_files.source as resume_video'
    //         ])
    //         ->get();

    //     foreach ($resumeFilePaths as $key => $filePath) {
    //         $url = $filePath->resume_cv;
    //         $path = parse_url($url, PHP_URL_PATH);

    //         if ($path) {
    //             // Get the directory path
    //             $directory = pathinfo($path, PATHINFO_DIRNAME);
    //             // Get the file name
    //             $filename = pathinfo($path, PATHINFO_BASENAME);

    //             $orginalPath = public_path() . $path;

    //             // Check if the file exists
    //             if (file_exists($orginalPath)) {
    //                 return response()->download($orginalPath, $filename);
    //             }
    //         }
    //     }

    //     return response()->json([
    //         'msg' => 'Resume file not found'
    //     ]);
    // }

    public function downloadResumeFile($ids)
    {
        $resumeFilePath = Resume::query()
        ->where('resumes.id', $ids)
        ->leftJoin('resume_files', 'resumes.id', '=', 'resume_files.resume_id')
        ->leftJoin('files as cv_files', function ($join) {
            $join->on('resume_files.id', '=', 'cv_files.fileable_id')
                ->where('cv_files.type', '=', 'resume_cv')
                ->where('cv_files.fileable_type', '=', 'App\Models\ResumeFile');
        })
        // ->whereNotNull('cv_files.source')
        ->select([
            'cv_files.source as resume_cv',
        ])
        ->first();

        if ($resumeFilePath && $resumeFilePath->resume_cv && $resumeFilePath->resume_cv != null) {
            $url = $resumeFilePath->resume_cv;
            $path = parse_url($url, PHP_URL_PATH);
            $filename = pathinfo($path, PATHINFO_BASENAME);
            $originalPath = public_path() . $path;

            if (file_exists($originalPath)) {
                return response()->download($originalPath, $filename);
            }
        }

        // return response()->json([
        //     'msg' => 'Resume file not found.',
        // ], 404);

        return response()->json([
            'status' => 'error',
            'msg' => 'Resume file not found.',
        ]);
    }
}
