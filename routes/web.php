<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

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


Route::get('/', function () {
    return view('welcome');
});

// Route::post('/login',[AuthController::class, 'authenticate']);

Route::post('/logout',[AuthController::class, 'logout']);

// Route::post('/register',[AuthController::class, 'register']);

// Route::post('/forget-password',[AuthController::class, 'forget']);

// Route::get('/email',[AuthController::class, 'emailtest']);

// Route::get('/auth/user', [AuthController::class, 'me'])->middleware('auth:sanctum');

// Route::get('/login',function(){
//     return '';
// });

// Route::get('/email/verify', function () {
//     return view('auth.verify-email');
// });

// Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
//     $request->fulfill();
 
//     return redirect('/home');
// });

// Route::post('/email/verification-notification', function (Request $request) {
//     $request->user()->sendEmailVerificationNotification();
 
//     return back()->with('message', 'Verification link sent!');
// });

// Route::get('/email/verify', 'Auth\VerificationController@show')->name('verification.notice');

// Route::get('/verification/verify','Auth\VerificationController@show')->name('verification.notice');

// Route::get('/users', function () {
//     return \App\Models\User::all();
// })->middleware('auth:sanctum');



Route::get('clear-cache', function() {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});


require __DIR__.'/auth.php';