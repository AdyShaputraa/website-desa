<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class LocalizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_switch_to_english_from_login_page(): void
    {
        $this->from('/login')
            ->get('/language/en')
            ->assertRedirect('/login')
            ->assertSessionHas('locale', 'en');

        $this->get('/login')->assertSee('Sign in to your account');
    }

    public function test_user_can_switch_back_to_indonesian(): void
    {
        $this->withSession(['locale' => 'en'])
            ->from('/login')
            ->get('/language/id')
            ->assertRedirect('/login');

        $this->get('/login')->assertSee('Masuk ke akun Anda');
    }

    public function test_unsupported_locale_is_not_found(): void
    {
        $this->get('/language/fr')->assertNotFound();
    }

    public function test_dashboard_follows_selected_language(): void
    {
        Role::findOrCreate('admin', 'web');

        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $this->withSession(['locale' => 'en'])
            ->actingAs($admin)
            ->get('/dashboard')
            ->assertOk()
            ->assertSee('Total residents')
            ->assertSee('Latest requests');
    }
}
