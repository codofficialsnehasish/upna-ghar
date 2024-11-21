<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Service;
use App\Models\ServiceMedia;
use App\Models\PaymentType;
use App\Models\WorkProcess;
use App\Models\Promice;
use App\Models\TimeSlot;
use App\Models\ApartmentType;
use App\Models\ServiceBook;
use App\Models\ServiceFormTemplate;
use App\Models\ServiceFormTemplateFields;

use App\Models\Category;
use App\Models\ServiceCategories;

class ServicesApiController extends Controller
{
    public function get_categories($id = null){
        if($id != null){
            $category = Category::findOrFail($id);
            if($category){
                return response()->json([
                    'status'=>'true',
                    'categories'=>$category->children
                ]);
            }else{
                return response()->json([
                    'status'=>'false',
                    'massage'=>'Not Categories Avaliable'
                ]);
            }
        }else{
            $categorys = Category::where('parent_id',null)->get();
            if($categorys){
                return response()->json([
                    'status'=>'true',
                    'categories'=>$categorys
                ]);
            }else{
                return response()->json([
                    'status'=>'false',
                    'massage'=>'Not Categories Avaliable'
                ]);
            }
        }
    }

    public function index(Request $request){
        if(!empty($request->category_id)){
            $category = Category::find($request->category_id);
            if($category){
                $services = ServiceCategories::where('category_id', $request->category_id)
                            ->with('services') // Load the related services
                            ->get()
                            ->pluck('services');
                if($services){
                    return response()->json([
                        'status' => 'true',
                        'services' => $services
                    ]);
                }else{
                    return response()->json([
                        'status'=>'false',
                        'massage'=>'Please Enter Valid Category ID'
    
                        // 'services'=>Service::leftJoin('payment_types','payment_types.id','services.price_type_id')
                        //                     ->leftJoin('service_types','service_types.id','services.service_type')
                        //                     ->where('services.visibility',1)
                        //                     ->get([
                        //                         'services.*',
                        //                         'payment_types.name as price_type',
                        //                         'service_types.name as service_type',
                        //                     ])
    
                    //     'services'=>Service::where('services.visibility',1)
                    //                         ->get()
                    ]);
                }
            }else{
                return response()->json([
                    'status'=>'false',
                    'massage'=>'Please Enter Valid Category ID'
                ]);
            }
            
        }else{
            return response()->json([
                'status'=>'false',
                'massage'=>'Please Enter Valid Category ID'
            ]);
        }
    }

    // public function service_details($service_id){
    //     if(Service::where('id',$service_id)->exists()){
    //         $service = Service::leftJoin('payment_types', 'payment_types.id', '=', 'services.price_type_id')
    //         ->where('services.id', $service_id)
    //         ->select('services.*', 'payment_types.name as price_type')
    //         ->first();
            
    //         $time_slot_ids = explode(',',$service->time_slot);
    //         $service_media = ServiceMedia::where('service_id',$service->id)->get();
    //         $work_process = WorkProcess::where('service_id',$service->id)->get();
    //         $promice = Promice::where('service_id',$service->id)->get();
    //         return response()->json([
    //             'status'=>'true',
    //             'data'=>[
    //                 'service' => $service,
    //                 'service_media' => ServiceMedia::where('service_id',$service->id)->get(),
    //                 'work_process' => WorkProcess::where('service_id',$service->id)->get(),
    //                 'promice' => Promice::where('service_id',$service->id)->get(),
    //                 'booking' => [
    //                     'apartment_types' => ApartmentType::where('visibility',1)->get(),
    //                     'time_slot' => TimeSlot::whereIn('id', $time_slot_ids)->get(),
    //                     'survey_charge' => $service->survey_charge,
    //                     'form_template' => ServiceFormTemplate::leftJoin('service_form_templates_fields','service_form_templates_fields.form_template_id','service_form_templates.id')
    //                                         ->where('service_form_templates.id',$service->template_id)
    //                                         ->get(['service_form_templates_fields.*'])
    //                 ]
    //             ]
    //         ]);
    //     }else{ 
    //         return response()->json(['status' => 'false','message' => 'Service ID not exists'], 401);
    //     }
    // }

    public function service_details($service_id){
        if(Service::where('id',$service_id)->exists()){
            $service = Service::where('services.id', $service_id)->first();
            
            $time_slot_ids = explode(',',$service->time_slot);
            $service_media = ServiceMedia::where('service_id',$service->id)->get();
            // $work_process = WorkProcess::where('service_id',$service->id)->get();
            // $promice = Promice::where('service_id',$service->id)->get();
            return response()->json([
                'status'=>'true',
                'data'=>[
                    'service' => $service,
                    'service_media' => ServiceMedia::where('service_id',$service->id)->get(),
                    // 'work_process' => WorkProcess::where('service_id',$service->id)->get(),
                    // 'promice' => Promice::where('service_id',$service->id)->get(),
                    'booking' => [
                        // 'apartment_types' => ApartmentType::where('visibility',1)->get(),
                        'time_slot' => TimeSlot::whereIn('id', $time_slot_ids)->get(),
                        // 'survey_charge' => $service->survey_charge,
                        'form_template' => ServiceFormTemplate::leftJoin('service_form_templates_fields','service_form_templates_fields.form_template_id','service_form_templates.id')
                                            ->where('service_form_templates.id',$service->template_id)
                                            ->get(['service_form_templates_fields.*'])
                    ]
                ]
            ]);
        }else{ 
            return response()->json(['status' => 'false','message' => 'Service ID not exists'], 401);
        }
    }


    public function book_service(Request $request){
        $validator = Validator::make($request->all(), [
            'service_id' => 'required|numeric|exists:services,id',
            // 'apartment_type_id' => 'required|numeric|exists:apartment_types,id',
            'visit_date' => 'required|date|after_or_equal:today',
            'time_slot_id' => 'required|numeric|exists:time_slots,id',
            'payment_mode' => 'required|in:offline,online'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }else{
            $isBooked = ServiceBook::where('service_id', $request->service_id)
                                ->where('time_slot_id', $request->time_slot_id)
                                ->where('visit_date', $request->visit_date)
                                ->exists();

            if ($isBooked) {
                return response()->json([
                    'status' => 'false',
                    'massage' => 'The selected time slot is already booked. Please choose another slot.'
                ]);
            }

            $booking = new ServiceBook();
            $booking->status = 'pending';
            $booking->user_id = $request->user()->id;
            $booking->service_id = $request->service_id;
            $booking->time_slot_id = $request->time_slot_id;
            $booking->visit_date = $request->visit_date;
            // $booking->apartment_type_id = $request->apartment_type_id;
            // $booking->apartment_type_id = 0;
            $booking->latitude = $request->latitude;
            $booking->longitude = $request->longitude;
            $booking->survey_charge = Service::find($request->service_id)->survey_charge;
            $booking->survey_charge_payment_mode = $request->payment_mode;
            $booking->survey_charge_payment_status = $request->payment_mode == 'offline'? 'Unpaid' : 'Paid';
            $booking->verification_otp = generateOTP();
            $res = $booking->save();

            if($res){
                return response()->json(['status' => 'true','message' => 'Service Booked Successfully']);
            }else{
                return response()->json(['status' => 'false','message' => 'Service Not Booked, Try Again Later!']);
            }
        }
    }

    public function get_booked_service(Request $request){
        $booking = ServiceBook::where('user_id', $request->user()->id)
                ->orderBy('id', 'desc')
                ->get();

        if($booking){
            return response()->json([
                'status' => 'true',
                'data' => $booking
            ]);
        }else{
            return response()->json([
                'status' => 'false',
                'massage' => 'Not have any booked service'
            ]);
        }
    }

    public function cancel_booked_service(Request $request){
        $validator = Validator::make($request->all(), [
            'booking_id' => 'required|numeric|exists:service_books,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }else{
            $booking = ServiceBook::where('user_id',$request->user()->id)
                                    ->where('id',$request->booking_id)
                                    ->first();
            if($booking){
                $booking->status = 'cancelled';
                $res = $booking->update();
                if($res){
                    return response()->json([
                        'status' => 'true',
                        'massage' => 'Booking Cancelled Successfully',
                        'data' => $booking
                    ]);
                }else{
                    return response()->json([
                        'status' => 'false',
                        'massage' => 'Booking Not Cancelled',
                        'data' => $booking
                    ]);
                }
            }else{
                return response()->json([
                    'status' => 'false',
                    'massage' => 'Booking Not Found',
                ]);
            }
        }
    }
}