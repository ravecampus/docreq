<?php

namespace App\Http\Controllers;
use App\Models\Order;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $columns = ['first_name', 'middle_name', 'last_name', 'created_at'];
        $length = $request->length;
        $column = $request->column;
        $dir = $request->dir;
        $archive = $request->archive;
        $searchValue = $request->search;
        $from = date($request->from);
        $to = date($request->to);
        if($from){
            $query = Order::with('order_items')
            ->join('users', 'users.id', '=', 'orders.user_id')
            ->join('payments', 'payments.order_id', '=', 'orders.id')
            ->where('payments.created_at','>=', $from)
            ->where('payments.created_at','<=', $to)
            ->orderBy($columns[$column], $dir);
        }else{
            $query = Order::with('order_items')
            ->join('users', 'users.id', '=', 'orders.user_id')
            ->join('payments', 'payments.order_id', '=', 'orders.id')
            ->orderBy($columns[$column], $dir);
        }
       
    
        if($searchValue){
            $query->where(function($query) use ($searchValue){
                $query->where('first_name', 'like', '%'.$searchValue.'%')
                ->orWhere('middle_name', 'like', '%'.$searchValue.'%')
                ->orWhere('last_name', 'like', '%'.$searchValue.'%')
                ->orWhere('delivery_address', 'like', '%'.$searchValue.'%')
                ->orWhere('trucking_number', 'like', '%'.$searchValue.'%');
            });
        }
        $projects = $query->get();
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
        //
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
