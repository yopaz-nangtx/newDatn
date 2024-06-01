<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lesson;

class LessonController extends Controller
{
    public function detailApi(Request $request, $lesson_id)
    {
        $lesson = Lesson::where('id', $request->lesson_id)->with(['classroom', 'room'])->first();

        return $lesson;
    }
}
