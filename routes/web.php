<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;
use Illuminate\Support\Facades\URL;
// use App\Jobs\SendMailToUser;

use App\Mail\NotifyUser;
use Illuminate\Support\Facades\Mail;

use App\Jobs\SendMails;

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

Route::get('/sendsms', function(Request $request){
    $userDataToMail = [
        'browserInfo'   => $request->header('User-Agent'),
        'loginIP'       => $request->ip(),
        'userInfo'      => ['name' => 'Biplob Shaha', 'email' => 'devbipu@gmail.com'],
        'mailInfo'      => 'Login Alert mail'
    ];
    $sendRes = Mail::to($userDataToMail['userInfo']['email'])->queue(new NotifyUser($userDataToMail));
    if ($sendRes) {
        return "SUCCESS";
    }
});

// Route::get('/', [FrontController::class, 'index']);
Route::get('/{any}', [FrontController::class, 'index'])->where('any', '.*');
