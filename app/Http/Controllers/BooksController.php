<?php

namespace App\Http\Controllers;

use App\Models\Books;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon;

class BooksController extends Controller
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
        $books = DB::table('books')
            ->select('name as bookName','id as bookId','book_no as bookNumber', 'edition as edition', 'author as author','publisher as publisher')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('books.books-list', ['books' => $books]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('books.books-add');

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
            'bookName'          => 'required',
            'bookNumber'        => 'required',
            'edition'           => 'required',
            'author'           => 'required',
            'publisher'        => 'required',
        ]);
        
    
        $students = Books::create([
            'name'         => $input['bookName'],
            'book_no'      => $input['bookNumber'],
            'edition'      => $input['edition'],
            'author'       => $input['author'],
            'publisher'    => $input['publisher'],
            'created_at'  => $today,
            'updated_at'  => $today,
        ]);
        return response()->json(['status'=>'success']); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Books  $books
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $books = DB::table('books')
            ->select('name as bookName','id as bookId', 'book_no as bookNumber','edition as edition', 'author as author','publisher as publisher' )
            ->where('id', '=',$id )
            ->get();

        return view('books.books-show',["books" =>$books[0] ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Books  $books
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $books = DB::table('books')
            ->select('name as bookName','id as bookId', 'book_no as bookNumber','edition as edition', 'author as author','publisher as publisher' )
            ->where('id', '=',$id )
            ->get();

        return view('books.books-edit',["books" =>$books[0] ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Books  $books
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Books $books)
    {
        $input     =   $request->all();
        $today     =   Carbon\Carbon::now();
        $aUpdate   =   [];
        $id        =   $input['id'];
        $prodColors=   [];

        $validatedData = $request->validate([
            'bookName'          => 'required',
            'bookNumber'        => 'required',
            'edition'           => 'required',
            'author'           => 'required',
            'publisher'        => 'required',
        ]);
        

         $aUpdate     = [
            'name'         => $input['bookName'],
            'book_no'      => $input['bookNumber'],
            'edition'      => $input['edition'],
            'author'       => $input['author'],
            'publisher'    => $input['publisher'],
            'updated_at'   => $today,
        ];
        $books = DB::table('books')
            ->where('id', $id)
            ->update($aUpdate);
        return response()->json(['status'=>'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Books  $books
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('books')->where('id', '=', $id)->delete();
        return redirect()->back();
    }
}
