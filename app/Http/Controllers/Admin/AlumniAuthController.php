<?php

namespace App\Http\Controllers\Api;

use Mail;
use App\Models\Alumni;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Interfaces\UserInterface;
use Illuminate\Support\Facades\DB;
use App\Interfaces\AlumniInterface;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Admin\AlumniRequest;
use App\Models\User;

class AlumniAuthController extends Controller
{
    protected $user;
    protected $alumni;

    public function __construct(UserInterface $user, AlumniInterface $alumni)
    {
        $this->user = $user;
        $this->alumni = $alumni;
    }

    public function alumniRegister(AlumniRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request;

            // Start user create
            if (request()->auth_id){
                $user = User::query()->findOrFail(request()->auth_id);
            } else {
                $data['name'] = $data->first_name . ' ' . $data->middle_name . ' ' . $data->last_name;
                $data['employment_status'] = 'Alumni';
                $data['password'] = Hash::make($request->password);
                $user = $this->user->create($data);
            }
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
            $this->alumni->create($data, $parameters);
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Alumni created successfully',
            ], 200);
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
        //             "company_name" => $data->organization,
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

        //     return response()->json([
        //         'status' => true,
        //         'message' => 'Alumni created successfully',
        //     ], 200);

        // } catch (\Exception $e) {
        //     DB::rollBack();
        //     return response()->json([
        //         'error', $e->getMessage()
        //     ]);
        // }
    }

    protected function alumniLogin(Request $request)
    {
        try {
            $user = User::with('alumni')->where('email', $request->email)->first();
            if ($user != null) {
                if ($user->status == 'Active') {
                    $request->validate([
                        'email' => 'required|email',
                        'password' => 'required',
                    ]);

                    $credentials = $request->only('email', 'password');
                    if (Auth::attempt($credentials)) {
                        return response()->json([
                            'status' => true,
                            'message' => 'You have Successfully loggedin',
                            'token' => $user->createToken("API TOKEN")->plainTextToken,
                            'auth_user_id' => $user->id,
                            'auth_alumni_id' => $user->alumni->id,
                        ], 200);
                    } else {
                        return response()->json([
                            'status' => true,
                            'message' => 'Your credentials does not match with our record',
                        ], 401);
                    }
                } elseif ($user->status == 'Inactive') {
                    return response()->json([
                        'status' => true,
                        'message' => 'Your account is not active! Please active your account',
                    ], 401);
                }

            } else {
                return response()->json([
                    'status' => true,
                    'message' => 'You have entered invalid credentials',
                ], 401);
            }

            // if (Auth::guard('alumni')->attempt($request->only(['email', 'password']))) {
            //     $alumni = Alumni::where('email', $request->email)->first();

            //     return response()->json([
            //         'status' => true,
            //         'message' => 'Alumni Logged in successfully',
            //         'token' => $alumni->createToken("API TOKEN")->plainTextToken,
            //         'auth_id' => $alumni->id
            //     ], 200);
            // } else {
            //     return response()->json([
            //         'status' => false,
            //         'message' => 'Email & Password does not match with our record',
            //         'errors' => $validate->errors()
            //     ], 401);
            // }
        } catch (\Throwable $th){
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $th->getMessage()
            ],500);
        }
    }

    public function alumniForgotPassword(Request $request) {
        $validate = Validator::make($request->all(),[
            'email' => 'required|email',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validate->errors()
            ], 401);
        }

        $email = $request->email;
        $token = Str::random(65);

        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => now()->addHours(1)
        ]);

        // Send Mail
        Mail::send('mail.reset_password', ['token' => $token], function($msg) use ($email){
            $msg->to($email);
            $msg->subject('Password reset mail');
        });

        return response()->json([
            'message' => 'Password reset mail send success. Please check your mail'
        ]);
    }

    public function alumniResetPassword(Request $request) {
        $validate = Validator::make($request->all(), [
            'password' => 'required|min:8|confirmed',
            'token' => 'required|exists:password_resets',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'errors' => $validate->errors()
            ], 422);
        }

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
}
