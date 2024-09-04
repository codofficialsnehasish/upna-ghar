<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Service;
use App\Models\ServiceBook;

class Dashboard extends Controller
{
    public function dashboard(){
        $data['title'] = 'Dashboard';
        $data['total_users'] = User::where('role','user')->count();
        $data['total_workers'] = User::where('role','worker')->count();
        $data['total_services'] = Service::all()->count();
        $data['today_bookings'] = ServiceBook::whereDate('created_at',date('Y-m-d'))->count();
        $data['today_survey_appointments'] = ServiceBook::where('visit_date',date('Y-m-d'))->where('status','approved')->get();
        return view("admin/dashboard")->with($data);
    }
}