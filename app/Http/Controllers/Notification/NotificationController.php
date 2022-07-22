<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function show()
    {
        $notifications = User::query()->find(Auth::id())->notifications()->latest()->paginate(10);
        return response($notifications);
    }

    public function markAsRead(Request $request)
    {
        $request->validate([
            'notification_id' => 'required|exists:notifications,id',
        ]);
        User::query()->find(Auth::id())->notifications()->find($request->notification_id)->markAsRead();
        return response(null);
    }
}
