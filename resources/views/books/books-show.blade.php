@extends('dashboard')
@section('content')

<div class="card-header">
    <button type="button" class="btn btn-info" style="float: right"; onclick="window.location='{{ URL::route('books'); }}'" ><i class="fa fa-arrow-left"></i> Back </button>
</div>
<div class="card-body">
   <h5>  View Books Page</h5>
</div>

<form action="javascript:void(0)" id="booksEditForm" name="booksEditForm" >
    <input type="hidden" name="id" class="form-control" id="id" value="{{$books->bookId}}">
    <div class="card-body">
        <div class="form-group">
            <label for="color"> Book Name <span style="color:#ff0000">*</span></label>
                <input type="text" name="bookName" class="form-control" id="bookName" placeholder="Enter Book Name " value="{{$books->bookName}}" readonly>
            <div class="error" id="bookNameErr"></div>
        </div>

        <div class="form-group">
            <label for="color"> Book Number <span style="color:#ff0000">*</span></label>
                <input type="text" name="bookNameNumber" class="form-control" id="bookNameNumber" placeholder="Enter Book Number " value="{{$books->bookName}}" readonly>
            <div class="error" id="bookNumberErr"></div>
        </div>

        <div class="form-group">
            <label for="color"> Edition <span style="color:#ff0000">*</span></label>
                <input type="text" name="edition" class="form-control" id="edition" placeholder="Enter Edition " value="{{$books->edition}}" readonly>
            <div class="error" id="editionErr"></div>

        </div>

        <div class="form-group">
            <label for="color"> Author <span style="color:#ff0000">*</span></label>
                <input type="text" name="author" class="form-control" id="author" placeholder="Enter Author Name " value="{{$books->author}}"  readonly>
            <div class="error" id="authorErr"></div>
        </div>

        <div class="form-group">
            <label for="color"> Publisher <span style="color:#ff0000">*</span></label>
                <input type="text" name="publisher" class="form-control" id="publisher" placeholder="Enter Publisher Name " value="{{$books->publisher}}" readonly>
            <div class="error" id="publisherErr"></div>
        </div>

    </div>
    <!-- /.card-body -->
</form>                             

@endsection
@section('scripts')
   
@endsection