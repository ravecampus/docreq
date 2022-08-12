<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderListController extends Controller
{
    public function orderList(Request $request){
        $columns = ['status', 'trucking_number'];
        $length = $request->length;
        $column = $request->column;
        $dir = $request->dir;
        $archive = $request->archive;
        $searchValue = $request->search;
        $query = Order::with('order_items','payment')
            ->join('users', 'users.id', '=', 'orders.user_id')
            ->join('payments', 'payments.order_id', '=', 'orders.id')
            ->orderBy('orders.'.$columns[$column], $dir);
    
        if($searchValue){
            $query->where(function($query) use ($searchValue){
                $query->where('trucking_number', 'like', '%'.$searchValue.'%')
                ->OrWhere('first_name', 'like', '%'.$searchValue.'%')
                ->OrWhere('last_name', 'like', '%'.$searchValue.'%')
                ->OrWhere('middle_name', 'like', '%'.$searchValue.'%');
            });
        }
        $projects = $query->paginate($length);
        return ['data'=>$projects, 'draw'=> $request->draw];
    }

    public function authOrderList(Request $request){
        $columns = ['status', 'trucking_number'];
        $length = $request->length;
        $column = $request->column;
        $dir = $request->dir;
        $archive = $request->archive;
        $searchValue = $request->search;
        $userid = Auth::id();
        $query = Order::with('order_items', 'payment')->where('user_id', $userid)->orderBy($columns[$column], $dir);
    
        if($searchValue){
            $query->where(function($query) use ($searchValue){
                $query->where('trucking_number', 'like', '%'.$searchValue.'%');
            });
        }
        $projects = $query->paginate($length);
        return ['data'=>$projects, 'draw'=> $request->draw];
    }

    public function specificOrder(Request $request){
        $columns = ['created_at', 'trucking_number'];
        $length = $request->length;
        $column = $request->column;
        $dir = $request->dir;
        $archive = $request->archive;
        $searchValue = $request->search;
        $status = $request->status;
        $userid = Auth::id();
        $query = Order::with('order_items', 'payment')->where('user_id', $userid)->where('status', $status)->orderBy($columns[$column], $dir);
    
        if($searchValue){
            $query->where(function($query) use ($searchValue){
                $query->where('trucking_number', 'like', '%'.$searchValue.'%');
            });
        }
        $projects = $query->paginate($length);
        return ['data'=>$projects, 'draw'=> $request->draw];
    }

    public function orderpay($id){
        $order = Order::with('order_items')->where('status', 0)->find($id);
        return response()->json($order, 200);
    }
}
