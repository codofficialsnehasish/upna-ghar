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
use App\Models\ServiceType;
use App\Models\Category;
use App\Models\ServiceCategories;

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

    /*public function create(){
        $data['title'] = 'Service';
        $data['payment_type'] = PaymentType::where('visibility',1)->get();
        // $data['parents'] = Service::where('parent_id',null)->where('sub_parent_id',null)->get();
        // $data['sub_parents'] = Service::where('parent_id',null)->where('sub_parent_id',null)->get();
        $data['time_slot'] = TimeSlot::where('visibility',1)->get();
        $data['form_templates'] = ServiceFormTemplate::where('is_visible',1)->get();
        $data['service_type'] = ServiceType::where('visibility',1)->get();
        $data['categorys'] = Category::where('visibility',1)->where('parent_id',null)->get();
        // return view($this->view_path.'create')->with($data);
        return view($this->view_path.'basic_info')->with($data);
    }*/
    public function basic_info(){
        $data['title'] = 'Service';
        $data['payment_type'] = PaymentType::where('visibility',1)->get();
        // $data['parents'] = Service::where('parent_id',null)->where('sub_parent_id',null)->get();
        // $data['sub_parents'] = Service::where('parent_id',null)->where('sub_parent_id',null)->get();
        $data['time_slot'] = TimeSlot::where('visibility',1)->get();
        $data['form_templates'] = ServiceFormTemplate::where('is_visible',1)->get();
        $data['service_type'] = ServiceType::where('visibility',1)->get();
        $data['categorys'] = Category::where('visibility',1)->where('parent_id',null)->get();
        // return view($this->view_path.'create')->with($data);
        return view($this->view_path.'basic_info')->with($data);
    }

    public function basic_info_store(Request $request){
        // return $request->all();
        $request->validate([
            'name' => 'required',
            // 'price' => 'required',
            // 'price_type' => 'required',
            'time_slot' => 'required',
            // 'survey_charge' => 'required',
            // 'outer-group.*.work-process.*.title' => 'required|string|max:255',
            // 'outer-group.*.work-process.*.description' => 'required|string|max:1000',
            // 'outer-group.*.promice-group.*.promicedata' => 'required|string|max:500',
        ]);

        $service = new Service();
        $service->name = $request->name;
        // $service->parent_id = $request->parent_service;
        // $service->sub_parent_id = $request->sub_parent_service;
        $service->slug = createSlug($request->name,Service::class);
        // $service->price = $request->price;
        $service->price = 0.00;
        // $service->price_type_id = $request->price_type;
        $service->price_type_id = $request->price_type;
        $service->description = $request->description; 
        $service->time_slot = implode(',',$request->time_slot);
        // $service->survey_charge = $request->survey_charge;
        // $service->survey_charge = 0.00;
        $service->service_types = $request->service_types;
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

        // Categories
        // foreach($request->categories as $categorie){
        //     ServiceCategories::create([
        //         'services_id' => $service->id,
        //         'category_id' => $categorie,
        //     ]);
        // }

        if ($request->has('categories')) {  
            $service->categories()->sync($request->categories);
        }
        

        // Uploading service Media
        // $media_files = $request->file('service_media');
        // if (!empty($media_files)) {
        //     foreach ($media_files as $file) {
        //         $service_media = new ServiceMedia();
        //         $filename = time() . '_' . $file->getClientOriginalName();
        //         $directory = public_path('web_storage/service_media');
        //         $mimeType = $file->getMimeType();
        //         $file->move($directory, $filename);
        //         $filePath = "web_storage/service_media/" . $filename;

        //         // Determine the media type
        //         if (strstr($mimeType, "video/")) {
        //             $service_media->media_type = 'video';
        //         } elseif (strstr($mimeType, "image/")) {
        //             $service_media->media_type = 'image';
        //         } else {
        //             $service_media->media_type = 'unknown';
        //         }
        //         $service_media->service_id = $service->id;
        //         $service_media->filepath = $filePath;
        //         $service_media->visibility = 1;
        //         $service_media->save();
        //     }
        // }


        // $outerGroup = $request->input('outer-group');

        // // Loop through each item in the outer-group array
        // foreach ($outerGroup as $groupIndex => $group) {
        //     // Access and loop through work-process data if available
        //     if (isset($group['work-process'])) {
        //         foreach ($group['work-process'] as $workProcessIndex => $workProcess) {
        //             $obj_workprocess = new WorkProcess();
        //             $obj_workprocess->service_id = $service->id;
        //             $obj_workprocess->title = $workProcess['title'];
        //             $obj_workprocess->description = $workProcess['desc'];
        //             $obj_workprocess->save();
        //         }
        //     }

        //     // Access and loop through promice-group data if available
        //     if (isset($group['promice-group'])) {
        //         foreach ($group['promice-group'] as $promiceGroupIndex => $promiceGroup) {
        //             $obj_promice = new Promice();
        //             $obj_promice->service_id = $service->id;
        //             $obj_promice->promice = $promiceGroup['promicedata'];
        //             $obj_promice->save();
        //         }
        //     }
        // }


        if($res){
            // return back()->with(['success'=>'Service Stored Successfully.']);
            return redirect(route('service.edit-price-info',$service->id))->with(['success'=>'Basic Information Added Successfully']);
        }else{
            return back()->with(['error'=>'Service Not Stored.']);
        }
    }

    public function edit_basic_info(Request $request){
        $data['title'] = 'Service';
        $service = Service::find($request->id);
        $data['service'] = $service;
        // $data['service_media'] = ServiceMedia::where('service_id',$r->id)->get();
        // $data['service_work_process'] = WorkProcess::where('service_id',$r->id)->get();
        // $data['service_promice'] = Promice::where('service_id',$r->id)->get();
        // $data['payment_type'] = PaymentType::where('visibility',1)->get();
        // $data['parents'] = Service::where('parent_id',null)->where('sub_parent_id',null)->get();
        // $data['sub_parents'] = Service::where('parent_id',null)->where('sub_parent_id',null)->get();
        $data['time_slot'] = TimeSlot::where('visibility',1)->get();
        $data['form_templates'] = ServiceFormTemplate::where('is_visible',1)->get();
        // $data['service_type'] = ServiceType::where('visibility',1)->get();
        $data['categorys'] = Category::where('visibility',1)->where('parent_id',null)->get();
        $data['selectedCategories'] = $service->categories->pluck('id')->toArray();
        return view($this->view_path.'basic_info_edit')->with($data);
    }

    public function edit_basic_info_store(Request $request){
        $request->validate([
            'name' => 'required',
            // 'price' => 'required',
            // 'price_type' => 'required',
            'time_slot' => 'required',
            // 'survey_charge' => 'required',
            // 'outer-group.*.work-process.*.title' => 'required|string|max:255',
            // 'outer-group.*.work-process.*.description' => 'required|string|max:1000',
            // 'outer-group.*.promice-group.*.promicedata' => 'required|string|max:500',
        ]);

        $service = Service::find($request->id);
        $service->name = $request->name;
        // $service->parent_id = $request->parent_service;
        // $service->sub_parent_id = $request->sub_parent_service;
        $service->slug = createSlug($request->name,Service::class);
        // $service->price = $request->price;
        // $service->price_type_id = $request->price_type;
        $service->description = $request->description; 
        $service->time_slot = implode(',',$request->time_slot);
        // $service->survey_charge = $request->survey_charge;
        $service->service_types = $request->service_types;
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
        $res = $service->update();

        if ($request->has('categories')) {  
            $service->categories()->sync($request->categories);
        }

        if($res){
            return redirect(route('service.edit-price-info',$service->id))->with(['success'=>'Service Updated Successfully.']);
        }else{
            return back()->with(['error'=>'Service Not Updated.']);
        }
    }

    /*public function get_sub_category(Request $request){
        $sub_parent = Category::where('parent_id',$request->id)->where('visibility',1)->get();  
        echo json_encode($sub_parent);
    }*/

    /*public function get_sub_parent(Request $r){
        $sub_parent = Service::where('parent_id',$r->id)->where('sub_parent_id',null)->get();  
        echo json_encode($sub_parent);
    }*/

    

    public function edit_price_info(Request $request){
        if(request()->segment(4) == ''){
			return redirect(route('service.basic-info'))->with('error','Please Fill Basic Information');
		}
        $data['title'] = 'Service';
        $data['service'] = Service::find($request->id);
        return view($this->view_path.'price_edit')->with($data);
    }

    public function edit_price_info_store(Request $request){
        $service = Service::find($request->id);
        $service->price = $request->price;
        $service->discount_rate = $request->discount_rate;
        // $product->discounted_price = $request->product_price - (($request->discount_rate / 100) * $request->product_price);
        $service->gst_rate = $request->gst_rate;
        $service->total_price = $request->total_price;
        // $product->gst_amount = ($request->gst_rate / 100) * $product->discounted_price;
        $service->discount_price = ($request->discount_rate / 100) * $request->product_price;
        $gstRate = $request->gst_rate/100;
        $service->gst_amount = ($request->total_price * $gstRate) / (1 + $gstRate);
        $res = $service->update();
        if($res){
            // return redirect(route('products.inventory-edit',$product->id))->with(['success'=>'Price Details Updated Successfully']);
            return back()->with(['success'=>'Price Details Updated Successfully']);
        }else{
            return redirect()->back()->with(['error'=>'Some error occurs!']);
        }
    }

    public function edit(Request $r){
        $data['title'] = 'Service';
        $service = Service::find($r->id);
        $data['service'] = $service;
        $data['service_media'] = ServiceMedia::where('service_id',$r->id)->get();
        $data['service_work_process'] = WorkProcess::where('service_id',$r->id)->get();
        $data['service_promice'] = Promice::where('service_id',$r->id)->get();
        $data['payment_type'] = PaymentType::where('visibility',1)->get();
        // $data['parents'] = Service::where('parent_id',null)->where('sub_parent_id',null)->get();
        // $data['sub_parents'] = Service::where('parent_id',null)->where('sub_parent_id',null)->get();
        $data['time_slot'] = TimeSlot::where('visibility',1)->get();
        $data['form_templates'] = ServiceFormTemplate::where('is_visible',1)->get();
        $data['service_type'] = ServiceType::where('visibility',1)->get();
        $data['categorys'] = Category::where('visibility',1)->where('parent_id',null)->get();
        $data['selectedCategories'] = $service->categories->pluck('id')->toArray();
        return view($this->view_path.'edit')->with($data);
    }

    public function delete_service_media(string $id){
        $media = ServiceMedia::find($id);
        $res = $media->delete();
        if($res){
            return back()->with(['success'=>'Service Media Deleted Successfully.']);
        }else{
            return back()->with(['error'=>'Service Media Not Deleted.']);
        }
    }

    public function delete_work_process(string $id){
        $work_process = WorkProcess::find($id);
        $res = $work_process->delete();
        if($res){
            return back()->with(['success'=>'Work Process Deleted Successfully.']);
        }else{
            return back()->with(['error'=>'Work Process Not Deleted.']);
        }
    }

    public function delete_promice(string $id){
        $promice = Promice::find($id);
        $res = $promice->delete();
        if($res){
            return back()->with(['success'=>'Promice Deleted Successfully.']);
        }else{
            return back()->with(['error'=>'Promice Not Deleted.']);
        }
    }

    public function update(Request $request){
        // return $request->all();
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'price_type' => 'required',
            'time_slot' => 'required',
            'survey_charge' => 'required',
            // 'outer-group.*.work-process.*.title' => 'required|string|max:255',
            // 'outer-group.*.work-process.*.description' => 'required|string|max:1000',
            // 'outer-group.*.promice-group.*.promicedata' => 'required|string|max:500',
        ]);

        $service = Service::find($request->id);
        $service->name = $request->name;
        $service->parent_id = $request->parent_service;
        $service->sub_parent_id = $request->sub_parent_service;
        $service->slug = createSlug($request->name,Service::class);
        $service->price = $request->price;
        $service->price_type_id = $request->price_type;
        $service->description = $request->description; 
        $service->time_slot = implode(',',$request->time_slot);
        $service->survey_charge = $request->survey_charge;
        $service->service_type = $request->service_type;
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
        $res = $service->update();

        if ($request->has('categories')) {  
            $service->categories()->sync($request->categories);
        }

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

        if (!empty($outerGroup) && is_array($outerGroup)) {
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
        }


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
