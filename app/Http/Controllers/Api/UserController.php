<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request){

        $request->validate([
            'name' => 'required' ,
            'email' => ['required' , 'email' , 'unique:users'],
            'password' => ['required' , 'confirmed' , 'min:8'],
            'tc' => 'required'
        ]);
        if(User::where('email' , $request->email)->first()){
            return response([
                'message' => 'Email already exists' ,
                'status' => 'failed'
            ] , 200);
        }

        $user = User::create([
            'name' => $request->name ,
            'email' => $request->email ,
            'password' => Hash::make($request->password) ,
            'tc' => json_decode($request->tc)
        ]);

        return response([
            'user' => $user ,
            'token' => $user->createToken($request->email)->plainTextToken ,
            'message' => 'Registration Success' ,
            'status' => 'success'
        ] , 201);
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|email' ,
            'password' => 'required'
        ]);
        $user = User::where('email' , $request->email)->first();
        if($user && Hash::check($request->password , $user->password)){
            $token = $user->createToken($request->email)->plainTextToken;
            return response([
                'user' => $user ,
                'token' => $token ,
                'message' => 'Login Success' ,
                'status' => 'success'
            ] , 200);
        }
        return response([
            'message' => 'Login or password incorrect' ,
            'status' => 'failed'
        ] , 401);
    }

    public function logOut(){
        $user = Auth::user();
        $user->tokens()->delete ();

        return response([
            'message' => 'Logout Success' ,
            'status' => 'success'
        ] , 200);
    }

    public function loggedUser(){
        $user = auth()->user();

        return response([
            'user' => $user ,
            'message' => 'Current User Data' ,
            'status' => 'success' ,
        ] , 200);

    }
    public function changePassword(Request $request){
        $request->validate([
            'password' => 'required|confirmed'
        ]);
        $loggeduser = auth()->user();
        $loggeduser->password = Hash::make($request->password);
        $loggeduser->save();
        return response([
            'message' => 'Password changed successfully' ,
            'status' => 'success' ,
        ] , 200);

    }





}
