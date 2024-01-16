<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AdditionalServiceController;
use App\Http\Controllers\Api\ProfileColorController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\WindowColorController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Api\OpeningTypeController;
use App\Http\Controllers\Api\CalculationTypeController;
use App\Http\Controllers\Api\AssemblyServiceController;
use App\Http\Controllers\Api\ProfileTypeController;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\CornerController;
use App\Http\Controllers\Api\WindowHandlerController;
use App\Http\Controllers\Api\SealantController;
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

Route::middleware(['auth:sanctum'])->group( function () {
    Route::get('/user' , function (Request $request){
       return $request->user();
    });

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    Route::post('/change-password', [PasswordResetController::class, 'changePassword'])
        ->name('change.password');

    Route::middleware(['admin'])->group(function () {

    });

});

Route::apiResource('profile-colors' , ProfileColorController::class);
Route::apiResource('window-colors' , WindowColorController::class);
Route::apiResource('additional-services' , AdditionalServiceController::class);
Route::apiResource('assembly-services' , AssemblyServiceController::class);
Route::apiResource('opening-types' , OpeningTypeController::class);
Route::apiResource('calculation-types' , CalculationTypeController::class);
Route::apiResource('profiles' , ProfileTypeController::class);
Route::apiResource('clients' , ClientController::class);
Route::apiResource('corners' , CornerController::class);
Route::apiResource('window-handlers' , WindowHandlerController::class);
Route::apiResource('sealants' , SealantController::class);

Route::post('/profile-colors/delete-multiple' , [ProfileColorController::class , 'deleteMultiple']);
Route::post('/window-colors/delete-multiple' , [WindowColorController::class , 'deleteMultiple']);
Route::post('/additional-services/delete-multiple' , [AdditionalServiceController::class , 'deleteMultiple']);
Route::post('/assembly-services/delete-multiple' , [AssemblyServiceController::class , 'deleteMultiple']);
Route::post('/opening-types/delete-multiple' , [OpeningTypeController::class , 'deleteMultiple']);
Route::post('/profiles/delete-multiple' , [ProfileTypeController::class , 'deleteMultiple']);
Route::post('/clients/delete-multiple' , [ClientController::class , 'deleteMultiple']);
Route::post('/calculation-types/delete-multiple' , [CalculationTypeController::class , 'deleteMultiple']);
Route::post('/corners/delete-multiple' , [CornerController::class , 'deleteMultiple']);
Route::post('/window-handlers/delete-multiple' , [WindowHandlerController::class , 'deleteMultiple']);
Route::post('/sealants/delete-multiple' , [SealantController::class , 'deleteMultiple']);

Route::post('/image-upload', [ImageController::class, 'imageUpload']);
Route::post('/image-delete', [ImageController::class, 'imageDelete']);

Route::get('/image' , function (){
    return view('image');
});

// API CRUD for Posts , Just for Fun
Route::apiResource('posts' , PostController::class);


