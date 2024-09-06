<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Http\Controllers\API\ServicesApiController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\ServiceBook;
use App\Models\FormResponse;

class WorkerController extends Controller
{
    public function get_assign_services(Request $request){
        $servicesApiController = new ServicesApiController();

        $booked_services = ServiceBook::where('allotted_worker_id',$request->user()->id)
                        ->where('status','approved')
                        ->where('visit_date',date('Y-m-d'))
                        ->get()
                        ->map(function ($item) use ($servicesApiController) {
                            $item->service_details = json_decode($servicesApiController->service_details($item->service_id)->getContent(), true);
                            return $item;
                        });
        return response()->json([
            'status' => 'true',
            'data' => $booked_services
        ]);
    }

    public function verify_service_otp(Request $request){
        $validator = Validator::make($request->all(), [
            'service_booking_id' => 'required|numeric|exists:service_books,id',
            'otp' => 'required|digits:4',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }else{
            $service_book = ServiceBook::find($request->service_booking_id);
            if($service_book->verification_otp == $request->otp){
                $service_book->is_verified = 1;
                $service_book->verification_time = now();
                $service_book->update();
                
                return response()->json([
                    'status' => 'true',
                    'massage' => 'OTP Verified Successfully'
                ],200);
            }else{
                return response()->json([
                    'status' => 'true',
                    'massage' => 'Incorrect OTP'
                ],401);
            }
        }
    }

    public function submit_requirement_form(Request $request){
        $data = $request->validate([
            'booking_id' => 'required|integer|exists:service_books,id',
            'fields' => 'required|array',
            'fields.*.label_name' => 'required|string',
            'fields.*.value' => 'required'
        ]);
        // return $request->fields;
        foreach ($data['fields'] as $field) {
            FormResponse::create([
                'booking_id' => $data['booking_id'],
                'label_name' => $field['label_name'],
                'value' => is_array($field['value']) ? implode(', ', $field['value']) : $field['value'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return response()->json([
            'status' => 'true',
            'massage' => 'Form Submit Successfully'
        ]);
    }
}