<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\SafetyFirm\SafetyFirm;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function profile()
    {
        $data['user'] = Auth::user();
        if (Auth::check()) {
            return view('user.profile.show',$data);
        }
        return abort(404);
    }
    public function editProfile($id)
    {
        $user = User::find($id);
        $data = [
            'user' => $user
        ];
        if (count(request()->all()) > 0) {
            \DB::beginTransaction();
            request()->validate([
                'bn_name' => 'required',
                'mobile' => 'required|unique:users,mobile,'.@$user->id,
                'email' => 'required|unique:users,email,'.@$user->id,
                'username' => 'required|unique:users,username,'.@$user->id,
                'address' => 'required',
            ]);
            $user->update(request()->all());
            \Toastr::success('User Profile Updated', 'Success');
            \DB::commit();
            return redirect(route('user-profile'));
            try {
            } catch (\Exception $e) {
                \DB::rollBack();
                return back()->withInput()->with('error', $e->getMessage());
            }
        }else{
            return view('user.profile.edit',$data);
        }
    }
    /*public function root()
    {
        return view('index');
    }

    /*Language Translation*/
    /*public function lang($locale)
    {
        if ($locale) {
            App::setLocale($locale);
            Session::put('lang', $locale);
            Session::save();
            return redirect()->back()->with('locale', $locale);
        } else {
            return redirect()->back();
        }
    }*/

    public function updateProfile(Request $request, $id)
    {
        // return $request->all();
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'dob' => ['required', 'date', 'before:today'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],
        ]);

        $user = User::find($id);
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->dob = date('Y-m-d', strtotime($request->get('dob')));

        if ($request->file('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
            $avatarPath = public_path('/images/');
            $avatar->move($avatarPath, $avatarName);
            if (file_exists(public_path($user->avatar))) {
                unlink(public_path($user->avatar));
            }
            $user->avatar = '/images/' . $avatarName;
        }
        $user->update();
        if ($user) {
            Session::flash('message', 'User Details Updated successfully!');
            Session::flash('alert-class', 'alert-success');
            return response()->json([
                'isSuccess' => true,
                'Message' => "User Details Updated successfully!"
            ], 200); // Status code here
        } else {
            Session::flash('message', 'Something went wrong!');
            Session::flash('alert-class', 'alert-danger');
            return response()->json([
                'isSuccess' => true,
                'Message' => "Something went wrong!"
            ], 200); // Status code here
        }
    }

    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        if (!(Hash::check($request->get('current_password'), Auth::user()->password))) {
            return response()->json([
                'isSuccess' => false,
                'Message' => "Your Current password does not matches with the password you provided. Please try again."
            ], 200); // Status code
        } else {
            $user = User::find($id);
            $user->password = Hash::make($request->get('password'));
            $user->update();
            if ($user) {
                Session::flash('message', 'Password updated successfully!');
                Session::flash('alert-class', 'alert-success');
                return response()->json([
                    'isSuccess' => true,
                    'Message' => "Password updated successfully!"
                ], 200); // Status code here
            } else {
                Session::flash('message', 'Something went wrong!');
                Session::flash('alert-class', 'alert-danger');
                return response()->json([
                    'isSuccess' => true,
                    'Message' => "Something went wrong!"
                ], 200); // Status code here
            }
        }
    }
}
