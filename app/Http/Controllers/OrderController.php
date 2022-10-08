<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ItemUserPurpose;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
            'delivery_info'=>'required',
            'purpose'=>'required',
            'delivery_option'=>'required',
            'request_detail'=>'required',
        ]);
        $order = Order::create([
            'full_name' => $request->delivery_info,
            'mobile_number' => $request->mobile_number,
            'delivery_address' => $request->delivery_address,
            'delivery_option' => $request->delivery_option,
            'email' => $request->email,
            'trucking_number' => $request->trucking_number,
            'delivery_fee' => $request->delivery_fee,
            // 'other_info' => $request->request_detail,
            'total' => $request->total,
            'grand_total' => $request->grand_total,
            'status' => 0,
            'user_id' => Auth::id(),
        ]);
    

        $order->trucking_number = str_pad($order->id, 8, "0", STR_PAD_LEFT);
        $order->save();

        $checkout = $request->checkout;
        $purp = $request->purpose;
        foreach ($checkout as $value) {
            OrderItem::create([
                'image' => $value['image'],
                'item_id' => $value['item_id'],
                'item_name' => $value['item_name'],
                'description' => $value['description'],
                'note' => $value['note'],
                'price' => $value['price'],
                'quantity' => $value['quantity'],
                'order_id' => $order->id,
            ]);
            
            foreach ($purp as $val) {
                ItemUserPurpose::create([
                    'user_id' =>  Auth::id(),
                    'item_id' =>  $value['item_id'],
                    'purpose_id' => $val['purpose_id']
                ]);
            }
           

        }

        return response()->json($order, 200);
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
        //
    }
}
