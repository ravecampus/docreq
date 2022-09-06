<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
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
            'delivery_address'=>'required',
            'request_detail'=>'required',
            'delivery_option'=>'required',
            'account'=>'required',
        ]);
        $order = Order::create([
            'delivery_address' => $request->delivery_address,
            'delivery_option' => $request->delivery_option,
            'email' => $request->email,
            'trucking_number' => $request->trucking_number,
            'delivery_fee' => $request->delivery_fee,
            'other_info' => $request->request_detail,
            'total' => $request->total,
            'grand_total' => $request->grand_total,
            'status' => 0,
            'user_id' => Auth::id(),
        ]);
    

        $order->trucking_number = str_pad($order->id, 8, "0", STR_PAD_LEFT);
        $order->save();

        $checkout = $request->checkout;
        foreach ($checkout as $value) {
            OrderItem::create([
                'item_id' => $value['item_id'],
                'item_name' => $value['item_name'],
                'description' => $value['description'],
                'price' => $value['price'],
                'quantity' => $value['quantity'],
                'order_id' => $order->id,
            ]);
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
