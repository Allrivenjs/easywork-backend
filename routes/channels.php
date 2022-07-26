<?php

use App\Models\Room;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('chat-channel.{room_id}', function ($user, $room_id) {
    return Room::query()->whereHas('users', function ($query) use ($user) {
        $query->where('user_id', $user->id);
    })->where('id', $room_id)->exists();
});

Broadcast::channel('channel-session', function ($user) {
    return $user;
});
