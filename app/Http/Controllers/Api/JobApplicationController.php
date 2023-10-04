<?php

namespace App\Http\Controllers\Api;

use Image;
use Carbon\Carbon;
use App\Models\File;
use App\Models\User;
use App\Models\Resume;
use Barryvdh\DomPDF\PDF;
use App\Models\UserRating;
use Illuminate\Http\Request;
use App\Models\UserApplication;
use Illuminate\Mail\Attachment;
use App\Mail\SendApplicantResume;
use Illuminate\Support\Facades\URL;
use App\Exports\ApplicantListExport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Interfaces\JobApplicationInterface;
use App\Http\Resources\JobApplicationCollection;
use App\Http\Resources\JobApplicationUserCollection;


class JobApplicationController extends Controller
{
    protected $jobapplication;
    protected $pdf;

    public function __construct(JobApplicationInterface $jobapplication, PDF $pdf)
    {
        $this->jobapplication = $jobapplication;
        $this->pdf = $pdf;
    }

    public function index()
    {
        $query = UserApplication::query()->with(['user'])->where('job_status', 'Hired')->get();

        return new JobApplicationUserCollection($query);



        // dd('im in index now what you think about me if you relize that ther');
        // if (request()->per_page) {
        //     $perPage = request()->per_page;
        //     $fieldName = request()->field_name;
        //     $keyword = request()->keyword;
        //     $query = UserApplication::query()
        //     ->with('resume')
        //     ->paginate($perPage);
        //     // ->where($fieldName, 'LIKE', "%$keyword%")->orderBy('id', 'desc')->paginate($perPage);

        //     return new JobApplicationCollection($query);
        // }
    }

    public function userJobApplication($resume_id) {

        if (request()->per_page) {
            $perPage = request()->per_page;
            $from_date = request()->selectedDate['from_date'];
            $to_date = request()->selectedDate['to_date'];
            $keyword = request()->keyword;
            $query = UserApplication::query()
            ->where('resume_id',$resume_id)
            ->where('application_type',"Job")
            ->with('resume')
            ->with('job_post')
            ->when(request()->selectedDate['from_date'] != null && request()->selectedDate['to_date'] != null, function($query) use($from_date,$to_date) {
                $query->whereBetween('applyed_date', [$from_date, $to_date]);
            })
            ->whereHas('job_post', function($query) use($keyword)
            {
                $query->where('company_name', 'LIKE', "%$keyword%");
                $query->orWhere('company_address', "LIKE", "%$keyword%");
                $query->orWhere('job_title', "LIKE", "%$keyword%");
            })
            ->where('withdraw_status',false)
            ->paginate($perPage);
            return new JobApplicationCollection($query);
        }
    }

    public function userJobWithdrawApplicationList($resume_id) {

        if (request()->per_page) {
            $perPage = request()->per_page;
            $from_date = request()->selectedDate['from_date'];
            $to_date = request()->selectedDate['to_date'];
            $keyword = request()->keyword;

            $query = UserApplication::query()
            ->where('resume_id',$resume_id)
            ->where('application_type',"Job")
            ->where('withdraw_status',true)
            ->with('resume')
            ->with('job_post')

            ->when(request()->selectedDate['from_date'] != null && request()->selectedDate['to_date'] != null, function($query) use($from_date,$to_date) {
                $query->whereBetween('applyed_date', [$from_date, $to_date]);
            })
            ->whereHas('job_post', function($query) use($keyword)
            {
                $query->where('company_name', 'LIKE', "%$keyword%");
                $query->orWhere('company_address', "LIKE", "%$keyword%");
                $query->orWhere('job_title', "LIKE", "%$keyword%");
            })
            ->paginate($perPage);
            return new JobApplicationCollection($query);
        }
    }

    public function jobApplicationWithdraw(Request $request) {

        $request->validate([
            'withdraw_reson' =>'required'
        ]);
        $jobApplication = UserApplication::where('id',$request->id)->first();
        $jobApplication->update([
            'withdraw_status'=>true,
            'withdraw_reson'=>$request->withdraw_reson,
        ]);
        return response()->json('success');
    }

    public function jobApplicationWithdrawCancle($id) {
        UserApplication::where('id',$id)->update([
            'withdraw_status'=>false,
        ]);
        return response()->json('success');
    }



    public function allShortlist($jobId)
    {
        $perPage = request()->per_page;
        $query = UserApplication::query()->with('resume')
        ->where('application_type',"Job")
        ->where('withdraw_status',false)
        ->where('job_post_id',$jobId)
        ->where('job_status','Interviewed')->orderBy('id', 'desc')->paginate($perPage);
        return new JobApplicationCollection($query);
    }

    public function jobApplications($jobId)
    {
        $perPage = request()->per_page;
        $from_date = request()->selectedDate['from_date'];
        $to_date = request()->selectedDate['to_date'];
        // $keyword = request()->keyword;
        // $fieldName = request()->field_name;
        $query = UserApplication::query()
        ->with(['resume','job_post'])
        ->where('application_type',"Job")
        ->where('withdraw_status',false)
        ->where('job_post_id',$jobId)
        // ->where($fieldName, 'LIKE', "%$keyword%")
        ->whereHas('resume',function($query){
            $keyword = request()->keyword;
            $fieldName = request()->field_name;
            $query->where($fieldName,'LIKE', "%$keyword%");
        })
        // ->orWhereHas('job_post',function($query){
        //     $keyword = request()->keyword;
        //     $fieldName = request()->field_name;
        //     $query->where($fieldName,'LIKE', "%$keyword%");
        // })
        ->when(request()->selectedDate['from_date'] != null && request()->selectedDate['to_date'] != null, function($query) use($from_date,$to_date) {
            $query->whereBetween('applyed_date', [$from_date, $to_date]);
        })
            ->where('job_status','New')
            ->orderBy('id', 'desc')
            ->paginate($perPage);
        return new JobApplicationCollection($query);
    }


    public function withdrawApplication($jobId)
    {
        $perPage = request()->per_page;
        $query = UserApplication::query()
        ->with('resume')
        ->where('application_type',"Job")
        ->where('withdraw_status',true)
        ->where('job_post_id',$jobId)
            ->orderBy('id', 'desc')
            ->paginate($perPage);
        return new JobApplicationCollection($query);
    }


    public function shortlist($id)
    {
        $jobApplication = UserApplication::query()->findOrFail($id)->update(['job_status'=>'Interviewed']);
        return response()->json($jobApplication);
    }

    public function removeShortlist($id)
    {
        $jobApplication = UserApplication::query()->findOrFail($id)->update(['job_status'=>'New']);

        return response()->json($jobApplication);
    }

    public function store(Request $request)
    {
        $jobApplication = UserApplication::where('job_post_id', $request->job_post_id)->where('resume_id', $request->resume_id)->exists();
        $authResume = Resume::where('id', $request->resume_id)->exists();
        $user = User::where('id',$request->user_id)->first();


        if(!$authResume) {
            $response = ['status' => 'error', 'message' => 'You have no account in Job portal'];
        }
        elseif($jobApplication) {
            $response = ['status' => 'error', 'message' => 'You Already Applyed for this job'];
        }
        elseif($user && $user->employment_status == "Admin" || $user->employment_status == "Company" ) {
            $response = ['status' => 'error', 'message' => 'Only Student/Alumni can Applyed for this job'];
        }else {
            // $request['applyed_date'] = Carbon::now()->format('Y-m-d');
            $request['applyed_date'] = Carbon::now()->format('Y-m-d');

            // Carbon::tomorrow()->format('l Y m d')
            $jobApplication = UserApplication::create($request->all());
            $response = ['status' => 'success', 'message' => 'You Applyed for this job successfully',200];
            }
        return response()->json($response);
    }




    // public function show($id)
    // {
    //     //
    // }


    // public function edit($id)
    // {
    //     //
    // }


    // public function update(Request $request, $id)
    // {
    //     //
    // }


    public function destroy($id)
    {
        $jobapplication = $this->jobapplication->findOrFail($id);

        $this->jobapplication->delete($jobapplication->id);
        return response()->json([
            'message' => trans('Interest deleted successfully'),
        ], 200);
    }

    public function download($id)
    {
        // $application = JobApplication::findOrFail($id);
        // $file = $application->file;
        // $file= public_path(). "/uploads/attachment/jobapplications/".$file;
        // return response()->download($file,'filename.pdf');

    }

    public function sendMail(Request $request)
    {
        $request->validate([
            'sendTo' => 'required|email',
            'subject' => 'required|string',
            'body' => 'required',
        ]);
        $data = $request;

        $files = [];
        foreach ($data['applicantIds'] as $id){
            $application = UserApplication::query()->findOrFail($id);
            $file = $data->base_url . '/resume-view?user_id=' . $application->user_id;
            $files[] = $file;

            // $application = UserApplication::query()->findOrFail($id);
            // $encryptedUserId = base64_encode($application->user_id);
            // $file = $data->base_url . '/resume-view?user_id=' . urlencode($encryptedUserId);
            // $files[] = $file;

            // $file = $application->file;
            // $file = URL::to("/uploads/attachment/jobapplications/".$file);
            // $files[] = $file;
        }

        $data['resumes'] = $files;
        Mail::to($data['sendTo'])->send(new SendApplicantResume($data));

        return response()->json(['message' => 'Email sent successfully']);
    }

    public function exportXLS($applicantIds) {
        $applicantsArray = explode(',', $applicantIds);
        return Excel::download(new ApplicantListExport($applicantsArray), 'applicants.xlsx');
    }

    public function exportPDF($filename, $ids)
    {
        $idsString = $ids;
        $idsArray = explode(',', $idsString);
        $applicants = UserApplication::query()->with(['resume', 'job_post'])->whereIn('id', $idsArray)->get();

        $datatable = '<style>
            .table-bordered {
                border-collapse: collapse;
            }
            .table-bordered th, .table-bordered td {
                border: 1px solid black;
                padding: 8px;
            }
        </style>';

        $datatable .= '<table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Name</th>
                                <th>Gender</th>
                                <th>Email</th>
                                <th>Special Qualfication</th>
                                <th>Job Title</th>
                                <th>Applyed Date</th>
                            </tr>
                        </thead>
                        <tbody>';
        foreach ($applicants as $key => $applicant) {
            $datatable .= '<tr>';
            $datatable .= '<td>' . $key + 1 . '</td>';
            $datatable .= '<td>' . $applicant->resume->first_name . ' ' . $applicant->resume->middle_name . ' ' . $applicant->resume->last_name . '</td>';
            $datatable .= '<td>' . $applicant->resume->gender . '</td>';
            $datatable .= '<td>' . $applicant->resume->email . '</td>';
            $datatable .= '<td>' . $applicant->resume->special_qualfication . '</td>';
            $datatable .= '<td>' . $applicant->job_post->job_title . '</td>';
            $datatable .= '<td>' . Carbon::parse($applicant->applyed_date)->format('d-m-Y') . '</td>';
            $datatable .= '</tr>';
        }
        $datatable .= '</tbody></table>';

        $this->pdf->loadHtml($datatable);
        $this->pdf->setPaper('A4');
        $this->pdf->render();

        return $this->pdf->download($filename);
    }
}
