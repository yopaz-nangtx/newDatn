<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\Homework;
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
        return view('homework.add-homework');
    }

    /** homework save record */
    public function homeworkSave(Request $request)
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
            $question = new Homework;
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

    /** view for edit homework */
    public function homeworkEdit($id)
    {
        $questionEdit = Homework::find($id);

        return view('question.edit-question', compact('questionEdit'));
    }

    /** update record */
    public function homeworkUpdate(Request $request)
    {
        $question = Homework::find($request->id);

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
            $question = Homework::find($request->id);
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
