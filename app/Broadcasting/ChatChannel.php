<?php

namespace App\Broadcasting;

use App\Models\Room;
use App\Models\User;

class ChatChannel
{
    /**
     * Create a new channel instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Authenticate the user's access to the channel.
     *
     * @param  \App\Models\User  $user
     * @return array|bool
     */
    public function join(User $user, $room_id)
    {
        return Room::query()->whereHas('users', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->where('id', $room_id)->exists();
    }
}
