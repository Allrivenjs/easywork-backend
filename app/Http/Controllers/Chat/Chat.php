<?php

namespace App\Http\Controllers\Chat;

use App\Events\MessageNotification;
use App\Interfaces\Chat\ChatInterface;
use App\Models\Message;
use App\Models\Room;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class Chat implements ChatInterface
{
    public function createRoom(bool $type): Room
    {
        $name = Str::uuid();
        $room = new Room();
        $room->name = $name;
        $room->type = $type;
        $room->save();
        return $room;
    }

    public function getUsers($roomId): User | array
    {
        $room = Room::query()->find($roomId);
        return $room->users;
    }

    public function addUser($roomId, $userId): void
    {
        $room = Room::query()->find($roomId);
        $user = User::query()->find($userId);
        $room->users()->attach($user);
    }

    public function sendMessage($roomIdId, $message): void
    {
        $user = Auth::guard('api')->user()->getAuthIdentifier();
        $data = [
            'message'=>$message,
            'user_id'=>$user,
            'room_id'=>$roomIdId->id
        ];
        $message = new Message($data);
        $message->save();
        broadcast(new MessageNotification($data))->toOthers();
    }

    public function getRooms(): array
    {
        return User::query()->find(Auth::guard('api')->user()->getAuthIdentifier())->rooms;
    }


    public function getMessages($roomId)
    {
        $room = Room::query()->with('messages')->find($roomId);
        return $room->messages;
    }

    public function matchUser($receiverId, $userId): \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model| bool
    {
        $personOne = Room::query()->whereHas('users', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->first();
        $personTwo = Room::query()->whereHas('users', function ($query) use ($receiverId) {
            $query->where('user_id', $receiverId);
        })->first();

        if ($personOne && $personTwo) {
            return $personOne->id === $personTwo->id ? $personOne : false;
        }
        return false;
    }
}
