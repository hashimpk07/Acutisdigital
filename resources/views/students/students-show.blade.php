@extends('dashboard')
@section('content')

<div class="card-header">
    <button type="button" class="btn btn-info" style="float: right"; onclick="window.location='{{ URL::route('students'); }}'" ><i class="fa fa-arrow-left"></i> Back </button>
</div>
<div class="card-body">
   <h5>  Product Details  Page</h5>
</div>

<form action="javascript:void(0)" id="studentsShowForm" name="studentsShowForm"  enctype="multipart/form-data">
    <input type="hidden" name="id" class="form-control" id="id" value="{{$students->studentsId}}">
    <div class="card-body">
        <div class="form-group">
            <label for="color"> Student Name <span style="color:#ff0000">*</span></label>
                <input type="text" name="studentName" class="form-control" id="studentName" placeholder="Enter  Stuents Name" value="{{$students->studentName}}" readonly>
            <div class="error" id="studentNameErr"></div>
        </div>

        <div class="form-group">
            <label for="color"> Course Name <span style="color:#ff0000">*</span></label>
                <input type="text" name="courseName" class="form-control" id="courseName" placeholder="Enter Course Name " value="{{$students->courseName}}" readonly>
            <div class="error" id="courseNameErr"></div>
        </div>

        <div class="form-group">
            <label for="color"> Email <span style="color:#ff0000">*</span></label>
                <input type="text" name="email" class="form-control" id="email" placeholder="Enter Email Name " value="{{$students->email}}" readonly>
            <div class="error" id="emailErr"></div>
        </div>

        <div class="form-group">
            <label for="color"> Mobile Number <span style="color:#ff0000">*</span></label>
                <input type="text" name="mobile" class="form-control" id="mobile" placeholder="Enter Mobile Name " value="{{$students->mobileNumber}}" readonly>
            <div class="error" id="mobileErr"></div>
        </div>

        <div class="form-group">
            <label for="member_input_image"> Student Image <span style="color:#ff0000">*</span> </label>
            <div class="form-group" id="students_image_div" >
                <?php if( '' != $students->studentImage ){?>
                <div class="input-group">
                    <img id="students_image" name="students_image" src="{{ asset('images/').'/'.$students->studentImage }}" alt="your image" style="width:25% !important;" />
                </div>
                <?php }else{ ?>
                <div class="input-group">
                    <img id="students_image" name="students_image" src="" alt="your image" />
                </div>
                <?php } ?>
            </div>
        </div>

    </div>
    <!-- /.card-body -->
</form>
                                          

@endsection
@section('scripts')
   
@endsection