<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\BookIssuse;
use App\Models\Students;
use App\Models\Books;
use Carbon;
use Validator;

class BookIssuseController extends Controller
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
        $library = DB::table('issue_details')
            ->select('issue_details.student_id as studentsId','issue_details.book_id as booksId', 'issue_details.issue_date as issueDate','issue_details.return_date as returnDate' ,'books.name as bookName' ,'books.book_no as booknumber','books.author as bookAuthor','students.name as studentName','issue_details.return_status as status')
            ->join('books','books.id','=','issue_details.book_id')
            ->join('students','students.id','=','issue_details.student_id')
            ->orderBy('issue_details.created_at', 'desc')
            ->paginate(10);
        return view('library.library-list', ['library' => $library]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $students   = DB::table('students')->get();
        $books      = DB::table('books')->get();
        return view('library.library-issue',["students" => $students,"books" => $books]);
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
            'bookName'      => 'required',
            'studentName'   => 'required',
            'issueDate'     => 'required',
            'returnDate'    => 'required',
        ]);

        $bookAvailable = DB::table('issue_details')
                    ->select('id')
                    ->where('book_id', '=', $input['bookName'] )
                    ->where('student_id', '=', $input['studentName'] )
                    ->where('return_status', '=', 0 )
                    ->first();
        if(empty($bookAvailable)){
            return response()->json(['status'=>'error','message' =>'Sorry Data mismatched! Please Check Book Name and Student Student']);
        }else{

            $aUpdate     = [
                'return_date'   =>  $input['returnDate'],
                'return_status' =>  1,
                'updated_at'    =>  $today
            ];
            $products = DB::table('issue_details')
            ->where('id', $bookAvailable->id)
            ->update($aUpdate);
            return response()->json(['status'=>'success']); 
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $students  = DB::table('students')->get();
        $books      = DB::table('books')->get();
        return view('library.library-return',["students" => $students,"books" => $books]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $students  = DB::table('students')->get();
        $books      = DB::table('books')->get();
        return view('library.library-return',["students" => $students,"books" => $books]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $input      = $request->all();
        $today      = Carbon\Carbon::now();

        $validatedData = $request->validate([
            'bookName'      => 'required',
            'studentName'   => 'required',
            'issueDate'     => 'required',
            'returnDate'    => 'required',
        ]);

        $bookAvailable = DB::table('issue_details')
                    ->select('id')
                    ->where('book_id', '=', $input['bookName'] )
                    ->where('return_status', '=', 0 )
                    ->first();
        if(!empty($bookAvailable)){
            return response()->json(['status'=>'error','message' =>'This book is not available,Already Issued']);
        }else{

            $bookIssuse = BookIssuse::create([
                'student_id'    => $input['studentName'],
                'book_id'       => $input['bookName'],
                'issue_date'    => $input['issueDate'],
                'return_date'   => $input['returnDate'],
                'return_status' => 0,
                'created_at'    => $today,
                'updated_at'    => $today,
            ]);
            return response()->json(['status'=>'success']); 
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
