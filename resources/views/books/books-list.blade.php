@extends('dashboard')
@section('content')

<!-- /.card-header -->
<div class="card-header">
    <button type="button" class="btn btn-info" style="float: right"; onclick="window.location='{{ URL::route('books.add'); }}'" ><i class="fa fa-plus"></i> Add Books </button>
</div>
<div class="card-body">
    <h5> Books Table</h5>
    <?php
    if( 0  != $books->total() ){?>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="width: 10px">#</th>
                <th > Book Name </th>
                <th> Book Number </th>
                <th> Edition </th>
                <th> Author </th>
                <th> Publisher </th>
                <th style="width: 170px">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $i = ($books->perPage() * ($books->currentPage() - 1)) + 1; ?>
            @foreach($books as $book)
 
            <tr>
                <td >{{ $i++ }}</td>
                <td > {{ $book->bookName }} </td>
                <td > {{ $book->bookNumber }} </td>
                <td > {{ $book->edition }} </td>
                <td > {{ $book->author }} </td>
                <td > {{ $book->publisher }} </td>
                 <td>
                    <a class="btn"  title="edit" href="{{ route('books.edit', ['id' => $book->bookId ]) }}"  ><i class="fas fa-edit"></i></a>
                    <a class="btn" title="view" href="{{ route('books.show', ['id' => $book->bookId]) }}" ><i class="fas fa-eye"></i></a>
                    <a class="btn" title="delete" onclick="return confirm('Are you sure to detete Product {{ $book->bookName }} ?')"  href="{{ route('books.delete', ['id' => $book->bookId]) }}" ><i class="fas fa-times"></i></a>
                </td>
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
        {!! $books->links('pagination::bootstrap-4') !!}
    </ul>
</div>
@endsection
