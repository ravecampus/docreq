<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Charges;

class ChargesController extends Controller
{
    
    public function delivery(Request $request, $id)
    {
        $charge = Charges::find($id);
        // $charge->title = $request->title;
        $charge->amount = $request->amount;
        $charge->save();
        return response()->json($charge, 200);
    }

   
    public function payment(Request $request, $id)
    {
        $charge = Charges::find($id);
        $charge->title = $request->title;;
        $charge->percentage = $request->percentage;
        $charge->save();
        return response()->json($charge, 200);
    }

    public function getCharge($id){
        $charge = Charges::find($id);
        return response()->json($charge, 200);
    }
}
