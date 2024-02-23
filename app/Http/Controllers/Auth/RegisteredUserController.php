<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PhoneNumber;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone_number' => ['required' , 'unique:users'],
            'password' => ['required' ,'min:8' , 'confirmed' ]
        ]);
        $password = Str::random(10);
        $user = User::create([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
            'parol' => $request->password,
            'registered' => true
        ]);

        event(new Registered($user));

        Auth::login($user);

        $token = $user->createToken('api-token');

        return response()->json([
            'user' => $user ,
            'token' => $token->plainTextToken
        ]);
    }

    public function loginOrRegister(Request $request) {


        $request->validate([
            'name' => ['required'] ,
            'phone_number' => ['required'] ,
            'code' => ['required' , 'numeric'] ,
        ]);

        $phoneNumber = PhoneNumber::where('phone_number' , $request->phone_number)->first();
        if(!$phoneNumber){
            return response()->json([
                'code' => 404 ,
                'message' => "Bunaqa foydalanuvchi topilmadi!"
            ] , 404);
        }
        if($request->code != 1234){
            return response()->json([
                'code' => 404 ,
                'message' => "Tasdiqlash kodi noto'g'ri!"
            ] , 404);
        }
        $phoneNumber->delete();

        $user = User::where('phone_number' , $request->phone_number)->first();
        if($user && $user->registered){
            $user->tokens()->delete();
            $token = $user->createToken('api-token');
            return response()->json([
                'user' => $user ,
                'token' => $token->plainTextToken
            ]);
        }else{
            $password = Str::random(10);
            $user = User::create([
                'name' => $request->name ,
                'phone_number' => $request->phone_number ,
                'password' => $password ,
                'registered' => true ,
                'parol' => $password
            ]);
            $token = $user->createToken('api-token');
            return response()->json([
                'user' => $user ,
                'token' => $token->plainTextToken
            ]);
        }
    }
}
//1|3yZKq45IaDGeBwWgjRDgsXxAdJMhiIqaiF6q4t7p2215b13f
