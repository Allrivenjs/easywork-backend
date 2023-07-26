<?php

namespace Http\Controllers\Posts;

use App\Models\Topic;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class TopicControllerTest extends TestCase
{
    public function testStore()
    {
        $this->withoutExceptionHandling();

        $this->actingAs(User::factory()->makeOne())->post(route('topics.store', [
            'name' => 'test',
        ]))->assertStatus(Response::HTTP_CREATED);
        Topic::query()->where('name', 'test')->first()?->delete();
    }

    public function testShow()
    {
        $this->withoutExceptionHandling();
        $topic = Topic::factory()->create();
        $response = $this->actingAs(User::factory()->makeOne())->get("api/topics/{$topic->id}")
            ->assertStatus(Response::HTTP_OK);
        $response->assertJson(fn (AssertableJson $json) => $json->where('name', $topic->name)->etc());
        $topic->delete();
    }

    public function testIndex()
    {
        $this->withoutExceptionHandling();
        $this->get(route('topics.index'))->assertStatus(Response::HTTP_OK);
    }

    public function testDestroy()
    {
        $this->withoutExceptionHandling();
        $topic = Topic::factory()->create();
        $this->actingAs(User::factory()->makeOne())->delete(route('topics.destroy', $topic->id))
            ->assertStatus(Response::HTTP_OK);
        $this->assertNull(Topic::query()->find($topic->id));
    }

    public function testUpdate()
    {
        $this->withoutExceptionHandling();
        $topic = Topic::factory()->create();
        $this->actingAs(User::factory()->makeOne())->put("api/topics/{$topic->id}", [
            'name' => 'test',
        ])->assertStatus(Response::HTTP_OK);
        $this->assertEquals('test', Topic::query()->find($topic->id)->name);
        $topic->delete();
    }
}
