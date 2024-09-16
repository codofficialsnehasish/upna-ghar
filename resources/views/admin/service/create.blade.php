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
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('service.index') }}">{{ $title }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Add New {{ $title }}</li>
                            </ol>
                        </div>
                        <div class="col-md-4">
                            <div class="float-end d-none d-md-block">
                                <div class="dropdown">
                                    <a href="{{ route('service.index') }}" class="btn btn-primary  dropdown-toggle" aria-expanded="false">
                                        <i class="fas fa-arrow-left me-2"></i> Back
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <form class="custom-validation outer-repeater" action="{{ route('service.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="card">
                                <div class="card-header bg-primary text-light">
                                    Add New Service
                                </div>
                                <div class="card-body row">
                                    <div class="row">
                                        {{--<div class="col-md-4">
                                            <label for="parent_service" class="form-label">Parent Service</label>
                                            <select class="form-select" id="parent_service" name="parent_service">
                                                <option selected disabled value="">Choose...</option>
                                                @foreach($parents as $parent)
                                                <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                Please select a valid state.
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="sub_parent_service" class="form-label">Sub Parent Service</label>
                                            <select class="form-select" id="sub_parent_service" name="sub_parent_service">
                                                <option selected disabled value="">Choose...</option>
                                                @foreach($sub_parents as $sub_parent)
                                                <option value="{{ $sub_parent->id }}">{{ $sub_parent->name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                Please select a valid state.
                                            </div>
                                        </div>--}}
                                        <div class="mb-3 col-md-12">
                                            <label class="form-label">Name</label>
                                            <div>
                                                <input data-parsley-type="text" type="text" class="form-control" required placeholder="Enter Service Title" name="name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label">Description</label>
                                        <div>
                                            <textarea class="editor" name="description"></textarea>
                                        </div>    
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label">Choose Time Slot</label>
                                        <select class="select2 form-control select2-multiple" required name="time_slot[]" multiple="multiple" multiple data-placeholder="Choose ...">
                                            @foreach($time_slot as $slot)
                                            <option value="{{ $slot->id }}">{{ formated_time($slot->start_time) }} - {{ formated_time($slot->end_time) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label">Choose Form Template</label>
                                        <select class="form-control" required name="template">
                                            <option value selected disabled>Choose...</option>
                                            @foreach($form_templates as $form_template)
                                            <option value="{{ $form_template->id }}">{{ $form_template->template_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div data-repeater-list="outer-group" class="outer">
                                        <div data-repeater-item class="outer">
                                            <div class="inner-repeater mb-4">
                                                <div data-repeater-list="work-process" class="inner mb-3">
                                                    <label class="form-label">Work Process</label>
                                                    <div data-repeater-item class="inner mb-3 row">
                                                        <div class="mb-3 col-md-5">
                                                            <div>
                                                                <input data-parsley-type="text" type="text" class="form-control" placeholder="Enter Title" name="title">
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 col-md-6">
                                                            <div>
                                                                <input data-parsley-type="text" type="text" class="form-control" placeholder="Enter Description" name="desc">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1 col-sm-1">
                                                            <div class="d-grid">
                                                                <button data-repeater-delete type="button" class="btn btn-danger inner mt-2 mt-sm-0"><i class="fas fa-trash-alt"></i></button>
                                                            </div>    
                                                        </div>
                                                    </div>
                                                </div>
                                                <button data-repeater-create type="button" class="btn btn-success inner" value="Add Number"><i class="far fa-plus-square"></i></button>
                                            </div>
                                            <div class="inner-repeater mb-4">
                                                <div data-repeater-list="promice-group" class="inner mb-3">
                                                    <label class="form-label">Promice :</label>
                                                    <div data-repeater-item class="inner mb-3 row">
                                                        <div class="col-md-10 col-sm-8">
                                                            <input type="text" class="inner form-control" name="promicedata" placeholder="Enter promice..."/>
                                                        </div>
                                                        <div class="col-md-2 col-sm-4">
                                                            <div class="d-grid">
                                                                <input data-repeater-delete type="button" class="btn btn-danger inner mt-2 mt-sm-0" value="Delete"/>
                                                            </div>    
                                                        </div>
                                                    </div>
                                                </div>
                                                <input data-repeater-create type="button" class="btn btn-success inner" value="Add Promice"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="card">
                                <div class="card-header bg-primary text-light">
                                    Service Main Image
                                </div>
                                <div class="card-body text-center">
                                    <div class="mb-0">
                                        <img class="img-thumbnail rounded me-2" id="blah" alt="" width="200" src="" data-holder-rendered="true" style="display: none;">
                                    </div>
                                    <div class="mb-0">
                                        <input type="file" name="service_image" class="filestyle" id="imgInp" data-input="false" data-buttonname="btn-secondary">
                                    </div> 
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header bg-primary text-light">
                                    Service Pricing
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Price</label>
                                        <div>
                                            <input data-parsley-type="number" type="number" class="form-control" placeholder="Enter Price" name="price">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="pricetype" class="form-label">Price Type</label>
                                        <select class="form-select" id="pricetype" name="price_type">
                                            <option selected disabled value="">Choose...</option>
                                            @foreach($payment_type as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            Please select a valid state.
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="pricetype" class="form-label">Service Type</label>
                                        <select class="form-select" id="servicetype" name="service_type">
                                            <option selected disabled value="">Choose...</option>
                                            @foreach($service_type as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            Please select a valid state.
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Survey Charge</label>
                                        <div>
                                            <input data-parsley-type="number" type="number" class="form-control" placeholder="Enter Charge" name="survey_charge">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header bg-primary text-light">
                                    Service Video & Images
                                </div>
                                <div class="card-body text-center">
                                    <div class="mb-3 row" id="imageContainer">
                                    </div>
                                    <div class="mb-3">
                                        <input type="file" name="service_media[]" class="filestyle" id="fileInput" data-buttonname="btn-secondary" multiple>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header bg-primary text-light">
                                    Publish
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label mb-3 d-flex">Visiblity</label>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" id="customRadioInline1" name="is_visible" class="form-check-input" value="1" checked>
                                            <label class="form-check-label" for="customRadioInline1">Show</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" id="customRadioInline2" name="is_visible" class="form-check-input" value="0">
                                            <label class="form-check-label" for="customRadioInline2">Hide</label>
                                        </div>
                                    </div>
                                    <div class="mb-0">
                                        <div>
                                            <button type="submit" class="btn btn-primary waves-effect waves-light me-1">
                                                Save & Next
                                            </button>
                                            <button type="reset" class="btn btn-secondary waves-effect">
                                                Cancel
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @section('script')
    <!-- <script>
        $('#fileInput').on('change', function(){
            var files = $(this)[0].files;
            var imageContainer = $('#imageContainer');
            imageContainer.empty(); // Clear previous images

            for(var i = 0; i < files.length; i++){
                var reader = new FileReader();
                reader.onload = function(event){
                    imageContainer.append('<div class="col-sm-6"><img src="' + event.target.result + '" style="width:50px;" class="" alt=""></div>');
                };
                reader.readAsDataURL(files[i]);
            }
        });
    </script> -->
    <script>
        $('#fileInput').on('change', function(){
            var files = $(this)[0].files;
            var mediaContainer = $('#imageContainer');
            mediaContainer.empty(); // Clear previous media

            for(let i = 0; i < files.length; i++){
                let file = files[i]; // Use let to create a new variable scope
                var reader = new FileReader();
                
                reader.onload = function(event){
                    var fileType = file.type.split('/')[0]; // Get the file type (image/video)

                    if(fileType === 'image') {
                        mediaContainer.append('<div class="col-sm-6"><img src="' + event.target.result + '" style="width:50px;" alt=""></div>');
                    } else if(fileType === 'video') {
                        mediaContainer.append('<div class="col-sm-6"><video src="' + event.target.result + '" style="width:50px;" controls></video></div>');
                    }
                };

                reader.readAsDataURL(file);
            }
        });
    </script>
    <script>
        $("#parent_service").on('change', function(){ 
            $("#sub_parent_service").html('');
            const parent_id = $(this).val();
            $.ajax({
                url : "{{ route('service.get-sub-parent') }}",
                data:{id : parent_id, _token:"{{ csrf_token() }}" },
                method:'post',
                dataType:'json',
                beforeSend: function(){
                    $('#sub_parent_service').html('<option value="">Loading...</option>'); 
                    },
                success:function(response) {
                    $("#sub_parent_service").html('');
                    $("#sub_parent_service").append('<option value="">Select...</option>');
                    $.each(response , function(index, item) {
                        $("#sub_parent_service").append('<option value="'+item.id+'">'+item.name+'</option>');
                    });
                }
            });
        });
    </script>
    <script>
        $(".select2").select2({
            tags: true
        });
    </script>
    @endsection
@include("admin.dash.footer")