<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purpose;
use App\Models\Item;
use App\Models\ItemUserPurpose;
use App\Models\OtherPurposeItem;

use Illuminate\Support\Facades\DB;

class PurposeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $columns = ['name', 'created_at'];
        $length = $request->length;
        $column = $request->column;
        $dir = $request->dir;
        $archive = $request->archive;
        $searchValue = $request->search;
        $query = Purpose::orderBy($columns[$column], $dir);
    
        if($searchValue){
            $query->where(function($query) use ($searchValue){
                $query->where('name', 'like', '%'.$searchValue.'%');
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(['name'=>'required|string']);

        $purpose = Purpose::create([
            'name' => $request->name,
        ]);

        return response()->json($purpose, 200);
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
        $request->validate(['name'=>'required|string']);

        $purpose = Purpose::find($id);
        $purpose->name = $request->name;
        $purpose->save();

        return response()->json($purpose, 200);
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

    public function listPurpose(){
        $purpose = Purpose::all();
        return response()->json($purpose, 200);
    }

    public function recommenderList(){
        $itmuspur = ItemUserPurpose::join('items', 'items.id', '=', 'item_user_purpose.item_id')
        ->select('image','description','item_id as id','price', 'purpose_id','item_name','note', DB::raw( 'count(purpose_id) as rate'))
        ->groupBy('item_id', 'purpose_id')->orderBy('rate','desc')
        ->get();

        return response()->json($itmuspur, 200);
    }

    public function otherAlsoReq(){
        $itmuspur = OtherPurposeItem::join('items', 'items.id', '=', 'other_purpose_item.item_id')
        ->select('image','description','item_id as id','price','item_name','note', DB::raw( 'count(item_id) as rate'))
        ->groupBy('item_id')->orderBy('rate','desc')
        ->get();

        return response()->json($itmuspur, 200);
    }
}
