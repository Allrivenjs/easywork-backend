<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Interfaces\Chat\RoomInterface;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{


    public function __construct(private RoomInterface $room){}

    public function getRooms(): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        return Response($this->room->getRooms());
    }

    public function getMessages($roomId): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        return Response($this->room->getMessages($roomId));
    }


    /**
     * @throws \Throwable
     */
    public function getExistRoom(Request $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $request->validate([
            'receiver_id' => 'required',
        ]);
        $userId = Auth::guard('api')?->user()?->getAuthIdentifier();
        $receiver_id = $request->query('receiver_id');
        throw_if(is_null($receiver_id), 'Receiver id is required for query param');
        throw_if($receiver_id == $userId, 'You can not chat with yourself');
        $match = $this->room->matchUser($receiver_id, $userId);
        $response = $match ?: $this->createChatRoom($receiver_id);

        return response($response);
    }

    public function createChatRoom($receiver_id): \App\Models\Room
    {
        $room = $this->room->createRoom(0);
        $userId = Auth::guard('api')?->user()?->getAuthIdentifier();
        $this->room->addUser($room->id, $receiver_id);
        $this->room->addUser($room->id, $userId);

        return $room;
    }

    public function sendMessage(Request $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $room = $request->validate([
            'room_id' => 'required|integer',
            'message' => 'required|string',
        ]);
        $this->room->sendMessage($room['room_id'], $room['message']);

        return Response(null);
    }

    public function markAsRead(Request $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $request->validate([
            'message' => 'required|exists:messages,id',
        ]);
        Message::query()->find($request->query('message'))->markAsReadTo();

        return Response(null);
    }
}
