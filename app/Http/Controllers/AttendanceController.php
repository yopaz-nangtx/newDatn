<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAttendanceRequest;
use App\Models\Attendance;
use App\Models\Classroom;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Carbon\Carbon;


class AttendanceController extends Controller
{
    // API
    public function listClassLessons(Request $request)
    {
        $classroomIds = User::find($request->user()->id)->classrooms->pluck('id')->toArray();
        $classrooms = Classroom::whereIn('id', $classroomIds)->with([
            'lessons' => function (Builder $query) {
                $query->whereNot('is_finished', 1);
            },
            'teacher'])->get();

        return $classrooms;
    }

    public function listApi(Request $request)
    {
        $attendances = Attendance::where('student_id', $request->user()->id)->orderBy('id', 'desc')->get();
        foreach ($attendances as $attendance) {
            $attendance['lesson_name'] = $attendance->lesson->lesson_name;
            $attendance['class_name'] = $attendance->lesson->classroom;
            $attendance->lesson->startt_time = Carbon::parse($attendance->lesson->start_time)->format('d/m/Y H:i:s');
            $attendance['created_att']= Carbon::parse($attendance->created_at)->format('d/m/Y H:i:s');
        }

        return $attendances;
    }

    public function storeApi(StoreAttendanceRequest $request)
    {
        $request['status'] = 1;

        $attendances = Attendance::create($request->all());

        return $attendances;
    }
}
