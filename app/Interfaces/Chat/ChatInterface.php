<?php

namespace App\Interfaces\Chat;

interface ChatInterface extends RoomInterface
{
    public function getMessages($roomId);

    public function sendMessage($roomId, $message): void;

    public function getRooms();
}
