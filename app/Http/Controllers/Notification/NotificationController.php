<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function show(): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $notifications = User::query()->find(Auth::id())->notifications()->latest()->paginate(10);
        return response($notifications);
    }

    public function markAsRead(Request $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $request->validate([
            'notification_id' => 'required|exists:notifications,id',
        ]);
        User::query()->find(Auth::id())->notifications()->find($request->notification_id)->markAsRead();
        return response(null);
    }
}
