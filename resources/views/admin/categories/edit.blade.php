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
                                <li class="breadcrumb-item active" aria-current="page">Edit {{ $title }}</li>
                            </ol>
                        </div>
                        <div class="col-md-4">
                            <div class="float-end d-none d-md-block">
                                <div class="dropdown">
                                    <a href="{{ route('category.index') }}" class="btn btn-primary  dropdown-toggle" aria-expanded="false">
                                        <i class="fas fa-arrow-left me-2"></i> Back
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <form class="custom-validation outer-repeater" action="{{ route('category.update',$cate->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="card">
                                <div class="card-header bg-primary text-light">
                                    Edit {{ $title }}
                                </div>
                                <div class="card-body row">
                                    <div class="row">
                                        <div class="mb-3 col-md-12">
                                            <label class="form-label">Name</label>
                                            <div>
                                                <input data-parsley-type="text" type="text" class="form-control" required  name="name" value="{{ $cate->name }}">
                                            </div>
                                        </div>
                                        {{-- <div class="mb-3 col-md-6">
                                            <label class="form-label">Slug</label>
                                            <div>
                                                <input data-parsley-type="text" type="text" class="form-control" required  name="slug" value="{{ $cate->slug }}">
                                            </div>
                                        </div> --}}
                                        <div class="col-md-12 mb-3">
                                            <label for="parent_id" class="form-label">Parent Category</label>
                                            <select class="form-select" id="parent_id" name="parent_id">
                                                <option selected disabled value="">Choose...</option>
                                                @foreach($categorys as $category)
                                                <option @if($cate->parent_id == $category->id) selected @endif value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                Please select a valid category.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label">Description</label>
                                        <div>
                                            <textarea class="editor" name="description">{{ $cate->description }}</textarea>
                                        </div>    
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="card">
                                <div class="card-header bg-primary text-light">
                                    Category Image
                                </div>
                                <div class="card-body text-center">
                                    <div class="mb-0">
                                        <img class="img-thumbnail rounded me-2" id="blah" alt="" width="200" src="{{ asset($cate->image) }}" data-holder-rendered="true" style="display: {{ is_have_image($cate->image) }};">
                                    </div>
                                    <div class="mb-0">
                                        <input type="file" name="image" class="filestyle" id="imgInp" data-input="false" data-buttonname="btn-secondary">
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
                                            <input type="radio" id="customRadioInline1" name="is_visible" class="form-check-input" value="1" {{ check_uncheck($cate->visibility, 1) }}>
                                            <label class="form-check-label" for="customRadioInline1">Show</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" id="customRadioInline2" name="is_visible" class="form-check-input" value="0" {{ check_uncheck($cate->visibility, 0) }}>
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
@include("admin.dash.footer")