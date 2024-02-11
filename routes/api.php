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
use App\Http\Controllers\Api\TypeController;
use App\Http\Controllers\Api\HandlerTypeController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\StatusController;
use App\Http\Controllers\Api\PdfController;
use App\Http\Controllers\Api\HandlerPositionController;
use App\Http\Controllers\Api\OpeningTypeNumberController;
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
    Route::get('/orders/pdf1/{order_id}' , [PdfController::class , 'exportPdf1']);
    Route::get('/orders/pdf2/{order_id}' , [PdfController::class , 'exportPdf2']);
    Route::get('/orders/pdf3/{order_id}' , [PdfController::class , 'exportPdf3']);
    Route::get('/orders/pdf4/{order_id}' , [PdfController::class , 'exportPdf4']);

    Route::get('/user' , function (Request $request){
       $user = \Illuminate\Support\Facades\Auth::user();
       $role = "user";
        if($user->superadmin==1){
            $role = "superadmin";
        }
       if($user->is_admin==1 && $user->superadmin == 0){
           $role = "admin";
       }else{
           $role = "user";
       }
       return response()->json([
           'user' => $user ,
           'user_role' => $role ,
       ]);

    });
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    Route::post('/change-password', [PasswordResetController::class, 'changePassword'])
        ->name('change.password');

    // Super Admin
    Route::middleware(['superadmin'])->group(function (){
        Route::apiResource('profile-colors' , ProfileColorController::class , [
            'only' => ['store' , 'update' , 'destroy']
        ]);
        Route::apiResource('window-colors' , WindowColorController::class , [
            'only' => ['store' , 'update' , 'destroy']
        ]);
        Route::apiResource('additional-services' , AdditionalServiceController::class , [
            'only' => ['store' , 'update' , 'destroy']
        ]);
        Route::apiResource('assembly-services' , AssemblyServiceController::class);

        Route::apiResource('types' , TypeController::class , [
            'only' => ['update' , 'store' , 'destroy']
        ]);

        Route::apiResource('opening-types' , OpeningTypeController::class , [
            'only' => ['store' , 'update' , 'destroy']
        ]);

// Get Opening Types by Types

        Route::apiResource('calculation-types' , CalculationTypeController::class);

        Route::apiResource('profiles' , ProfileTypeController::class , [
            'only' => ['store' , 'update' , 'destroy']
        ]);

        Route::apiResource('corners' , CornerController::class);
        Route::apiResource('window-handlers' , WindowHandlerController::class);
        Route::apiResource('sealants' , SealantController::class);
        Route::get('/all-sealants', [SealantController::class , 'all']);


        Route::apiResource('handler-types' , HandlerTypeController::class , [
            'only' => ['store' , 'update' , 'destroy']
        ]);

        Route::apiResource('statuses' , StatusController::class);
        Route::apiResource('handler-positions' , HandlerPositionController::class , [
            'only' => ['store' , 'update' , 'destroy']
        ]);

        Route::apiResource('opening-type-numbers' , OpeningTypeNumberController::class , [
            'only' => ['store' , 'update' , 'destroy']
        ]);

        Route::post('/opening-type-numbers/addImage', [OpeningTypeNumberController::class , 'addImage']);
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

    });

    // Admin
    Route::middleware(['admin'])->group(function () {
        Route::apiResource('clients' , ClientController::class);
        Route::get('/all-clients', [ClientController::class , 'all']);
    });

    Route::apiResource('orders' , OrderController::class);

});
//profiles
Route::get('/all-profiles', [ProfileTypeController::class , 'all']);
Route::apiResource('profiles' , ProfileTypeController::class , [
    'only' => ['show' , 'index']
]);
//profile-colors
Route::get('/all-profile-colors', [ProfileColorController::class , 'all']);
Route::get('/profile-colors/profile/{type_id}', [ProfileColorController::class , 'getByType']);
Route::apiResource('profile-colors' , ProfileColorController::class , [
    'only' => ['show' , 'index']
]);
//window-colors
Route::get('/all-window-colors', [WindowColorController::class , 'all']);
Route::get('/window-colors/profile-color/{type_id}', [WindowColorController::class , 'getByType']);
Route::apiResource('window-colors' , WindowColorController::class , [
    'only' => ['show' , 'index']
]);
//additional-services
Route::get('/all-additional-services', [AdditionalServiceController::class , 'all']);
Route::apiResource('additional-services' , AdditionalServiceController::class , [
    'only' => ['show' , 'index']
]);
//assembly-services
Route::get('/all-assembly-services', [AssemblyServiceController::class , 'all']);
//opening-types
Route::get('/all-opening-types', [OpeningTypeController::class , 'all']);
Route::get('/opening-types/type/{type_id}', [OpeningTypeController::class , 'getByType']);

Route::apiResource('opening-types' , OpeningTypeController::class , [
    'only' => ['index' , 'show']
]);
// handler types
Route::apiResource('handler-types' , HandlerTypeController::class , [
    'only' => ['show' , 'index']
]);
Route::get('/all-handler-types', [HandlerTypeController::class , 'all']);
//calculation-types
Route::get('/all-calculation-types', [CalculationTypeController::class , 'all']);
//corners
Route::get('/all-corners', [CornerController::class , 'all']);
//window-handlers
Route::get('/all-window-handlers', [WindowHandlerController::class , 'all']);
//handler-positions
Route::get('/all-handler-positions', [HandlerPositionController::class , 'all']);
//opening-type-numbers
Route::get('/all-opening-type-numbers', [OpeningTypeNumberController::class , 'all']);
Route::get('/opening-type-numbers/opening-types/{opening_type_id}', [OpeningTypeNumberController::class , 'getByOpeningType']);
//handler-positions
Route::apiResource('handler-positions' , HandlerPositionController::class , [
    'only' => ['show' , 'index']
]);
//opening-type-numbers
Route::apiResource('opening-type-numbers' , OpeningTypeNumberController::class , [
    'only' => ['show' , 'index']
]);
Route::apiResource('types' , TypeController::class , [
    'only' => ['show' , 'index']
]);

Route::post('/order-details' , [PdfController::class , 'orderDetails']);
Route::post('/total-price' , [PdfController::class , 'totalPrice']);
Route::post('/order-price' , [OrderController::class ,'getOrderPrice']);

Route::get('/image' , function (){
    return view('image');
});

// API CRUD for Posts , Just for Fun
Route::apiResource('posts' , PostController::class);


