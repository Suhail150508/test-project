<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\EmailVerificationNotification;
use App\Notifications\UserNotification;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Notifications\Notifiable;
use Notification;

class EmailVerifyController extends Controller
{

    public function emailVerify(Request $request) {
        if(count($request->all()) > 0 ){
            $user = User::where('email',$request->email)->first();
            $request->validate([
                'email' => 'required|email|exists:users,email',
            ],
            [
                'email.exists' => trans('login.email_not_match')
            ]
            );

            if((@$user && $user->verification_code == null) && ($user->status == "Inactive" || $user->status == "Active" )){
                $request->validate([
                    'already_verified' => 'required',
                ],
                [
                    'already_verified.required' => trans('login.already_verified')
                ]
                );
            }else{
                $encoded_email = base64_encode($request->email);
                $verification_code = $encoded_email.base64_encode(rand(10000000,99999999));
                $user->update([
                    'verification_code' => $verification_code,
                ]);
                $verification_link = route('email_verification_check',['email' => $encoded_email,'verification_code' => $user->verification_code]);
                Notification::send($user, new EmailVerificationNotification($verification_link));

                \Toastr::success(trans('login.email_verify_message'), 'Success');
                return redirect()->back()->with('success', trans('login.email_verify_message'));;
            }

        }else{
            return view('auth.email_verify');
        }

    }

    public function emailVerificationCheck($encoded_email,$verification_code) {
        $email = base64_decode($encoded_email);
        $user = User::where('email',$email)->where('verification_code',$verification_code)->first();
        if(@$user){
            $user->update([
                'status' => 'Active',
                'verification_code' => '',
            ]);
            \Toastr::success(trans('login.email_verify_success_message'), 'Success');
            return redirect(route('login'))->with('success',trans('login.email_verify_success_message'));
        }else{
            \Toastr::error(trans('login.email_verify_failed_message'), 'Failed');
            return redirect(route('login'))->with('error',trans('login.email_verify_failed_message'));
        }
    }
}
