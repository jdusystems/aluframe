<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): JsonResponse
    {
        $request->authenticate();

        $user = $request->user();

        $token = $user->createToken('api-token');

        return response()->json([
            'user' => $user,
            'token' => $token->plainTextToken
        ]);
     }
     public function userLogin(LoginRequest $request): JsonResponse
    {
        $request->authenticate();

        $user = $request->user();
        if($user->is_admin || $user->superadmin){
            return response()->json([
                'message' => "Admins can't login here"
            ] , 422);
        }
        $token = $user->createToken('api-token');

        return response()->json([
            'user' => $user,
            'token' => $token->plainTextToken
        ]);
     }
//2|Ag3rpM2yNBbGGdGJmWkGZuA8VInkxPuzZCDeEo3mde55230c
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): JsonResponse
    {
        $user = $request->user();

        $expirationDate = Carbon::now()->subDays(2);
       $user->tokens()->where('created_at' , $expirationDate)->delete();
       return response()->json([
           'message' => 'Successfully logged out!'
       ]);
    }
}
