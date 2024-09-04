<!-- adding header -->
@include("dash/header")
<!-- end header -->

            <!-- ========== Left Sidebar Start ========== -->
            @include("dash/left_side_bar")
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
                                    <h6 class="page-title">Slider</h6>
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Supersathi</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">All Slider</li>
                                    </ol>
                                </div>
                                <div class="col-md-4">
                                    <div class="float-end d-none d-md-block">
                                        <div class="dropdown">
                                            <a href="{{url('/slideradd')}}" class="btn btn-primary  dropdown-toggle" aria-expanded="false">
                                                <i class="fas fa-plus me-2"></i> Add New
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        
                        <!-- show data -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body table-responsive">
                                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Sl No.</th>
                                                    <th>Title</th>
                                                    <th>Image</th>
                                                    <th>Visibility</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $i = 1 @endphp
                                                @foreach($slider as $s)
                                                <tr>
                                                    <td>@php echo $i++ @endphp</td>
                                                    <td>{{$s->title}}</td>
                                                    <td>
                                                        @if($s->image == "Not provided") 
                                                            {{$s->image}} 
                                                        @else
                                                            <img src="{{'files/slider_images'}}/{{$s->image}}" width="50">
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($s->is_visible==1)
                                                            <span class="btn btn-success btn-sm"><i class="fas fa-eye" data-bs-toggle="tooltip" data-bs-placement="top" title="Visible"></i></span>
                                                        @else
                                                            <span class="btn btn-danger btn-sm"><i class="fas fa-eye-slash" data-bs-toggle="tooltip" data-bs-placement="top" title="Not Visible"></i></span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-success mr-2" href="{{url('/slideredit')}}/{{$s->id}}" alt="edit"><i class="ti-check-box"></i></a>
                                                        <a class="btn btn-danger" onclick="return confirm('Are you sure?')" href="{{url('/slider_del')}}/{{$s->id}}"><i class="ti-trash"></i></a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div>
                        <!-- end show data -->
                        
                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->


                
                @include("dash/footer")