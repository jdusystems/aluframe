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
   public function changePassword(Request $request){

       $request->validate([
           'current_password' => ['required'],
           'new_password' => ['required' , 'confirmed' , 'min:8']
       ]);

       $user = $request->user();

       if(!Hash::check($request->input('current_password') , $user->password)){
           return response()->json([
             'message' => 'Current password is incorrect'
           ] , 422);
       }

       $user->update([
           'password' => Hash::make($request->input('new_password')),
       ]);

       return response()->json([
           'message' => "Password updated successfully!"
       ]);
   }


    public function sendResetPasswordEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response([
                'message' => "Email doesn't exists",
                'status' => 'failed'
            ], 404);
        }
        $token = Str::random(60);
        if(PasswordReset::where('email', $request->email)->first()) {
            return response([
                'message' => 'Password reset link has already been sent to your Email',
                'status' => 'success',
            ], 208);
        }
        PasswordReset::create([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);

        $email = $request->email;
        Mail::send('reset_password_email', ['token' => $token], function (Message $message) use ($email) {
            $message->from('nodir.x@jdu.uz');
            $message->subject('Reset Your Password');
            $message->to($email);
        });

        return response([
            'message' => 'Password reset link has been sent to your Email',
            'status' => 'success',
        ]);
    }
    public function reset(Request $request, $token)
    {
        $request->validate([
            'password' => ['required', 'confirmed'],
        ]);

        $passwordReset = PasswordReset::where('token', $token)->first();
        if (!$passwordReset) {
            return response([
                'message' => 'Token is Invalid or Expired',
                'status' => 'failed'
            ], 404);
        }

        $user = User::where('email', $passwordReset->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Delete the token after resetting password

        PasswordReset::where('email', $user->email)->delete();

        return response([
            'message' => 'Password has been changed successfully',
            'status' => 'success'
        ], 200);
    }
}
