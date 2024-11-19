<!-- adding header -->
@include("admin/dash/header")
<!-- end header -->

    <!-- ========== Left Sidebar Start ========== -->
    @include("admin/dash/left_side_bar")
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
                <form action="{{ route('service.basic-info-store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <!-- Nav tabs -->
                                @include('admin.service.nav-tabs')

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div class="tab-pane active p-3" id="basicinfo" role="tabpanel">
                                        <div class="card-body row">
                                            <div class="row">
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label">Name</label>
                                                    <div>
                                                        <input data-parsley-type="text" type="text" class="form-control" required placeholder="Enter Service Title" name="name">
                                                    </div>
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="service_type" class="form-label">Service Type</label>
                                                    <select class="form-select" id="service_type" name="service_types">
                                                        {{-- <option selected disabled value="">Choose...</option> --}}
                                                        <option selected value="directBooking">Direct Booking</option>
                                                        <option value="surveyRequired">Survey Required</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Please select a valid state.
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header bg-primary text-light">
                                <div class="d-flex flex-wrap">
                                    <span class="me-2">Category</span>
                                    {{-- <a class="fw-bold fs-9 text-white" type="button" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                                        <i class="fas fa-plus-circle"></i>
                                    </a> --}}
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="category-tree" style="max-height: 300px; overflow-y: auto; border: 1px solid #ddd; padding: 10px;">
                                    @if (!empty($categorys))
                                        @foreach ($categorys as $category)
                                            <!-- Only display top-level categories -->
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $category->id }}" id="category{{ $category->id }}" {{ isset($selectedCategories) && in_array($category->id, $selectedCategories) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="category{{ $category->id }}"> {{ $category->name }} </label>
                                            </div>
                                            @include('admin.service.subcategory', [
                                                'subcategories' => $category->children,
                                                'parent_id' => $category->id,
                                                'margin' => 20,
                                                'selectedCategories' => isset($selectedCategories) ? $selectedCategories : [],
                                            ])
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
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

@include("admin/dash/footer")