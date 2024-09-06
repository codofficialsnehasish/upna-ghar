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
                    <div class="col-md-4">
                        <div class="float-end d-none d-md-block">
                            <div class="dropdown">
                                <a href="{{ route('booking.index') }}" class="btn btn-primary  dropdown-toggle" aria-expanded="false">
                                    <i class="fas fa-arrow-left me-2"></i> Back
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-primary text-light text-center">Service : {{ $service->name }}</div>
                        <div class="card-body">
                            <div class="row">
                                <!-- First Column -->
                                <div class="mt-4 col-md-6">
                                    <table class="table mb-0">
                                        <tbody>
                                            @php
                                                $half = ceil(count($form_responses) / 2); // Calculate the halfway point
                                            @endphp
                                            @foreach($form_responses->slice(0, $half) as $form_response)
                                            <tr>
                                                <td><span>{{ $form_response->label_name }}</span></td>
                                                <td class="text-end">{{ $form_response->value }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Second Column -->
                                <div class="mt-4 col-md-6">
                                    <table class="table mb-0">
                                        <tbody>
                                            @foreach($form_responses->slice($half) as $form_response)
                                            <tr>
                                                <td><span>{{ $form_response->label_name }}</span></td>
                                                <td class="text-end">{{ $form_response->value }}</td>
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
    </div>

    @include("admin.dash.footer")