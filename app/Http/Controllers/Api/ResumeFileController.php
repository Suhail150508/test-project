<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\ResumeFileInterface;
use App\Models\ResumeFile;

class ResumeFileController extends Controller
{
    protected $resumeFile;

    public function __construct(ResumeFileInterface $resumeFile){
        $this->resumeFile = $resumeFile;
    }
    public function index()
    {
       $data = ResumeFile::where('resume_id',6)->get();
       return response()->json($data);
    }

    public function userResumeFile($resume_id)
    {
        $resumeFiles =  ResumeFile::where('resume_id', $resume_id)->latest()->first();
        if($resumeFiles) {
            $data['id'] = @$resumeFiles->id;
            $data['resume_id'] =  @$resumeFiles->resume_id;
            $data['resume_video'] =  @$resumeFiles->resumeVideo->source;
            $data['resume_cv'] =  @$resumeFiles->resumeCv->source;
            return response()->json($data);
        }
       
    }

    public function store(Request $request)
    {

        // dd($request->all());
        $request->validate([
            "resume_cv" => "required|mimes:pdf",
            "resume_video" => "required|required|mimes:mp4,mov,avi",
        ]);
        $resume = ResumeFile::where('resume_id',$request->resume_id)->first();
        if($resume) {
            // unlink('uploads/attachment/resumeVideo/'.);
            $resume->delete();
        }
        $parameters = [
            'file_info' => [
                [
                    'type' => 'resume_cv',
                    'files' => $request->resume_cv,
                    'directory' => 'resumeCV',
                    'input_field' => 'resume_cv',
                    'width' => '',
                    'height' => '',
                ],
                [
                    'type' => 'resume_video',
                    'files' => $request->resume_video,
                    'directory' => 'resumeVideo',
                    'input_field' => 'resume_video',
                    'width' => '',
                    'height' => '',
                ],
            ],
        ];
        $resumeFile = $this->resumeFile->create($request, $parameters);
        return response()->json($resumeFile);
    }

    public function show(ResumeFile $resume_file)
    {
        // $resumeFiles =  $this->resumeFile->findOrFail($resume_file->id);
        // $resumeFiles =  ResumeFile::where('resume');

        return response()->json($resumeFiles);
    }

    public function update(Request $request, $id)
    {
       
    }

    public function destroy($id)
    {
        $this->resumeFile->delete($id);
        return response()->json('success');
    }
}
