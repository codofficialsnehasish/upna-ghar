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
        $data['services'] = Service::all();
        return view($this->view_path.'create')->with($data);
    }

    public function store(Request $request)
    {
        // echo "<pre>";
        // print_r($request->all()); 
        // echo "</pre>"; 
        // die;

        // $data = $request->all();
        // return $data;die;
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
        // $template->label_name
        // $template->input_type
        // $template->input_type_options
        // $template->input_is_required

        return redirect()->back()->with('success', 'Data processed successfully!');
    }

    private function formatOptions(array $item)
    {
        switch ($item['input_type']) {
            case 'select':
                return json_encode($item['select_options'] ?? []);
            case 'radio':
                return json_encode($item['radio_options'] ?? []);
            case 'checkbox':
                return json_encode($item['checkbox_options'] ?? []);
            case 'color':
                return json_encode(['color' => $item['color'] ?? '']);
            default:
                return json_encode([]);
        }
    }

    public function show(ServiceFormTemplate $serviceFormTemplate)
    {
        //
    }

    public function edit(ServiceFormTemplate $serviceFormTemplate)
    {
        //
    }

    public function update(Request $request, ServiceFormTemplate $serviceFormTemplate)
    {
        //
    }

    public function destroy(ServiceFormTemplate $serviceFormTemplate)
    {
        //
    }
}
