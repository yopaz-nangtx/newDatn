<?php

namespace App\Http\Controllers;

use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

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
    /** home dashboard */
    public function index()
    {
        return view('dashboard.home');
    }

    /** profile user */
    public function userProfile()
    {
        $user = User::find(Session::get('id'));

        return view('dashboard.profile', compact('user'));
    }

    /** profile user */
    public function userProfileEdit()
    {
        $user = User::find(Session::get('id'));

        return view('accounts.edit-profile', compact('user'));
    }

    /** profile user */
    public function userProfileUpdate(Request $request)
    {
        $user = User::find($request->id);

        $request->validate([
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->email, 'email'),
            ],
            'name' => 'required|string',
            'phone_number' => 'required|string|regex:/^0\d{9,10}$/',
            'birthday' => 'required|before:today',
            'image' => 'nullable|file|mimes:jpg,jpeg,png',
            'gender' => 'required',
            'address' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            $user = User::find($request->id);

            $user->name = $request['name'];
            $user->email = $request['email'];
            $user->gender = (int) $request['gender'];
            $user->address = $request['address'];
            $user->phone_number = $request['phone_number'];
            $user->birthday = Carbon::createFromFormat('Y-m-d', $request['birthday']);
            $user->save();

            $user->image_url = $user->uploadFile($request->file('image'), $user->id);
            $user->save();
            $user->setSession();

            Toastr::success('Has been update successfully', 'Success');

            DB::commit();

            return redirect()->route('user/profile/page');

        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('fail, Update Profile', 'Error');

            return redirect()->back();
        }
    }

    /** teacher dashboard */
    public function teacherDashboardIndex()
    {
        return view('dashboard.teacher_dashboard');
    }

    /** student dashboard */
    public function studentDashboardIndex()
    {
        return view('dashboard.student_dashboard');
    }
}
