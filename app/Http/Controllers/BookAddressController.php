<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BookAddress;

class BookAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $columns = ['province', 'created_at'];
        $length = $request->length;
        $column = $request->column;
        $dir = $request->dir;
        $archive = $request->archive;
        $searchValue = $request->search;
        $query = BookAddress::where('user_id',Auth::id())->where('deleted', 0)->orderBy($columns[$column], $dir);
    
        if($searchValue){
            $query->where(function($query) use ($searchValue){
                $query->where('province', 'like', '%'.$searchValue.'%');
            });
        }
        $projects = $query->paginate($length);
        return ['data'=>$projects, 'draw'=> $request->draw];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'mobile_number' => 'required|regex:/(09)[0-9]{9}/',
            'first_name'=>'required|string',
            'middle_name'=>'required|string',
            'last_name'=>'required|string',
            'street'=>'required|string',
            'province'=>'required|string',
            'city_or_municipality'=>'required|string',
            'barangay'=>'required|string'
        ]);

        $book = BookAddress::create([
           
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'mobile_number' => $request->mobile_number,
            'street' => $request->street,
            'province' => $request->province,
            'note' => $request->note,
            'city_or_municipality' => $request->city_or_municipality,
            'barangay' => $request->barangay,
            'user_id' => Auth::id()
        ]);

        return response()->json($book,200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'mobile_number' => 'required|regex:/(09)[0-9]{9}/',
            'first_name'=>'required|string',
            'middle_name'=>'required|string',
            'last_name'=>'required|string',
            'street'=>'required',
            'province'=>'required',
            'city_or_municipality'=>'required',
            'barangay'=>'required'
        ]);

        $book = BookAddress::find($id);
        $book->mobile_number = $request->mobile_number;
        $book->first_name = $request->first_name;
        $book->middle_name = $request->middle_name;
        $book->last_name = $request->last_name;
        $book->street = $request->street;
        $book->province = $request->province;
        $book->note = $request->note;
        $book->city_or_municipality = $request->city_or_municipality;
        $book->barangay = $request->barangay;
        $book->user_id = Auth::id();
        $book->save();
        return response()->json($book,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = BookAddress::find($id);
        $book->deleted = 1;
        $book->save();
        return response()->json($book,200);
    }

    public function authAddressBook(){
        $auth = BookAddress::where('user_id', Auth::id())->get();
        return response()->json($auth, 200);
    }
}
