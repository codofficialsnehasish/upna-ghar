<?php

namespace App\Http\Controllers;

use App\Models\ApartmentType;
use Illuminate\Http\Request;

class ApartmentTypeController extends Controller
{
    public function __construct(){
        $this->view_path = 'admin.master_data.apartment_type.';
    }

    public function index()
    {
        $data['title'] = 'Apartment Type';
        $data['types'] = ApartmentType::all();
        return view($this->view_path.'index')->with($data);
    }

    public function create()
    {
        $data['title'] = 'Apartment Type';
        return view($this->view_path.'create')->with($data);
    }

    public function store(Request $request)
    {
        $type = new ApartmentType();
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
        $data['title'] = 'Apartment Type';
        $data['type'] = ApartmentType::find($id);
        return view($this->view_path.'edit')->with($data);
    }

    public function update(Request $request, string $id)
    {
        $type = ApartmentType::find($id);
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
        $type = ApartmentType::find($id);
        $res = $type->delete();
        if($res){
            return back()->with(['success'=>'Data Deleted Successfully.']);
        }else{
            return back()->with(['error'=>'Data Not Deleted.']);
        }
    }
}
