<?php

namespace Tests\Feature\Http\Controllers\Tasks;

use App\Http\Controllers\Tasks\StatusController;
use App\Models\Status;
use App\Models\User;
use Tests\TestCase;

class StatusControllerTest extends TestCase
{

    public function testStore()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $user->assignRole('admin');
        $this->actingAs($user, 'api');
        $response = $this->postJson(route('status.store'), [
            'name' => 'test'
        ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('statuses', [
            'name' => 'test'
        ]);
        Status::query()->where('name', 'test')->first()->delete();
        $user->delete();
    }

    public function testDestroy()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $user->assignRole('admin');
        $this->actingAs($user, 'api');
        $status = Status::factory()->create();
        $response = $this->deleteJson(route('status.destroy', $status->id));
        $response->assertStatus(200);
        $this->assertDatabaseMissing('statuses', [
            'id' => $status->id
        ]);
        $user->delete();
    }

    public function testShow()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->makeOne();
        $this->actingAs($user, 'api');
        $user->assignRole('admin');
        $status = Status::factory()->create();
        $response = $this->getJson(route('status.show', $status->id));
        $response->assertStatus(200);
        $this->assertDatabaseHas('statuses', [
            'id' => $status->id
        ]);
        $user->delete();
        $status->delete();
    }

    public function testUpdate()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $user->assignRole('admin');
        $this->actingAs($user, 'api');
        $status = Status::factory()->create();
        $response = $this->putJson(route('status.update', $status->id), [
            'name' => 'test'
        ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('statuses', [
            'id' => $status->id,
            'name' => 'test'
        ]);
        $user->delete();
        $status->delete();
    }

    public function testIndex()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->makeOne();
        $user->assignRole('admin');
        $this->actingAs($user, 'api');
        $response = $this->getJson(route('status.index'));
        $response->assertStatus(200);
        $user->delete();
    }
}
