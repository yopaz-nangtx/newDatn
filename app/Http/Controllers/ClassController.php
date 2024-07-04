<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Classroom;
use App\Models\ClassroomStudent;
use App\Models\Lesson;
use App\Models\Room;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
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
        $teachers = User::where('role', 2)->orderBy('id', 'desc')->get();

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

            if (isset($request->students)) {
                foreach ($request->students as $studentId) {
                    ClassroomStudent::create([
                        'classroom_id' => $classroom->id,
                        'student_id' => $studentId,
                    ]);
                }
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

    public function classEdit(Request $request, $id)
    {
        $class = Classroom::findOrFail($id);
        $students = User::where('role', 3)->orderBy('id', 'desc')->get();
        $rooms = Room::all();
        $teachers = User::where('role', 2)->orderBy('id', 'desc')->get();
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
            if (isset($request->students)) {
                foreach ($request->students as $studentId) {
                    ClassroomStudent::create([
                        'classroom_id' => $classroom->id,
                        'student_id' => $studentId,
                    ]);
                }
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

    //API
    public function getListApi(Request $request)
    {
        $classroomIds = User::find($request->user()->id)->classrooms->pluck('id')->toArray();
        $classrooms = Classroom::whereIn('id', $classroomIds)->with(['room', 'lessons' => ['documents'], 'teacher'])->get();

        $numberOfLessonsStudied = 0;
        foreach ($classrooms as $classroom) {
            $classroom['countLessons'] = count($classroom->lessons);
            foreach ($classroom->lessons as $lesson) {
                $numberOfLessonsStudied += $lesson->isFinished();
                $attendenceStatus = Attendance::where('lesson_id', $lesson->id)->where('student_id', $request->user()->id)->first()?->status;
                $lesson['attendenceStatus'] = $attendenceStatus;
            }
            $classroom['numberOfLessonsStudied'] = $numberOfLessonsStudied;
            $numberOfLessonsStudied = 0;
            unset($classroom['created_at'],$classroom['updated_at']);
        }

        return $classrooms;
    }

    public function detailApi(Request $request, $class_id)
    {
        $classrooms = Classroom::where('id', $class_id)->with(['room', 'lessons' => ['documents'], 'teacher'])->get();

        $numberOfLessonsStudied = 0;
        foreach ($classrooms as $classroom) {
            $classroom['countLessons'] = count($classroom->lessons);
            foreach ($classroom->lessons as $lesson) {
                $lesson->startt_time = Carbon::parse($lesson->start_time)->format('d/m/Y H:i:s');

                $numberOfLessonsStudied += $lesson->isFinished();
                $attendenceStatus = Attendance::where('lesson_id', $lesson->id)->where('student_id', $request->user()->id)->first()?->status;
                $lesson['attendenceStatus'] = $attendenceStatus;
            }
            $classroom['numberOfLessonsStudied'] = $numberOfLessonsStudied;
        }

        return $classrooms;
    }

    public function getLessonTodayApi(Request $request)
    {
        $classroomIds = User::find($request->user()->id)->classrooms->pluck('id')->toArray();
        $classrooms = Classroom::whereIn('id', $classroomIds)->with(['room',
            'lessons' => function (Builder $query) {
                $query->whereDate('start_time', Carbon::today());
            },
            'teacher'])->get();

        $numberOfLessonsStudied = 0;
        foreach ($classrooms as $key => $classroom) {
            foreach ($classroom->lessons as $lesson) {
                $numberOfLessonsStudied += $lesson['is_finished'];
            }
            $classroom['numberOfLessonsStudied'] = $numberOfLessonsStudied;
        }

        return $classrooms;
    }

    public function getLessonScheduleTaskApi(Request $request)
    {
        $time = strtotime($request->datetime);
        $today = date('Y-m-d', $time);

        $user = User::where('id', $request->user()->id)->with([
            'classrooms' => [
                'room',
                'lessons' => function (Builder $query) use ($today) {
                    $query->whereDate('start_time', $today);
                },
                'teacher',
            ],
        ])->get();

        $classrooms = $user[0]['classrooms'];

        return $classrooms;
    }

    public function getTaskApi(Request $request)
    {
        //TODO : sửa lại db
        $user = User::where('id', $request->user()->id)->first();
        $classrooms = $user->classrooms;
        foreach ($classrooms as $classroom) {
            $homeworkClassroom = [];
            $classroom['teacher'] = $classroom->teacher;
            $classroom['room'] = $classroom->room;

            foreach ($classroom->lessons as $lesson) {
                foreach ($lesson->homeworks as $homework) {
                    $homeworkClassroom[] = $homework;
                }
            }
            $classroom['homeworks'] = $homeworkClassroom;
        }

        return $classrooms;

    }
}
