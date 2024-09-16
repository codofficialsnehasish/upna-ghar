<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Slider;
use Illuminate\Support\Facades\Validator;
class SliderController extends Controller
{
    //============================ Slider ======================

    public function slider(Request $r)
    {
        if ($r->is('api/*')) {
            $s = Slider::where('is_visible',1)->get();
            return ['status' => "true", "data" => $s];
        } else {
            $s = Slider::all();
            $data['title'] = 'Slider';
            $data['slider'] = $s;
            return view("admin/slider/content")->with($data);
        }
    }

    public function sliderAdd()
    {
        $data['title'] = 'Add Slider';
        return view("admin/slider/add")->with($data);
    }

    public function slider_submit(Request $r)
    {
        $validator = Validator::make($r->all(), [
            'name' => 'required|string|max:255',
            'desc' => 'nullable|string',
            'sliderimg' => 'required|image|max:3000',
            'is_visible' => 'required|boolean',
        ], [
            'sliderimg.required' => 'Please Choose a Slider Image.',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }
        $slider = new Slider();
        $slider->title = $r->name;
        $slider->description = $r->desc;

        if ($r->hasFile('sliderimg')) {
            $img = $r->file('sliderimg');
            $filename = time(). '_' .$img->getClientOriginalName();
            $directory = public_path('web_directory/slider_images');
            $img->move($directory, $filename);
            $filePath = "web_directory/slider_images/".$filename;
            $slider->image = $filePath;
        }

        $slider->is_visible = $r->is_visible;
        $res = $slider->save();
        if($res){
            return redirect()->back()->with(['success'=>'Data Added Successfully']);
        }else{
            return redirect()->back()->with(['error'=>'Data Not Added']);
        }
    }

    public function sliderEdit(Request $r)
    {
        $obj = Slider::find($r->id);
        $data['title'] = 'Edit Slider';
        $data['slider'] = $obj;
        return view("admin/slider/edit")->with($data);
    }

    public function slider_edit_submit(Request $r)
    {
        $validator = Validator::make($r->all(), [
            'name' => 'required|string|max:255',
            'desc' => 'nullable|string',
            'sliderimg' => 'nullable|image|max:3000',
            'is_visible' => 'required|boolean',
        ], [
            'sliderimg.nullable' => 'Please Choose a Slider Image.',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }
        $slider = Slider::find($r->id);
        $slider->title = $r->name;
        $slider->description = $r->desc;



        if ($r->hasFile('sliderimg')) {
            $img = $r->file('sliderimg');
            $filename = time(). '_' .$img->getClientOriginalName();
            $directory = public_path('web_directory/slider_images');
            $img->move($directory, $filename);
            $filePath = "web_directory/slider_images/".$filename;
            $slider->image = $filePath;
        }

        $slider->is_visible = $r->is_visible;
        $res = $slider->update();
        if($res){
            return redirect()->back()->with(['success'=>'Data Updated Successfully']);
        }else{
            return redirect()->back()->with(['error'=>'Data Not Updated']);
        }
        // return redirect(url('/slider'));
    }

    public function slider_del(Request $r)
    {
        $obj = Slider::find($r->id);
        $res = $obj->delete();
        if($res){
            return redirect()->back()->with(['success'=>'Data Deleted Successfully']);
        }else{
            return redirect()->back()->with(['error'=>'Data Not Deleted']);
        }
        // return redirect(url('/slider'));
    }

}


    //==========xxxxxxx======= End of Slider ===========xxxxxx=======
