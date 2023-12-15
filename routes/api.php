<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\PasswordResetController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('/register' , [UserController::class , 'register']);
Route::post('/login' , [UserController::class , 'login']);
Route::post('/forgot-password' , [PasswordResetController::class , 'sendResetPasswordEmail']);

Route::middleware('auth:sanctum')->group(function(){
    Route::post('/logout' , [UserController::class , 'logOut']);
    Route::post('/user' , [UserController::class , 'loggedUser']);
    Route::post('/reset-password' , [UserController::class , 'changePassword']);
});


