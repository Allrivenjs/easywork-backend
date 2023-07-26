<?php

namespace Tests\Feature\Http\Controllers\Comment;

use App\Models\task;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
    public function testComment()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $post = task::factory()->create();
        $this->actingAs($user)->post(route('comment'), [
            'body' => 'Test comment',
            'own_id' => $user->id,
            'task_id' => $post->id,
        ])->assertStatus(Response::HTTP_CREATED);
        $user->delete();
        $post->comments()->each(fn ($comment) => $comment->delete());
        $post->delete();
    }

    public function testReply()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $post = task::factory()->create();
        $comment = $post->comments()->create([
            'body' => 'Test comment',
            'own_id' => $user->id,
        ]);
        $this->actingAs($user)->post(route('comment.reply'), [
            'body' => 'Test reply',
            'parent_id' => $comment->id,
            'own_id' => $user->id,
            'task_id' => $post->id,
        ])->assertStatus(Response::HTTP_OK);
        $user->delete();
        $post->comments()->each(function ($comment) {
            $comment->replies()->each(fn ($reply) => $reply->delete());
            $comment->delete();
        });
        $post->delete();
    }

    public function testDelete()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $post = task::factory()->create();
        $comment = $post->comments()->create([
            'body' => 'Test comment',
            'own_id' => $user->id,
        ]);
        $this->actingAs($user)->delete(route('comment.delete', $comment->id))->assertStatus(Response::HTTP_OK);
        $post->delete();
    }

    public function testGetComments()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->make();
        $postc = task::factory()->create();
        $post = task::query()->first();
        $this->actingAs($user)->call('GET', route('comment.get'), ['task_id' => $post->id])
            ->assertJson($post->comments()->with(['replies', 'owner'])->get()->toArray());
        $postc->delete();
    }
}
