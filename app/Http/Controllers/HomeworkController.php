<?php

namespace App\Http\Controllers;

use App\Models\Homework;
use App\Models\HomeworkQuestion;
use App\Models\HomeworkResult;
use App\Models\Lesson;
use App\Models\LessonHomework;
use App\Models\Question;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeworkController extends Controller
{
    public function homework()
    {
        $homeworks = Homework::all();

        return view('homework.homework', compact('homeworks'));
    }

    /** homework add page */
    public function homeworkAdd()
    {
        $questions = Question::orderBy('id', 'desc')->get();

        return view('homework.add-homework', compact('questions'));
    }

    /** homework save record */
    public function homeworkSave(Request $request)
    {
        $request->validate([
            'homework_name' => 'required|string',
            'time' => 'required|integer|min:1',
            'end_date' => 'required',
            'end_time' => 'required',
            'questions' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $dateTimeString = $request->end_date.' '.$request->end_time;
            $dateTime = Carbon::createFromFormat('Y-m-d H:i', $dateTimeString);

            $homework = new Homework;
            $homework->homework_name = $request['homework_name'];
            $homework->time = $request['time'];
            $homework->end_time = $dateTime;
            $homework->save();

            if (isset($request->questions)) {
                foreach ($request->questions as $questionId) {
                    HomeworkQuestion::create([
                        'homework_id' => $homework->id,
                        'question_id' => $questionId,
                    ]);
                }
            }

            Toastr::success('Has been add successfully', 'Success');
            DB::commit();

            return redirect()->route('homework/list');
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('fail, Add new question', 'Error');

            return redirect()->back();
        }
    }

    /** view for edit homework */
    public function homeworkEdit($id)
    {
        $allQuestions = Question::orderBy('id', 'desc')->get();
        $homeworkEdit = Homework::find($id);
        $questionIds = $homeworkEdit->questions->pluck('id');
        $dateTime = Carbon::parse($homeworkEdit->end_time);
        $endDate = $dateTime->format('Y-m-d');
        $endTime = $dateTime->format('H:i');

        return view('homework.edit-homework', compact('homeworkEdit', 'allQuestions', 'questionIds', 'endDate', 'endTime'));
    }

    /** update record */
    public function homeworkUpdate(Request $request)
    {
        unset($request['_token'], $request['_method']);

        $homework = Homework::find($request->id);

        $request->validate([
            'homework_name' => 'required|string',
            'time' => 'required|integer|min:1',
            'end_date' => 'required',
            'end_time' => 'required',
            'questions' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $dateTimeString = $request->end_date.' '.$request->end_time;
            $dateTime = Carbon::createFromFormat('Y-m-d H:i', $dateTimeString);

            $homework = Homework::find($request->id);
            $homework->homework_name = $request['homework_name'];
            $homework->time = $request['time'];
            $homework->end_time = $dateTime;

            foreach ($homework->homeworkQuestions as $homeworkQuestion) {
                $homeworkQuestion->delete();
            }
            $homework->save();

            if (isset($request->questions)) {
                foreach ($request->questions as $questionId) {
                    HomeworkQuestion::create([
                        'homework_id' => $homework->id,
                        'question_id' => $questionId,
                    ]);
                }
            }

            Toastr::success('Has been update successfully', 'Success');
            DB::commit();

            return redirect()->route('homework/list');

        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('fail, Update question', 'Error');

            return redirect()->back();
        }
    }

    /** homework delete */
    public function homeworkDelete(Request $request)
    {
        DB::beginTransaction();
        try {

            if (! empty($request->id)) {
                Homework::destroy($request->id);
                DB::commit();
                Toastr::success('Question deleted successfully', 'Success');

                return redirect()->route('question/list');
            }

        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Question deleted fail', 'Error');

            return redirect()->route('question/list');
        }
    }

    // API
    public function listApi(Request $request)
    {
        $user = $request->user();
        $classIds = $user->classrooms->pluck('id');
        $lessonIds = Lesson::whereIn('classroom_id', $classIds)->pluck('id')->toArray();
        $homeworkIds = LessonHomework::whereIn('lesson_id', $lessonIds)->pluck('homework_id')->toArray();

        $homeworks = Homework::whereIn('id', $homeworkIds)->get();
        foreach ($homeworks as $homework) {
            $lessonId = LessonHomework::where('homework_id', $homework->id)->first()->lesson_id;
            $lesson = Lesson::find($lessonId);
            $classroom = $lesson->classroom;

            $homework['teacher'] = $classroom->teacher->name;
            $homework['nameClass'] = $classroom->name;

            $homework['assignmentName'] = $homework->homework_name;
            unset($homework['homework_name'], $homework['created_at'], $homework['updated_at']);
            $homeworkResult = HomeworkResult::where('homework_id', $homework->id)
                ->where('student_id', $request->user()->id)->orderBy('id', 'desc')
                ->first();
            $homework['count_question'] = count($homework->questions);
            $homework['is_finished'] = $homeworkResult ? $homeworkResult->is_finished : 0;
            $homework['score'] = $homeworkResult?->score;
        }

        return $homeworks;
    }

    public function listQuestionApi(Request $request, $homework_id)
    {
        $questions = Homework::find($homework_id)->questions;
        foreach ($questions as $question) {
            $question['option'] = [
                $question->option_1,
                $question->option_2,
                $question->option_3,
                $question->option_4,
            ];
            $question['answer'] = $question[$question->answer];
            unset($question['option_1'],
                $question['option_2'],
                $question['option_3'],
                $question['option_4'],
                $question['created_at'],
                $question['updated_at']
            );
        }

        return $questions;
    }

    public function storeResultApi(Request $request)
    {
        $request['score'] = $request->count_correct / $request->count_question * 100;
        $request['is_finished'] = 1;
        unset($request['count_correct'], $request['count_question']);
        $resultHomework = HomeworkResult::createOrFirst($request->all());

        return $resultHomework;
    }
}
