<?php

use App\Http\Controllers\Api\ProfileColorController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\WindowColorController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::post('/reset-password/{token}' , [PasswordResetController::class , 'reset']);

Route::middleware('auth:sanctum')->group(function(){
    Route::post('/logout' , [UserController::class , 'logOut']);
    Route::get('/user' , [UserController::class , 'loggedUser']);
    Route::post('/change-password' , [UserController::class , 'changePassword']);
});

Route::apiResource('profile-colors' , ProfileColorController::class);
Route::apiResource('window-colors' , WindowColorController::class);

// API CRUD for Posts , Just for Fun
Route::apiResource('posts' , PostController::class);
