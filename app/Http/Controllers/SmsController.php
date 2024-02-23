<?php

namespace App\Http\Controllers;

use App\Models\PhoneNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class SmsController extends Controller
{
    public function sendSms(Request $request){

        $request->validate([
            'name' => ['required' , 'string' , 'max:50'] ,
            'phone_number' => ['required' , 'string' , 'max:12'] ,
        ]);

        $token = $this->getToken();
        $phone = $request->phone_number;
        $code = mt_rand(1000 , 9999);

        $items = PhoneNumber::where('phone_number' , $request->phone_number)->get();
        if(!empty($items)){
        DB::table('phone_numbers')->where('phone_number' , $request->phone_number)->delete();
        }
        PhoneNumber::create([
            'name' => $request->name ,
            'phone_number' => $phone ,
            'code' => $code
        ]);
        $headers = [
            'Authorization' => "Bearer ".$token ,
            'Accept' => 'application/json',
        ];
        $payload = [
            'mobile_phone' => $phone,
            'message' => "Sizning tasdiqlash kodingiz! " .$code,
        ];
        $url = 'notify.eskiz.uz/api/message/sms/send';
        try {
            Http::withHeaders($headers)
                ->post($url, $payload);
            return response()->json(['message' => "SMS muvaffaqiyatli jo'natildi", 'status_code' => 200]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }


        // Handle the response as needed
        $statusCode = $response->status();
        $responseData = $response->json();


        return $statusCode;
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
