<?php

namespace App\Http\Controllers;

use App\Models\ServiceType;
use Illuminate\Http\Request;

class ServiceTypeController extends Controller
{
    public function __construct(){
        $this->view_path = 'admin.master_data.service_type.';
    }

    public function index(Request $request)
    {
        if($request->is('api/*')){
            return response()->json([
                "status" => "true",
                "data" => ServiceType::where('visibility',1)->get(['id','name'])
            ]);
        }
        $data['title'] = 'Service Type';
        $data['types'] = ServiceType::all();
        return view($this->view_path.'index')->with($data);
    }

    public function create()
    {
        $data['title'] = 'Service Type';
        return view($this->view_path.'create')->with($data);
    }

    public function store(Request $request)
    {
        $type = new ServiceType();
        $type->name = $request->name;
        $type->description = $request->description;
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
        $data['title'] = 'Service Type';
        $data['type'] = ServiceType::find($id);
        return view($this->view_path.'edit')->with($data);
    }

    public function update(Request $request, string $id)
    {
        $type = ServiceType::find($id);
        $type->name = $request->name;
        $type->description = $request->description;
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
        $type = ServiceType::find($id);
        $res = $type->delete();
        if($res){
            return back()->with(['success'=>'Data Deleted Successfully.']);
        }else{
            return back()->with(['error'=>'Data Not Deleted.']);
        }
    }
}
