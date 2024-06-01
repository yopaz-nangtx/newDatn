<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Lesson;
use Illuminate\Http\Request;

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
}
