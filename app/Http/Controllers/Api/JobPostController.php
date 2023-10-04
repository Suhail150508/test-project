<?php

namespace App\Http\Controllers\Api;
use Arr;
use Carbon\Carbon;
use App\Models\Seo;
use App\Models\User;
use App\Models\Address;
use App\Models\JobPost;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\UserApplication;
use App\Notifications\NewJobPost;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Notifications\NewJobNotify;
use App\Http\Controllers\Controller;
use App\Interfaces\JobPostInterface;
use App\Http\Resources\JobPostCollection;
use App\Http\Requests\Admin\JobPostRequest;
use App\Models\NoticeEvent;
use Illuminate\Support\Facades\Notification;
use App\Notifications\CreatorJobPostApproved;
use App\Notifications\JobPostUpdateApplicantNotification;
use App\Notifications\NewJobPostNotificationToAlumniAndStudent;

class JobPostController extends Controller
{
    protected $jobPost;

    public function __construct(JobPostInterface $jobPost)
    {
        $this->jobPost = $jobPost;
    }

    public function index()
    {
        if (request()->per_page && !request()->all_jobs) {
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;

            $query = JobPost::query()
            ->with(['job_applications','address'])
            ->when($fieldName == "Yes" || $fieldName == "No", function($query) use ($fieldName){
                 $query->where('is_approved', $fieldName);
            })
            ->when($fieldName !="Yes" && $fieldName != "No",function($q) use ($fieldName,$keyword){
                $q->where($fieldName, 'LIKE', "%$keyword%");
            })
            ->orderBy('id', 'desc')->paginate($perPage);
            return new JobPostCollection($query);
        } else {
            $perPage = request()->per_page;
            $prices =  request()->selected;
            $employment_status =  request()->employment_status;

            if(request()->employment_status) {
                $employment_status =  request()->employment_status['employment_status'];
            }
            if(request()->selected)  {
                $prices =  request()->selected['prices'];
            }
            $query = JobPost::query()

        //  ->when(request()->input('prices', []), function($query) use($prices) {
            ->when($prices, function($query) use($prices) {
                $query
                ->when(in_array(0, $prices), function ($query) {
                    $query->orWhereBetween('min_salary', ['500', '1000000']);
                    $query->orWhereBetween('max_salary', ['500', '1000000']);
                })
                ->when(in_array(1, $prices), function ($query) {
                    $query->whereBetween('min_salary', ['10000', '19999']);
                    $query->whereBetween('max_salary', ['10000', '20000']);
                })
                ->when(in_array(2, $prices), function ($query) {

                    $query->orWhereBetween('min_salary', ['20000', '29999']);
                    $query->orWhereBetween('max_salary', ['20001', '30000']);
                })
                ->when(in_array(3, $prices), function ($query) {

                    $query->orWhereBetween('min_salary', ['30000', '39999']);
                    $query->orWhereBetween('max_salary', ['30000', '40000']);
                })
                ->when(in_array(4, $prices), function ($query) {

                    $query->orWhereBetween('min_salary', ['40000', '49999']);
                    $query->orWhereBetween('max_salary', ['40000', '50000']);
                });

            })
            ->when($employment_status, function($query) use($employment_status) {
                $query
                ->when(in_array(0, $employment_status), function ($query) {
                    $query->where('status', ['Full Time']);
                })
                ->when(in_array(1, $employment_status), function ($query) {
                    $query->orWhereIn('employment_status', ['Full Time']);
                })
                ->when(in_array(2, $employment_status), function ($query) {
                    $query->orWhereIn('employment_status', ['Part Time']);
                })
                ->when(in_array(3, $employment_status), function ($query) {
                    $query->orWhereIn('employment_status', ['Contractual']);
                })
                ->when(in_array(4, $employment_status), function ($query) {
                    $query->orwhereIn('employment_status', ['Internship']);
                })

                ->when(in_array(5, $employment_status), function ($query) {
                    $query->orWhereIn('employment_status', ['Freelance']);
                });
                })
                ->orderBy('id', 'desc')->paginate($perPage);
            return new JobPostCollection($query);

        }
    }

    public function jobInternship() {

        $perPage = request()->per_page;
        $prices =  request()->selected;

        if(request()->selected)  {
            $prices =  request()->selected['prices'];
        }

        $query = JobPost::query()
        ->where('employment_status','Internship')
         ->when($prices, function($query) use($prices) {
            $query
            ->when(in_array(0, $prices), function ($query) {
                $query->whereBetween('min_salary', ['10000', '19999']);
                $query->whereBetween('max_salary', ['10000', '20000']);
            })
            ->when(in_array(1, $prices), function ($query) {
                $query->orWhereBetween('min_salary', ['20000', '29999']);
                $query->orWhereBetween('max_salary', ['20001', '30000']);
            })
            ->when(in_array(2, $prices), function ($query) {
                $query->orWhereBetween('min_salary', ['30000', '39999']);
                $query->orWhereBetween('max_salary', ['30000', '40000']);
            })
            ->when(in_array(3, $prices), function ($query) {
                $query->orWhereBetween('min_salary', ['40000', '49999']);
                $query->orWhereBetween('max_salary', ['40000', '50000']);
            });
        })
        // ->when(request()->input('employment_status', []), function($query) use($employment_status) {
        //     $query
        //     ->when(in_array(0, $employment_status), function ($query) {
        //         $query->orWhereIn('employment_status', ['Full Time']);
        //     })
        //     ->when(in_array(1, $employment_status), function ($query) {
        //         $query->orWhereIn('employment_status', ['Part Time']);
        //     })
        //     ->when(in_array(2, $employment_status), function ($query) {
        //         $query->orWhereIn('employment_status', ['Contractual']);
        //     })
        //     ->when(in_array(3, $employment_status), function ($query) {
        //         $query->orwhereIn('employment_status', ['Internship']);
        //     })
        //     ->when(in_array(3, $employment_status), function ($query) {
        //         $query->orWhereIn('employment_status', ['Freelance']);
        //     });
        // })
        ->orderBy('id', 'desc')->paginate($perPage);
        return new JobPostCollection($query);
    }

    public function jobApproveStatusUpdate($id) {
        $job_post = JobPost::where('id', $id)->first();
        if ($job_post->is_approved == "No") {
            $job_post->update([
                'is_approved' => "Yes"
            ]);
        } else {
            $job_post->update([
                'is_approved' => "No"
            ]);
        }
        return response()->json(['success' => 'success']);
    }

    public function userJobPosts($user_id) {
        if (request()->per_page) {
            $perPage = request()->per_page;
            $keyword = request()->keyword;
            $fieldName = request()->field_name;
            $query = JobPost::query()
            ->where('user_id',$user_id)
            ->when($fieldName == "Yes" || $fieldName == "No", function($query) use ($fieldName){
                $query->where('is_approved', $fieldName);
           })
           ->when($fieldName !="Yes" && $fieldName != "No",function($q) use ($fieldName,$keyword){
               $q->where($fieldName, 'LIKE', "%$keyword%");
           })
            ->orderBy('id', 'desc')->paginate($perPage);
            return new JobPostCollection($query);
        }
    }

    public function newJobPostsForAdmin()
    {
        if (request()->per_page) {
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;

            $query = JobPost::query()
                ->where($fieldName, 'LIKE', "%$keyword%")
                ->where('is_approved', 'No')
                ->orderBy('id', 'desc')->paginate($perPage);
            return new JobPostCollection($query);
        }
    }

    public function deletedListIndex()
    {
        $jobPost = $this->jobPost->with(['address'])->onlyTrashed()->get();
        return response()->json($jobPost);
    }

    // public function store(JobPostRequest $request)
    // {
    //     $data = $request;
    //     $parameters = [
    //         'image_info' => [
    //             [
    //                 'type' => 'company_logo',
    //                 'images' => $data->company_logo,
    //                 'directory' => 'company_logo',
    //                 'input_field' => 'company_logo',
    //                 'width' => '',
    //                 'height' => '',
    //             ],
    //         ],
    //     ];

    //     DB::beginTransaction();
    //     try {
    //         $data['user_id'] = $request->user_id;
    //         $jobPost = $this->jobPost->create($data, $parameters);

    //         $data['job_post_id'] = $jobPost->id;
    //         Address::create($data->all());
    //         DB::commit();
    //     } catch (\Exception $e) {
    //         DB::rollback();
    //         dd($e->getMessage());
    //     }


    //     //mail-notification to admin for approval
    //     // $admins = User::query()->where('is_admin','Yes')->get();
    //     // Notification::send($admins, new NewJobPost($jobPost));

    //     // mail-notification to alumnis and students for new job post
    //     $users = User::query()->whereIn('employment_status', ['Student', 'Alumni'])->get();
    //     Notification::send($users, new NewJobPostNotificationToAlumniAndStudent($jobPost));

    //     return response()->json([
    //         'data' => $jobPost,
    //         'success' => 'Job Post Created Successfully',
    //     ], 200);
    // }

    public function store(JobPostRequest $request)
    {
        $data = $request;
        $parameters = [
            'image_info' => [
                [
                    'type' => 'company_logo',
                    'images' => $data->company_logo,
                    'directory' => 'company_logo',
                    'input_field' => 'company_logo',
                    'width' => '',
                    'height' => '',
                ],
            ],

            'file_info' => [
                [
                    'type' => 'document',
                    'files' => $data->document,
                    'directory' => 'job_post/document',
                    'input_field' => 'document',
                ],
            ],
        ];

        DB::beginTransaction();
        try {
            $data['user_id'] = $request->user_id;
            $jobPost = $this->jobPost->create($data, $parameters);

            // Notice event and seo data create start
            $noticeEvent = New NoticeEvent();
            $noticeEvent->job_post_id = $jobPost['id'];
            $noticeEvent->title = $jobPost['headline'];
            $noticeEvent->slug = Str::slug($jobPost['headline']);
            $noticeEvent->description = $jobPost['job_details'];
            $noticeEvent->time = now()->format('H:i');
            $noticeEvent->date = now()->format('Y-m-d');
            $noticeEvent->save();

            $noticeevent = NoticeEvent::find($noticeEvent->id);

            // Data insert in seo table
            $seo = new Seo();
            $seo->model_name = 'App\Models\NoticeEvent';
            $seo->model_id = $noticeevent->id;
            $seo->site = 'ccc';
            $seo->page_url = '/notice-event/' . $noticeevent->slug;
            $seo->title = $noticeevent->title;
            $seo->keywords = 'ccc, notice event';
            $seo->description = Str::limit(strip_tags($noticeevent->description), 100);
            $seo->save();

            $seo = new Seo();
            $seo->model_name = 'App\Models\NoticeEvent';
            $seo->model_id = $noticeevent->id;
            $seo->site = 'alumni';
            $seo->page_url = '/notice-event/' . $noticeevent->slug;
            $seo->title = $noticeevent->title;
            $seo->keywords = 'alumni, notice event';
            $seo->description = Str::limit(strip_tags($noticeevent->description), 100);
            $seo->save();
            // Notice event and seo data create end

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        // mail-notification to alumnis and students for new job post
        $users = User::query()->whereIn('employment_status', ['Student', 'Alumni'])->get();
        // Notification::send($users, new NewJobPostNotificationToAlumniAndStudent($jobPost));

        return response()->json([
            'data' => $jobPost,
            'success' => 'Job Post Created Successfully',
        ], 200);
    }

    public function show(JobPost $job_post)
    {
        $jobPost = $this->jobPost->with(['user'])->findOrFail($job_post->id);
        $jobPost['company_logo'] = $jobPost->websiteLogo?$jobPost->websiteLogo->source : "";
        $jobPost['document'] = $jobPost->documentFile?$jobPost->documentFile->source : "";

        // $jobPost['division_id'] = $jobPost->address->division_id;
        // $jobPost['district_id'] = $jobPost->address->district_id;
        // $jobPost['thana_id'] = $jobPost->address->thana_id;

        return response()->json($jobPost);
    }

    // public function edit($id)
    // {
    //     $jobPost = $this->jobPost->findOrFail($job_post->id);
    //     $jobPost['webs_logo'] = $jobPost->websiteLogo->source;
    //     return response()->json($jobPost);
    // }

    // public function update(JobPostRequest $request, JobPost $job_post)
    // {
    //     $applicantLists = UserApplication::with('user')->where('job_post_id', $job_post->id)->get();

    //     $data = $request;
    //     $parameters = [
    //         'image_info' => [
    //             [
    //                 'type' => 'company_logo',
    //                 'images' => $data->company_logo,
    //                 'directory' => 'company_logo',
    //                 'input_field' => 'company_logo',
    //                 'width' => '',
    //                 'height' => '',
    //             ],
    //         ],
    //     ];

    //     DB::beginTransaction();
    //     try {
    //         $jobPost = $this->jobPost->update($job_post->id, $data, $parameters);
    //         $addressData['job_post_id'] = $jobPost->id;
    //         $addressData['division_id'] = $job_post->address->division_id;
    //         $addressData['district_id'] = $job_post->address->district_id;
    //         $addressData['thana_id'] =   $job_post->address->thana_id;
    //         Address::where('id',$job_post->address->id)->update($addressData);

    //         if (!$applicantLists->isEmpty()) {
    //             foreach ($applicantLists as $key => $applicant) {
    //                 $details = array();
    //                 $details['greeting'] = 'Dear '.$applicant->user->username.',';
    //                 $details['body'] = 'The job you have applied for has been updated. Kindly check the updated post here:';
    //                 $details['actionText'] = 'View';
    //                 $details['actionUrl'] = 'https://jobs1.ewubd.edu/job-details?jobId='. $applicant->job_post_id;
    //                 $details['endText'] = 'Best Regards, CCC';
    //                 Notification::send($applicant->user, new JobPostUpdateApplicantNotification($details));
    //             }
    //         }

    //         DB::commit();
    //         // all good
    //     } catch (\Exception $e) {
    //         DB::rollback();
    //         dd($e->getMessage());
    //         // something went wrong
    //     }

    //     //mail-notification to admin for approval
    //     // $admins = User::query()->where('is_admin','Yes')->get();
    //     // Notification::send($admins, new NewJobPost($jobPost));

    //     return response()->json([
    //         'data' => $jobPost,
    //         'success' => 'Job Post updated Successfully',
    //     ], 200);
    // }

    public function update(JobPostRequest $request, JobPost $job_post)
    {
        $applicantLists = UserApplication::with('user')->where('job_post_id', $job_post->id)->get();
        $data = $request;
        $parameters = [
            'image_info' => [
                [
                    'type' => 'company_logo',
                    'images' => $data->company_logo,
                    'directory' => 'company_logo',
                    'input_field' => 'company_logo',
                    'width' => '',
                    'height' => '',
                ],
            ],

            'file_info' => [
                [
                    'type' => 'document',
                    'files' => $data->document,
                    'directory' => 'job_post/document',
                    'input_field' => 'document',
                ],
            ],
        ];

        DB::beginTransaction();
        try {
            $jobPost = $this->jobPost->update($job_post->id, $data, $parameters);

            // Notice event and seo data update start
            $noticeEvent = NoticeEvent::where('job_post_id', $job_post->id)->first();
            $noticeEvent->job_post_id = $jobPost['id'];
            $noticeEvent->title = $jobPost['headline'];
            $noticeEvent->slug = Str::slug($jobPost['headline']);
            $noticeEvent->description = $jobPost['job_details'];
            $noticeEvent->time = now()->format('H:i');
            $noticeEvent->date = now()->format('Y-m-d');
            $noticeEvent->save();

            $noticeevent = NoticeEvent::find($noticeEvent->id);

            // Update or create the SEO entry
            Seo::updateOrCreate(
                [
                    'model_name' => 'App\Models\NoticeEvent',
                    'model_id' => $noticeevent->id,
                    'site' => 'ccc', // Unique value for this record
                ],
                [
                    'page_url' => '/notice-event/' . $noticeevent->slug,
                    'title' => $noticeevent->title,
                    'keywords' => 'ccc, notice event',
                    'description' => Str::limit(strip_tags($noticeevent->description), 100),
                ]
            );

            Seo::updateOrCreate(
                [
                    'model_name' => 'App\Models\NoticeEvent',
                    'model_id' => $noticeevent->id,
                    'site' => 'alumni', // Unique value for this record
                ],
                [
                    'page_url' => '/notice-event/' . $noticeevent->slug,
                    'title' => $noticeevent->title,
                    'keywords' => 'alumni, notice event',
                    'description' => Str::limit(strip_tags($noticeevent->description), 100),
                ]
            );
            // Notice event and seo data update end

            if (!$applicantLists->isEmpty()) {
                foreach ($applicantLists as $key => $applicant) {
                    $details = array();
                    $details['greeting'] = 'Dear ' . $applicant->user->username . ',';
                    $details['body'] = 'The job you have applied for has been updated. Kindly check the updated post here:';
                    $details['actionText'] = 'View';
                    $details['actionUrl'] = 'https://jobs1.ewubd.edu/job-details?jobId=' . $applicant->job_post_id;
                    $details['endText'] = 'Best Regards, CCC';
                    Notification::send($applicant->user, new JobPostUpdateApplicantNotification($details));
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        return response()->json([
            'data' => $jobPost,
            'success' => 'Job Post updated Successfully',
        ], 200);
    }

    public function destroy(JobPost $job_post)
    {
        DB::beginTransaction();
        try {
            $this->jobPost->delete($job_post->id);
            // $jobPost->address->delete();
            DB::commit();
            return response()->json([
                'message' => trans('jobPost.deleted'),
            ], 200);
        } catch (\Exception $e){
            DB::rollBack();
            return response()->json([
                'error', $e->getMessage()
            ]);
        }
    }

    public function restore($id)
    {
        DB::beginTransaction();
        $this->jobPost->restore($id);
        $address = Address::onlyTrashed()->where('job_post_id', $id)->first();
        if ($address != null) {
            $address->restore();
        }
        DB::commit();
        return response()->json([
            'message' => trans('jobPost.restored'),
        ], 200);
        DB::rollBack();
        return response()->json([
            'error', $e->getMessage()
        ]);
    }

    public function forceDelete($id)
    {
        $this->jobPost->forceDelete($id);
        return response()->json([
            'message' => trans('jobPost.permanent_deleted'),
        ], 200);
    }

    public function status(Request $request)
    {
        $this->jobPost->status($request->id);

        return response()->json([
            'message' => trans('jobPost.status_updated'),
        ], 200);
    }

    //job post approval
    public function jobPostApproval($id)
    {
        // JobPost::query()->findOrFail($id)->update(["is_approved" => "Yes"]);
        $job_post = JobPost::where('id', $id)->first();
        if ($job_post->is_approved == "No") {
            $job_post->update([
                'is_approved' => "Yes"
            ]);
        } else {
            $job_post->update([
                'is_approved' => "No"
            ]);
        }

        return response()->json([
            "success" => trans('jobPost.approved')
        ],200);

        /*$jobPost = JobPost::query()->findOrFail($id);
        if ($jobPost->is_approved == "No"){
            $jobPost->update(["is_approved" => "Yes"]);

            // mail-notification for job post creator after approval
            $jobPost->user->notify(new CreatorJobPostApproved($jobPost));

            //start mail-notification for related job-seekers
            $needToNotifyUser = Collection::empty();
            $seekers = User::query()->where('employment_status','Job-Seeker')->get();

            foreach ($jobPost->department_ids as $department_id) {
                foreach ($seekers as $seeker){
                    if ($seeker->alumni_id){
                        if ($seeker->alumni->department_id == $department_id)
                            $needToNotifyUser[$seeker->id] = $seeker;
                    }elseif($seeker->student_id){
                        if ($seeker->student->department_id == $department_id)
                            $needToNotifyUser[$seeker->id] = $seeker;
                    }
                }
            }

            foreach ($needToNotifyUser as $user){
                Notification::route('mail',$user->email)->notify(new NewJobNotify($jobPost));
            }

            //end mail-notification for related job-seekers


            return response()->json([
                "success" => trans('jobPost.approved')
            ],200);
        } else{

            return response()->json([
                "info" => trans('jobPost.already_approved')
            ],208);
        }*/
    }

    public function singlecategory($id)
    {
        $current_date = Carbon::now()->format('Y-m-d');
        $prices =  request()->input('prices', []);
        $employment_status =  request()->input('employment_status', []);

        $query = JobPost::query()
        ->where('job_category_id',$id)
        ->where('job_deadline', ">=", $current_date)
        ->where('is_approved',"Yes")
         ->when(request()->input('prices', []), function($query) use($prices,$id) {
            $query
            ->when(in_array(0, $prices), function ($query,$id) {
                $query->whereBetween('min_salary', ['10000', '19999']);
                $query->whereBetween('max_salary', ['10000', '20000']);
            })
            ->when(in_array(1, $prices), function ($query,$id) {

                $query->orWhereBetween('min_salary', ['20000', '29999']);
                $query->orWhereBetween('max_salary', ['20001', '30000']);
            })
            ->when(in_array(2, $prices), function ($query,$id) {
                $query->orWhereBetween('min_salary', ['30000', '39999']);
                $query->orWhereBetween('max_salary', ['30001', '40000']);
            });
            // ->when(in_array(3, $prices), function ($query,$id) {
            //     $query->orWhereBetween('min_salary', ['30001', '4']);
            //     $query->orWhereBetween('max_salary', ['40000', '50000']);
            // });
            })
            // ->when(request()->input('prices', []), function($query) use($prices,$id) {
            //     $query
            //     ->when(in_array(0, $prices), function ($query,$id) {
            //         $query->whereBetween('min_salary', ['10000', '19999'])->where('job_category_id',$id);
            //         $query->whereBetween('max_salary', ['10000', '20000'])->where('job_category_id',$id);
            //     })
            //     ->when(in_array(1, $prices), function ($query,$id) {
            //         $query->orWhereBetween('min_salary', ['20000', '29999'])->where('job_category_id',$id);
            //         $query->orWhereBetween('max_salary', ['20001', '30000'])->where('job_category_id',$id);
            //     })
            //     ->when(in_array(2, $prices), function ($query,$id) {
            //         $query->orWhereBetween('min_salary', ['30000', '39999'])->where('job_category_id',$id);
            //         $query->orWhereBetween('max_salary', ['30000', '40000'])->where('job_category_id',$id);
            //     })
            //     ->when(in_array(3, $prices), function ($query,$id) {
            //         $query->orWhereBetween('min_salary', ['40000', '49999'])->where('job_category_id',$id);
            //         $query->orWhereBetween('max_salary', ['40000', '50000'])->where('job_category_id',$id);
            //     });
            //     })

            // ->when(request()->input('employment_status', []), function($query) use($employment_status,$id) {
            //     $query
            //     ->when(in_array(0, $employment_status), function ($query,$id) {

            //         $query->orWhereIn('employment_status', ['Full Time'])->where('job_category_id',$id);
            //     })
            //     ->when(in_array(1, $employment_status), function ($query,$id) {
            //         $query->orWhereIn('employment_status', ['Part Time'])->where('job_category_id',$id);
            //     })
            //     ->when(in_array(2, $employment_status), function ($query,$id) {
            //         $query->orWhereIn('employment_status', ['Contractual'])->where('job_category_id',$id);
            //     })
            //     ->when(in_array(3, $employment_status), function ($query,$id) {
            //         $query->orwhereIn('employment_status', ['Internship'])->where('job_category_id',$id);
            //     })

            //     ->when(in_array(3, $employment_status), function ($query,$id) {
            //         $query->orWhereIn('employment_status', ['Freelance'])->where('job_category_id',$id);
            //     });
            //     })
            ->get();
        return response()->json($query);
    }


    public function recentjobs()
    {
        $current_date = Carbon::now()->format('Y-m-d');
        $perPage = request()->per_page;
        $query = JobPost::query()
        ->where('is_approved',"Yes")
        ->where('job_deadline', ">=", $current_date)
        ->orderBy('id', 'asc')
        ->paginate($perPage);
        return new JobPostCollection($query);
    }

    public function userJobs()
    {
        $perPage = request()->per_page;
        $query = JobPost::query()
        ->where('is_approved',"Yes")
        ->orderBy('id', 'asc')
        ->paginate($perPage);
        return new JobPostCollection($query);
    }



    public function moreJobs()
    {
        $current_date = Carbon::now()->format('Y-m-d');
        $perPage = request()->per_page;
        $query = JobPost::query()
        ->where('is_approved',"Yes")
        ->where('job_deadline', ">=", $current_date)
        ->orderBy('id', 'asc')
        ->paginate($perPage);
        return new JobPostCollection($query);
    }
    public function jobsearch(Request $request)
    {
        $jobpost = JobPost::where("job_title","LIKE","%".$request->job_title."%")
        ->orwhere("company_name","LIKE","%".$request->job_title."%")->get();
        return response()->json($jobpost);
    }

    public function homesearchjob($searchkeyword)
    {
        $jobpost = JobPost::where("job_title","LIKE","%".$searchkeyword."%")
        ->orwhere("company_name","LIKE","%".$searchkeyword."%")->get();
        return response()->json($jobpost);
    }


    public function salaryrange() {
        $salaries = [
            10000, 20000, 30000, 40000
        ];
        return response()->json($salaries);
    }

    public function selectedtype(Request $request) {
        return response()->json($request->type);
    }

}
