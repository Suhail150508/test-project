<?php

namespace App\Http\Controllers\Auth;

use App\Notifications\EmailVerificationNotification;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Brian2694\Toastr\Toastr;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Notification;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/register';
    protected $redirectToSafetyFirm = '/safety-firm';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->middleware('guest:jobportaluser');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        $user = $this->create($request->all());
        //$this->guard()->login($user);

        /*if ($response = $this->registered($request, $user)) {
            return $response;
        }*/
        return $request->wantsJson()
            ? new JsonResponse([], 201)
            : redirect($this->redirectPath())->with('success', trans('settings.registration_email_verify_message'));

    }

    protected function validator(array $data): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($data, [
            'bn_name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'string', 'max:255', 'unique:users'],
            'nid' => ['nullable', 'string', 'unique:users'],
            'signature' => ['nullable', 'image' ,'mimes:jpg,jpeg,png','max:1024'],
            'address' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data): User
    {
        if (request()->has('signature')) {
            \Storage::disk('local')->put('/public/images/signature/'.$data['signature']->getClientOriginalName(),$data['signature']->get());

            $path = 'storage/images/signature/'.$data['signature']->getClientOriginalName();
        }
        $user =  User::create([
            'bn_name' => $data['bn_name'],
            'mobile' => $data['mobile'],
            'nid' => $data['nid'],
            'signature' => @$path,
            'address' => $data['address'],
            'email' => $data['email'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'user_type' => 'user',
            'status' => 'Inactive',
        ]);

        if($user){
            Notification::send($user, new EmailVerificationNotification($user,$data['password']));
            \Toastr::success(trans('settings.registration_email_verify_message'), 'Success');
            return $user;
        }
    }

    public function registrationVerify($encoded_email,$verification_code) {
        $email = base64_decode($encoded_email);
        $user = User::where('email',$email)->where('verification_code',$verification_code)->first();
        if(@$user){
            $user->update([
                'status' => 'Active',
                'verification_code' => '',
            ]);
            \Toastr::success(trans('settings.registration_email_verify_success_message'), 'Success');
            return redirect(route('login'))->with('success',trans('settings.registration_email_verify_success_message'));
        }else{
            \Toastr::error(trans('settings.registration_email_verify_failed_message'), 'Failed');
            return redirect(route('login'))->with('error',trans('settings.registration_email_verify_failed_message'));
        }
    }


}
