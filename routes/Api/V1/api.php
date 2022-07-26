<?php

use App\Http\Controllers\Auth\V1\AuthController;
use App\Http\Controllers\Chat\ChatController;
use App\Http\Controllers\Comment\CommentController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Courses\CoursesController;
use App\Http\Controllers\Notification\NotificationController;
use App\Http\Controllers\Payment\PaymentController;
use App\Http\Controllers\Profiles\ProfileController;
use App\Http\Controllers\Profiles\UserController;
use App\Http\Controllers\Profiles\UserTypeController;
use App\Http\Controllers\Tasks\AcceptTaskController;
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

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('register', [AuthController::class, 'register'])->name('register');

Route::get('profile/{profile}', [ProfileController::class, 'getProfileForSlug'])->name('profile.search');

Route::get('courses', [CoursesController::class, 'getCourses'])->name('courses');
Route::get('courses/{course}', [CoursesController::class, 'showCoursesWithSections']);
Route::get('courses/{course}/{video} ', [CoursesController::class, 'showVideo']);

Route::middleware('auth:api')->group(function () {

    Route::post('task/accept-task', [AcceptTaskController::class, 'index'])->name('tasks.accept-task');

    Route::get('me-notifications', [NotificationController::class, 'show']);
    Route::get('notifications-markAsRead', [NotificationController::class, 'markAsRead']);

    Route::post('comment-reply', [CommentController::class, 'reply'])->name('task.comment.reply');
    Route::post('comment', [CommentController::class, 'comment'])->name('task.comment');

    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('user', [UserController::class, 'index'])->name('user.index');
    Route::post('user/update', [UserController::class, 'update'])->name('user.update');
    Route::post('profile/update', [ProfileController::class, 'updateAboutProfile'])->name('profile.update');
    Route::post('profile/image/update', [ProfileController::class, 'updateImageProfile'])->name('profile.image.update');

    Route::get('get-my-rooms', [ChatController::class, 'getRooms'])->name('get-my-rooms');
    Route::get('chat/message/{room_id}', [ChatController::class, 'getMessages'])->name('chat.getMessages');
    Route::get('chat/exist-room-or-create', [ChatController::class, 'getExistRoom'])->name('chat.getExistRoom');
    Route::get('chat/markAsRead', [ChatController::class, 'markAsRead'])->name('chat.markAsRead');
    Route::post('chat/send-message', [ChatController::class, 'sendMessage'])->name('chat.sendMessage');

    Route::prefix('coursesAdmin')->group(function () {
        Route::middleware('can:coursesAdmin.course')->group(function () {
            //store
            Route::post('courses', [CoursesController::class, 'storeCourse'])->name('coursesAdmin.store.course ');
            Route::post('section/{course}', [CoursesController::class, 'storeSection'])->name('coursesAdmin.store.section');
            Route::post('video/{section}', [CoursesController::class, 'storeVideo'])->name('coursesAdmin.store.video');
            //update
            Route::post('courses/update/{course}', [CoursesController::class, 'updateCourse'])->name('coursesAdmin.update.course ');
            Route::post('section/update/{section}', [CoursesController::class, 'updateSection'])->name('coursesAdmin.update.section');
            Route::post('video/update/{video}', [CoursesController::class, 'updateVideo'])->name('coursesAdmin.update.video');
            //soft delete or hidden
            Route::delete('courses/hidden/{course}', [CoursesController::class, 'deleteCourse'])->name('coursesAdmin.delete.course ');
            Route::delete('section/hidden/{section}', [CoursesController::class, 'deleteSection'])->name('coursesAdmin.delete.section');
            Route::delete('video/hidden/{video}', [CoursesController::class, 'deleteVideo'])->name('coursesAdmin.delete.video');
            //force delete
            Route::delete('courses/hidden/{course}', [CoursesController::class, 'forceDeleteCourse'])->name('coursesAdmin.forceDelete.course ');
            Route::delete('section/hidden/{section}', [CoursesController::class, 'forceDeleteSection'])->name('coursesAdmin.forceDelete.section');
            Route::delete('video/hidden/{video}', [CoursesController::class, 'forceDeleteVideo'])->name('coursesAdmin.forceDelete.video');
        });
    });
    Route::apiResource('userType', UserTypeController::class);
    Route::get('getAnyFile', [Controller::class, 'getAnyFile']);
});

Route::get('tasks/{task}', [TasksController::class, 'getTasksForSlug']);
Route::apiResource('tasks', TasksController::class)->except('show', 'update');
Route::post('tasks/{task:id}', [TasksController::class, 'update']);
Route::apiResource('status', StatusController::class)->names('status');
Route::apiResource('topics', TopicController::class)->names('topics');

Route::get('getComments', [CommentController::class, 'getComments'])->name('task.getComments');
Route::get('me/tasks', [ProfileController::class, 'index'])->name('profile.me.task')->middleware(['auth:api']);

Route::get('ChatPresentChannel', function () {
    broadcast(new \App\Events\ChatPresentChannel(\App\Models\User::find(1)));
});

Route::prefix('payments')->group(function () {
    Route::post('pay', [PaymentController::class, 'pay'])->name('payments.pay');
});
