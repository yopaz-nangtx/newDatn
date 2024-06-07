<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function login()
    {
        return view('auth.login');
    }

    /** login with databases */
    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        DB::beginTransaction();
        try {

            $email = $request->email;
            $password = $request->password;

            if (Auth::attempt(['email' => $email, 'password' => $password])) {
                /** get session */
                $user = Auth::User();
                Session::put('id', $user->id);
                Session::put('name', $user->name);
                Session::put('email', $user->email);
                Session::put('gender', $user->gender);
                Session::put('phone_number', $user->phone_number);
                Session::put('address', $user->address);
                Session::put('role_name', $user->roleName());
                Session::put('role', $user->role);
                Session::put('birthday', $user->birthday);
                Session::put('image_url', $user->image_url);
                Toastr::success('Login successfully', 'Success');

                return redirect()->route('home');
            } else {
                Toastr::error('fail, WRONG USERNAME OR PASSWORD :)', 'Error');

                return redirect('login');
            }

        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('fail, LOGIN :)', 'Error');

            return redirect()->back();
        }
    }

    /** logout */
    public function logout(Request $request)
    {
        Auth::logout();
        // forget login session
        $request->session()->forget('name');
        $request->session()->forget('email');
        $request->session()->forget('phone_number');
        $request->session()->forget('address');
        $request->session()->forget('role_name');
        $request->session()->forget('image_url');
        $request->session()->forget('birthday');
        $request->session()->flush();

        Toastr::success('Logout successfully', 'Success');

        return redirect('login');
    }
}
