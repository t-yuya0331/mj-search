<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Mockery;
use Socialite;

class LoginControllerTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    // Register test
    public function testRegisterFUnctionality()
    {
        $response = $this->post('/register', [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect('/');
        $this->assertGuest();
}

    // Login test
    public function testLoginFunctionality()
    {
        $testUser = User::factory()->create();

        $response = $this->actingAs($testUser)->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($testUser);
    }

}
