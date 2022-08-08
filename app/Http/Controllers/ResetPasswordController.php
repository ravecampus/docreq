<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class ResetPasswordController extends Controller
{
    public function resetPasswordRequest(Request $request){
        $request->validate([
            'email'=>'required|email'
        ]);

        $user =  User::where('email', $request->email)->first();

        if(!$user){

            $errors = ['errors'=>['email' => ["We can't find your Email!"]]];
            return response()->json($errors, 422);
        }else{
            $random = rand(111111,999999);
            $user->verification_code = $random;

            if($user->save()){

                $userdata = array(
                    'email'=> $user->email,
                    'id'=> $user->id,
                    'full_name' => $user->first_name.' '.$user->last_name,
                    'random'=> $random
                );

                Mail::send('password_reset',['userdata'=>$userdata], function($message) use($userdata){
                    $message->from('no-reply@gmail.com', 'Password Reset');
                    $message->to($userdata['email'], $userdata['full_name']);
                    $message->subject("Reset Password Request");

                });
                $errors = ['errors'=>['main' => ["Please check your email!"]]];
                return response()->json($errors, 200);
            }
        }
    }
}
