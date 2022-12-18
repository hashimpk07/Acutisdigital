@extends('dashboard')
@section('content')

<!-- /.card-header -->
<div class="card-header">
    <button type="button" class="btn btn-info" style="float: right;"; onclick="window.location='{{ URL::route('book_issue.return'); }}'" ><i class="fa fa-plus"></i> Return Books  </button>
    <button type="button" class="btn btn-info" style="float: right;margin-right: 10px;"; onclick="window.location='{{ URL::route('book_issue.issue'); }}'" ><i class="fa fa-plus"></i> Issued Books </button>
</div>
<div class="card-body">
    <h5> Book Issue Details </h5>
    <?php
    if( 0  != $library->total() ){?>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="width: 10px">#</th>
                <th>Student Name</th>
                <th>Book Name</th>
                <th>Book Number</th>
                <th>Book Author</th>
                <th  style="width: 175px">Issue Date</th>
                <th style="width: 175px">Return Date</th>
                <th>Return Status</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $i = ($library->perPage() * ($library->currentPage() - 1)) + 1; ?>
            @foreach($library as $libry)
            <?php if( 0 == $libry->status ){
                $status = 'Issued';
            }else{
                $status = 'Return';
            }?>
            <tr>
                <td > {{ $i++ }} </td>
                <td > {{ $libry->studentName }} </td>
                <td > {{ $libry->bookName }} </td>
                <td > {{ $libry->booknumber }} </td>
                <td > {{ $libry->bookAuthor }} </td>
                <td > {{ date('d-M-Y', strtotime($libry->issueDate))}} </td>
                <td > {{ date('d-M-Y', strtotime($libry->returnDate)) }} </td>
                <td > {{ $status }} </td>
            </tr>

         @endforeach 
        </tbody>
    </table>
</div>
<?php } else{?> 
<img src="{{url('/images/norecordfound.png')}}" class="no-data-found" style="width: 100%;" />
    <?php } ?>
</div>
<!-- /.card-body -->
<div class="card-footer clearfix">
    <ul class="pagination pagination-sm m-0 float-right">
        {!! $library->links('pagination::bootstrap-4') !!}
    </ul>
</div>
@endsection
