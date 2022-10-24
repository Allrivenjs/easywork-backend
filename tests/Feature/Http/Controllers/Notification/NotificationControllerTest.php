<?php

namespace Tests\Feature\Http\Controllers\Notification;


use App\Models\task;
use App\Models\User;
use App\Notifications\CommentReplyNotification;
use Doctrine\DBAL\Driver\Middleware\AbstractConnectionMiddleware;
use Illuminate\Notifications\Notification;
use Tests\TestCase;

class NotificationControllerTest extends TestCase
{

    public function testMarkAsRead()
    {
        $user = User::factory()->create();
        $task = task::factory()->create();
        $newComment = $task->comments()->create([
            'body' => fake()->text,
            'own_id' => $user->id,
        ]);
        $user->notify(new CommentReplyNotification($newComment) );
        $id = $user->unreadNotifications()->first()->id;
        $response = $this->actingAs($user)->call('GET', route('notification.markAsRead'), [
            'notification_id' => $id,
        ]);
        $this->assertDatabaseHas('notifications', ['id' => $id, 'read_at' => now()]);
        $user->notifications()->find($id)->delete();
        $user->delete();
        $newComment->delete();
        $task->delete();



    }

    public function testShow()
    {
        $this->actingAs(User::find(1))->get(route('notification.show'))->assertOk();
    }
}
