<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\V1\AuthController;
use App\Http\Controllers\Auth\VerificationController;
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

Route::controller(AuthController::class)->group(function (){
    Route::post('login');
    Route::post('register');
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/email/verify/{id}/{hash}',[VerificationController::class,'__invoke'])->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
Route::post('/email/verification-notification',[VerificationController::class, 'resend'] )->middleware(['auth:api', 'throttle:6,1'])->name('verification.send');
//Route::get('/profile/{slug}',[ProfileController::class, 'getProfileForSlug'])->name('profile-slug');
Route::prefix('/user')->group(function (){
    //passwordReset
    Route::post('/forgot-password',[ForgotPasswordController::class, 'forgot_password'])->middleware('guest')->name('password.email');
    Route::post('/reset-password',[ResetPasswordController::class, 'reset_password'])->middleware('guest')->name('password.update');

});
