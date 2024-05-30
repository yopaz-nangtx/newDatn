<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class RoomController extends Controller
{
    public function room()
    {
        $rooms = Room::orderBy('id', 'desc')->get();

        return view('room.room', compact('rooms'));
    }

    /** room add page */
    public function roomAdd()
    {
        return view('room.add-room');
    }

    /** room save record */
    public function roomSave(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'capacity' => 'required|integer|gt:0',
            'description' => 'string',
        ]);

        DB::beginTransaction();
        try {
            $room = new Room;
            $room->name = $request['name'];
            $room->capacity = (int) $request['capacity'];
            $room->description = $request['description'];
            $room->save();

            Toastr::success('Has been add successfully', 'Success');
            DB::commit();

            return redirect()->route('room/list');
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('fail, Add new room', 'Error');

            return redirect()->back();
        }
    }

    /** view for edit room */
    public function roomEdit($id)
    {
        $roomEdit = Room::find($id);

        return view('room.edit-room', compact('roomEdit'));
    }

    /** update record */
    public function roomUpdate(Request $request)
    {
        $room = Room::find($request->id);

        $request->validate([
            'name' => [
                'required',
                'string',
                Rule::unique('rooms')->ignore($room->name, 'name'),
            ],
            'capacity' => 'required|integer|gt:0',
            'description' => 'string',
        ]);

        DB::beginTransaction();
        try {
            $room = Room::find($request->id);
            $room->name = $request['name'];
            $room->capacity = $request['capacity'];
            $room->description = $request['description'];
            $room->save();

            Toastr::success('Has been update successfully', 'Success');
            DB::commit();

            return redirect()->route('room/list');

        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('fail, Update room', 'Error');

            return redirect()->back();
        }
    }

    /** room delete */
    public function roomDelete(Request $request)
    {
        DB::beginTransaction();
        try {

            if (! empty($request->id)) {
                Room::destroy($request->id);
                DB::commit();
                Toastr::success('Room deleted successfully', 'Success');

                return redirect()->route('room/list');
            }

        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Room deleted fail', 'Error');

            return redirect()->route('room/list');
        }
    }
}
