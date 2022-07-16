<?php

namespace App\Http\Controllers\Chat;


use App\Http\Controllers\Controller;
use App\Interfaces\Chat\RoomInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ChatController extends Controller
{

    private RoomInterface $room;

    public function __construct(RoomInterface $room)
    {
        $this->room = $room;
    }

    public function getRooms(): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        return Response($this->room->getRooms());
    }

    public function getMessages($roomId): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        return Response($this->room->getMessages($roomId));
    }

    public function getExistRoom(Request $request): \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
    {
       $receiver_id = $request->query('receiver_id');
       $user_id = auth::guard('api')->user()->getAuthIdentifier();
       $match = $this->room->matchUser($receiver_id, $user_id);
       $respose = $match ?: $this->createChatRoom($receiver_id);
       return response($respose);
    }

    public function createChatRoom($receiver_id): \App\Models\Room
    {
        $room = $this->room->createRoom( 0);
        $this->room->addUser($room->id, $receiver_id);
        $this->room->addUser($room->id, Auth::guard('api')->user()->getAuthIdentifier());
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

}
