<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PasswordTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_open_password_page(): void
    {
        $this->get('/password')->assertRedirect(route('login'));
    }

    public function test_user_can_change_password(): void
    {
        $user = User::factory()->create(['password' => 'password123']);

        $this->actingAs($user)
            ->put('/password', [
                'current_password' => 'password123',
                'password' => 'password-baru-123',
                'password_confirmation' => 'password-baru-123',
            ])
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $this->assertTrue(Hash::check('password-baru-123', $user->fresh()->password));
    }

    public function test_incorrect_current_password_is_rejected(): void
    {
        $user = User::factory()->create(['password' => 'password123']);

        $this->actingAs($user)
            ->from('/password')
            ->put('/password', [
                'current_password' => 'salah',
                'password' => 'password-baru-123',
                'password_confirmation' => 'password-baru-123',
            ])
            ->assertRedirect('/password')
            ->assertSessionHasErrors('current_password');

        $this->assertTrue(Hash::check('password123', $user->fresh()->password));
    }

    public function test_new_password_must_be_confirmed(): void
    {
        $user = User::factory()->create(['password' => 'password123']);

        $this->actingAs($user)
            ->from('/password')
            ->put('/password', [
                'current_password' => 'password123',
                'password' => 'password-baru-123',
                'password_confirmation' => 'beda-password',
            ])
            ->assertRedirect('/password')
            ->assertSessionHasErrors('password');
    }

    public function test_new_password_must_be_at_least_eight_characters(): void
    {
        $user = User::factory()->create(['password' => 'password123']);

        $this->actingAs($user)
            ->from('/password')
            ->put('/password', [
                'current_password' => 'password123',
                'password' => 'pendek',
                'password_confirmation' => 'pendek',
            ])
            ->assertRedirect('/password')
            ->assertSessionHasErrors('password');
    }
}
