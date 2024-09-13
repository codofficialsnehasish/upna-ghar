<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\City;
use App\Models\State;
use App\Models\Country;

class Locations extends Controller
{
    public function get_states($country_id){
        $states = State::get_states_by_country($country_id);
        return response()->json([
            "status" => "true",
            "data" => $states
        ]);
    }

    public function get_cities($state_id){
        $cities = City::get_city_by_states($state_id);
        return response()->json([
            "status" => "true",
            "data" => $cities
        ]);
    }
}