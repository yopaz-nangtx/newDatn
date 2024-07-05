<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
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
        // All time
        $countRevenue = 0;
        $countStudent = count(User::where('role', 3)->get());
        $countTeacher = count(User::where('role', 2)->get());
        $classes = Classroom::all();
        $countClass = count($classes);
        foreach ($classes as $class) {
            $countRevenue += $class->revenue();
        }

        return view('dashboard.home', compact('countStudent', 'countTeacher', 'countClass', 'countRevenue'));
    }

    /** profile user */
    public function userProfile()
    {
        $user = User::find(Session::get('id'));

        return view('dashboard.profile', compact('user'));
    }

    /** view profile user */
    public function userProfileEdit()
    {
        $user = User::find(Session::get('id'));

        return view('accounts.edit-profile', compact('user'));
    }

    /** update profile user */
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
    public function teacherDashboardIndex($id)
    {
        $user = User::find($id);
        $today = Carbon::today();

        $countStudent = 0;
        $countLesson = 0;
        $teacher = User::find($id);
        $classes = $teacher->classes;
        $countClass = count($classes);
        foreach ($classes as $class) {
            $countStudent += count($class->students);
            $countLesson += count($class->lessons);
        }
        $countHour = $countLesson * 2;

        $classrooms = Classroom::where('teacher_id', $id)
            ->with(['lessons' => function ($query) use ($today) {
                $query->whereDate('start_time', '=', $today);
            }])
            ->get();

        return view('dashboard.teacher_dashboard', compact('countClass', 'countStudent', 'countLesson', 'countHour', 'user', 'classrooms', 'today'));
    }

    public function studentDashboardIndex($id)
    {
        $user = User::find($id);
        $today = Carbon::today();

        $classrooms = [];
        $countClassFinished = 0;
        $countLessonFinished = 0;
        $countClass = 0;
        $countLesson = 0;
        $classes = $user->classrooms;
        $countClass = count($classes);
        $classroomIds = $classes->pluck('id');
        $countClass = count($classes);
        foreach ($classes as $class) {
            $countLesson += count($class->lessons);
        }
        $countHour = $countLesson * 2;

        $classrooms = Classroom::whereIn('id', $classroomIds)->
            with(['lessons' => function ($query) use ($today) {
                $query->whereDate('start_time', '=', $today);
            }])
                ->get();

        foreach ($classes as $classroom) {
            if ($classroom->isFinished() && count($classroom->lessons) != 0) {
                $countClassFinished += 1;
            }
            $countLessonFinished += $classroom->countFinished();
        }

        $countHourFinished = $countLessonFinished * 2;

        return view('dashboard.student_dashboard', compact('classes','countClassFinished', 'countLessonFinished', 'countHourFinished', 'countClass', 'countLesson', 'countHour', 'user', 'classrooms', 'today'));
    }
}
