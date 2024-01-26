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
Route::get('/profile-colors/all', [ProfileColorController::class , 'all']);

Route::apiResource('window-colors' , WindowColorController::class);
Route::get('/window-colors/all', [WindowColorController::class , 'all']);

Route::apiResource('additional-services' , AdditionalServiceController::class);
Route::get('/additional-services/all', [AdditionalServiceController::class , 'all']);

Route::apiResource('assembly-services' , AssemblyServiceController::class);
Route::get('/assembly-services/all', [AssemblyServiceController::class , 'all']);

Route::apiResource('types' , TypeController::class);

Route::apiResource('opening-types' , OpeningTypeController::class);
Route::get('/opening-types/all', [OpeningTypeController::class , 'all']);

Route::apiResource('calculation-types' , CalculationTypeController::class);
Route::get('/calculation-types/all', [CalculationTypeController::class , 'all']);

Route::apiResource('profiles' , ProfileTypeController::class);
Route::get('/profiles/all', [ProfileTypeController::class , 'all']);

Route::apiResource('clients' , ClientController::class);
Route::get('/clients/all', [ClientController::class , 'all']);

Route::apiResource('corners' , CornerController::class);
Route::get('/corners/all', [CornerController::class , 'all']);

Route::apiResource('window-handlers' , WindowHandlerController::class);
Route::get('/window-handlers/all', [WindowHandlerController::class , 'all']);

Route::apiResource('sealants' , SealantController::class);
Route::get('/sealants/all', [SealantController::class , 'all']);

Route::apiResource('handler-types' , HandlerTypeController::class);
Route::get('/handler-types/all', [HandlerTypeController::class , 'all']);

Route::apiResource('orders' , OrderController::class);

Route::apiResource('statuses' , StatusController::class);

Route::apiResource('handler-positions' , HandlerPositionController::class);
Route::get('/handler-positions/all', [HandlerPositionController::class , 'all']);

Route::apiResource('opening-type-numbers' , OpeningTypeNumberController::class);
Route::get('/opening-type-numbers/all', [OpeningTypeNumberController::class , 'all']);

Route::post('/opening-type-numbers/addImage', [OpeningTypeNumberController::class , 'addImage']);

// Get Opening Types by Types
Route::get('/opening-types/type/{type_id}', [OpeningTypeController::class , 'getByType']);

Route::get('/pdf1' , [PdfController::class , 'exportPdf1']);
Route::get('/pdf2' , [PdfController::class , 'exportPdf2']);
Route::get('/pdf3' , [PdfController::class , 'exportPdf3']);
Route::get('/pdf4' , [PdfController::class , 'exportPdf4']);


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


