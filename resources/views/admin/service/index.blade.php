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
                                <a href="{{ route('service.basic-info') }}" class="btn btn-primary  dropdown-toggle" aria-expanded="false">
                                    <i class="fas fa-plus me-2"></i> Add New
                                </a>
                            </div>
                        </div>
                    </div>
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
                                        <th class="text-wrap">Name</th>
                                        <th class="text-wrap">Categories</th>
                                        <th class="text-wrap">Starting Price</th>
                                        <th class="text-wrap">Image</th>
                                        <th class="text-wrap">Visibility</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($services as $service)
                                    <tr>
                                        <td class="text-wrap">{{ $loop->iteration }}</td>   
                                        <td class="text-wrap">{{ $service->name }}</td>
                                        <td class="text-wrap"> @foreach($service->categories as $cata) {{ $cata->name.' / ' }} @endforeach</td>
                                        <td class="text-wrap">₹ {{ $service->price }} {{ get_name('payment_types',$service->price_type_id) }}</td>
                                        <td class="text-wrap"><img src="{{ asset($service->main_image) }}" alt="" width="60px"></td>
                                        <td class="text-wrap">{!! check_visibility($service->visibility) !!}</td>
                                        <td>
                                            <a class="btn btn-primary" href="{{ route('service.edit-basic-info',$service->id) }}" alt="edit"><i class="ti-check-box"></i></a>
                                            <a class="btn btn-danger" onclick="return confirm('Are You Sure?')" href="{{ route('service.delete',$service->id) }}"><i class="ti-trash"></i></a>
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
    @include("admin.dash.footer")