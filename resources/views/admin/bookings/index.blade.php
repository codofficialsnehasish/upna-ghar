<!-- adding header -->
@include("admin.dash.header")
<!-- end header -->

<!-- ========== Left Sidebar Start ========== -->
@include("admin.dash.left_side_bar")
<!-- Left Sidebar End -->

<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h6 class="page-title">{{ $title }}</h6>
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                        </ol>
                    </div>
                    <!-- <div class="col-md-4">
                        <div class="float-end d-none d-md-block">
                            <div class="dropdown">
                                <a href="{{ route('service.create') }}" class="btn btn-primary  dropdown-toggle" aria-expanded="false">
                                    <i class="fas fa-plus me-2"></i> Add New
                                </a>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th class="text-wrap">SL No</th>
                                        <th class="text-wrap">Status</th>
                                        <th class="text-wrap">Booking Details</th>
                                        <th class="text-wrap">Survey Details</th>
                                        <!-- <th class="text-wrap">User Name</th>
                                        <th class="text-wrap">Service Name</th>
                                        <th class="text-wrap">Apartment Type</th>
                                        <th class="text-wrap">Visit Time</th>
                                        <th class="text-wrap">Visit Date</th> -->
                                        <th class="text-wrap">Survey Charge</th>
                                        <th class="text-wrap">Payment Mode</th>
                                        <th class="text-wrap">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bookings as $booking)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>   
                                        <td>
                                            @if($booking->status == 'pending')
                                            <button class="btn btn-warning btn-sm"><b>{{ ucfirst($booking->status) }}</b></button>
                                            @elseif($booking->status == 'approved')
                                            <button class="btn btn-success btn-sm"><b>{{ ucfirst($booking->status) }}</b></button>
                                            @elseif($booking->status == 'rejected')
                                            <button class="btn btn-danger btn-sm"><b>{{ ucfirst($booking->status) }}</b></button>
                                            @elseif($booking->status == 'cancelled')
                                            <button class="btn btn-danger btn-sm"><b>{{ ucfirst($booking->status) }}</b></button>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="">
                                                <strong>Name : </strong>{{ $booking->user->name }} <br>
                                                <strong>Contact : </strong>{{ $booking->user->phone }} <br>
                                                <strong>Service : </strong>{{ $booking->service->name }} <br>
                                                <strong>Apartment : </strong>{{ get_name('apartment_types',$booking->apartment_type_id) }} <br>
                                                <strong>Timing : </strong>{{ get_time_slots($booking->time_slot_id) }} <br>
                                                <strong>Date : </strong>{{ $booking->visit_date }} <br>
                                            </div>
                                        </td>
                                        <td>
                                            @if($booking->status == 'approved')
                                            <div class="">
                                                <strong>Worker Name : </strong>{{ get_name('users',$booking->allotted_worker_id) }} <br>
                                                <strong>Contact : </strong>{{ get_user_phone($booking->allotted_worker_id) }} <br>
                                            </div>
                                            @endif
                                        </td>
                                        {{--<td class="text-wrap">{{ $booking->user->name }}</td>
                                        <td class="text-wrap">{{ $booking->service->name }}</td>
                                        <td class="text-wrap">{{ get_name('apartment_types',$booking->apartment_type_id) }}</td>
                                        <td class="text-wrap">{{ get_time_slots($booking->time_slot_id) }}</td>
                                        <td class="text-wrap">{{ $booking->visit_date }}</td> --}}

                                        <td class="text-wrap">{{ $booking->survey_charge }}</td>
                                        <td class="text-wrap">{{ ucfirst($booking->survey_charge_payment_mode) }} ({{ $booking->survey_charge_payment_status }})</td>
                                        <td>
                                            @if($booking->status != 'approved')
                                            <a class="btn btn-secondary" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#staticBackdrop{{$booking->id}}"><i class="far fa-check-circle"></i></a>
                                            @endif
                                            @if($booking->status != 'rejected')
                                            <a class="btn btn-secondary" onclick="return confirm('Are You Sure?')" href="{{ route('booking.update-booking-status',['bookingid'=>$booking->id,'status'=>0]) }}"><i class="fas fa-ban"></i></a>
                                            @endif
                                            <a class="btn btn-secondary" onclick="return confirm('Are You Sure?')" href="{{ route('booking.destroy',$booking->id) }}"><i class="ti-trash"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @foreach($bookings as $booking)
    <div class="modal fade" id="staticBackdrop{{$booking->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Approve Service Request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('booking.update-booking-status') }}" method="get">
                <input type="hidden" value="{{ $booking->id }}" name="bookingid">
                <input type="hidden" value="1" name="status">
                <div class="modal-body">
                    <div class="mb-3 col-md-12">
                        <label class="form-label">Choose Time Slot</label>
                        <select class="form-control" required name="worker">
                            <option value selected disabled>Choose...</option>
                            @foreach($workers as $worker)
                            <option value="{{ $worker->id }}">{{ $worker->name }} - {{ ($worker->phone) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Process</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

    @include("admin.dash.footer")