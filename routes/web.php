<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;
use Illuminate\Support\Facades\URL;
// use App\Jobs\SendMailToUser;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/






Route::get('/sendmail', function(){
	$userDataToMail = [
        'browserInfo'   => 'chrome',
        'userInfo'      => ['name' => 'Biplob Shaha', 'email' => 'devbipu@gmail.com'],
        'mailInfo'      => 'Login Alert mail'
    ];
	dispatch(new App\Jobs\SendMailToUser($userDataToMail));
	dd("success");
});



// Route::get('/', [FrontController::class, 'index']);
Route::get('/{any}', [FrontController::class, 'index'])->where('any', '.*');

// Route::get('/', [FrontController::class, 'showview']);