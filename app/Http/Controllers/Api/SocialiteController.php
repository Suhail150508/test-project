<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->stateless()->redirect();
    }

    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->stateless()->user();
        if ($provider == 'facebook') {
            $data = [
                "provider" => 'facebook',
                "id" => $user->attributes['id'],
                "nickname" => $user->attributes['nickname'],
                "name" => $user->attributes['name'],
                "email" => $user->attributes['email'],
                "avatar" => $user->attributes['avatar'],
                "access_token" => $user->token
            ];
        } elseif ($provider == 'linkedin') {
            $data = [
                "provider" => 'linkedin',
                "id" => $user->attributes['id'],
                "nickname" => $user->attributes['nickname'],
                "name" => $user->attributes['name'],
                "first_name" => $user->attributes['first_name'],
                "last_name" => $user->attributes['last_name'],
                "email" => $user->attributes['email'],
                "avatar" => $user->attributes['avatar'],
                "access_token" => $user->token
            ];
        }

        $redirectUrl = 'http://127.0.0.1:5173/profile?data=' . urlencode(json_encode($data));
        // $redirectUrl = 'http://alumni.fscd.xyz/profile?data=' . urlencode(json_encode($user));

        return redirect($redirectUrl);
    }

    // public function getUserInfo($provider) {
    //     if ($provider == 'facebook') {
    //         $user = Socialite::driver($provider)->userFromToken(env('FACEBOOK_ACCESS_TOKEN'));
    //     } elseif($provider == 'linkedin') {
    //         $user = Socialite::driver($provider)->userFromToken(env('LINKEDIN_ACCESS_TOKEN'));
    //     }

    //     return response()->json(['user' => $user]);
    // }
}
