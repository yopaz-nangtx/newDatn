<?php

namespace App\Http\Controllers;

use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TeacherController extends Controller
{
    /** add teacher page */
    public function teacherAdd()
    {
        $users = User::where('role', 2)->orderBy('id','desc')->get();

        return view('teacher.add-teacher', compact('users'));
    }

    /** teacher list */
    public function teacherList()
    {
        $listTeacher = User::where('role', 2)->get();

        return view('teacher.list-teachers', compact('listTeacher'));
    }

    /** teacher Grid */
    public function teacherGrid()
    {
        $teacherGrid = User::where('role', 2)->get();

        return view('teacher.teachers-grid', compact('teacherGrid'));
    }

    /** save record */
    public function saveRecord(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users',
            'name' => 'required|string',
            'phone_number' => 'required|string|regex:/^0\d{9,10}$/',
            'gender' => 'required',
            'birthday' => 'required|before:today',
            'image' => 'required|mimes:jpg,jpeg,png',
            'address' => 'required|string'
        ]);

        DB::beginTransaction();
        try {
            $request['role'] = 2;
            $request['password'] = Hash::make('password');
            $request['image_url'] = $this->upload($request);
            
            $user = new User;
            $user->name = $request['name'];
            $user->email = $request['email'];
            $user->gender = (int)$request['gender'];
            $user->address = $request['address'];
            $user->phone_number = $request['phone_number'];
            $user->birthday = Carbon::createFromFormat('Y-m-d', $request['birthday']);
            $user->role = $request['role'];
            $user->password = $request['password'];
            $user->image_url = $request['image_url'];
            $user->save();

            Toastr::success('Has been add successfully', 'Success');
            DB::commit();

            return redirect()->route('teacher/list');
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('fail, Add new teacher', 'Error');

            return redirect()->back();
        }
    }

    /** edit record */
    public function editRecord($user_id)
    {
        $teacher = User::where('id', $user_id)->where('role', 2)->first();

        return view('teacher.edit-teacher', compact('teacher'));
    }

    /** update record teacher */
    public function updateRecordTeacher(Request $request)
    {
        $user = User::find($request->id);

        $request->validate([
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->email, 'email')
            ],
            'name' => 'required|string',
            'phone_number' => 'required|string|regex:/^0\d{9,10}$/',
            'birthday' => 'required|before:today',
            'image' => 'nullable|file|mimes:jpg,jpeg,png',
            'gender' => 'required',
            'address' => 'required|string'
        ]);
        
        DB::beginTransaction();
        try {
            unset($request['_token'], $request['_method']);
            if ($request->file('image')) {
                $request['image_url'] = $this->upload($request);
            }
            unset($request['image']);

            $user = User::find($request->id);
            
            $user->name = $request['name'];
            $user->email = $request['email'];
            $user->gender = (int)$request['gender'];
            $user->address = $request['address'];
            $user->phone_number = $request['phone_number'];
            $user->birthday = Carbon::createFromFormat('Y-m-d', $request['birthday']);
            $user->image_url = $request['image_url'];
            $user->save();

            Toastr::success('Has been update successfully', 'Success');
            DB::commit();

            return redirect()->route('teacher/list/page');

        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('fail, Update teacher', 'Error');

            return redirect()->back();
        }
    }

    /** delete record */
    public function teacherDelete(Request $request)
    {
        DB::beginTransaction();
        try {
            if (! empty($request->id)) {
                User::destroy($request->id);
                DB::commit();
                Toastr::success('Teacher deleted successfully', 'Success');

                return redirect()->route('teacher/list/page');
            }

        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Teacher deleted fail', 'Error');

            return redirect()->route('teacher/list/page');
        }
    }

    public function upload($request)
    {
        $file = $request->file('image');

        try {
            return $this->uploadImage($file);
        } catch (Exception $e) {
            return false;
        }
    }

    public function uploadImage($file)
    {
        $fileName = $file->getClientOriginalName();
        $file->move(public_path('uploads'), $fileName);

        $imageUrl = url('public/uploads/'.$fileName);

        return $imageUrl;
    }

    public function prepairFolder()
    {
        $year = date('Y');
        $month = date('m');
        $storagePath = "$year/$month/";

        if (! file_exists($storagePath)) {
            mkdir($storagePath, 0755, true);
        }

        return $storagePath;
    }
}
