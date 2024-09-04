<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\ServiceBook;

class WorkerController extends Controller
{
    public function get_assign_services(Request $request){
        $booked_services = ServiceBook::where('allotted_worker_id',$request->user()->id)
                        ->where('status','approved')->get();
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
}