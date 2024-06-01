<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\ClassroomStudent;
use App\Models\Lesson;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ClassController extends Controller
{
    public function class(Request $request)
    {
        if ($request->user()->role == 1) {
            $classes = Classroom::orderBy('id', 'desc')->get();
        } else {
            $classes = Classroom::where('teacher_id', $request->user()->id)->get();
        }
        foreach ($classes as $class) {
            $class['count_finished'] = count(Lesson::where('classroom_id', $class->id)
                ->where('end_time', '<', now())
                ->get());
        }

        return view('class.class', compact('classes'));
    }

    public function classAdd()
    {
        $students = User::where('role', 3)->orderBy('id', 'desc')->get();
        $rooms = Room::all();
        $teachers = User::where('role',2)->orderBy('id','desc')->get();

        return view('class.add-class', compact('students', 'rooms', 'teachers'));
    }

    /** homework save record */
    public function classSave(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'teacher_id' => 'required',
            'room_id' => 'required',
            'students' => 'required',
            'fee' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $classroom = new Classroom;
            $classroom->name = $request['name'];
            $classroom->teacher_id = $request['teacher_id'];
            $classroom->room_id = $request['room_id'];
            $classroom->fee = $request['fee'];
            $classroom->save();

            foreach ($request->students as $studentId) {
                ClassroomStudent::create([
                    'classroom_id' => $classroom->id,
                    'student_id' => $studentId,
                ]);
            }

            Toastr::success('Has been add successfully', 'Success');
            DB::commit();

            return redirect()->route('class/list');
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('fail, Add new class', 'Error');

            return redirect()->back();
        }
    }

    public function classEdit(Request $request, $id) {
        $class = Classroom::findOrFail($id);
        $students = User::where('role', 3)->orderBy('id', 'desc')->get();
        $rooms = Room::all();
        $teachers = User::where('role',2)->orderBy('id','desc')->get();
        $studentIds = $class->students->pluck('id');

        return view('class.edit-class', compact('class', 'students', 'rooms', 'teachers', 'studentIds'));
    }

    /** homework save record */
    public function classUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'teacher_id' => 'required',
            'room_id' => 'required',
            'students' => 'required',
            'fee' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $classroom = Classroom::find($request->id);
            $classroom->name = $request['name'];
            $classroom->teacher_id = $request['teacher_id'];
            $classroom->room_id = $request['room_id'];
            $classroom->fee = $request['fee'];
            $classroom->save();

            foreach ($classroom->classroomStudents as $classroomStudent) {
                $classroomStudent->delete();
            }
            foreach ($request->students as $studentId) {
                ClassroomStudent::create([
                    'classroom_id' => $classroom->id,
                    'student_id' => $studentId,
                ]);
            }

            Toastr::success('Has been add successfully', 'Success');
            DB::commit();

            return redirect()->route('class/list');
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('fail, Edit class', 'Error');

            return redirect()->back();
        }
    }
}
