<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TwoFactorAuthentication;

class TwoFactorAuthenticationController extends Controller
{
    public function twoFactorAuthenticationGet(Request $request)
    {
        $data = TwoFactorAuthentication::where('user_id', $request->user_id)->first();

        return response()->json($data);
    }

    public function twoFactorAuthenticationUpdate(Request $request) {
        $data = $request->all();
        TwoFactorAuthentication::updateOrCreate(['user_id' => $data['user_id']], $data);

        return response()->json([
            'msg' => 'Data save successfully'
        ]);
    }
}
