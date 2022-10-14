<?php

namespace Http\Controllers\Auth\V1;

use App\Models\User;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    private function login(): array
    {
        $user = User::factory()->create();
        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        return compact('user', 'response');
    }

    public function testLogin()
    {
        $data = $this->login();
        $data['user']->delete();
        $data['response']->assertOk();
    }

    public function testLogout()
    {
        $data = $this->login();
        $response2 = $this->get(route('logout'), [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$data['response']->json('access_token'),
        ]);

        $data['user']->delete();
        $response2->assertOk();
    }

    public function testRegister()
    {
        $data = User::factory()->make()->toArray();
        $data['password'] = 'password';
        $response = $this->post(route('register'), $data);
        User::query()->where('email', $data['email'])->first()?->delete();
        $response->assertOk();
    }
}
