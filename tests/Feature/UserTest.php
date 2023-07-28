<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use WithFaker;

    public function test_user_can_register()
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->post('/register', $data);

        $response->assertStatus(302); 
        $this->assertAuthenticated(); 
    }

    public function test_login_with_valid_credentials()
    {
        $userData = [
            'email' => 'test@test.com',
            'password' => 'password',
        ];

        $response = $this->post('/login', $userData);

        $response->assertStatus(302); 
        $this->assertAuthenticated(); 
    }

    public function test_can_logout()
    {
        $user = $this->actingAs(User::factory()->create());

        $response = $this->post('/logout');

        $response->assertStatus(302); 
        $this->assertGuest(); 
    }
}
