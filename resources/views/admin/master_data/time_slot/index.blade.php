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
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                        </ol>
                    </div>
                    <div class="col-md-4">
                        <div class="float-end d-none d-md-block">
                            <div class="dropdown">
                                <a href="{{ route('time-slot.create') }}" class="btn btn-primary  dropdown-toggle" aria-expanded="false">
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
                                        <th class="text-wrap">Start Time</th>
                                        <th class="text-wrap">End Time</th>
                                        <th class="text-wrap">Visibility</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($types as $type)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>   
                                        <td>{{ formated_time($type->start_time) }}</td>
                                        <td>{{ formated_time($type->end_time) }}</td>
                                        <td>{!! check_visibility($type->visibility) !!}</td>
                                        <td>
                                            <a class="btn btn-primary" href="{{ route('time-slot.edit',$type->id) }}" alt="edit"><i class="ti-check-box"></i></a>
                                            <form action="{{ route('time-slot.destroy', $type->id) }}" onsubmit="return confirm('Are Your Sure?')" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger" type="submit"><i class="ti-trash"></i></button>
                                            </form>
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