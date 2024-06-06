<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Classroom;
use App\Models\ClassroomStudent;
use App\Models\Homework;
use App\Models\HomeworkResult;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Lesson;
use App\Models\LessonHomework;

class LessonController extends Controller
{
    public function lesson(Request $request, $id)
    {
        $class = Classroom::findOrFail($id);

        $lessons = $class->lessons;
        foreach ($lessons as $lesson) {
            $lesson['attendance'] = count($lesson->attendances()->where('status', 0)->get());
            $lesson['is_finished'] = Carbon::now()->greaterThan($lesson->end_time) ? 1 : 0;
        }

        return view('lesson.lesson', compact('class', 'lessons'));
    }

    public function lessonAdd($id)
    {
        $class = Classroom::findOrFail($id);
        $homeworks = Homework::all();

        return view('lesson.add-lesson', compact('class', 'homeworks'));
    }

    /** homework save record */
    public function lessonSave(Request $request)
    {
        $request->validate([
            'lesson_name' => 'required|string',
            'start_date' => 'required|after:today',
            'start_time' => 'required',
        ]);

        $dateTimeString = $request->start_date.' '.$request->start_time;
        $startTime = Carbon::createFromFormat('Y-m-d H:i', $dateTimeString);
        $endTime = Carbon::createFromFormat('Y-m-d H:i', $dateTimeString)->addHours(2);

        DB::beginTransaction();
        try {
            $lesson = new Lesson;
            $lesson->lesson_name = $request['lesson_name'];
            $lesson->classroom_id = $request->class_id;
            $lesson->start_time = $startTime;
            $lesson->end_time = $endTime;
            $lesson->save();

            foreach ($request->homeworks as $homeworkId) {
                LessonHomework::create([
                    'homework_id' => $homeworkId,
                    'lesson_id' => $lesson->id,
                ]);
            }

            Toastr::success('Has been add successfully', 'Success');
            DB::commit();

            return redirect()->route('lesson/list', $request->class_id);
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('fail, Add new lesson', 'Error');

            return redirect()->back();
        }
    }

    public function lessonEdit(Request $request, $id, $class_id) {
        $class = Classroom::findOrFail($class_id);
        $lesson = Lesson::where('id', $id)->first();
        $dateTime = Carbon::parse($lesson->start_time);
        $startDate = $dateTime->format('Y-m-d');
        $startTime = $dateTime->format('H:i');
        $homeworks = Homework::all();
        $homeworkIds = $lesson->homeworks->pluck('id');

        return view('lesson.edit-lesson', compact('class', 'lesson', 'homeworks', 'homeworkIds', 'startDate', 'startTime'));
    }

    /** homework save record */
    public function lessonUpdate(Request $request)
    {
        $request->validate([
            'lesson_name' => 'required|string',
            'start_date' => 'required|after:today',
            'start_time' => 'required',
        ]);

        $dateTimeString = $request->start_date.' '.$request->start_time;
        $startTime = Carbon::createFromFormat('Y-m-d H:i', $dateTimeString);
        $endTime = Carbon::createFromFormat('Y-m-d H:i', $dateTimeString)->addHours(2);

        DB::beginTransaction();
        try {
            $lesson = Lesson::find($request->lesson_id);
            $lesson->lesson_name = $request['lesson_name'];
            $lesson->classroom_id = $request->class_id;
            $lesson->start_time = $startTime;
            $lesson->end_time = $endTime;
            $lesson->save();

            foreach ($lesson->lessonHomeworks as $lessonHomework) {
                $lessonHomework->delete();
            }

            foreach ($request->homeworks as $homeworkId) {
                LessonHomework::create([
                    'homework_id' => $homeworkId,
                    'lesson_id' => $lesson->id,
                ]);
            }

            Toastr::success('Has been add successfully', 'Success');
            DB::commit();

            return redirect()->route('lesson/list', $request->class_id);
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('fail, Edit lesson', 'Error');

            return redirect()->back();
        }
    }

    public function lessonDelete(Request $request)
    {
        DB::beginTransaction();
        try {

            if (! empty($request->id)) {
                Lesson::destroy($request->id);
                DB::commit();
                Toastr::success('Lesson deleted successfully', 'Success');

                return redirect()->route('lesson/list', $request->class_id);
            }

        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Lesson deleted fail', 'Error');

            return redirect()->route('lesson/list', $request->class_id);
        }
    }

    public function lessonAttendance(Request $request, $lesson_id)
    {
        $lesson = Lesson::findOrFail($lesson_id);
        $classroom = $lesson->classroom;
        $students = $classroom->students;
        $studentRender = [];

        foreach ($students as $student) {
            $attendance = Attendance::where('lesson_id', $lesson->id)->where('student_id', $student->id)->first();
            if($attendance ) {
                $student['attendance'] = $attendance;
                $studentRender[] = $student;
            }
        }

        return view('lesson.attendance', compact('lesson', 'studentRender'));
    }

    public function lessonHomework(Request $request, $lesson_id)
    {
        $lesson = Lesson::findOrFail($lesson_id);
        $classroom = $lesson->classroom;
        $students = $classroom->students;
        $homeworkIds = LessonHomework::where('lesson_id', $lesson->id)->pluck('homework_id')->toArray();
        $studentRenders = [];

        foreach ($students as $student) {
            $homeworkResults = HomeworkResult::where('student_id', $student->id)->whereIn('homework_id', $homeworkIds)->get();
            if($homeworkResults) {
                foreach($homeworkResults as $homeworkResult) {
                    $student['homeworkResult'] = $homeworkResult;
                    $studentRenders[] = $student;
                }
            }
        }

        return view('lesson.homework', compact('lesson', 'studentRenders'));
    }

    public function detailApi(Request $request, $lesson_id)
    {
        $lesson = Lesson::where('id', $request->lesson_id)->with(['classroom', 'room'])->first();

        return $lesson;
    }
}
