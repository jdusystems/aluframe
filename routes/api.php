<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;

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

Route::post('/profile-colors/delete-multiple' , [ProfileTypeController::class , 'deleteMultiple']);
Route::post('/window-colors/delete-multiple' , [WindowColorController::class , 'deleteMultiple']);
Route::post('/additional-services/delete-multiple' , [AdditionalServiceController::class , 'deleteMultiple']);
Route::post('/assembly-services/delete-multiple' , [AssemblyServiceController::class , 'deleteMultiple']);
Route::post('/opening-types/delete-multiple' , [OpeningTypeController::class , 'deleteMultiple']);
Route::post('/profiles/delete-multiple' , [ProfileTypeController::class , 'deleteMultiple']);
Route::post('/clients/delete-multiple' , [ClientController::class , 'deleteMultiple']);
Route::post('/calculation-types/delete-multiple' , [CalculationTypeController::class , 'deleteMultiple']);


Route::post('/image-upload', [ImageController::class, 'imageUpload']);
Route::post('/image-delete', [ImageController::class, 'imageDelete']);

Route::get('/image' , function (){
    return view('image');
});

// API CRUD for Posts , Just for Fun
Route::apiResource('posts' , PostController::class);



// Auth User


Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest')
    ->name('register');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest')
    ->name('login');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    ->middleware('guest')
    ->name('password.email');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
    ->middleware('guest')
    ->name('password.store');

Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['auth', 'signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');
