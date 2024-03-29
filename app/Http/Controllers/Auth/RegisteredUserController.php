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
use Illuminate\Support\Facades\Http;
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
        if($request->code != $phoneNumber->code){
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

            $this->sendSms($user->phone_number , $user->parol);
            $token = $user->createToken('api-token');
            return response()->json([
                'user' => $user ,
                'token' => $token->plainTextToken
            ]);
        }
    }

    public function sendSms($phone , $parol){


        $token = $this->getToken();

        $headers = [
            'Authorization' => "Bearer ".$token ,
            'Accept' => 'application/json',
        ];
        $payload = [
            'mobile_phone' => $phone,
            'message' =>"Ваш логин и пароль для входа Aluframe ЭПЗ" ." <br>"."Логин:". $phone ."<br>". "Пароль:" . $parol,
        ];
        $url = 'notify.eskiz.uz/api/message/sms/send';
        try {
            Http::withHeaders($headers)
                ->post($url, $payload);
            return response()->json(['message' => "Telefon raqamingizga login va parolingiz jo'natildi!", 'status_code' => 200]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    public function getToken(){
        $url = env('SMS_URL');
        $username = env('SMS_USERNAME');
        $password = env('SMS_PASSWORD');

        $response = Http::post($url, [
            'email' => $username,
            'password' => $password,
        ]);
        $token = $response['data']['token'];
        return $token;
    }
}
//1|3yZKq45IaDGeBwWgjRDgsXxAdJMhiIqaiF6q4t7p2215b13f
