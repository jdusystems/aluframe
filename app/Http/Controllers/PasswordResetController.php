<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Mail\Message;
use Illuminate\Support\Str;
use Carbon\Carbon;
class PasswordResetController extends Controller
{
    public function sendResetPasswordEmail(Request $request){

        $request->validate([
            'email' => 'required|email'
        ]);
        $user = User::where('email' , $request->email)->first();
        if(!$user){
            return response([
                'message' => "Email doesn't exists" ,
                'status' => 'failed'
            ] , 404);
        }
        $token = Str::random(60);
         PasswordReset::create([
            'email' => $request->email ,
            'token' => $token ,
            'created_at' => Carbon::now() ,
        ]);

        $email = $request->email;
        Mail::send('reset_password_email' , ['token' => $token] , function(Message $message )use($email){
                $message->from('nodir.x@jdu.uz');
                $message->subject('Reset Your Password');
                $message->to($email);
        });

        return response([
            'message' => 'Password reset link has been sent to your Email' ,
            'status' => 'success' ,
        ]);
    }
    public function reset(Request $request , $token){
        
    }

}
