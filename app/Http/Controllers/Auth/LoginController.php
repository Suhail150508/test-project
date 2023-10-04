<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Brian2694\Toastr\Toastr;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    /*protected $redirectTo = RouteServiceProvider::HOME;*/

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:admin')->except('logout'); //admin guard logout
        $this->middleware('guest:jobportaluser')->except('logout'); //admin guard logout

        $this->username = $this->findUsername();
    }

    protected function validateLogin(Request $request)
    {

        $user = User::where($this->username(),$request->login)->first();

        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);

        if(@$user && $user->email_verified_at == null){
            $request->validate([
                $this->username() => 'exists:users,'.$this->username().',email_verified_at,NOT NULL',
            ],
                [
                    $this->username().'.exists' => trans('login.not_verified')
                ]
            );
        }elseif(@$user && $user->status == "Inactive"){
            $request->validate([
                $this->username() => 'exists:users,'.$this->username().',status,Active',
            ],
                [
                    $this->username().'.exists' => trans('login.not_activated')
                ]
            );
        }

    }

    public function findUsername()
    {
        $login = request()->input('login');

        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        request()->merge([$fieldType => $login]);

        return $fieldType;
    }

    public function username()
    {
        return $this->username;
    }

    protected function authenticated(Request $request, $user)
    {
        \Toastr::success(trans('auth.success',['user' => $user->bn_name]));
        return redirect()->route('dashboard');


    }
}
