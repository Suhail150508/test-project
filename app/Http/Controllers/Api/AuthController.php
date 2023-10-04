<?php

namespace App\Http\Controllers\Api;

use App\Models\Otp;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\SslWireless\SslWireless;
use App\Interfaces\UserInterface;
use Illuminate\Support\Facades\DB;
use App\Interfaces\AlumniInterface;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\TwoFactorAuthentication;
use App\Http\Requests\Admin\LoginRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Admin\AlumniRequest;
use App\Notifications\LoginOtpNotification;
use App\Http\Requests\Admin\RegisterRequest;
use Illuminate\Support\Facades\Notification;
use App\Http\Requests\Admin\resetPasswordRequest;
use App\Http\Requests\Admin\forgotPasswordRequest;

class AuthController extends Controller
{
    protected $user;
    protected $alumni;

    public function __construct(UserInterface $user, AlumniInterface $alumni)
    {
        $this->user = $user;
        $this->alumni = $alumni;
    }

    // For alumni register
    public function alumniRegister(AlumniRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request;

            // Start user create
            if (request()->auth_id) {
                $user = User::query()->findOrFail(request()->auth_id);
            } else {
                $data['name'] = $data->first_name . ' ' . $data->middle_name . ' ' . $data->last_name;
                $data['employment_status'] = 'Alumni';
                $data['password'] = Hash::make($request->password);
                $user = $this->user->create($data);
                $token = $user->createToken('authToken')->plainTextToken;
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
                'token' => $token
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error', $e->getMessage()
            ]);
        }
    }

    // For manually alumni register
    public function alumniRegisterManually(AlumniRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request;

            // Start user create
            $data['name'] = $data->first_name . ' ' . $data->middle_name . ' ' . $data->last_name;
            $data['employment_status'] = 'Alumni';
            $data['status'] = 'Inactive';
            $data['password'] = Hash::make($request->password);
            $user = $this->user->create($data);
            $token = $user->createToken('authToken')->plainTextToken;
            // End user create

            $data['user_id'] = $user->id;
            $data['status'] = 'Active';
            $data['reg_type'] = 'Manual';
            $data['reg_status'] = 'Pending';
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
                'token' => $token
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error', $e->getMessage()
            ]);
        }
    }

    // public function register(RegisterRequest $request)
    // {
    //     try {
    //         $data = $request->all();
    //         $data['password'] = Hash::make($request->password);
    //         $user = User::create($data);
    //         $token = $user->createToken('authToken')->plainTextToken;

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Register successfully',
    //             'token' => $token
    //         ], 200);
    //     } catch (\Throwable $th) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'validation error',
    //             'errors' => $th->getMessage()
    //         ], 500);
    //     }
    // }

    public function login(LoginRequest $request)
    {
        try {
            $user = User::where('email', $request->email)->first();
            if ($user != null) {
                if ($user->status == 'Active') {
                    $credentials = $request->only('email', 'password');
                    if (Auth::attempt($credentials)) {
                        $token = $user->createToken('authToken')->plainTextToken;

                        // 2FA OTP sent code start
                        $twoFAInfo = TwoFactorAuthentication::where('user_id', $user->id)->first();
                        if ($twoFAInfo && $twoFAInfo->status === 'Enable') {
                            $this->OTPSendFor2FA($twoFAInfo);
                        }

                        // $twoFAInfo = TwoFactorAuthentication::where('user_id', $user->id)->first();
                        // if ($twoFAInfo && $twoFAInfo->status === 'Enable') {
                        //     $generateOtp = mt_rand(100000, 999999);
                        //     $otp = Otp::where('mobile', $twoFAInfo->mobile)->first();
                        //     if ($otp) {
                        //         // Record exists, delete it
                        //         $otp->delete();

                        //         Otp::create([
                        //             'mobile' => $twoFAInfo->mobile,
                        //             'otp' => $generateOtp,
                        //             'expire_at' => now()->addMinutes(2),
                        //             'expiry_time' => 2,
                        //         ]);
                        //     } else {
                        //         Otp::create([
                        //             'mobile' => $twoFAInfo->mobile,
                        //             'otp' => $generateOtp,
                        //             'expire_at' => now()->addMinutes(2),
                        //             'expiry_time' => 2,
                        //         ]);
                        //     }


                        //     // $sslWireless = new SslWireless();
                        //     // $to = $twoFAInfo->mobile;
                        //     // // $to = $mobile;
                        //     // $message = "Your OTP is: " . $generateOtp . " This OTP will be expired in 2 minutes. Please don't share your OTP in any one";
                        //     // $sslWireless->sendSms($to, $message);

                        //     Notification::route('mail', $twoFAInfo->email)->notify(new LoginOtpNotification($generateOtp));
                        // }
                        // 2FA OTP sent code end

                        return response()->json([
                            'status' => true,
                            'message' => 'You have Successfully loggedin',
                            'two_fa_status' => $twoFAInfo? $twoFAInfo->status : 'Disable',
                            'token' => $token,
                            'auth_id' => $user->id,
                            'alumni_id' => $user->alumni ? $user->alumni->id : null,
                            'resume_id' => $user->resume ? $user->resume->id: null,
                        ], 200);
                    } else {
                        return response()->json([
                            'status' => true,
                            'message' => 'Your credentials does not match with our records',
                        ], 401);
                    }
                } elseif ($user->status == 'Inactive') {
                    return response()->json([
                        'status' => true,
                        'message' => 'Your account is currently inactive. Contact the Administrators to activate your account.',
                    ], 401);
                }
            } else {
                return response()->json([
                    'status' => true,
                    'message' => 'You have entered invalid credentials',
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

    public function OTPSendFor2FA($twoFAInfo){
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

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully'], 200);
    }

    public function forgotPassword(forgotPasswordRequest $request) {
        $email = $request->email;
        $token = Str::random(65);

        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => now()->addHours(1)
        ]);

        // Send Mail
        Mail::send('mail.reset_password', ['token' => $token], function ($msg) use ($email) {
            $msg->to($email);
            $msg->subject('Password reset mail');
        });

        return response()->json([
            'message' => 'Password reset mail send success. Please check your mail'
        ]);
    }

    public function resetPassword(resetPasswordRequest $request) {
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
