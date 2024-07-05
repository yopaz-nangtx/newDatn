<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function admin()
    {
        $revenueMonthly = [];
        $growthStudentMonthly = [];
        $growthTeacherMonthly = [];

        $revenueYearly = [];
        $growthStudentYearly = [];
        $growthTeacherYearly = [];

        // CHART MONTHLY
        $currentMonth = Carbon::now()->month;
        for ($i = 0; $i < $currentMonth; $i++) {
            $revenue = 0;

            $startOfMonth = now()->subMonth($i)->startOfMonth();
            $endOfMonth = now()->subMonth($i)->endOfMonth();

            $classes = Classroom::whereDate('created_at', '>=', $startOfMonth)->whereDate('created_at', '<=', $endOfMonth)->get();
            foreach ($classes as $class) {
                $revenue += $class->revenue();
            }
            $revenue = $revenue / 1000000;

            $teachers = User::where('role', 2)->whereDate('created_at', '>=', $startOfMonth)->whereDate('created_at', '<=', $endOfMonth)->get();

            $students = User::where('role', 3)->whereDate('created_at', '>=', $startOfMonth)->whereDate('created_at', '<=', $endOfMonth)->get();

            $revenueMonthly[] = $revenue;
            $growthStudentMonthly[] = count($students);
            $growthTeacherMonthly[] = count($teachers);
        }

        // CHART YEARLY
        $currentYear = Carbon::now()->year;
        for ($i = 0; $i < 6; $i++) {
            $revenue = 0;

            $startOfYear = now()->subYear($i)->startOfYear();
            $endOfYear = now()->subYear($i)->endOfYear();

            $classes = Classroom::whereDate('created_at', '>=', $startOfYear)->whereDate('created_at', '<=', $endOfYear)->get();
            foreach ($classes as $class) {
                $revenue += $class->revenue();
            }
            $revenue = $revenue / 1000000;

            $teachers = User::where('role', 2)->whereDate('created_at', '>=', $startOfYear)->whereDate('created_at', '<=', $endOfYear)->get();

            $students = User::where('role', 3)->whereDate('created_at', '>=', $startOfYear)->whereDate('created_at', '<=', $endOfYear)->get();

            $revenueYearly[] = $revenue;
            $growthTeacherYearly[] = count($teachers);
            $growthStudentYearly[] = count($students);
        }

        $data = [
            'revenueMonthly' => $revenueMonthly,
            'growthStudentMonthly' => $growthStudentMonthly,
            'growthTeacherMonthly' => $growthTeacherMonthly,
            'revenueYearly' => $revenueYearly,
            'growthStudentYearly' => $growthStudentYearly,
            'growthTeacherYearly' => $growthTeacherYearly,
        ];

        return $data;
    }

    public function teacherHome(Request $request)
    {
        $id = Session::get('id');
        $teacher = User::where('id', $id)->where('role', 2)->first();

        $growthStudentMonthly = [];
        $growthClassMonthly = [];

        $growthStudentYearly = [];
        $growthClassYearly = [];

        // CHART MONTHLY
        $currentMonth = Carbon::now()->month;
        for ($i = 0; $i < $currentMonth; $i++) {
            $countStudent = 0;

            $startOfMonth = now()->subMonth($i)->startOfMonth();
            $endOfMonth = now()->subMonth($i)->endOfMonth();

            $classes = Classroom::whereDate('created_at', '>=', $startOfMonth)->whereDate('created_at', '<=', $endOfMonth)->where('teacher_id', $teacher->id)->get();
            foreach ($classes as $class) {
                $countStudent += count($class->students);
            }

            $growthClassMonthly[] = count($classes);
            $growthStudentMonthly[] = $countStudent;
        }

        // CHART YEARLY
        $currentYear = Carbon::now()->year;
        for ($i = 0; $i < 6; $i++) {
            $countStudent = 0;
            $countClassContinue = 0;
            $countClassFinished = 0;

            $startOfYear = now()->subYear($i)->startOfYear();
            $endOfYear = now()->subYear($i)->endOfYear();

            $classes = Classroom::whereDate('created_at', '>=', $startOfYear)->whereDate('created_at', '<=', $endOfYear)->where('teacher_id', $teacher->id)->get();
            foreach ($classes as $class) {
                $countStudent += count($class->students);
            }

            $growthClassYearly[] = count($classes);
            $growthStudentYearly[] = $countStudent;
        }

        $data = [
            'growthStudentMonthly' => $growthStudentMonthly,
            'growthClassMonthly' => $growthClassMonthly,
            'growthStudentYearly' => $growthStudentYearly,
            'growthClassYearly' => $growthClassYearly,
        ];

        return $data;
    }

    public function teacher(Request $request, $id)
    {
        $teacher = User::where('id', $id)->where('role', 2)->first();

        $growthStudentMonthly = [];
        $growthClassMonthly = [];

        $growthStudentYearly = [];
        $growthClassYearly = [];

        // CHART MONTHLY
        $currentMonth = Carbon::now()->month;
        for ($i = 0; $i < $currentMonth; $i++) {
            $countStudent = 0;

            $startOfMonth = now()->subMonth($i)->startOfMonth();
            $endOfMonth = now()->subMonth($i)->endOfMonth();

            $classes = Classroom::whereDate('created_at', '>=', $startOfMonth)->whereDate('created_at', '<=', $endOfMonth)->where('teacher_id', $teacher->id)->get();
            foreach ($classes as $class) {
                $countStudent += count($class->students);
            }

            $growthClassMonthly[] = count($classes);
            $growthStudentMonthly[] = $countStudent;
        }

        // CHART YEARLY
        $currentYear = Carbon::now()->year;
        for ($i = 0; $i < 6; $i++) {
            $countStudent = 0;
            $countClassContinue = 0;
            $countClassFinished = 0;

            $startOfYear = now()->subYear($i)->startOfYear();
            $endOfYear = now()->subYear($i)->endOfYear();

            $classes = Classroom::whereDate('created_at', '>=', $startOfYear)->whereDate('created_at', '<=', $endOfYear)->where('teacher_id', $teacher->id)->get();
            foreach ($classes as $class) {
                $countStudent += count($class->students);
            }

            $growthClassYearly[] = count($classes);
            $growthStudentYearly[] = $countStudent;
        }

        $data = [
            'growthStudentMonthly' => $growthStudentMonthly,
            'growthClassMonthly' => $growthClassMonthly,
            'growthStudentYearly' => $growthStudentYearly,
            'growthClassYearly' => $growthClassYearly,
        ];

        return $data;
    }

    public function scheduleTeacher($id, Request $request)
    {
        try {
            $selectedDate = $request->query('date');
            $formattedDate = Carbon::parse($selectedDate)->toDateString();

            $classrooms = Classroom::where('teacher_id', $id)
                ->with(['lessons' => function ($query) use ($formattedDate) {
                    $query->whereDate('start_time', '=', $formattedDate);
                }])
                ->get();

            $formattedData = [];
            foreach ($classrooms as $classroom) {
                foreach ($classroom->lessons as $lesson) {
                    $formattedLessons[] = [
                        'startTime' => $lesson->start_time->format('Y-m-d H:i:s'),
                        'endTime' => $lesson->end_time->format('Y-m-d H:i:s'),
                    ];
                }
                $formattedData[] = [
                    'classroomName' => $classroom->name,
                    'roomName' => $classroom->room->name,
                    'lessons' => $classroom->lessons,
                ];
            }

            return response()->json(['id' => $id, 'classrooms' => $formattedData]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch teacher lessons.'], 500);
        }
    }

    public function scheduleStudent($id, Request $request)
    {
        try {
            $selectedDate = $request->query('date');
            $formattedDate = Carbon::parse($selectedDate)->toDateString();
            $user = User::find($id);
            $classroomIds = $user->classrooms->pluck('id');

            $classrooms = Classroom::whereIn('id', $classroomIds)
                ->with(['lessons' => function ($query) use ($formattedDate) {
                    $query->whereDate('start_time', '=', $formattedDate);
                }])
                ->get();

            $formattedData = [];
            foreach ($classrooms as $classroom) {
                foreach ($classroom->lessons as $lesson) {
                    $formattedLessons[] = [
                        'startTime' => $lesson->start_time->format('Y-m-d H:i:s'),
                        'endTime' => $lesson->end_time->format('Y-m-d H:i:s'),
                    ];
                }
                $formattedData[] = [
                    'classroomName' => $classroom->name,
                    'roomName' => $classroom->room->name,
                    'lessons' => $classroom->lessons,
                ];
            }

            return response()->json(['id' => $id, 'classrooms' => $formattedData]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch teacher lessons.'], 500);
        }
    }
}
