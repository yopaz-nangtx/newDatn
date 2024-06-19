<?php

namespace App\Http\Controllers;

use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    /** index page student list */
    public function student()
    {
        $studentList = User::where('role', 3)->orderBy('id', 'desc')->get();

        return view('student.student', compact('studentList'));
    }

    /** student add page */
    public function studentAdd()
    {
        return view('student.add-student');
    }

    /** student save record */
    public function studentSave(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users',
            'name' => 'required|string',
            'phone_number' => 'required|string|regex:/^0\d{9,10}$/',
            'gender' => 'required',
            'birthday' => 'required|before:today',
            'image' => 'required|mimes:jpg,jpeg,png',
            'address' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            $request['role'] = 3;
            $request['password'] = Hash::make('password');

            $user = new User;
            $user->name = $request['name'];
            $user->email = $request['email'];
            $user->gender = (int) $request['gender'];
            $user->address = $request['address'];
            $user->phone_number = $request['phone_number'];
            $user->birthday = Carbon::createFromFormat('Y-m-d', $request['birthday']);
            $user->role = $request['role'];
            $user->password = $request['password'];
            // $user->image_url = $request['image_url'];
            $user->save();
            $user->image_url = $user->uploadFile($request->file('image'), $user->id);
            $user->save();

            Toastr::success('Has been add successfully', 'Success');
            DB::commit();

            return redirect()->route('student/list');
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('fail, Add new student', 'Error');

            return redirect()->back();
        }
    }

    /** view for edit student */
    public function studentEdit($id)
    {
        $studentEdit = User::where('id', $id)->where('role', 3)->first();

        return view('student.edit-student', compact('studentEdit'));
    }

    /** update record */
    public function studentUpdate(Request $request)
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
            unset($request['_token'], $request['_method']);
            if ($request->file('image')) {
                $request['image_url'] = $this->upload($request);
            }
            unset($request['image']);

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

            Toastr::success('Has been update successfully', 'Success');
            DB::commit();

            return redirect()->route('student/list');

        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('fail, Update student', 'Error');

            return redirect()->back();
        }
    }

    /** student delete */
    public function studentDelete(Request $request)
    {
        DB::beginTransaction();
        try {

            if (! empty($request->id)) {
                User::destroy($request->id);
                DB::commit();
                Toastr::success('Student deleted successfully', 'Success');

                return redirect()->route('student/list');
            }

        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Student deleted fail', 'Error');

            return redirect()->route('student/list');
        }
    }
}
