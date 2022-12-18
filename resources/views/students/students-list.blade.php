@extends('dashboard')
@section('content')

<!-- /.card-header -->
<div class="card-header">
    <button type="button" class="btn btn-info" style="float: right"; onclick="window.location='{{ URL::route('students.add'); }}'" ><i class="fa fa-plus"></i> Add Students </button>
</div>
<div class="card-body">
    <h5> Students Table</h5>
    <?php
    if( 0  != $students->total() ){?>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="width: 10px">#</th>
                <th > Photo </th>
                <th> Name </th>
                <th> Course </th>
                <th> Email Id </th>
                <th> Mobile Number </th>
                <th style="width: 170px">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $i = ($students->perPage() * ($students->currentPage() - 1)) + 1; ?>
            @foreach($students as $student)
 
            <tr>
                <td >{{ $i++ }}</td>
                <td style="width: 10px" > 
                <?php 
                    if( '' == $student->studentImage ){?>
                    <img src="{{ asset('images/avatar.png') }}" alt="tag"  height="50" width="50"> 
                <?php }else{ ?>
                    <img src="{{asset('images/').'/'.$student->studentImage }}" alt="tag"  height="50" width="50" >
                    <?php     } ?>
                </td>
                <td > {{ $student->studentName }} </td>
                <td > {{ $student->courseName }} </td>
                <td > {{ $student->email }} </td>
                <td > {{ $student->mobileNumber }} </td>
                 <td>
                    <a class="btn"  title="edit" href="{{ route('students.edit', ['id' => $student->studentsId]) }}"  ><i class="fas fa-edit"></i></a>
                    <a class="btn" title="view" href="{{ route('students.show', ['id' => $student->studentsId]) }}" ><i class="fas fa-eye"></i></a>
                    <a class="btn" title="delete" onclick="return confirm('Are you sure to detete Product {{ $student->studentName }} ?')"  href="{{ route('students.delete', ['id' => $student->studentsId]) }}" ><i class="fas fa-times"></i></a>
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
        {!! $students->links('pagination::bootstrap-4') !!}
    </ul>
</div>
@endsection
