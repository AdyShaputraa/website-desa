<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_open_settings(): void
    {
        $this->get('/settings')->assertRedirect(route('login'));
    }

    public function test_user_can_update_name_and_email(): void
    {
        $user = User::factory()->create([
            'name' => 'Nama Lama',
            'email' => 'lama@example.com',
        ]);

        $this->actingAs($user)
            ->patch('/settings', [
                'name' => 'Nama Baru',
                'email' => 'baru@example.com',
            ])
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Nama Baru',
            'email' => 'baru@example.com',
        ]);

        $this->actingAs($user->fresh())
            ->get('/settings')
            ->assertOk()
            ->assertSee('Nama Baru');
    }

    public function test_email_must_be_unique(): void
    {
        User::factory()->create(['email' => 'dipakai@example.com']);

        $user = User::factory()->create(['email' => 'saya@example.com']);

        $this->actingAs($user)
            ->from('/settings')
            ->patch('/settings', [
                'name' => $user->name,
                'email' => 'dipakai@example.com',
            ])
            ->assertRedirect('/settings')
            ->assertSessionHasErrors('email');
    }

    public function test_user_can_keep_their_own_email(): void
    {
        $user = User::factory()->create(['email' => 'saya@example.com']);

        $this->actingAs($user)
            ->patch('/settings', [
                'name' => $user->name,
                'email' => 'saya@example.com',
            ])
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => 'saya@example.com',
        ]);
    }

    public function test_validation_messages_follow_locale(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->from('/settings')
            ->patch('/settings', [
                'name' => '',
                'email' => 'bukan-email',
            ])
            ->assertSessionHasErrors(['name', 'email']);

        $errors = session('errors');

        $this->assertStringContainsString('wajib diisi', $errors->first('name'));
        $this->assertStringContainsString('alamat email yang valid', $errors->first('email'));
    }
}
