<?php

namespace Tests\Feature\Http\Controllers\Tasks;

use App\Models\AcceptTask;
use App\Models\task;
use App\Models\User;
use Tests\TestCase;


class AcceptTaskControllerTest extends TestCase
{

    public function testIndex()
    {
        $this->actingAs(User::factory()->makeOne())->get(route('tasks.accept-task.index'))->assertOk();
    }

    public function testAccept()
    {
        $task = task::factory()->create();
        $user = User::factory()->create();
        $taskAccept = AcceptTask::factory()->create([
            'task_id' => $task->id,
            'user_id' => $user->id,
            'charge' => fake()->numberBetween(100, 1000),
            'accepted_at' => null,
        ]);
        $response = $this->actingAs(User::factory()->makeOne())->post(route('tasks.accept-task.accept'), [
            'accept_task_id' => $taskAccept->id,
        ]);
        $response->assertOk();
        $this->assertDatabaseHas('accept_tasks', [
            'id' => $taskAccept->id,
            'accepted_at' => now(),
        ]);
        $taskAccept->delete();
        $task->delete();
        $user->delete();
    }

    public function testBeforeAccept()
    {

    }

    public function testDecline()
    {

    }

    public function testGetAcceptTask()
    {

    }
}
