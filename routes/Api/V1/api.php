<?php


use App\Http\Controllers\Auth\V1\AuthController;
use App\Http\Controllers\Profiles\ProfileController;
use App\Http\Controllers\Profiles\UserController;
use App\Http\Controllers\Profiles\UserTypeController;
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

Route::post('login',[AuthController::class, 'login'])->name('login');
Route::post('register',[AuthController::class, 'register'])->name('register');


Route::get('profile/{profile}', [ProfileController::class, 'getProfileForSlug'])->name('profile.search');

Route::middleware('auth:api')->group(function (){

    Route::get('user', [UserController::class, 'index'])->name('user.index');
    Route::post('user/update', [UserController::class, 'update'])->name('user.update');
    Route::post('profile/update',[ProfileController::class, 'updateAboutProfile'])->name('profile.update');

    Route::apiResource('userType', UserTypeController::class);
  //  Route::post('userType/{userType}',[ UserTypeController::class, 'update']);
});

