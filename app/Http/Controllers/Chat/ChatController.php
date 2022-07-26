<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Interfaces\Chat\RoomInterface;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    private mixed $userId;

    public function __construct(private RoomInterface $room)
    {
        $this->userId = Auth::guard('api')?->user()?->getAuthIdentifier();
    }

    public function getRooms(): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        return Response($this->room->getRooms());
    }

    public function getMessages($roomId): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        return Response($this->room->getMessages($roomId));
    }

    /**
     * @throws \Exception
     */
    public function getExistRoom(Request $request): \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
    {
        $request->validate([
            'receiver_id' => 'required',
        ]);
        $receiver_id = $request->query('receiver_id');
        if ($receiver_id == $this->userId) throw new \Exception('You can not chat with yourself');
        $match = $this->room->matchUser($receiver_id, $this->userId);
        $response = $match ?: $this->createChatRoom($receiver_id);

        return response($response);
    }

    public function createChatRoom($receiver_id): \App\Models\Room
    {
        $room = $this->room->createRoom(0);

        $this->room->addUser($room->id, $receiver_id);
        $this->room->addUser($room->id, $this->userId);

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
