<?php

namespace App\Http\Controllers;

use App\Models\TimeSlot;
use Illuminate\Http\Request;

class TimeSlotController extends Controller
{
    public function __construct(){
        $this->view_path = 'admin.master_data.time_slot.';
    }

    public function index()
    {
        $data['title'] = 'Time Slot';
        $data['types'] = TimeSlot::all();
        return view($this->view_path.'index')->with($data);
    }

    public function create()
    {
        $data['title'] = 'Time Slot';
        return view($this->view_path.'create')->with($data);
    }

    public function store(Request $request)
    {
        $type = new TimeSlot();
        $type->start_time = $request->start_time;
        $type->end_time = $request->end_time;
        $type->visibility = $request->visibility;
        $res = $type->save();
        if($res){
            return redirect()->back()->with(['success'=>'Data Added Successfully']);
        }else{
            return redirect()->back()->with(['error'=>'Data Not Added, try again!']);
        }
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $data['title'] = 'Time Slot';
        $data['type'] = TimeSlot::find($id);
        return view($this->view_path.'edit')->with($data);
    }

    public function update(Request $request, string $id)
    {
        $type = TimeSlot::find($id);
        $type->start_time = $request->start_time;
        $type->end_time = $request->end_time;
        $type->visibility = $request->visibility;
        $res = $type->save();
        if($res){
            return redirect()->back()->with(['success'=>'Data Updated Successfully']);
        }else{
            return redirect()->back()->with(['error'=>'Data Not Updated, try again!']);
        }
    }

    public function destroy(string $id)
    {
        $type = TimeSlot::find($id);
        $res = $type->delete();
        if($res){
            return back()->with(['success'=>'Data Deleted Successfully.']);
        }else{
            return back()->with(['error'=>'Data Not Deleted.']);
        }
    }
}
