<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ItemPurpose;
use App\Models\Item;

class ItemPurposeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $item = ItemPurpose::select('items.*','item_purpose.purpose_id')
        ->join('items', 'items.id', '=', 'item_purpose.item_id')
        ->where('item_purpose.purpose_id', $request->id)->paginate(3);
        return response()->json($item, 200);
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
        $item = $request->item_id;
        $purpose = $request->purpose;
        foreach ($purpose as $value) {
            $vd = ItemPurpose::where('item_id', $item)->where('purpose_id', $value['purpose_id'])->first();
            if(!isset($vd)){
                ItemPurpose::create([
                    'item_id' => $item,
                    'purpose_id' => $value['purpose_id'],
                ]);
            }
            
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ip = ItemPurpose::find($id);
        $ip->delete();

        return response()->json($id, 200);
    }
}
