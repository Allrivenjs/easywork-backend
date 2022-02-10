<?php


use App\Http\Controllers\Auth\V1\AuthController;
use App\Http\Controllers\Profiles\UserController;
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

Route::post('login',[AuthController::class, 'login']);
Route::post('register',[AuthController::class, 'register']);


Route::middleware('auth:api')->group(function (){
    Route::get('user',[UserController::class, 'index']);
});

