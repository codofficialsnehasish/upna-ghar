<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Service;
use App\Models\ServiceMedia;
use App\Models\PaymentType;
use App\Models\WorkProcess;
use App\Models\Promice;
use App\Models\TimeSlot;
use App\Models\ServiceFormTemplate;

class ServiceController extends Controller
{
    public function __construct(){
        $this->view_path = "admin.service.";
    }

    public function index(Request $request){
        $data['title'] = 'Service';
        $data['services'] = Service::all();
        return view($this->view_path.'index')->with($data);
    }

    public function create(){
        $data['title'] = 'Service';
        $data['payment_type'] = PaymentType::where('visibility',1)->get();
        $data['parents'] = Service::where('parent_id',null)->where('sub_parent_id',null)->get();
        $data['sub_parents'] = Service::where('parent_id',null)->where('sub_parent_id',null)->get();
        $data['time_slot'] = TimeSlot::where('visibility',1)->get();
        $data['form_templates'] = ServiceFormTemplate::where('is_visible',1)->get();
        return view($this->view_path.'create')->with($data);
    }

    public function get_sub_parent(Request $r){
        $sub_parent = Service::where('parent_id',$r->id)->where('sub_parent_id',null)->get();  
        echo json_encode($sub_parent);
    }

    public function store(Request $request){
        // return $request->all();
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'price_type' => 'required',
        ]);
        $service = new Service();
        $service->name = $request->name;
        $service->parent_id = $request->parent_service;
        $service->sub_parent_id = $request->sub_parent_service;
        $service->slug = createSlug($request->name,Service::class);
        $service->price = $request->price;
        $service->price_type_id = $request->price_type;
        $service->description = $request->description; 
        $service->time_slot = implode(',',$request->time_slot);
        $service->survey_charge = $request->survey_charge;
        $service->template_id = $request->template;
        
        if ($request->hasFile('service_image')) {
            $img = $request->file('service_image');
            $filename = time(). '_' .$img->getClientOriginalName();
            $directory = public_path('web_directory/service_images');
            $img->move($directory, $filename);
            $filePath = "web_directory/service_images/".$filename;
            $service->main_image = $filePath;
        }

        $service->visibility = $request->is_visible;
        $res = $service->save();

        // Uploading service Media
        $media_files = $request->file('service_media');
        if (!empty($media_files)) {
            foreach ($media_files as $file) {
                $service_media = new ServiceMedia();
                $filename = time() . '_' . $file->getClientOriginalName();
                $directory = public_path('web_storage/service_media');
                $mimeType = $file->getMimeType();
                $file->move($directory, $filename);
                $filePath = "web_storage/service_media/" . $filename;

                // Determine the media type
                if (strstr($mimeType, "video/")) {
                    $service_media->media_type = 'video';
                } elseif (strstr($mimeType, "image/")) {
                    $service_media->media_type = 'image';
                } else {
                    $service_media->media_type = 'unknown';
                }
                $service_media->service_id = $service->id;
                $service_media->filepath = $filePath;
                $service_media->visibility = 1;
                $service_media->save();
            }
        }


        $outerGroup = $request->input('outer-group');

        // Loop through each item in the outer-group array
        foreach ($outerGroup as $groupIndex => $group) {
            // Access and loop through work-process data if available
            if (isset($group['work-process'])) {
                foreach ($group['work-process'] as $workProcessIndex => $workProcess) {
                    $obj_workprocess = new WorkProcess();
                    $obj_workprocess->service_id = $service->id;
                    $obj_workprocess->title = $workProcess['title'];
                    $obj_workprocess->description = $workProcess['description'];
                    $obj_workprocess->save();
                }
            }

            // Access and loop through promice-group data if available
            if (isset($group['promice-group'])) {
                foreach ($group['promice-group'] as $promiceGroupIndex => $promiceGroup) {
                    $obj_promice = new Promice();
                    $obj_promice->service_id = $service->id;
                    $obj_promice->promice = $promiceGroup['promicedata'];
                    $obj_promice->save();
                }
            }
        }


        if($res){
            return back()->with(['success'=>'Service Stored Successfully.']);
        }else{
            return back()->with(['error'=>'Service Not Stored.']);
        }
    }

    public function edit(Request $r){
        $data['title'] = 'Service';
        $data['service'] = Service::find($r->id);
        return view($this->view_path.'edit')->with($data);
    }

    public function update(Request $request){
        $request->validate([
            'name' => 'required',
        ]);
        $service = Service::find($request->id);
        $service->name = $request->name;
        $service->slug = createSlug($request->name,Service::class);
        $service->starting_price = $request->starting_price;
        $service->description = $request->description;

        if ($request->hasFile('service_image')) {
            $img = $request->file('service_image');
            $filename = time(). '_' .$img->getClientOriginalName();
            $directory = public_path('web_directory/service_images');
            $img->move($directory, $filename);
            $filePath = "web_directory/service_images/".$filename;
            $service->main_image = $filePath;
        }

        $service->visibility = $request->is_visible;
        $res = $service->update();
        if($res){
            return back()->with(['success'=>'Service Updated Successfully.']);
        }else{
            return back()->with(['error'=>'Service Not Updated.']);
        }
    }

    public function delete(Request $r){
        $service = Service::find($r->id);
        $res = $service->delete();
        if($res){
            return back()->with(['success'=>'Service Deleted Successfully.']);
        }else{
            return back()->with(['error'=>'Service Not Deleted.']);
        }
    }
}