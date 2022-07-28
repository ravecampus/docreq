<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Session;

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
            'middle_name'=>'required',
            'last_name'=>'required',
            'gender'=>'required',
        ]);
        $user = User::find(Auth::id());
        $user->first_name = $request->first_name;
        $user->middle_name = $request->middle_name;
        $user->last_name = $request->last_name;
        $user->gender = $request->gender;
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
