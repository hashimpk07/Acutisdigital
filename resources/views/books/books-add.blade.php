@extends('dashboard')
@section('content')

<div class="card-header">
    <button type="button" class="btn btn-info" style="float: right"; onclick="window.location='{{ URL::route('books'); }}'" ><i class="fa fa-arrow-left"></i> Back </button>
</div>
<div class="card-body">
   <h5>  New Books Add Page</h5>
</div>

<form action="javascript:void(0)" id="booksAddForm" name="booksAddForm">

    <p id="error" style="color: red;margin-left: 21px;"></p>
    <div class="card-body">
        <div class="form-group">
            <label for="color"> Book Name <span style="color:#ff0000">*</span></label>
                <input type="text" name="bookName" class="form-control" id="bookName" placeholder="Enter Book Name ">
            <div class="error" id="bookNameErr"></div>
        </div>

        <div class="form-group">
            <label for="color"> Book Number <span style="color:#ff0000">*</span></label>
                <input type="text" name="bookNumber" class="form-control" id="bookNumber" placeholder="Enter Book Number ">
            <div class="error" id="bookNumberErr"></div>
        </div>

        <div class="form-group">
            <label for="color"> Edition <span style="color:#ff0000">*</span></label>
                <input type="text" name="edition" class="form-control" id="edition" placeholder="Enter Edition ">
            <div class="error" id="editionErr"></div>
        </div>

        <div class="form-group">
            <label for="color"> Author <span style="color:#ff0000">*</span></label>
                <input type="text" name="author" class="form-control" id="author" placeholder="Enter Author Name ">
            <div class="error" id="authorErr"></div>
        </div>

        <div class="form-group">
            <label for="color"> Publisher <span style="color:#ff0000">*</span></label>
                <input type="text" name="publisher" class="form-control" id="publisher" placeholder="Enter Publisher Name ">
            <div class="error" id="publisherErr"></div>
        </div>

        
    </div>

    <!-- /.card-body -->
    <div class="card-footer">
        <button type="submit" class="booksForm-add btn btn-submit btn-primary" id="booksForm-add">Save</button>
    </div>
</form>
                                          
<div style="display: none;" class="pop-outer">
    <div class="pop-inner">
        <h2 class="pop-heading">Books Added Successfully</h2>
    </div>
</div> 
@endsection
@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <script type="text/javascript">  
        $( function() {     
            $('#bookName').on('input', function() {
                $('#bookNameErr').hide();
            });
            $('#bookNumber').on('input', function() {
                $('#bookNumberErr').hide();
            });
            $('#edition').on('input', function() {
                $('#editionErr').hide();
            });
            $('#author').on('input', function() {
                $('#authorErr').hide();
            });
            $('#publisher').on('input', function() {
                $('#publisherErr').hide();
            });
        });

        
        
        $("#booksAddForm").submit(function(e) {
            
            e.preventDefault();
       
            var flag            = 0;
            var bookName        = $("#bookName").val();
            var bookNumber      = $("#bookNumber").val();
            var edition         = $('#edition').val();
            var author          = $('#author').val();
            var publisher       = $("#publisher").val();
   
            if(bookName == "") {
                $("#studentNameErr").html("Please Enter Student");
                flag = 1;
            }

            if(bookName == ""){
                $("#bookNameErr").html("Please Enter Course");
                flag = 1;
            }
            if( bookNumber == "" ){
                $("#bookNumberErr").html("Please Enter Email Id");
                flag = 1;
            }

            if( edition == "" ){
                $("#editionErr").html("Please Enter Mobile Number");
                flag = 1;
            }

            if( publisher == "" ){
                $("#publisherErr").html("Please Enter Mobile Number");
                flag = 1;
            }
    
            if(author == "") {
                $("#authorErr").html("Please Enter Images");
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
                    url:"{{ route('books.create') }}",
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
                                window.location = '{{ route('books') }}'
                            }, 2500);
                        }else{
                             $("#error").html("Data Not Saved ! Please check Data");
                        }
                    
                    },
                    error: function(response) {
                        $("#error").text("Please check the data ! Wrong Data Enter");
                        $("#bookNameNumber").focus();

                    }
                    
                });
            }
        });

       

</script>
@endsection