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
                                <li class="breadcrumb-item"><a href="{{ route('service-form-template.index') }}">{{ $title }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Add New {{ $title }}</li>
                            </ol>
                        </div>
                        <div class="col-md-4">
                            <div class="float-end d-none d-md-block">
                                <div class="dropdown">
                                    <a href="{{ route('service-form-template.index') }}" class="btn btn-primary  dropdown-toggle" aria-expanded="false">
                                        <i class="fas fa-arrow-left me-2"></i> Back
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <form class="custom-validation outer-repeater" action="{{ route('service-form-template.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="card">
                                <div class="card-header bg-primary text-light">
                                    Add New Service
                                </div>
                                <div class="card-body row">
                                    {{--<div class="mb-3 col-md-6">
                                        <label for="service_id" class="form-label">Choose Service</label>
                                        <select class="form-select" id="service_id" name="service_id">
                                            <option selected disabled value="">Choose...</option>
                                            @foreach($services as $parent)
                                            <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            Please select a valid state.
                                        </div>
                                    </div>--}}
                                    <div class="mb-3 col-md-12">
                                        <label for="service_id" class="form-label">Template Name</label>
                                        <div>
                                            <input data-parsley-type="text" type="text" class="form-control" placeholder="Template Name" name="template_name">
                                        </div>
                                    </div>
                                    <hr>
                                    <table width="100%" cellpadding="5" cellspacing="5" id="table_repeter">
                                        <tr>
                                            <th width="20%">Type</th>
                                            <th width="30%">Label Name</th>
                                            <!-- <th width="30%">Class Name(optional)</th> -->
                                            <th width="8%">Required</th>
                                            <th width="8%">Readonly</th>
                                            <th width="4%">&nbsp;</th>
                                        </tr>
                                        <tr>
                                            <td>
                                                <select class="form-select" name="type_id[]"  id="type_id_1" onchange="setoptionval(this.value,1);" aria-label="Default select example">
                                                    <option value selected disabled>None</option>
                                                    <option value="text">Text</option>
                                                    <option value="number">Number</option>
                                                    <option value="select">Select</option>
                                                    <option value="radio">Radio</option>
                                                    <option value="checkbox">Checkbox</option>
                                                    <!-- <option value="color">Color</option> -->
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" name="label_name[]" id="label_name_1" class="form-control"/>
                                                <input type="text" class="form-control mt-3" name="option[]" id="option_1" placeholder="e.g opt1,opt2,opt3" style="display:none;"/>
                                                <!-- <input type="color" class="form-control form-control-color mw-100" id="coption_1" value="#02a499" name="option[]" style="display:none;"> -->
                                            </td>
                                            <td>
                                                <input type="checkbox" name="required[]" class="form-check-input me-2" id="customCheck1">
                                            </td>
                                            <td>
                                                <input type="checkbox" name="readonly[]" class="form-check-input me-2" id="customCheck1">
                                            </td>
                                        </tr>
                                    </table>
                                    <div  id="more1"><a class="btn btn-success btn-sm float-end" href="javascript:;" onClick="showMore_edit('field_1');"><i class="fa fa-plus"></i>Add More</a></div>
                                    <p>&nbsp;</p>
                                    <input type="hidden" name="cont" id="cont" value="1" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
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
    
    <script>
		function showMore_edit(id){
            var idd = id.split("_");
            var idty = parseInt(idd[1]);
            idty = idty + 1;
            var table = document.getElementById("table_repeter");
            console.log(table);
            var rowCount = table.rows.length;
            
            var row = table.insertRow(rowCount);
            var cell0 = row.insertCell(0);
            var rowCount = table.rows.length;
            var row = table.insertRow(rowCount);
            // console.log(cell0,cell1, cell2, cell3);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            // var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(2);
            var cell5 = row.insertCell(3);
            var cell6 = row.insertCell(4);
            document.getElementById("cont").value = idty;
               
				
			cell1.innerHTML = '<select class="form-select" name="type_id[]" id="type_id_'+idty+'" aria-label="Default select example" onchange="setoptionval(this.value,'+idty+');"><option value selected disabled>None</option><option value="text">Text</option><option value="number">Number</option><option value="select">Select</option><option value="radio">Radio</option><option value="checkbox">Checkbox</option></select>';
				
			cell2.innerHTML = '<input type="text" class="form-control" name="label_name[]" id="label_name_'+idty+'" /><input type="text" class="form-control mt-3" name="option[]" id="option_'+idty+'" placeholder="e.g opt1,opt2,opt3" style="display:none;"/>';

			// cell3.innerHTML = '<input type="text" class="form-control" name="class_name[]" id="class_name_'+idty+'" placeholder="eg. form-control btn" />';

            cell4.innerHTML = '<input type="checkbox" class="form-check-input me-2" name="required[]" id="required_'+idty+'" />';
				  
			cell5.innerHTML = '<input type="checkbox" class="form-check-input me-2" name="readonly[]" id="readonly_'+idty+'" />';
                 
            cell6.innerHTML = "<a  href=\"javascript:;\" class=\"btn btn-danger btn-sm\" data-bs-toggle=\"tooltip\" data-bs-placement=\"top\" title=\"Remove this Item\" onClick=\"deleteRow(this)\"><i class=\"ti-trash\"></i></a>";

				  
			document.getElementById("more1").innerHTML = "<a class=\"btn btn-success btn-sm float-end\" href=\"javascript:;\" onClick=\"showMore_edit('field_" + idty + "');\"><i class=\"fa fa-plus\"></i>Add More</a>";
                
                
        }
      
	  
	    function setoptionval(valu,id){
            // console.log(valu);
            if(valu=='select' || valu=='radio' || valu=='checkbox'){
                $('#option_'+id).show();
            }
            // if(valu == 'color'){
            //     $('#coption_'+id).show();
            // }
            else{
                $('#option_'+id).hide();
            }
	    }

        function deleteRow(btn) {
            if (confirm("Are You Sure?") == true) {
                var row = btn.parentNode.parentNode;
                row.parentNode.removeChild(row);
            } else { }
		}
    </script>

    @endsection
@include("admin.dash.footer")