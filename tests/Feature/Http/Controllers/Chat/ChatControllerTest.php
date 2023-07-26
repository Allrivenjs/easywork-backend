<?php

namespace Http\Controllers\Chat;

use App\Models\Message;
use App\Models\Room;
use App\Models\User;
use Tests\TestCase;

class ChatControllerTest extends TestCase
{
    public function testMarkAsRead()
    {
        $room = Room::factory()->create();
        $message = Message::factory()->create();
        $user = User::factory()->makeOne();
        $this->actingAs($user)->call('GET', route('chat.markAsRead', ['message' => $message->id]));
        $this->assertDatabaseHas('messages', ['id' => $message->id, 'read_at' => now()]);
        $room->delete();
        $message->delete();
    }

    public function testGetMessages()
    {
        $room = Room::factory()->create();
        $message = Message::factory()->create();
        $user = User::factory()->makeOne();
        $response = $this->actingAs($user)->get(route('chat.getMessages', ['room_id' => $room->id]));
        $response->assertOk();
        $room->delete();
        $message->delete();
    }

    public function testGetExistRoom()
    {
        $user = User::factory()->create();
        $receiver = User::factory()->create();
        $room = Room::factory()->create();
        $room->users()->attach([$user->id, $receiver->id]);
        $response = $this->actingAs($user)->get(route('chat.getExistRoom', ['receiver_id' => $receiver->id]));
        $data = [
            'id' => $room->id,
            'name' => $room->name,
            'type' => $room->type,
            'created_at' => $room->created_at,
            'updated_at' => $room->updated_at,
        ];
        $this->assertEquals($response->getContent(), json_encode($data));
        $response->assertOk();
        $room->delete();
        $user->delete();
        $receiver->delete();
    }

    public function testCreateChatRoom()
    {
        $user = User::factory()->create();
        $receiver = User::factory()->create();
        $response = $this->actingAs($user)->get(route('chat.getExistRoom', ['receiver_id' => $receiver->id]));
        $response->assertOk();
        Room::query()->find(json_decode($response->getContent())->id)->delete();
        $user->delete();
        $receiver->delete();
    }

    public function testGetRooms()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('chat.get-my-rooms'));
        $user->delete();
        $response->assertOk();
    }

    public function testSendMessage()
    {
        $user = User::factory()->create();
        $room = Room::factory()->create();
        $response = $this->actingAs($user)->post(route('chat.send-message'), ['message' => 'test', 'room_id' => $room->id]);
        $response->assertOk();
        $room->delete();
        $user->delete();
    }
}
