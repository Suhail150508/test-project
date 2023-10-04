<?php

namespace App\Http\Controllers\Api;

use DB;
use Auth;
use App\Models\Otp;
use App\Models\User;
use App\Models\Resume;
use App\Models\UserRating;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\JobPortalUser;
use Illuminate\Support\Carbon;
use App\SslWireless\SslWireless;
use App\Exports\JobApplicantExport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\TwoFactorAuthentication;
use Illuminate\Support\Facades\Validator;
use App\Notifications\LoginOtpNotification;
use Illuminate\Support\Facades\Notification;
use App\Http\Requests\Admin\JobProfileRequest;
use App\Http\Resources\JobPortalUserCollection;
use App\Http\Requests\Admin\JobProfileRatingRequest;


class JobProfileController extends Controller
{

    public function index()
    {
        if (request()->per_page) {
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;
            $query = Resume::query()
                ->leftJoin('resume_files', 'resumes.id', '=', 'resume_files.resume_id')
                ->leftJoin('files as cv_files', function ($join) {
                    $join->on('resume_files.id', '=', 'cv_files.fileable_id')
                        ->where('cv_files.type', '=', 'resume_cv')
                        ->where('cv_files.fileable_type', '=', 'App\Models\ResumeFile');
                })
                ->leftJoin('files as video_files', function ($join) {
                    $join->on('resume_files.id', '=', 'video_files.fileable_id')
                        ->where('video_files.type', '=', 'resume_video')
                        ->where('video_files.fileable_type', '=', 'App\Models\ResumeFile');
                })
                ->leftJoin('career_applications', 'resumes.id', '=', 'career_applications.resume_id')
                ->leftJoin('education', 'resumes.id', '=', 'education.resume_id')
                ->leftJoin('addresses', 'resumes.id', '=', 'addresses.resume_id')
                ->leftJoin('divisions', 'divisions.id', '=', 'addresses.division_id')
                ->leftJoin('districts', 'districts.id', '=', 'addresses.district_id')
                ->leftJoin('thanas', 'thanas.id', '=', 'addresses.thana_id')
                ->leftJoin('subjects AS subjects1', 'subjects1.id', '=', 'education.major_subject_id')
                ->leftJoin('subjects AS subjects2', 'subjects2.id', '=', 'education.minor_subject_id')
                ->select(
                    'resumes.*',
                    'education.board',
                    'education.passing_year',
                    'education.id as idd',
                    'career_applications.present_salary',
                    'divisions.name',
                    'subjects1.name As major_subject',
                    'subjects2.name as minor_subject',
                    'cv_files.source as resume_cv',
                    'video_files.source as resume_video'
                )
                ->when($fieldName == "division_name" && $keyword, function ($q) use ($keyword) {
                    $q->orWhere('divisions.name', 'LIKE', "%$keyword%");
                })
                ->when($fieldName == "division_name" && $keyword, function ($q) use ($keyword) {
                    $q->orWhere('divisions.name', 'LIKE', "%$keyword%");
                })
                ->when($fieldName == "district_name" && $keyword, function ($q) use ($keyword) {
                    $q->orWhere('districts.name', 'LIKE', "%$keyword%");
                })
                ->when($fieldName == "thana_name" && $keyword, function ($q) use ($keyword) {
                    $q->orWhere('thanas.name', 'LIKE', "%$keyword%");
                })
                ->when($fieldName == "major_id" && $keyword, function ($q) use ($keyword) {
                    $q->orWhere('subjects1.name', 'LIKE', "%$keyword%");
                })
                ->when($fieldName == "minor_id" && $keyword, function ($q) use ($keyword) {
                    $q->orWhere('subjects2.name', 'LIKE', "%$keyword%");
                })
                ->when($fieldName != "division_name" && $fieldName != "district_name" && $fieldName != "thana_name" && $fieldName != "major_id" && $fieldName != "minor_id" && $keyword, function ($q) use ($keyword, $fieldName) {
                    $q->where($fieldName, 'LIKE', "%$keyword%");
                })
                ->orderBy('resumes.id', 'desc')
                ->with('userRating')
                ->groupBy('resumes.id')
                ->paginate($perPage);

            return new JobPortalUserCollection($query);
        }
    }

    public function jobCompanies()
    {

        if (request()->per_page) {
            // If more than 0
            $perPage = request()->per_page;
            $fieldName = request()->field_name;
            $keyword = request()->keyword;
            $query = Resume::query()
                ->whereHas('user', function ($query) {
                    $query->where('employment_status', 'Company');
                })
                ->orderBy('id', 'desc')
                ->paginate($perPage);
            return new JobPortalUserCollection($query);
        }
    }


    public function allApplicants()
    {
        $data = Resume::query()->pluck('id');
        return response()->json($data);
    }

    public function exportXLS($applicantIds)
    {
        $applicantIdsArray = explode(',', $applicantIds);
        return Excel::download(new JobApplicantExport($applicantIdsArray), 'applicant.xlsx');
    }

    public function userRatingIndex($resume_id)
    {
        $data = UserRating::where('resume_id', $resume_id)->orderBy('id', 'desc')->get();
        // $data['note'] = $data[0]['note'];
        return response()->json($data);
    }


    public function store(JobProfileRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->all();
            $data['password'] = Hash::make($request->password);

            if ($request->auth_id) {
                $user = User::query()->findOrFail($request->auth_id);
                $data['user_id'] = $user->id;
                $data['first_name'] = $user->name;
                $data['birthdate'] = Carbon::createFromFormat('d/m/Y', $request->input('birthdate'))->format('Y-m-d');
                $data['national_id'] = $data['nid'];
                $data['email'] = $user->email;

                Resume::query()->create($data);
                DB::commit();

                return response()->json([
                    'status' => true,
                    'message' => 'Job Account created successfully',
                ], 200);
            } else {
                $user = User::create($data);
                $data['user_id'] = $user->id;
                Resume::create($data);
                DB::commit();

                return response()->json([
                    'status' => true,
                    'message' => 'User created successfully',
                    'token' => $user->createToken("API TOKEN")->plainTextToken
                ], 200);
            }
        } catch (\Exception $e) {
            // An error occured; cancel the transaction...
            DB::rollback();

            // and throw the error again.
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    public function userRatingStore(JobProfileRatingRequest $request)
    {
        $UserRating = UserRating::where('resume_id', $request->resume_id)->get();
        if ($UserRating) {
            foreach ($UserRating as $item) {
                $item->delete();
            }
        }
        foreach ($request->ratingFormDetails as $item) {
            $item['resume_id'] = $request->resume_id;
            $item['note'] = $request->note;
            $item = UserRating::create($item);
        }
        return response()->json('success');
    }


    public function userprofile($auth_id)
    {
        $jobProfileUser = User::with(['resume', 'jobPost', 'employee'])->withCount(['jobApplications', 'workshopApplications', 'trainingApplications', 'jobPost'])->where('id', $auth_id)->first();
        if ($jobProfileUser->resume->resumeImage) {
            $jobProfileUser['resume_image'] = $jobProfileUser->resume->resumeImage->source;
        }
        $user_jobpost_withapplications = $jobProfileUser->jobPost()->withCount(['job_applications', 'sort_listed_applications'])->get();
        $jobProfileUser['total_job_applications'] = $user_jobpost_withapplications->sum('job_applications_count');
        $jobProfileUser['total_sortlisted_applications'] = $user_jobpost_withapplications->sum('sort_listed_applications_count');
        return response()->json($jobProfileUser);
    }

    public function userlogin(request $request)
    {
        try {
            $validate = Validator::make(
                $request->all(),
                [
                    'email' => 'required|email',
                    'password' => 'required',
                ]
            );

            if ($validate->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validate->errors()
                ], 401);
            }

            if (Auth::attempt($request->only(['email', 'password']))) {
                $user = User::where('email', $request->email)->first();
                $resume = Resume::where('user_id', $user->id)->first();

                // 2FA OTP sent code start
                $twoFAInfo = TwoFactorAuthentication::where('user_id', $user->id)->first();
                if ($twoFAInfo && $twoFAInfo->status === 'Enable') {
                    $this->OTPSendFor2FA($twoFAInfo);
                }

                return response()->json([
                    'status' => true,
                    'message' => 'User Logged in successfully',
                    'two_fa_status' => $twoFAInfo ? $twoFAInfo->status : 'Disable',
                    'token' => $user->createToken("API TOKEN")->plainTextToken,
                    'auth_id' => $user->id,
                    'employment_status' => $user->employment_status,
                    'resume_id' => @$resume->id,
                    'resume' => $resume,
                ], 200);
            } else {
                return response()->json([
                    'status' => true,
                    'message' => 'Your credentials does not match with our records',
                ], 401);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $th->getMessage()
            ], 500);
        }
    }

    public function OTPSendFor2FA($twoFAInfo)
    {
        $generateOtp = mt_rand(100000, 999999);
        $otp = Otp::where('type', '2fa')->where('mobile', $twoFAInfo->mobile)->where('email', $twoFAInfo->email)->first();
        if ($otp) {
            // Record exists, delete it
            $otp->delete();

            Otp::create([
                'type' => '2fa',
                'mobile' => $twoFAInfo->mobile,
                'email' => $twoFAInfo->email,
                'otp' => $generateOtp,
                'expire_at' => now()->addMinutes(2),
                'expiry_time' => 2,
            ]);
        } else {
            Otp::create([
                'type' => '2fa',
                'mobile' => $twoFAInfo->mobile,
                'email' => $twoFAInfo->email,
                'otp' => $generateOtp,
                'expire_at' => now()->addMinutes(2),
                'expiry_time' => 2,
            ]);
        }

        $sslWireless = new SslWireless();
        $to = $twoFAInfo->mobile;
        $message = "Your OTP is: " . $generateOtp . " This OTP will be expired in 2 minutes. Please don't share your OTP in any one";
        $sslWireless->sendSms($to, $message);

        Notification::route('mail', $twoFAInfo->email)->notify(new LoginOtpNotification($generateOtp));
    }

    public function jobProfileForgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->email;
        $token = Str::random(65);

        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => now()->addHours(1)
        ]);

        // Send Mail
        Mail::send('mail.job_profile_reset_password', ['token' => $token], function ($msg) use ($email) {
            $msg->to($email);
            $msg->subject('Password reset mail');
        });

        return response()->json([
            'message' => 'Password reset mail send success. Please check your mail'
        ]);
    }

    public function jobProfileResetPassword(Request $request){
        $request->validate([
            'password' => 'required|min:8|confirmed',
            'token' => 'required|exists:password_resets',
        ]);

        $token = DB::table('password_resets')->where('token', $request->token)->first();
        // $user = Alumni::whereEmail($token->email)->first();
        $user = User::whereEmail($token->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_resets')->where('token', $request->token)->delete();

        return response()->json([
            'message' => 'Password reset success'
        ]);
    }

    public function userlogout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function update(Request $request, $id)
    {
        try {
            $user = Resume::where('id', $id)->update($request->all());
            return response()->json([
                'type' => "success",
                'message' => 'Job Profile updated',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'type' => "error",
                'message' =>  $th->getMessage()
            ]);
        }

        // $user = Resume::where('id',$id)->update($request->all());
        // $data= [
        //     'type' => "error",
        //     'message' => "Current password Not match with old password",
        // ];
        // return response()->json('success');
    }

    public function accountUpdate(Request $request, $id)
    {
        $user = User::where('id', $id)->first();
        if ($request->currentpassword && $request->newpassword) {
            #Match The Old Password
            if (!Hash::check($request->currentpassword, $user->password)) {
                $data = [
                    'type' => "error",
                    'message' => "Current password Not match with old password",
                ];
            } elseif ($request->currentpassword == $request->newpassword) {
                $data = [
                    'type' => "error",
                    'message' => "Current password New password can't be same",
                ];
            } else {
                $request['password'] = Hash::make($request->newpassword);
                $user = User::where('id', $id)->update(['password' => $request['password']]);

                $data = [
                    'type' => "success",
                    'message' => "password updated successfully",
                ];
            }
            return response()->json($data);
        }
        $data = [
            'type' => "error",
            'message' => "Input field can't be empty",
        ];
        return response()->json($data);
    }

    public function userRatingUpdate(Request $request, $id)
    {
        $userRating = UserRating::findOrFail($id);
        $userRating->update($request->all());
        return response()->json('success');
    }

    public function destroy($id)
    {
    }
}
