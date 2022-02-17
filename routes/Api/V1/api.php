<?php


use App\Http\Controllers\Auth\V1\AuthController;
use App\Http\Controllers\Courses\CoursesController;
use App\Http\Controllers\Profiles\ProfileController;
use App\Http\Controllers\Profiles\UserController;
use App\Http\Controllers\Profiles\UserTypeController;
use App\Http\Controllers\Tasks\StatusController;
use App\Http\Controllers\Tasks\TasksController;
use App\Http\Controllers\Tasks\TopicController;
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

Route::get('courses',[CoursesController::class, 'getCourses'])->name('courses');
Route::get('courses/{course}',[CoursesController::class, 'showCoursesWithSections']);
Route::get('courses/{course}/{video} ',[CoursesController::class, 'showVideo']);

Route::middleware('auth:api')->group(function (){

    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('user', [UserController::class, 'index'])->name('user.index');
    Route::post('user/update', [UserController::class, 'update'])->name('user.update');
    Route::post('profile/update',[ProfileController::class, 'updateAboutProfile'])->name('profile.update');
    Route::post('profile/image/update',[ProfileController::class, 'updateImageprofile'])->name('profile.image.update');

Route::prefix('coursesAdmin')->group(function (){

    Route::middleware('can:coursesAdmin.course')->group(function (){
        //store
        Route::post('courses',[CoursesController::class, 'storeCourse'])->name('coursesAdmin.store.course ');
        Route::post('section/{course}',[CoursesController::class, 'storeSection'])->name('coursesAdmin.store.section');
        Route::post('video/{section}',[CoursesController::class, 'storeVideo'])->name('coursesAdmin.store.video');
        //update
        Route::post('courses/update/{course}',[CoursesController::class, 'updateCourse'])->name('coursesAdmin.update.course ');
        Route::post('section/update/{section}',[CoursesController::class, 'updateSection'])->name('coursesAdmin.update.section');
        Route::post('video/update/{video}',[CoursesController::class, 'updateVideo'])->name('coursesAdmin.update.video');
        //soft delete or hidden
        Route::delete('courses/hidden/{course}',[CoursesController::class, 'deleteCourse'])->name('coursesAdmin.delete.course ');
        Route::delete('section/hidden/{section}',[CoursesController::class, 'deleteSection'])->name('coursesAdmin.delete.section');
        Route::delete('video/hidden/{video}',[CoursesController::class, 'deleteVideo'])->name('coursesAdmin.delete.video');
        //force delete
        Route::delete('courses/hidden/{course}',[CoursesController::class, 'forceDeleteCourse'])->name('coursesAdmin.forceDelete.course ');
        Route::delete('section/hidden/{section}',[CoursesController::class, 'forceDeleteSection'])->name('coursesAdmin.forceDelete.section');
        Route::delete('video/hidden/{video}',[CoursesController::class, 'forceDeleteVideo'])->name('coursesAdmin.forceDelete.video');

    });


});
    Route::apiResource('userType', UserTypeController::class);
    Route::apiResource('status',StatusController::class)->names('status');
    Route::apiResource('topics', TopicController::class)->names('topics');

    //  Route::post('userType/{use rType}',[ UserTypeController::class, 'update']);
});
Route::apiResource('tasks', TasksController::class);
