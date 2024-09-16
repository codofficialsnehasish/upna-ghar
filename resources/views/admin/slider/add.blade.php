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
                                    <h6 class="page-title">Slider</h6>
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{url('/malibupoinserene-619-dash')}}">Home</a></li>
                                        <li class="breadcrumb-item"><a href="{{url('/slider')}}">Slider</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Add New Slider</li>
                                    </ol>
                                </div>
                                <div class="col-md-4">
                                    <div class="float-end d-none d-md-block">
                                          <div class="dropdown">
                                             <a href="{{route('slider')}}" class="btn btn-primary  dropdown-toggle" aria-expanded="false">
                                                <i class="fas fa-arrow-left me-2"></i> Back
                                             </a>
                                          </div>
                                       </div>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        <form class="custom-validation" action="{{route('slider.submit')}}" method="post" enctype="multipart/form-data">
                           @csrf
                           <div class="row">
                              <div class="col-lg-9">
                                 <div class="card">
                                    <div class="card-header bg-primary text-light">
                                       Add New Slider
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Title</label>
                                                    <div>
                                                       <input data-parsley-type="text" type="text" class="form-control" required placeholder="Enter Title" name="name" id="name" value="Untitled" onclick="Clear(this.id);" onblur="Setvalue(this.id);">
                                                    </div>
                                                 </div>
                                            </div>
                                        </div>


                                       <div class="mb-3">
                                          <label class="form-label">Description</label>
                                          <div>
                                             <textarea name="desc"  class="form-control editor" rows="5"></textarea>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <!-- end col -->
                              <div class="col-lg-3">
                                 <div class="card">
                                    <div class="card-header bg-primary text-light">
                                          Image
                                    </div>
                                    <div class="card-body text-center">
                                       <div class="mb-0">
                                          <img class="img-thumbnail rounded me-2" id="blah" alt="" width="200" src="" data-holder-rendered="true" style="">
                                       </div>
                                       <div class="mb-0">
                                          <input type="file" name="sliderimg" class="filestyle" id="imgInp" data-input="false" data-buttonname="btn-secondary">
                                          <!-- <input type="hidden" name="media_id" id="media_id" />
                                          <a href="javascript:;" id="openLibrary">or Choose From Library</a> -->
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
                                             Save & Publish
                                             </button>
                                             <!-- <button type="reset" class="btn btn-secondary waves-effect">
                                                Cancel
                                                </button> -->
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <!-- end col -->
                           </div>
                           <!-- end row -->
                        </form>
                     </div> <!-- container-fluid -->
               </div>
            <!-- End Page-content -->



   @include("admin/dash/footer")

<script>
   function Clear(str)
      {
         valu=document.getElementById(str).value;
         if(valu==='Untitled'){
            document.getElementById(str).value= "";
         }
      }


      function Setvalue(str)
      {
         valu=document.getElementById(str).value;
         if(valu===''){
            document.getElementById(str).value= "Untitled";
         }
      }
      imgInp.onchange = evt => {
         const [file] = imgInp.files;
         if (file) {
            console.log("ok");
            blah.src = URL.createObjectURL(file);
         }
      }
</script>
