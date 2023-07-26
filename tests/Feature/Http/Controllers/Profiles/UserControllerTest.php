<?php

namespace Tests\Feature\Http\Controllers\Profiles;

use App\Http\Controllers\Profiles\UserController;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class UserControllerTest extends TestCase
{

    public function testIndex()
    {
        $user = User::factory()->create();
        $user->profile()->create([
            'ranking'=> 0,
            'slug' => fake()->slug,
            'about' => fake()->text,
        ]);
        $this->actingAs($user)->get(route('user.index'))->assertOk();
    }

    public function testUpdate()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(route('user.update'), [
            'name' => 'test',
            'lastname' => 'test',
            'phone' => fake()->phoneNumber,
            'birthday' => now(),
            'profile_photo_path' => UploadedFile::fake()->image('test.jpg'),
        ]);
        $response->assertOk();
        $user->delete();
    }
}
