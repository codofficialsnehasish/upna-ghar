<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\User;
use App\Models\Otp;
use App\Models\City;
use App\Models\State;
use App\Models\ServiceType;

class AuthenticationController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|digits:10|regex:/^[6789]/',
            'login_type' => 'required|in:user,worker',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }else{
            
            $user = User::where('phone', $request->phone_number)->first();

            // Check if the user exists
            if ($user) {
                if($user->role == $request->login_type){
                    if ($request->otp) {
                        return $this->verifyOTP($request);
                    } else {
                        return $this->sendNewOTP($user->phone);
                    }
                }else{
                    return response()->json(['status' => 'false','message' => 'This user not exists in this role.'], 401);
                }
            } else {
                // New user, need to register first or check OTP
                if ($request->otp) {
                    return response()->json(['status' => 'false','message' => 'Unauthorized: Please register your account.'], 401);
                } else {
                    return $this->register($request->phone_number,$request->login_type);
                }
            }
        }
    }

    protected function verifyOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|digits:10|regex:/^[6789]/',
            'otp' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user = User::where('phone', $request->phone_number)->first();

        if (!$user) {
            return response()->json(['status' => 'false','message' => 'Please register your account.'], 401);
        }

        // If User exists then verify OTP
        $otp = Otp::where('user_id', $user->id)->latest()->first();

        if(!$otp || $otp->otp != $request->otp){
            return response()->json(['status' => 'false','message' => 'Invalid OTP'], 401);
        }

        // Check if token matches
        $token = $user->token;
        if (!$token) {
            return response()->json(['status' => 'false','message' => 'Token not found'], 401);
        }

        // Token is valid, proceed with login
        $otpCreatedAt = Carbon::parse($otp->created_at);
        $currentTime = Carbon::now(); 
        $otpValidityDuration = 5; // OTP valid for 5 minute

        if ($otpCreatedAt->diffInMinutes($currentTime) > $otpValidityDuration) {
            return response()->json(['status' => 'false','message' => 'OTP has expired.'], 401);
        }

        return response()->json([
            'status' => 'true',
            'message' => 'Login successful', 
            'token' => $token,
            'user'=>$user
        ]);
    }

    protected function register($phoneNumber,$login_type)
    {
        // Check if user with this phone number already exists
        $existingUser = User::where('phone', $phoneNumber)->first();
        if ($existingUser) {
            return response()->json(['status' => 'false','message' => 'User already exists.'], 400);
        }
    
        // Generate OTP
        $user = User::create(['phone' => $phoneNumber,'role' => $login_type]);
        // $otp = rand(1000, 9999); // Random OTP
        $otp = 1234; // Dummy OTP, change it when in development
        $token = $user->createToken('AuthToken')->plainTextToken; // Generate new token
        $user->update(['token' => $token]); // Store token in user table
        Otp::create(['user_id' => $user->id, 'otp' => $otp, 'created_at' => now()]);
    
        return response()->json([
            'status' => 'true',
            'message' => 'Your account has been created.',
            'sent' => 'OTP sent to your phone number.',
            'note' => 'OTP is valid for 5 minute.',
            // 'token' => $token,
        ]);
    }
    

    protected function sendNewOTP($phoneNumber)
    {
        // Generate new OTP for existing user
        // $otp = rand(1000, 9999);
        $otp = 1234;
        $user = User::where('phone', $phoneNumber)->first();
        $user->tokens()->delete(); // Delete existing tokens
        $token = $user->createToken('AuthToken')->plainTextToken; // Generate new Token
        Otp::where('user_id', $user->id)->update(['otp' => $otp, 'created_at' => now()]);
        $user->update(['token' => $token]); // Update token in user table
    
        return response()->json([
            'status' => 'true',
            'message' => 'New OTP generated successfully.',
            'sent' => 'An OTP has been sent to your phone number.',
            'note' => 'OTP is valid for 1 minute.',
            // 'token' => $token, // Send updated token in the response
        ]);
    }

    public function update_profile(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }else{
            $user = User::find($request->user()->id);
            $user->name = $request->name;
            if($user->email != $request->email){
                $user->email = $request->email;
            }
            $user->work_expereince = $request->work_expereince;
            $user->type_of_service = implode(',',$request->type_of_service);
            $user->street_address = $request->street_address;
            $user->nearby_landmark = $request->nearby_landmark;
            $user->state = $request->state;
            $user->city = $request->city;
            $user->pin_code = $request->pin_code;

            if ($request->has('user_image') && !empty($request->input('user_image'))) {
                $base64Image = $request->input('user_image');
                $decodedImage = base64_decode($base64Image);
                if ($decodedImage !== false) {
                    $filename = uniqid() . '.png';
                    $directory = public_path('web_directory/user_images');
                    $filePath = $directory . '/' . $filename;
                    file_put_contents($filePath, $decodedImage);
                    $filePath = "web_directory/user_images/".$filename;
                    $user->user_image = $filePath;
                }
            }
            

            if ($request->has('document') && !empty($request->input('document'))) {
                $base64Image = $request->input('document');
                $decodedImage = base64_decode($base64Image);
                if ($decodedImage !== false) {
                    $filename = uniqid() . '.png';
                    $directory = public_path('web_directory/user_documents');
                    $filePath = $directory . '/' . $filename;
                    file_put_contents($filePath, $decodedImage);
                    $filePath = "web_directory/user_documents/".$filename;
                    $user->document = $filePath;
                }
            }

            $res = $user->update();

            $serviceIds = explode(',', $user->type_of_service);
            $serviceNames = [];

            // Loop through each ID and fetch the service name
            foreach ($serviceIds as $id) {
                $serviceNames[] = ServiceType::get_service_type_name($id);
            }

            $extraData = [
                'state_name' => State::get_state_name($user->state),
                'city_name' => City::get_city_name($user->city),
                'service_types' => $serviceNames
            ];
            if($res){
                return response()->json([
                    'status' => 'true',
                    'message' => 'Profile Updated Succesfully',
                    'data' => array_merge($user->toArray(), $extraData)
                ]);
            }else{
                return response()->json([
                    'status' => 'false',
                    'message' => 'Profile Not Updated, Please Try Again',
                    'data' => $user
                ]);
            }
        }
    }


    public function get_user_data(Request $request){
        return $request->user();
    }
}
