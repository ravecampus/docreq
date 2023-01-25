<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Session;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function signup(Request $request){
        $request->validate([
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

       return response()->json($user,200);
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required'
        ]);
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if(!Auth::attempt($credentials)):
            $errors = ['errors'=>['main' => ['Wrong Credential!']]];
            return response()->json($errors,401);
        endif;

        $user = Auth::getProvider()->retrieveByCredentials($credentials);

        $a = Auth::user();
        return response()->json($a,200);
    }

    public function logout()
    {
        try {
            Session::flush();
            $success = true;
            $message = 'Successfully logged out';
        } catch (\Illuminate\Database\QueryException $ex) {
            $success = false;
            $message = $ex->getMessage();
        }

        // response
        $response = [
            'success' => $success,
            'message' => $message,
        ];
        return response()->json($response);
    }

    public function fillupName(Request $request){
        $request->validate([
            'first_name'=>'required',
            // 'middle_name'=>'required',
            'last_name'=>'required',
            'gender'=>'required',
            'birth_date' =>'required|string',
            'birth_place' =>'required|string',
            'current_enrolled' =>'required',
            'fathers_name' =>'required|string',
            'mothers_name' =>'required|string',

        ]);
        $user = User::find(Auth::id());
        $user->first_name = $request->first_name;
        $user->middle_name = $request->middle_name;
        $user->last_name = $request->last_name;
        $user->gender = $request->gender;
        $user->mobile = $request->mobile;
        $user->address = $request->address;
        $user->birth_place = $request->birth_place;
        $user->mothers_name  = $request->mothers_name;
        $user->fathers_name = $request->fathers_name;
        $user->academic_program = $request->academic_program;
        $user->current_enrolled = $request->current_enrolled;
        $user->year_graduated = $request->year_graduated == 0 ? 0000 : $request->year_graduated;
        $user->last_sy = $request->last_sy == 0 ? 0000 : $request->last_sy;
        $user->birth_date = Carbon::parse($request->birth_date)->format('Y-m-d');
        $user->save();
        return response()->json($user, 200);
    }

    public function changeEmail(Request $request){
        $request->validate([
            'email' => 'required|string|email',
        ]);
        $user = User::find(Auth::id());
        $user->email = $request->email;
        $user->save();
        return response()->json($user, 200);
    }

    public function changePassword(Request $request){
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);
        
        $user = User::find(Auth::id());
        $user->password = bcrypt($request->password);
        $user->save();
        return response()->json($user, 200);
    }

}
