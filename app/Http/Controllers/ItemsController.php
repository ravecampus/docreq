<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\ItemPurpose;

class ItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $columns = ['item_name', 'description', 'created_at'];
        $length = $request->length;
        $column = $request->column;
        $dir = $request->dir;
        $archive = $request->archive;
        $searchValue = $request->search;
        $query = Item::with('purpose')->where('deleted', 0)->orderBy($columns[$column], $dir);
    
        if($searchValue){
            $query->where(function($query) use ($searchValue){
                $query->where('item_name', 'like', '%'.$searchValue.'%')
                ->orWhere('description', 'like', '%'.$searchValue.'%');
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
        $request->validate([
            'item_name'=>'required',
            'description'=>'required',
            'price'=>'required|numeric',

        ]);
        $item = Item::create([
            'item_name'=> $request->item_name,
            'description'=> $request->description,
            'note'=> $request->note,
            'price'=> $request->price,
        ]);
        $purpose = $request->purpose;
        foreach ($purpose as $value) {
            ItemPurpose::create([
                'item_id' => $item->id,
                'purpose_id' => $value['purpose_id'],
            ]);
        }

        return response()->json($item, 200);
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
            'item_name'=>'required',
            'description'=>'required',
            'price'=>'required|numeric',

        ]);
        $item = Item::find($id);
        $item->item_name =  $request->item_name;
        $item->description = $request->description;
        $item->note = $request->note;
        $item->price = $request->price;
        $item->save();
        
        return response()->json($item, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Item::find($id);
        $item->deleted = 1;
        $item->save();
        return response()->json($item, 200);
    }
}
