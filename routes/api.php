<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\FileUploadController;
use App\Models\User;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return User::where('id', request()->user()->id)
    ->with(['avatar' => function($query){
        $query->select(['id','view_path',]);
    }])->first();
});



Route::controller(AuthController::class)->group(function(){
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
});

Route::controller(FileUploadController::class)->group( function(){
    Route::get('/getimages', 'retriveImages');
    Route::post('/imgupload', 'uploadFile');
    Route::post('/deletefile', 'deleteFile');
});
