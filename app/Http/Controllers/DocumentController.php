<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class DocumentController extends Controller
{
    public function document()
    {
        $documentList = Document::orderBy('id', 'desc')->get();

        return view('document.document', compact('documentList'));
    }

    /** document add page */
    public function documentUpload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:doc,pdf,docx',
        ]);

        DB::beginTransaction();
        try {
            $document = new Document;
            $document->link_url = "";
            $document->save();

            $document->link_url = $document->uploadFile($request->file('file'), $document->id);
            $document->save();

            Toastr::success('Has been add successfully', 'Success');
            DB::commit();

            return redirect()->route('document/list');
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('fail, Upload new document', 'Error');

            return redirect()->back();
        }
    }

    /** student delete */
    public function documentDelete(Request $request)
    {
        DB::beginTransaction();
        try {

            if (! empty($request->id)) {
                Document::destroy($request->id);
                DB::commit();
                Toastr::success('Document deleted successfully', 'Success');

                return redirect()->route('document/list');
            }

        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Document deleted fail', 'Error');

            return redirect()->route('document/list');
        }
    }
}
