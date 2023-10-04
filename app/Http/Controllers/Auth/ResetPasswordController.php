<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /*protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ];
    }*/

    protected function validationErrorMessages()
    {
        return [
            'password.confirmed' => trans('passwords.confirm_password_not_match')
        ];
    }

    public function showResetForm(Request $request)
    {
        $token = $request->route()->parameter('token');

        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    protected function resetPassword($user, $password)
    {
        $this->setUserPassword($user, $password);

        $user->setRememberToken(Str::random(60));

        $user->save();

        event(new PasswordReset($user));

        \Toastr::success(trans('passwords.password_reset_success'), 'Success');

    }

    protected function sendResetResponse(Request $request, $response)
    {
        if ($request->wantsJson()) {
            return new JsonResponse(['message' => trans($response)], 200);
        }

        return redirect(route('login'))
            ->with('status', trans('passwords.password_reset_success'));
    }

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    //protected $redirectTo = '/login';
}
