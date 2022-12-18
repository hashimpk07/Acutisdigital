@extends('dashboard')
@section('content')

<div class="card-header">
    <button type="button" class="btn btn-info" style="float: right"; onclick="window.location='{{ URL::route('students'); }}'" ><i class="fa fa-arrow-left"></i> Back </button>
</div>
<div class="card-body">
   <h5>  Update Students Page</h5>
</div>

<form action="javascript:void(0)" id="studentsEditForm" name="studentsEditForm"  enctype="multipart/form-data">
    <input type="hidden" name="id" class="form-control" id="id" value="{{$students->studentsId}}">
    <div class="card-body">
        <div class="form-group">
            <label for="color"> Student Name <span style="color:#ff0000">*</span></label>
                <input type="text" name="studentName" class="form-control" id="studentName" placeholder="Enter  Stuents Name" value="{{$students->studentName}}">
            <div class="error" id="studentNameErr"></div>
        </div>

        <div class="form-group">
            <label for="color"> Course Name <span style="color:#ff0000">*</span></label>
                <input type="text" name="courseName" class="form-control" id="courseName" placeholder="Enter Course Name " value="{{$students->courseName}}">
            <div class="error" id="courseNameErr"></div>
        </div>

        <div class="form-group">
            <label for="color"> Email <span style="color:#ff0000">*</span></label>
                <input type="text" name="email" class="form-control" id="email" placeholder="Enter Email Name " value="{{$students->email}}">
            <div class="error" id="emailErr"></div>
        </div>

        <div class="form-group">
            <label for="color"> Mobile Number <span style="color:#ff0000">*</span></label>
                <input type="text" name="mobile" class="form-control" id="mobile" placeholder="Enter Mobile Name " value="{{$students->mobileNumber}}">
            <div class="error" id="mobileErr"></div>
        </div>

        <div class="form-group">
            <label for="member_input_image"> Stubent Image <span style="color:#ff0000">*</span> </label>
            <div class="form-group" id="students_image_div" >
                <?php if( '' != $students->studentImage ){?>
                <div class="input-group">
                    <img id="students_image" name="students_image" src="{{ asset('images/').'/'.$students->studentImage }}" alt="your image" style="width: 12% !important;" />
                </div>
                <?php }else{ ?>
                <div class="input-group">
                    <img id="students_image" name="students_image" src="" alt="your image" />
                </div>
                <?php } ?>
            </div>
            <input type='file' id="students_input_image" onchange="readURL(this);"  name="students_input_image" value="{{ $students->studentImage }}" data-value="{{ $students->studentImage }}" class="form-control" />
            <div class="error" id="students_imageErr"></div>
        </div>

    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <button type="submit" class="productForm-add btn btn-submit btn-primary" id="productForm-add">Save</button>
    </div>
</form>
                                          
<div style="display: none;" class="pop-outer">
    <div class="pop-inner">
        <h2 class="pop-heading">Students Updated Successfully</h2>
    </div>
</div> 
@endsection
@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <script type="text/javascript">  
        $( function() {     
            $('#studentName').on('input', function() {
                $('#studentNameErr').hide();
            });
            $('#courseName').on('input', function() {
                $('#courseNameErr').hide();
            });
            $('#email').on('input', function() {
                $('#emailErr').hide();
            });
            $('#mobile').on('input', function() {
                $('#mobileErr').hide();
            });
        });

      

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                $('#students_image_div').show();
                reader.onload = function (e) {
                    $('#students_image').attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#studentsEditForm").submit(function(e) {
            
            e.preventDefault();
       
            var flag            = 0;
            var studentName     = $("#studentName").val();
            var courseName      = $("#courseName").val();
            var email           = $('#email').val();
            var mobile          = $('#mobile').val();
            var image           = $("#students_input_image").val();
   
            if(studentName == "") {
                $("#studentNameErr").html("Please Enter Student");
                flag = 1;
            }

            if(courseName == ""){
                $("#courseNameErr").html("Please Enter Course");
                flag = 1;
            }
            if( email == "" ){
                $("#emailErr").html("Please Enter Email Id");
                flag = 1;
            }

            if( mobile == "" ){
                $("#mobileErr").html("Please Enter Mobile Number");
                flag = 1;
            }
            if( 1 == flag ){
                return false;
            }else{
            
                formData = new FormData(this);
                
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url:"{{ route('students.update') }}",
                    type: "POST",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success:function(data){
                        if( data.status == 'success' ){
                            $(".pop-outer").fadeIn("slow");
                            setTimeout(function () {
                                window.location = '{{ route('students') }}'
                            }, 2500);
                        }else{
                            $("#error").html("Data Not Saved ! Please check Data");
                        }
                    },
                    error: function(response) {
                        $("#error").text("Please check the data ! Wrong Data Enter");
                        $("#studentName").focus();
                    }
                    
                });
            }
        });

       

</script>
@endsection