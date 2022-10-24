<?php

namespace Tests\Feature\Http\Controllers\Profiles;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;


class ProfileControllerTest extends TestCase
{
    public function testUpdateAboutProfile()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->call('POST', route('profile.update'), [
            'about' => fake()->text,
        ]);
        $response->assertStatus(200);
        $user->delete();
    }

    public function testUpdateImageProfile()
    {
        $user = User::factory()->create();
        $user->profile()->create([
            'ranking'=> 0,
            'slug' => fake()->slug,
            'about' => fake()->text,
        ]);
        $response = $this->actingAs($user)->call('POST', route('profile.update.image'), [
            'image' => UploadedFile::fake()->image('test.jpg'),
        ]);
        $response->assertStatus(201);
        $user->profile->delete();
        $user->delete();
    }

    public function testIndex()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->call('GET', route('profile.me.task'));
        $response->assertStatus(200);
        $user->delete();
    }

    public function testGetProfileForSlug()
    {
        $user = User::factory()->create();
        $user->profile()->create([
            'ranking'=> 0,
            'slug' => fake()->slug,
            'about' => fake()->text,
        ]);
        $response = $this->actingAs($user)->call('GET', route('profile.search', $user->profile->slug));
        $response->assertStatus(200);
        $user->profile->delete();
        $user->delete();
    }
}
