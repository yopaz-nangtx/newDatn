<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function admin() {
        $revenueMonthly = [];
        $growthStudentMonthly = [];
        $growthTeacherMonthly = [];
        
        $revenueYearly = [];
        $growthStudentYearly = [];
        $growthTeacherYearly = [];

        // CHART MONTHLY
        $currentMonth = Carbon::now()->month;
        for ($i = 0; $i < $currentMonth ; $i++) {
            $revenue = 0;

            $startOfMonth = now()->subMonth($i)->startOfMonth();
            $endOfMonth = now()->subMonth($i)->endOfMonth();

            $classes = Classroom::whereDate('created_at', '>=', $startOfMonth)->whereDate('created_at', '<=', $endOfMonth)->get();
            foreach($classes as $class)
            {
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
            foreach($classes as $class)
            {
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
            'growthTeacherYearly' => $growthTeacherYearly
        ];

        return $data;
    }

    public function teacher(Request $request, $id) {
        $teacher = User::where('id', $id)->where('role', 2)->first();

        $growthStudentMonthly = [];
        $growthClassMonthly = [];
        
        $growthStudentYearly = [];
        $growthClassYearly = [];

        // CHART MONTHLY
        $currentMonth = Carbon::now()->month;
        for ($i = 0; $i < $currentMonth ; $i++) {
            $countStudent = 0;

            $startOfMonth = now()->subMonth($i)->startOfMonth();
            $endOfMonth = now()->subMonth($i)->endOfMonth();

            $classes = Classroom::whereDate('created_at', '>=', $startOfMonth)->whereDate('created_at', '<=', $endOfMonth)->where('teacher_id', $teacher->id)->get();
            foreach($classes as $class)
            {
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
            foreach($classes as $class)
            {
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
}
