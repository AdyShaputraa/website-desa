<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_from_dashboard_to_login(): void
    {
        $this->get('/dashboard')->assertRedirect(route('login'));
    }

    public function test_user_can_login_with_email_and_password(): void
    {
        $user = User::factory()->create(['password' => 'password123']);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password123',
        ])->assertRedirect(route('dashboard'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_login_fails_with_incorrect_password(): void
    {
        $user = User::factory()->create(['password' => 'password123']);

        $this->from('/login')
            ->post('/login', [
                'email' => $user->email,
                'password' => 'wrong-password',
            ])
            ->assertRedirect('/login')
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_authenticated_user_is_redirected_to_dashboard_from_home(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/')->assertRedirect(route('dashboard'));
    }

    public function test_user_can_logout_and_is_redirected_to_login(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('/logout')
            ->assertRedirect(route('login'));

        $this->assertGuest();
    }
}
