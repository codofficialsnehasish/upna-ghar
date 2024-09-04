<!-- adding header -->
@include("admin/dash/header")
<!-- end header -->

            <!-- ========== Left Sidebar Start ========== -->
            @include("admin/dash/left_side_bar")
            <!-- Left Sidebar End -->

            

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="page-title-box">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h6 class="page-title">Dashboard</h6>
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item active">Welcome to {{ app_name() }} Dashboard</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card mini-stat bg-primary text-white">
                                    <a href="{{ route('users') }}">
                                        <div class="card-body">
                                            <div class="mb-4">
                                                <div class="float-start mini-stat-img me-4">
                                                    <img src="{{ asset('dashboard_assets/images/services-icon/23.png') }}" alt="">
                                                </div>
                                                <h5 class="font-size-16 text-uppercase text-white-50">Total Users</h5>
                                                <h4 class="fw-medium font-size-24" style="color:white;">{{ $total_users }}</h4>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card mini-stat bg-primary text-white">
                                    <a href="{{ route('workers') }}">
                                        <div class="card-body">
                                            <div class="mb-4">
                                                <div class="float-start mini-stat-img me-4">
                                                    <img src="{{ asset('dashboard_assets/images/services-icon/24.png') }}" alt="">
                                                </div>
                                                <h5 class="font-size-16 text-uppercase text-white-50">Total Workers</h5>
                                                <h4 class="fw-medium font-size-24" style="color:white;">{{ $total_workers }}</h4>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card mini-stat bg-primary text-white">
                                    <a href="{{ route('service.index') }}">
                                        <div class="card-body">
                                            <div class="mb-4">
                                                <div class="float-start mini-stat-img me-4">
                                                    <img src="{{ asset('dashboard_assets/images/services-icon/26.png') }}" alt="">
                                                </div>
                                                <h5 class="font-size-16 text-uppercase text-white-50">Total Services</h5>
                                                <h4 class="fw-medium font-size-24" style="color:white;">{{ $total_services }}</h4>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card mini-stat bg-primary text-white">
                                    <a href="{{ route('booking.today-bookings') }}">
                                        <div class="card-body">
                                            <div class="mb-4">
                                                <div class="float-start mini-stat-img me-4">
                                                    <img src="{{ asset('dashboard_assets/images/services-icon/27.png') }}" alt="">
                                                </div>
                                                <h5 class="font-size-16 text-uppercase text-white-50" style="font-size: 15px !important;">Today Bookings</h5>
                                                <h4 class="fw-medium font-size-24" style="color:white;">{{ $today_bookings }}</h4>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Today's Survey Appointments</h4>
                                        <div class="table-responsive">
                                            <table class="table table-hover table-centered table-nowrap mb-0">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">SL.No</th>
                                                        <th scope="col">Customer Name</th>
                                                        <th scope="col">Worker Name</th>
                                                        <th scope="col">Visiting Time</th>
                                                        <th scope="col">Survey Charge</th>
                                                        <th scope="col">Payment</th>
                                                        <th scope="col">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($today_survey_appointments as $appointment)
                                                    <tr>
                                                        <th scope="row">{{ $loop->iteration }}</th>
                                                        <td>
                                                            <div>
                                                                @if(!empty($appointment->user->user_image))
                                                                <img src="{{ asset($appointment->user->user_image) }}" alt="" class="avatar-xs rounded-circle me-2"> 
                                                                @endif
                                                                {{ $appointment->user->name }}
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div>
                                                                @if(!empty(get_user_profile_pic($appointment->allotted_worker_id)))
                                                                <img src="assets/images/users/user-2.jpg" alt="" class="avatar-xs rounded-circle me-2"> 
                                                                @endif
                                                                {{ get_name('users',$appointment->allotted_worker_id) }}
                                                            </div>
                                                        </td>
                                                        <td>{{ get_time_slots($appointment->time_slot_id) }}</td>
                                                        <td>₹ {{ $appointment->survey_charge }}</td>
                                                        <td>{{ ucfirst($appointment->survey_charge_payment_mode) }} ({{ $appointment->survey_charge_payment_status }})</td>
                                                        <td><span class="badge bg-danger">Not Check In</span></td>
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
                </div>
                <!-- End Page-content -->

                
                @include("admin/dash/footer")