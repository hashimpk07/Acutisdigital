<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Students;
use Carbon;
use Validator;

class StudentsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = DB::table('students')
            ->select('name as studentName','id as studentsId','image as studentImage', 'course as courseName','email as email','mobile as mobileNumber' )
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('students.students-list', ['students' => $students]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('students.students-add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input      = $request->all();
        $today      = Carbon\Carbon::now();

        $validatedData = $request->validate([
            'studentName'          => 'required',
            'courseName'           => 'required',
            'email'                => 'required',
            'mobile'               => 'required',
            'students_input_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ]);
        
        //insert new file
        if ($files = $request->file('students_input_image')) {
            $destinationPath = 'images/'; 
            $studentsImage    = time()."-".$request->studentName.".".$files->getClientOriginalExtension();
           $files->move($destinationPath, $studentsImage);
        }else{
            $studentsImage = NULL;
        }

        $students = Students::create([
            'name'        => $input['studentName'],
            'course'      => $input['courseName'],
            'email'       => $input['email'],
            'mobile'      => $input['mobile'],
            'image'       => $studentsImage,
            'created_at'  => $today,
            'updated_at'  => $today,
        ]);
        return response()->json(['status'=>'success']); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Students  $students
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $students = DB::table('students')
            ->select('name as studentName','id as studentsId', 'course as courseName','image as studentImage', 'course as courseName','email as email','mobile as mobileNumber' )
            ->where('id', '=',$id )
            ->get();

        return view('students.students-show',["students" =>$students[0] ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Students  $students
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $students = DB::table('students')
            ->select('name as studentName','id as studentsId', 'course as courseName','image as studentImage', 'course as courseName','email as email','mobile as mobileNumber' )
            ->where('id', '=',$id )
            ->get();

        return view('students.students-edit',["students" =>$students[0] ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Students  $students
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $input     =   $request->all();
        $today     =   Carbon\Carbon::now();
        $aUpdate   =   [];
        $id        =   $input['id'];
        $prodColors=   [];

        $validatedData = $request->validate([
            'studentName'          => 'required',
            'courseName'           => 'required',
            'email'                => 'required',
            'mobile'               => 'required',
            'image'                => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ]);
        

         $aUpdate     = [
            'name'         => $input['studentName'],
            'course'       => $input['courseName'],
            'email'        => $input['email'],
            'mobile'       => $input['mobile'],
            'created_at'   => $today,
            'updated_at'   => $today,
        ];
        //insert new file
        if ($files = $request->file('students_input_image')) {
            $destinationPath = 'images/'; 
            $studentsImage    = time()."-".$request->productName.".".$files->getClientOriginalExtension();
           $files->move($destinationPath, $studentsImage);
           $aUpdate['image']  = $studentsImage;
        }
      
        $students = DB::table('students')
            ->where('id', $id)
            ->update($aUpdate);
        return response()->json(['status'=>'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Students  $students
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('students')->where('id', '=', $id)->delete();
        return redirect()->back();
    }
}
