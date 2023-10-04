<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Alumni;
use App\Models\Resume;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;

class AdminauthController extends Controller
{
    public function createAdmin(Request $request)
    {
        try {
            $validateAdmin = Validator::make($request->all(),
                [
                    'name' => 'required',
                    'username' => 'required',
                    'email' => 'required|email|unique:admins,email',
                    'password' => 'required',
                ]);

            if ($validateAdmin->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateAdmin->errors()
                ],401);
            }

            $admin = Admin::create([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->username,
                'password' => Hash::make($request->password),
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Admin created successfully',
                'token' => $admin->createToken("API TOKEN")->plainTextToken
            ],200);

        } catch (\Throwable $th){
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $th->getMessage()
            ],500);
        }
    }

    protected function loginAdmin(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            if (Auth::attempt($credentials)) {
                $user = $request->user();
                if($request->user()->is_admin == 'Yes' && $request->user()->employment_status == 'Admin') {
                    return response()->json([
                        'token' => $user->createToken("API TOKEN")->plainTextToken,
                        'auth_id' => $user->id,
                        'token_type' => 'Bearer',
                        'message' => 'Admin Logged in successfully',
                    ]);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record',
                ], 401);
            }
           

            /*$validateAdmin = Validator::make($request->all(),
                [
                    'email' => 'required|email',
                    'password' => 'required',
                ]);

            if ($validateAdmin->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateAdmin->errors()
                ],401);
            }
            if (!Auth::attempt($request->only(['email','password'])))
            {
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record',
                    'errors' => $validateAdmin->errors()
                ],401);
            }

            $admin = User::query()->where('email',$request->email)->first();

            return response()->json([
                'status' => true,
                'message' => 'Admin Logged in successfully',
                'token' => $admin->createToken("API TOKEN")->plainTextToken
            ],200);*/

        } catch (\Throwable $th){
            return response()->json([
                'status' => false,
                'message' =>$th->getMessage()
            ],500);
        }
    }

    public function getUser($id)
    {
        $user = User::query()->find($id);

        return response()->json($user);
    }

    public function userInfo(Request $request){
        $token = PersonalAccessToken::query()->where('token', hash('sha256', $request->token))->first();
        $user = $token->tokenable;
        if ($user){
            $alumni = Alumni::query()->where('user_id',$user->id)->first();
            $user['alumni'] = $alumni;
            $resume = Resume::query()->where('user_id',$user->id)->first();
            $user['resume'] = $resume;
            if ($user) {
                return response()->json(['data' => $user,'message' => 'Authenticated']);
            } else {
                return response()->json(['data' => $user,'message' => 'Not authenticated']);
            }
        }
        
        /*return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]);*/
    }

    public function logout(Request $request)
    {
        $user = User::query()->findOrFail($request->auth_id);
        Sanctum::revokeTokens($user);
        return response()->json(['message' => 'Logged out successfully']);
    }

}
