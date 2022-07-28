<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderListController extends Controller
{
    public function orderList(Request $request){
        $columns = ['created_at', 'trucking_number'];
        $length = $request->length;
        $column = $request->column;
        $dir = $request->dir;
        $archive = $request->archive;
        $searchValue = $request->search;
        $query = Order::with('client','order_items')->orderBy($columns[$column], $dir);
    
        if($searchValue){
            $query->where(function($query) use ($searchValue){
                $query->where('trucking_number', 'like', '%'.$searchValue.'%');
            });
        }
        $projects = $query->paginate($length);
        return ['data'=>$projects, 'draw'=> $request->draw];
    }

    public function authOrderList(Request $request){
        $columns = ['created_at', 'trucking_number'];
        $length = $request->length;
        $column = $request->column;
        $dir = $request->dir;
        $archive = $request->archive;
        $searchValue = $request->search;
        $userid = Auth::id();
        $query = Order::with('order_items')->where('user_id', $userid)->orderBy($columns[$column], $dir);
    
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
        $query = Order::with('order_items')->where('user_id', $userid)->where('status', $status)->orderBy($columns[$column], $dir);
    
        if($searchValue){
            $query->where(function($query) use ($searchValue){
                $query->where('trucking_number', 'like', '%'.$searchValue.'%');
            });
        }
        $projects = $query->paginate($length);
        return ['data'=>$projects, 'draw'=> $request->draw];
    }
}
