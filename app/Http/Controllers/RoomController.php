<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function __construct(){
        $this->view_path = 'admin.master_data.room.';
    }

    public function index()
    {
        $data['title'] = 'Rooms';
        $data['types'] = Room::all();
        return view($this->view_path.'index')->with($data);
    }

    public function create()
    {
        $data['title'] = 'Rooms';
        return view($this->view_path.'create')->with($data);
    }

    public function store(Request $request)
    {
        $type = new Room();
        $type->name = $request->name;
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
        $data['title'] = 'Rooms';
        $data['type'] = Room::find($id);
        return view($this->view_path.'edit')->with($data);
    }

    public function update(Request $request, string $id)
    {
        $type = Room::find($id);
        $type->name = $request->name;
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
        $type = Room::find($id);
        $res = $type->delete();
        if($res){
            return back()->with(['success'=>'Data Deleted Successfully.']);
        }else{
            return back()->with(['error'=>'Data Not Deleted.']);
        }
    }
}
