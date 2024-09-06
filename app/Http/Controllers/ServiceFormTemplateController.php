<?php

namespace App\Http\Controllers;

use App\Models\ServiceFormTemplate;
use App\Models\ServiceFormTemplateFields;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceFormTemplateController extends Controller
{
    public function __construct(){
        $this->view_path = "admin.service_form_template.";
    }

    public function index()
    {
        $data['title'] = 'Service Form Template';
        $data['templates'] = ServiceFormTemplate::all();
        return view($this->view_path.'index')->with($data);
    }

    public function create()
    {
        $data['title'] = 'Service Form Template';
        return view($this->view_path.'create')->with($data);
    }

    public function store(Request $request)
    {
        $template = new ServiceFormTemplate();
        $template->template_name = $request->template_name;
        $template->is_visible = $request->is_visible;
        $template->save();

        foreach($request->label_name as $key => $value){
            $template_fields = new ServiceFormTemplateFields();
            $template_fields->form_template_id = $template->id;
            $template_fields->label_name = $value;
            $template_fields->input_type = $request->type_id[$key];
            $template_fields->input_type_options = $request->option[$key];
            $template_fields->input_is_required = isset($request->required[$key]) ? 1 : 0;
            $template_fields->input_is_readonly = isset($request->readonly[$key]) ? 1 : 0;
            $template_fields->save();
        }

        return redirect()->back()->with('success', 'Data processed successfully!');
    }

    public function show(ServiceFormTemplate $serviceFormTemplate)
    {
        //
    }

    public function edit(string $id)
    {
        $data['title'] = 'Service Form Template';
        $data['template'] = ServiceFormTemplate::find($id);
        $data['template_fields'] = ServiceFormTemplateFields::where('form_template_id',$id)->get();
        return view($this->view_path.'edit')->with($data);
    }

    public function delete_form_field(string $id){
        $field = ServiceFormTemplateFields::find($id);
        $res = $field->delete();
        if($res){
            return redirect()->back()->with('success', 'Data Deleted Successfully');
        }else{
            return redirect()->back()->with('error', 'Data Not Deleted');
        }
    }

    public function update(Request $request, string $id)
    {
        $template = ServiceFormTemplate::find($id);
        $template->template_name = $request->template_name;
        $template->is_visible = $request->is_visible;
        $template->update();

        if(!empty(array_filter($request->label_name))){
            foreach($request->label_name as $key => $value){
                $template_fields = new ServiceFormTemplateFields();
                $template_fields->form_template_id = $template->id;
                $template_fields->label_name = $value;
                $template_fields->input_type = $request->type_id[$key];
                $template_fields->input_type_options = $request->option[$key];
                $template_fields->input_is_required = isset($request->required[$key]) ? 1 : 0;
                $template_fields->input_is_readonly = isset($request->readonly[$key]) ? 1 : 0;
                $template_fields->save();
            }
        }

        return redirect()->back()->with('success', 'Data updated successfully!');
    }

    public function destroy(string $id)
    {
        $template = ServiceFormTemplate::find($id);
        $res = $template->delete();
        if($res){
            return redirect()->back()->with('success', 'Data Deleted Successfully');
        }else{
            return redirect()->back()->with('error', 'Data Not Deleted');
        }
    }
}
