<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceBook;
use App\Models\User; 
use App\Models\FormResponse; 
use App\Models\Service;

class Bookings extends Controller
{
    public function __construct(){
        $this->view_path = 'admin.bookings.';
    }

    public function index()
    {
        $data['title'] = 'Bookings';
        $data['bookings'] = ServiceBook::all();
        $data['workers'] = User::where('role','worker')->get();
        return view($this->view_path.'index')->with($data);
    }

    public function today_bookings()
    {
        $data['title'] = 'Today Bookings';
        $data['bookings'] = ServiceBook::whereDate('created_at',date('Y-m-d'))->get();
        $data['workers'] = User::where('role','worker')->get();
        return view($this->view_path.'today_bookings')->with($data);
    }

    public function update_booking_status(Request $request)
    {
        $book = ServiceBook::find($request->bookingid);
        if($request->status == 0){
            $book->status = 'rejected';
        }
        if($request->status == 1){
            $book->status = 'approved';
            $book->allotted_worker_id = $request->worker;
        }
        $res = $book->update();
        if($res){
            return redirect()->back()->with(['success'=>'Booking status updated successfully']);
        }else{
            return redirect()->back()->with(['error'=>'Booking status not updated']);
        }
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        $book = ServiceBook::find($id);
        $res = $book->delete();
        if($res){
            return redirect()->back()->with(['success'=>'Booking Deleted Successfully']);
        }else{
            return redirect()->back()->with(['error'=>'Booking Not Deleted']);
        }
    }


    public function show_submitted_details_by_worker(string $id){
        $data['title'] = 'Submitted Details';
        $booking = ServiceBook::find($id);
        $data['booking'] = $booking;
        $data['service'] = Service::find($booking->service_id);
        $data['form_responses'] = FormResponse::where('booking_id',$id)->get();
        return view($this->view_path.'submit_forms_details')->with($data);
    }
}
