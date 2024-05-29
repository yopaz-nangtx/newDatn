<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\Homework;
use App\Models\HomeworkQuestion;
use App\Models\Question;
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
        // dd($request->all());

        DB::beginTransaction();
        try {
            $dateTimeString = $request->end_date . ' ' . $request->end_time;
            $dateTime = Carbon::createFromFormat('Y-m-d H:i', $dateTimeString);

            $homework = new Homework;
            $homework->homework_name = $request['homework_name'];
            $homework->time = $request['time'];
            $homework->end_time = $dateTime;
            $homework->save();

            foreach ($request->questions as $questionId) {
                HomeworkQuestion::create([
                    'homework_id' => $homework->id,
                    'question_id' => $questionId,
                ]);
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
            $dateTimeString = $request->end_date . ' ' . $request->end_time;
            $dateTime = Carbon::createFromFormat('Y-m-d H:i', $dateTimeString);

            $homework = Homework::find($request->id);
            $homework->homework_name = $request['homework_name'];
            $homework->time = $request['time'];
            $homework->end_time = $dateTime;

            foreach ($homework->homeworkQuestions as $homeworkQuestion) {
                $homeworkQuestion->delete();
            }
            $homework->save();

            foreach ($request->questions as $questionId) {
                HomeworkQuestion::create([
                    'homework_id' => $homework->id,
                    'question_id' => $questionId,
                ]);
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
}
