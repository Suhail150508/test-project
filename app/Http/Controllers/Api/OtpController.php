<?php

namespace App\Http\Controllers\Api;

use App\Models\Otp;
use App\Models\Alumni;
use App\Models\Resume;
use Illuminate\Http\Request;
use App\SslWireless\SslWireless;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Notification;
use App\Notifications\RegisterOtpNotification;

class OtpController extends Controller
{
    public function checkAlumniByStudentId($studentId)
    {
        $alumni = Alumni::where('ewu_id_no', $studentId)->first();
        if ($alumni != null) {
            return response()->json([
                'status' => true,
                'message' => 'You are registered'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'You are not register'
            ]);
        }
    }

    public function checkAlumniOrStudentByStudentIdFromJobPortal($studentId)
    {
        $student = Resume::where('ewu_id_no', $studentId)->first();
        if ($student != null) {
            return response()->json([
                'status' => true,
                'message' => 'You are registered'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'You are not register'
            ]);
        }
    }

    public function sendOtpByMobile($mobile)
    {
        $generateOtp = mt_rand(100000, 999999);

        $otp = Otp::where('type', 'registration')->where('mobile', $mobile)->first();
        if ($otp) {
            // Record exists, delete it
            $otp->delete();

            Otp::create([
                'type' => 'registration',
                'mobile' => $mobile,
                'otp' => $generateOtp,
                'expire_at' => now()->addMinutes(2),
                'expiry_time' => 2,
            ]);
        } else {
            Otp::create([
                'type' => 'registration',
                'mobile' => $mobile,
                'otp' => $generateOtp,
                'expire_at' => now()->addMinutes(2),
                'expiry_time' => 2,
            ]);
        }

        try {
            $sslWireless = new SslWireless();
            // $to = '01723559950';
            $to = $mobile;
            $message = "Your OTP is: " .$generateOtp. " This OTP will be expired in 2 minutes. Please don't share your OTP in any one";
            $sslWireless->sendSms($to, $message);

            // $msisdn = $mobile;
            // $messageBody = "Your OTP is: " .$generateOtp. " This OTP will be expired in 2 minutes. Please don't share your OTP in any one";;
            // $csmsId = "2934fe343";
            // $sslWireless->singleSms($msisdn, $messageBody, $csmsId);

            return response()->json([
                'status' => 'success',
                'message' => 'OTP sent successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Failed to send OTP'
            ]);
        }
    }

    public function sendOtpByEmail($email)
    {
        $generateOtp = mt_rand(100000, 999999);

        $otp = Otp::where('type', 'registration')->where('email', $email)->first();
        if ($otp) {
            // Record exists, delete it
            $otp->delete();

            Otp::create([
                'type' => 'registration',
                'email' => $email,
                'otp' => $generateOtp,
                'expire_at' => now()->addMinutes(2),
                'expiry_time' => 2,
            ]);
        } else {
            Otp::create([
                'type' => 'registration',
                'email' => $email,
                'otp' => $generateOtp,
                'expire_at' => now()->addMinutes(2),
                'expiry_time' => 2,
            ]);
        }

        try {
            Notification::route('mail', $email)->notify(new RegisterOtpNotification($generateOtp));

            return response()->json([
                'status' => 'success',
                'message' => 'OTP sent successfully'
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'status' => 'failed',
                'message' => 'Failed to send OTP'
            ]);
        }
    }

    public function verifyOtp($otp)
    {
        $otp = Otp::where('otp', $otp)->first();

        if ($otp != null) {
            if ($otp && now()->isBefore($otp->expire_at)) {
                $otp->delete();

                return response()->json([
                    'status' => 'success',
                    'message' => 'OTP verified successfully'
                ]);
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Your OTP has expired'
                ]);
            }
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Invalid OTP'
            ]);
        }
    }

    // temporary code start
    public function getStudentAlumniInfoByStudentId($student_id)
    {
        $alumni = Alumni::with('alumni')->where('ewu_id_no', $student_id)->first();
        if ($alumni != null) {
            return response()->json([
                'status' => true,
                'message' => "Student id match our records",
                'data' => $alumni
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Student id don't match our records"
            ]);
        }
    }
    // temporary code end
}
