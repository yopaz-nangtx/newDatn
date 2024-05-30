<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    public function question()
    {
        $questions = Question::all();

        return view('question.question', compact('questions'));
    }

    /** question add page */
    public function questionAdd()
    {
        return view('question.add-question');
    }

    /** question save record */
    public function questionSave(Request $request)
    {
        $request->validate([
            'question' => 'required|string',
            'option_1' => 'required|string',
            'option_2' => 'required|string',
            'option_3' => 'required|string',
            'option_4' => 'required|string',
            'answer' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $question = new Question;
            $question->question = $request['question'];
            $question->option_1 = $request['option_1'];
            $question->option_2 = $request['option_2'];
            $question->option_3 = $request['option_3'];
            $question->option_4 = $request['option_4'];
            $question->answer = $request['answer'];
            $question->save();

            Toastr::success('Has been add successfully', 'Success');
            DB::commit();

            return redirect()->route('question/list');
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('fail, Add new question', 'Error');

            return redirect()->back();
        }
    }

    /** view for edit question */
    public function questionEdit($id)
    {
        $questionEdit = Question::find($id);

        return view('question.edit-question', compact('questionEdit'));
    }

    /** update record */
    public function questionUpdate(Request $request)
    {
        $question = Question::find($request->id);

        $request->validate([
            'question' => 'required|string',
            'option_1' => 'required|string',
            'option_2' => 'required|string',
            'option_3' => 'required|string',
            'option_4' => 'required|string',
            'answer' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $question = Question::find($request->id);
            $question->question = $request['question'];
            $question->option_1 = $request['option_1'];
            $question->option_2 = $request['option_2'];
            $question->option_3 = $request['option_3'];
            $question->option_4 = $request['option_4'];
            $question->answer = $request['answer'];
            $question->save();

            Toastr::success('Has been update successfully', 'Success');
            DB::commit();

            return redirect()->route('question/list');

        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('fail, Update question', 'Error');

            return redirect()->back();
        }
    }

    /** question delete */
    public function questionDelete(Request $request)
    {
        DB::beginTransaction();
        try {

            if (! empty($request->id)) {
                Question::destroy($request->id);
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
