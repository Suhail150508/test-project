<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Skill;
use App\Models\Alumni;
use App\Models\Country;
use App\Models\District;
use Barryvdh\DomPDF\PDF;
use App\Models\Department;
use App\Models\Endorsement;
use Illuminate\Http\Request;
use App\Exports\AlumnisExport;
use App\Imports\AlumnisImport;
use App\Interfaces\UserInterface;
use App\Mail\AlumniInvitationMail;
use Illuminate\Support\Facades\DB;
use App\Interfaces\AlumniInterface;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Resources\AlumniResource;
use Illuminate\Support\Facades\Session;
use App\Http\Resources\AlumniCollection;

use App\Notifications\ProfileCompletion;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Requests\Admin\AlumniRequest;
use Illuminate\Support\Facades\Notification;
use App\Http\Resources\ProfileCompletionResource;
use App\Notifications\ManualRegApproveOrRejectNotification;


class AlumniController extends Controller
{
    protected $user;
    protected $alumni;
    protected $pdf;

    public function __construct(UserInterface $user, AlumniInterface $alumni, PDF $pdf)
    {
        $this->user = $user;
        $this->alumni = $alumni;
        $this->pdf = $pdf;
    }

    public function index()
    {
        if (request()->per_page && request()->place === 'admin_panel') {
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;

            $query = Alumni::query()
            // ->where('status', 'Active')
            ->where('reg_status', 'Approve')
            ->where(function ($query) use ($fieldName, $keyword) {
                $query->where($fieldName, 'LIKE', "%$keyword%")
                ->orWhereHas('department', function ($dep) use ($keyword) {
                    $dep->where('title', 'LIKE', "%$keyword%");
                })
                ->orWhereHas('country', function ($coun) use ($keyword) {
                    $coun->where('name', 'LIKE', "%$keyword%");
                })
                ->orWhereHas('district', function ($dist) use ($keyword) {
                    $dist->where('name', 'LIKE', "%$keyword%");
                })
                ->orWhereHas('skills', function ($skill) use ($keyword) {
                    $skill->where('title', 'LIKE', "%$keyword%");
                });
            })
            ->orderBy('id', 'desc')
            ->paginate($perPage);

            return new AlumniCollection($query);
        }elseif (request()->per_page && request()->place === 'alumni_list') {
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;

            $query = Alumni::query()
                ->where('status', 'Active')
                ->where('reg_status', 'Approve')
                ->where(function ($query) use ($fieldName, $keyword) {
                    $query->where($fieldName, 'LIKE', "%$keyword%")
                        ->orWhereHas('department', function ($dep) use ($keyword) {
                            $dep->where('title', 'LIKE', "%$keyword%");
                        })
                        ->orWhereHas('country', function ($coun) use ($keyword) {
                            $coun->where('name', 'LIKE', "%$keyword%");
                        })
                        ->orWhereHas('district', function ($dist) use ($keyword) {
                            $dist->where('name', 'LIKE', "%$keyword%");
                        })
                        ->orWhereHas('skills', function ($skill) use ($keyword) {
                            $skill->where('title', 'LIKE', "%$keyword%");
                        });
                })
                ->orderBy('id', 'desc')
                ->paginate($perPage);

            return new AlumniCollection($query);
        }elseif (request()->latest_member_place) {
            $query = $this->alumni->query()
            ->with('alumni')
            ->select('id', 'first_name', 'middle_name', 'last_name','department_name')
            ->orderBy('id', 'DESC')
            ->limit(12)
            ->get();

            return new AlumniCollection($query);
        } elseif (request()->feature_alumni_place) {
            $query = $this->alumni->query()
            ->with('alumni')
            ->where('is_feature', 1)
            ->select('id', 'first_name', 'middle_name', 'last_name', 'about')
            ->orderBy('id', 'DESC')
            ->get();

            return new AlumniCollection($query);
        } else {
            $query = $this->alumni->with(['country', 'division', 'district', 'department', 'achievements', 'skills', 'experiences', 'educations'])->get();

            return new AlumniCollection($query);
        }

    }

    public function alumniManualRegistration()
    {
        $perPage = request()->per_page;
        $fieldName = request()->field_name;
        $keyword = request()->keyword;

        $query = Alumni::query()
            ->where('reg_type', 'Manual')
            ->where(function ($query) use ($fieldName, $keyword) {
                $query->where($fieldName, 'LIKE', "%$keyword%")
                ->orWhereHas('department', function ($dep) use ($keyword) {
                    $dep->where('title', 'LIKE', "%$keyword%");
                })
                    ->orWhereHas('country', function ($coun) use ($keyword) {
                        $coun->where('name', 'LIKE', "%$keyword%");
                    })
                    ->orWhereHas('district', function ($dist) use ($keyword) {
                        $dist->where('name', 'LIKE', "%$keyword%");
                    })
                    ->orWhereHas('skills', function ($skill) use ($keyword) {
                        $skill->where('title', 'LIKE', "%$keyword%");
                    });
            })
            ->orderBy('id', 'desc')
            ->paginate($perPage);

        return new AlumniCollection($query);
    }

    public function search(){

        $keyword = request()->globalSearch;
        if ($keyword != null){
            $query = Alumni::query()->with('alumni','backgroundImage','department')
                ->where('first_name', 'LIKE', "%$keyword%")
                ->orWhere('middle_name', 'LIKE', "%$keyword%")
                ->orWhere('last_name', 'LIKE', "%$keyword%")
                ->orWhere('company_email', 'LIKE', "%$keyword%")
                ->orWhere('university_email', 'LIKE', "%$keyword%")
                ->orWhere('personal_email', 'LIKE', "%$keyword%")
                ->orWhere('passing_year', 'LIKE', "%$keyword%")
                ->orWhere('organization', 'LIKE', "%$keyword%")
                ->orWhere('department_name', 'LIKE', "%$keyword%")
                ->orderBy('id', 'desc')
                ->get();
        }

        return response()->json([
            'data' => @$query ? $query : ''
        ],200);
    }

    public function deletedListIndex()
    {
        $alumnis = $this->alumni->onlyTrashed();
        return response()->json($alumnis);
    }

    public function allAlumnis() {
        return $this->alumni->query()->pluck('id');
    }

    public function store(AlumniRequest $request)
     {
        try {
            DB::beginTransaction();
            $data = $request;

            // Start user create
            $data['name'] = $data->first_name . ' ' . $data->middle_name . ' ' . $data->last_name;
            $data['phone'] = $data->personal_contact_number;
            $data['employment_status'] = 'Alumni';
            $data['password'] = Hash::make($request->password);
            $user = $this->user->create($data);
            // End user create

            $data['user_id'] = $user->id;
            $parameters = [
                'image_info' => [
                    [
                        'type' => 'alumni',
                        'images' => $data->image,
                        'directory' => 'alumnis',
                        'input_field' => 'image',
                        'width' => '',
                        'height' => '',
                    ],
                ],
            ];
            $alumni = $this->alumni->create($data, $parameters);
            DB::commit();

            return new AlumniResource($alumni);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error', $e->getMessage()
            ]);
        }


        // try {
        //     DB::beginTransaction();
        //     $data = $request;

        //     $experiencesData = [
        //         [
        //             "title" => $data->occupation,
        //             "company_name" => $data->organization_details,
        //             "designation_department" => $data->designation_department,
        //             "start_date" => $data->doj,
        //             "is_current" => 'Yes',
        //             "user_type" => 'alumni',
        //         ]
        //     ];

        //     $data['password'] = Hash::make($request->password);

        //     $parameters = [
        //         'image_info' => [
        //             [
        //                 'type' => 'alumni',
        //                 'images' => $data->image,
        //                 'directory' => 'alumnis',
        //                 'input_field' => 'image',
        //                 'width' => '',
        //                 'height' => '',
        //             ],
        //         ],

        //         'create_many' => [
        //             [
        //                 'relation' => 'experiences',
        //                 'data' => $experiencesData
        //             ],
        //         ],
        //     ];
        //     $alumni = $this->alumni->create($data, $parameters);

        //     DB::commit();

        //     return new AlumniResource($alumni);
        // } catch (\Exception $e) {
        //     DB::rollBack();
        //     return response()->json([
        //         'error', $e->getMessage()
        //     ]);
        // }
    }

    public function show(Alumni $alumnus)
    {
        // $alumni = $this->alumni->findOrFail($alumnus->id);
        // $department = Department::where('id', $alumni->department_id)->first();
        // $country = Country::where('id', $alumni->country_id)->first();
        // $district = District::where('id', $alumni->district_id)->first();

        // $skills = $alumni->skills;
        // foreach ($skills as $key => $skill) {
        //     $endorsement_count = Endorsement::where('user_id', $alumni->id)->where('activity_type', get_class($skill))->where('activity_id', $skill->id)->count();
        //     $skill['endorsement_count'] = $endorsement_count;
        //     $endorsers = Endorsement::with('user', 'user.alumni')->where('user_id', $alumni->id)->where('activity_type', get_class($skill))->where('activity_id', $skill->id)->get();
        //     $skill['endorsers'] = $endorsers;
        // }


        // return response()->json([
        //     'alumni' => $alumni,
        //     'image_url' => $alumni->alumni ? $alumni->alumni->source : null,
        //     'background_image_url' => $alumni->backgroundImage ? $alumni->backgroundImage->source : null,
        //     'department' => $department,
        //     'achievements' => $alumni->achievements,
        //     'skills' => $skills,
        //     'country' => $country,
        //     'district' => $district,
        // ]);

        $alumni = $this->alumni->findOrFail($alumnus->id);
        return new AlumniResource($alumni);
    }

    public function edit($id)
    {
        $alumni = $this->alumni->findOrFail($id);
        return response()->json($alumni);
    }

    public function update(AlumniRequest $request, Alumni $alumnus)
    {
        try {
            DB::beginTransaction();
            $data = $request;

            // alumni update from admin panel
            if($data->valueFrom == 'alumni_update') {
                // Start user update
                $data['name'] = $data->first_name . ' ' . $data->middle_name . ' ' . $data->last_name;
                $data['phone'] = $data->personal_contact_number;
                if ($data->password != null) {
                    if (!Hash::check($data->current_password, $data->old_password)) {
                        $request['errorMsgForCurrentPassword'] = "Current password dosen't match our records";
                        $data['password'] = $request->old_password;
                    } else {
                        $data['password'] = Hash::make($request->password);
                    }
                } else {
                    $data['password'] = $request->old_password;
                }

                $this->user->update($alumnus->user_id, $data);
                // End user update

                $parameters = [
                    'image_info' => [
                        [
                            'type' => 'alumni',
                            'images' => $data->image,
                            'directory' => 'alumnis',
                            'input_field' => 'image',
                            'width' => '',
                            'height' => '',
                        ],
                    ],
                ];
                $alumni = $this->alumni->update($alumnus->id, $data, $parameters);
            }

            // alumni background image update from alumni profile
            if ($data->valueFrom == 'background_image') {
                $parameters = [
                    'image_info' => [
                        [
                            'type' => 'alumni-backgroud',
                            'images' => $data->background_image,
                            'directory' => 'alumnis/background',
                            'input_field' => 'image',
                            'width' => '',
                            'height' => '',
                        ],
                    ],
                ];
                $alumni = $this->alumni->update($alumnus->id, $data, $parameters);
            }

            // alumni profile image update from alumni profile
            if ($data->valueFrom == 'profile_image') {
                $parameters = [
                    'image_info' => [
                        [
                            'type' => 'alumni',
                            'images' => $data->profile_image,
                            'directory' => 'alumnis',
                            'input_field' => 'image',
                            'width' => '',
                            'height' => '',
                        ],
                    ],
                ];
                $alumni = $this->alumni->update($alumnus->id, $data, $parameters);
            }

            // alumni skill info update from alumni profile
            if ($data->valueFrom == 'skill_info') {
                $alumni = $this->alumni->update($alumnus->id, $data);
                $alumni->skills()->attach($request->skill_ids);
            }

            // alumni achievement info update from alumni profile
            if ($data->valueFrom == 'achievement_info') {
                $alumni = $this->alumni->update($alumnus->id, $data);
                $alumni->achievements()->attach($request->achievement_ids);
            }

            // alumni username & email info update from alumni profile
            if ($data->valueFrom == 'username_email_info') {
                $this->user->update($alumnus->user_id, $data);
            }

            // alumni password info update from alumni profile
            if ($data->valueFrom == 'password_info') {
                if (Hash::check($data->current_password, $data->old_password) == true) {
                    $data['current_password'] = Hash::make($data->current_password);
                    $data['password'] = Hash::make($data->new_password);
                    $data['password_confirm'] = Hash::make($data->password_confirm);

                    $this->user->update($alumnus->user_id, $data);
                } else{
                    $request['errorMsgForCurrentPassword'] = "Current password dosen't match our records";
                }
            }

            // alumni rating info from admin panel
            if ($data->valueFrom == 'rating_info') {
                $alumni = $this->alumni->update($alumnus->id, $data);
            }

            // alumni feature checkbox info from admin panel
            if ($data->valueFrom == 'feature_checkbox_info') {
                $alumni = $this->alumni->update($alumnus->id, $data);
            }

            // alumni active inactive checkbox info from admin panel
            if ($data->valueFrom == 'alumni_active_inactive_checkbox_info') {
                $this->user->update($alumnus->user_id, $data);
                $this->alumni->update($alumnus->id, $data);
            }

            // add approve remark from admin panel
            if ($data->valueFrom == 'add_approve_remark') {
                $data['status'] = 'Active';
                $this->user->update($alumnus->user_id, $data);

                $data['reg_status'] = 'Approve';
                $this->alumni->update($alumnus->id, $data);

                $user = User::find($alumnus->user_id);
                $info = [];
                $info['subject'] = 'Your Application is approved';
                $info['name'] = $user->name;
                $info['email'] = $user->email;
                $info['remark'] = $data->approve_remark;

                // Notification::send($user, new ManualRegApproveOrRejectNotification($info));
                Notification::route('mail', $info['email'])->notify(new ManualRegApproveOrRejectNotification($info));
            }

            // add reject remark from admin panel
            if ($data->valueFrom == 'add_reject_remark') {
                $data['status'] = 'Inactive';
                $this->user->update($alumnus->user_id, $data);

                $data['status'] = 'Active';
                $data['reg_status'] = 'Reject';
                $this->alumni->update($alumnus->id, $data);

                $user = User::find($alumnus->user_id);
                $info = [];
                $info['subject'] = 'Your Application is rejected';
                $info['name'] = $user->name;
                $info['email'] = $user->email;
                $info['remark'] = $data->reject_remark;

                // Notification::send($user, new ManualRegApproveOrRejectNotification($info));
                Notification::route('mail', $info['email'])->notify(new ManualRegApproveOrRejectNotification($info));
            }

            $alumni = $this->alumni->update($alumnus->id, $data);

            DB::commit();

            $request['update'] = 'update';

            return new AlumniResource($alumni);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error', $e->getMessage()
            ]);
        }
    }

    public function destroy(Alumni $alumnus)
    {
        if (request()->valueFrom == 'skill_info') {
            $alumnus->skills()->detach(request()->skill_id);

            return response()->json([
                'message' => trans('alumni.skill_deleted'),
            ], 200);
        }elseif (request()->valueFrom == 'achievement_info') {
            $alumnus->achievements()->detach(request()->achievement_id);

            return response()->json([
                'message' => trans('alumni.achievement_deleted'),
            ], 200);
        }else{
            $this->alumni->delete($alumnus->id);

            return response()->json([
                'message' => trans('alumni.soft_delete'),
            ], 200);
        }
    }

    public function restore($id)
    {
        DB::beginTransaction();
        try {
            $this->alumni->restore($id);
            $user = User::onlyTrashed()->where('alumni_id', $id)->first();
            if ($user != null) {
                $user->restore();
            }
            DB::commit();

            return response()->json([
                'message' => trans('alumni.alumni_restored_successfully'),
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error', $e->getMessage()
            ]);
        }
    }

    public function forceDelete($id)
    {
        $this->alumni->forceDelete($id);

        return response()->json([
            'message' => trans('alumni.alumni_deleted_permanently'),
        ], 200);
    }

    public function massDestroy($alumnis){
        $alumnisArray = explode(',', $alumnis);
        Alumni::whereKey($alumnisArray)->delete();

        return response()->noContent();
    }

    public function status(Request $request)
    {
        $this->alumni->status($request->id);

        return response()->json([
            'message' => trans('alumni.alumni_status_updated_successfully'),
        ], 200);
    }

    public function alumniProfileCompletionPercentage($id) {
        $alumni = Alumni::with('experiences', 'educations', 'skills', 'achievements')->findOrFail($id);
        // dd($alumni);
        $sum = 0;
        if($alumni->alumni) {
            $sum = $sum + 10;
        }
        if ($alumni->backgroundImage) {
            $sum = $sum + 10;
        }
        // basic info
        if ($alumni->ewu_id_no) {
            $sum = $sum + 4;
        }
        if ($alumni->first_name || $alumni->middle_name || $alumni->last_name) {
            $sum = $sum + 4;
        }
        if ($alumni->dob) {
            $sum = $sum + 2;
        }
        if ($alumni->blood_group) {
            $sum = $sum + 2;
        }
        // organization
        if ($alumni->organization) {
            $sum = $sum + 2;
        }
        if ($alumni->designation_department) {
            $sum = $sum + 2;
        }
        // location
        if ($alumni->country_id) {
            $sum = $sum + 2;
        }
        if ($alumni->district_id) {
            $sum = $sum + 2;
        }
        // Contact Info
        if ($alumni->contact_number) {
            $sum = $sum + 4;
        }
        if ($alumni->personal_email || $alumni->university_email || $alumni->company_email) {
            $sum = $sum + 2;
        }
        if ($alumni->facebook_profile_link) {
            $sum = $sum + 2;
        }
        if ($alumni->linkedin_profile_link) {
            $sum = $sum + 2;
        }
        // about
        if ($alumni->about) {
            $sum = $sum + 10;
        }
        // experience
        if (sizeof($alumni->experiences)) {
            $sum = $sum + 10;
        }
        // education
        if (sizeof($alumni->educations)) {
            $sum = $sum + 10;
        }
        // skills
        if (sizeof($alumni->skills)) {
            $sum = $sum + 10;
        }
        // achievement
        if (sizeof($alumni->achievements)) {
            $sum = $sum + 10;
        }

        return response()->json([
            'percentage' => $sum,
        ], 200);
    }

    public function import()
    {
        Excel::import(new AlumnisImport(),request()->file('file'));

        return response()->json([
            'message' => 'alumni created successfully',
        ], 200);
    }

    public function exportXLS($alumniIds)
    {
        $alumnisArray = explode(',', $alumniIds);
        return Excel::download(new AlumnisExport($alumnisArray), 'alumnis.xlsx');
    }

    public function inviteOthers()
    {
        $sender = Alumni::query()->findOrFail(request()->auth_id);
        $sender['email'] = request()->email;

        Mail::to(request()->email)->send(new AlumniInvitationMail($sender));

        return response()->json([
           'data' =>'success'
        ]);
    }

    // public function profileCompletionNotification($receiverAlumniId) {
    //     $alumni = Alumni::findOrFail($receiverAlumniId);
    //     $alumni->notify(new ProfileCompletion(request()->sender_alumni_id, request()->profile_completion_percentage_amount));

    //     return response()->noContent();
    // }

    // public function getUnreadProfileCompletionNotification() {
    //     $alumni = Alumni::findOrFail(request()->auth_id);

    //     return ProfileCompletionResource::collection($alumni->unreadNotifications);
    // }

    // public function readProfileCompletionNotification() {
    //     $alumni = Alumni::findOrFail(request()->alumni_id);
    //     // $alumni->notifications->markAsRead();

    //     $userUnreadNotification = $alumni->unreadNotifications
    //     ->where('id', request()->notification_id)
    //     ->first();

    //     if ($userUnreadNotification) {
    //         $userUnreadNotification->markAsRead();
    //     }

    //     return response()->json('success');
    // }


    // otp code start
    // public function checkAlumniByStudentId($studentId)
    // {
    //     $alumni = Alumni::where('ewu_id_no', $studentId)->first();
    //     if ($alumni != null) {
    //         return response()->json([
    //             'status' => true,
    //             'message' => 'You are registered'
    //         ]);
    //     } else{
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'You are not register'
    //         ]);
    //     }
    // }

    // // sent otp mail notification temporary code start
    // public function sendOtpByMobile($mobile)
    // {
    //     $generateOtp = mt_rand(100000, 999999);

    //     $otp = Otp::where('mobile', $mobile)->first();
    //     if ($otp) {
    //         // Record exists, delete it
    //         $otp->delete();

    //         Otp::create([
    //             'mobile' => $mobile,
    //             'otp' => $generateOtp,
    //             'expire_at' => now()->addMinutes(2),
    //             'expiry_time' => 2,
    //         ]);
    //     } else {
    //         Otp::create([
    //             'mobile' => $mobile,
    //             'otp' => $generateOtp,
    //             'expire_at' => now()->addMinutes(2),
    //             'expiry_time' => 2,
    //         ]);
    //     }

    //     try {
    //         // $client = new Client();

    //         // $response = $client->post(config('services.sslwireless.api_url'), [
    //         //     'headers' => [
    //         //         'Authorization' => 'Bearer 1279-98d2bb25-3f7e-49bf-a1e2-5d1a6c6c588f',
    //         //     ],
    //         //     'form_params' => [
    //         //         'api_username' => config('services.sslwireless.username'),
    //         //         'api_password' => config('services.sslwireless.password'),
    //         //         'senderid' => config('services.sslwireless.sender_id'),
    //         //         'smstext' => 'Hello, World!',
    //         //         'mobileno' => '01723559950',
    //         //     ],
    //         // ]);

    //         // return $response->getBody()->getContents();


    //         // $client = new Client();

    //         // $response = $client->post('https://smsplus.sslwireless.com/api/v3/send-sms', [
    //         //     'query' => [
    //         //         'api_token' => '1279-98d2bb25-3f7e-49bf-a1e2-5d1a6c6c588f',
    //         //         'api_username' => 'mahfuz',
    //         //         'api_password' => 'C5XzBV9',
    //         //         'sid' => 'EWU',
    //         //         'msisdn' => '01723559950',
    //         //         'sms' => 'Hello, World!',
    //         //         "csms_id" => "4473433434pZ684333392",
    //         //     ],
    //         // ]);

    //         // $dd = $response->getBody()->getContents();
    //         // dd($dd);
    //         // return $response->getBody()->getContents();


    //         $sslWireless = new SslWireless();
    //         // $to = $mobile;
    //         // $message = "Your OTP is: " .$generateOtp. "This OTP will expire in 2 minutes. Please don't share your OTP in any one";
    //         // $sslWireless->sendSms($to, $message);

    //         $msisdn = "01723559950";
    //         $messageBody = "Message Body";
    //         $csmsId = "2934fe343";
    //         $sslWireless->singleSms($msisdn, $messageBody, $csmsId);







    //         // $client = new Client();

    //         // $response = $client->request('POST', 'https://sms.sslwireless.com/pushapi/dynamic/server.php', [
    //         //     'form_params' => [
    //         //         'user' => 'mahfuz',
    //         //         'pass' => 'C5XzBV9',
    //         //         'sid' => 'EWU',
    //         //         'sms' => 'Your SMS text message goes here',
    //         //         'msisdn' => '01723559950', // Receiver's phone number with country code
    //         //         'csms_id' => '4473433434pZ684333392', // optional
    //         //         'fl' => '0', // optional
    //         //     ],
    //         // ]);

    //         // $response_body = $response->getBody()->getContents();

    //         // dd($response_body);








    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'OTP sent successfully'
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => 'failed',
    //             'message' => 'Failed to send OTP'
    //         ]);
    //     }



    //     // try {
    //     //     DB::beginTransaction();
    //     //     $generateOtp = mt_rand(100000, 999999);
    //     //     $otp = Otp::where('mobile', $mobile)->first();
    //     //     if ($otp) {
    //     //         // Record exists, delete it
    //     //         $otp->delete();

    //     //         Otp::create([
    //     //             'mobile' => $mobile,
    //     //             'otp' => $generateOtp,
    //     //             'expire_at' => now()->addMinutes(2),
    //     //             'expiry_time' => 2,
    //     //         ]);
    //     //     } else {
    //     //         Otp::create([
    //     //             'mobile' => $mobile,
    //     //             'otp' => $generateOtp,
    //     //             'expire_at' => now()->addMinutes(2),
    //     //             'expiry_time' => 2,
    //     //         ]);
    //     //     }

    //     //     $sslWireless = new SslWireless();
    //     //     $smsSent = $sslWireless->sendSms('01723559950', 'test message');

    //     //     if ($smsSent) {
    //     //         DB::commit();

    //     //         return response()->json([
    //     //             'status' => 'success',
    //     //             'message' => 'OTP sent successfully'
    //     //         ]);
    //     //     } else {
    //     //         DB::rollBack();

    //     //         return response()->json([
    //     //             'status' => 'failed',
    //     //             'message' => 'Failed to send OTP'
    //     //         ]);
    //     //     }
    //     // } catch (\Exception $e) {
    //     //     DB::rollBack();
    //     //     return $e->getMessage();
    //     // }
    // }

    // public function sendOtpByEmail($email)
    // {
    //     $generateOtp = mt_rand(100000, 999999);

    //     $otp = Otp::where('email', $email)->first();
    //     if ($otp) {
    //         // Record exists, delete it
    //         $otp->delete();

    //         Otp::create([
    //             'email' => $email,
    //             'otp' => $generateOtp,
    //             'expire_at' => now()->addMinutes(2),
    //             'expiry_time' => 2,
    //         ]);
    //     } else {
    //         Otp::create([
    //             'email' => $email,
    //             'otp' => $generateOtp,
    //             'expire_at' => now()->addMinutes(2),
    //             'expiry_time' => 2,
    //         ]);
    //     }

    //     try {
    //         Notification::route('mail', $email)->notify(new RegisterOtpNotification($generateOtp));

    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'OTP sent successfully'
    //         ]);
    //     } catch (\Exception $e) {

    //         return response()->json([
    //             'status' => 'failed',
    //             'message' => 'Failed to send OTP'
    //         ]);
    //     }
    // }

    // public function verifyOtp($otp)
    // {
    //     $otp = Otp::where('otp', $otp)->first();

    //     if ($otp != null) {
    //         if ($otp && now()->isBefore($otp->expire_at)) {
    //             $otp->delete();

    //             return response()->json([
    //                 'status' => 'success',
    //                 'message' => 'OTP verified successfully'
    //             ]);
    //         } else {
    //             return response()->json([
    //                 'status' => 'failed',
    //                 'message' => 'Your OTP has expired'
    //             ]);
    //         }
    //     } else {
    //         return response()->json([
    //             'status' => 'failed',
    //             'message' => 'Invalid OTP'
    //         ]);
    //     }
    // }
    // // sent otp mail notification temporary code end

    // public function getStudentAlumniInfoByStudentId($student_id) {
    //     $alumni = Alumni::with('alumni')->where('ewu_id_no', $student_id)->first();
    //     if ($alumni != null) {
    //         return response()->json([
    //             'status' => true,
    //             'message' => "Student id match our records",
    //             'data' => $alumni
    //         ]);
    //     } else {
    //         return response()->json([
    //             'status' => false,
    //             'message' => "Student id don't match our records"
    //         ]);
    //     }
    // }
    // otp code end


    // socialite code start
    // public function redirectToProvider($provider) {
    //     return Socialite::driver($provider)->stateless()->redirect();
    // }

    // public function handleProviderCallback($provider) {
    //     $user = Socialite::driver($provider)->stateless()->user();
    //     if ($provider == 'facebook') {
    //         $data = [
    //             "provider" => 'facebook',
    //             "id" => $user->attributes['id'],
    //             "nickname" => $user->attributes['nickname'],
    //             "name" => $user->attributes['name'],
    //             "email" => $user->attributes['email'],
    //             "avatar" => $user->attributes['avatar'],
    //             "access_token" => $user->token
    //         ];
    //     } elseif ($provider == 'linkedin') {
    //         $data = [
    //             "provider" => 'linkedin',
    //             "id" => $user->attributes['id'],
    //             "nickname" => $user->attributes['nickname'],
    //             "name" => $user->attributes['name'],
    //             "first_name" => $user->attributes['first_name'],
    //             "last_name" => $user->attributes['last_name'],
    //             "email" => $user->attributes['email'],
    //             "avatar" =>$user->attributes['avatar'],
    //             "access_token" => $user->token
    //         ];
    //     }

    //     $redirectUrl = 'http://127.0.0.1:5173/profile?data=' . urlencode(json_encode($data));
    //     // $redirectUrl = 'http://alumni.fscd.xyz/profile?data=' . urlencode(json_encode($user));

    //     return redirect($redirectUrl);
    // }

    // public function getUserInfo($provider) {
    //     if ($provider == 'facebook') {
    //         $user = Socialite::driver($provider)->userFromToken(env('FACEBOOK_ACCESS_TOKEN'));
    //     } elseif($provider == 'linkedin') {
    //         $user = Socialite::driver($provider)->userFromToken(env('LINKEDIN_ACCESS_TOKEN'));
    //     }

    //     return response()->json(['user' => $user]);
    // }
    // socialite code end


    public function exportPDF($filename, $ids)
    {
        $idsString = $ids;
        $idsArray = explode(',', $idsString);
        $alumnis = $this->alumni->query()->with(['alumni','department'])->whereIn('id', $idsArray)->get();

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
                                <th>ID</th>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Contact No</th>
                                <th>Department</th>
                                <th>Occupation</th>
                            </tr>
                        </thead>
                        <tbody>';
        foreach ($alumnis as $key=>$alumni) {
            $datatable .= '<tr>';
            $datatable .= '<td>' . $key + 1 . '</td>';
            $datatable .= '<td>' . $alumni->ewu_id_no. '</td>';

            $datatable .= '<td class="text-center"> <div class="passport-photo">';
            if ($alumni->alumni != null) {
                $imageString = $alumni->alumni->source;
                $explodeImageString = explode("uploads", $imageString)[1];
                $datatable .= "<img class='border' src='" . public_path('uploads/' . $explodeImageString) . "' alt='alumni-image' width='60' height='80'>";
            } else {
                $datatable .= 'N/A';
            }
            $datatable .= '</div></td>';

            $datatable .= '<td>' . $alumni->first_name .' '. $alumni->middle_name . ' ' . $alumni->last_name . '</td>';
            $datatable .= '<td>';
            $datatable .= '<span><b>Personal:</b>' . $alumni->personal_email . '</span><br>';
            $datatable .= '<span><b>University:</b>' . $alumni->university_email . '</span><br>';
            $datatable .= '<span><b>Company:</b>' . $alumni->company_email . '</span>';
            $datatable .= '</td>';
            $datatable .= '<td>' . $alumni->personal_contact_number . '</td>';
            $datatable .= '<td>' . $alumni->department->title . '</td>';
            $datatable .= '<td>' . $alumni->designation_department . '</td>';
            $datatable .= '</tr>';
        }
        $datatable .= '</tbody></table>';

        $this->pdf->loadHtml($datatable);
        $this->pdf->setPaper('A4');
        $this->pdf->render();

        return $this->pdf->download($filename);
    }
}
