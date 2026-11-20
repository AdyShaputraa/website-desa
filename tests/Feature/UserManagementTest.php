<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    private function userWithRole(string $role, array $attributes = []): User
    {
        Role::findOrCreate($role, 'web');
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $user = User::factory()->create(['is_active' => true, ...$attributes]);
        $user->assignRole($role);

        return $user;
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get('/users')->assertRedirect(route('login'));
    }

    public function test_non_admin_cannot_access_user_management(): void
    {
        $this->actingAs($this->userWithRole('staff'))
            ->get('/users')
            ->assertForbidden();
    }

    public function test_admin_sees_paginated_users(): void
    {
        $admin = $this->userWithRole('admin');
        User::factory()->count(12)->create(['is_active' => true]);

        $response = $this->actingAs($admin)->get('/users');

        $response->assertOk()
            ->assertSee('Menampilkan')
            ->assertSee('Manajemen Pengguna');

        $users = $response->viewData('users');

        $this->assertSame(10, $users->perPage());
        $this->assertSame(10, $users->count());
        $this->assertSame(13, $users->total());
    }

    public function test_admin_can_search_and_filter_by_role(): void
    {
        $admin = $this->userWithRole('admin');
        $staff = $this->userWithRole('staff', ['name' => 'Zulaikha Staff']);

        $search = $this->actingAs($admin)->get('/users?status=all&q=Zulaikha');
        $search->assertOk();
        $this->assertSame([$staff->id], $search->viewData('users')->pluck('id')->all());

        $filtered = $this->actingAs($admin)->get('/users?status=all&role=staff');
        $filtered->assertOk();
        $this->assertSame([$staff->id], $filtered->viewData('users')->pluck('id')->all());
    }

    public function test_admin_can_create_user_with_role(): void
    {
        $admin = $this->userWithRole('admin');
        Role::findOrCreate('staff', 'web');

        $this->actingAs($admin)
            ->post('/users', [
                'name' => 'Pengguna Baru',
                'email' => 'baru@example.com',
                'password' => 'password123',
                'password_confirmation' => 'password123',
                'nik' => '3201000000000123',
                'phone' => '081200000000',
                'roles' => ['staff'],
                'is_active' => '1',
            ])
            ->assertRedirect(route('users.index'));

        $user = User::where('email', 'baru@example.com')->firstOrFail();

        $this->assertTrue($user->hasRole('staff'));
        $this->assertTrue($user->is_active);
        $this->assertDatabaseHas('activity_log', [
            'subject_type' => User::class,
            'subject_id' => $user->id,
            'description' => 'roles_updated',
        ]);
    }

    public function test_admin_can_update_user_without_changing_password(): void
    {
        $admin = $this->userWithRole('admin');
        $user = $this->userWithRole('warga', ['password' => 'password123']);

        $originalHash = $user->password;

        $this->actingAs($admin)
            ->put("/users/{$user->id}", [
                'name' => 'Nama Diubah',
                'email' => $user->email,
                'password' => '',
                'password_confirmation' => '',
                'nik' => $user->nik,
                'phone' => '081299999999',
                'roles' => ['warga'],
                'is_active' => '1',
            ])
            ->assertRedirect(route('users.index'));

        $user->refresh();

        $this->assertSame('Nama Diubah', $user->name);
        $this->assertSame($originalHash, $user->password);
        $this->assertTrue(Hash::check('password123', $user->password));
    }

    public function test_admin_cannot_remove_own_admin_role_or_deactivate_self(): void
    {
        $admin = $this->userWithRole('admin');
        Role::findOrCreate('warga', 'web');

        $this->actingAs($admin)
            ->from("/users/{$admin->id}/edit")
            ->put("/users/{$admin->id}", [
                'name' => $admin->name,
                'email' => $admin->email,
                'roles' => ['warga'],
                'is_active' => '1',
            ])
            ->assertSessionHasErrors('roles');

        $this->assertTrue($admin->fresh()->hasRole('admin'));

        $this->actingAs($admin)
            ->from("/users/{$admin->id}/edit")
            ->put("/users/{$admin->id}", [
                'name' => $admin->name,
                'email' => $admin->email,
                'roles' => ['admin'],
                'is_active' => '0',
            ])
            ->assertSessionHasErrors('is_active');

        $this->assertTrue($admin->fresh()->is_active);
    }

    public function test_admin_cannot_delete_self(): void
    {
        $admin = $this->userWithRole('admin');

        $this->actingAs($admin)
            ->from('/users')
            ->delete("/users/{$admin->id}")
            ->assertSessionHasErrors('user');

        $this->assertNotSoftDeleted($admin);
    }

    public function test_admin_can_soft_delete_restore_and_force_delete_user(): void
    {
        $admin = $this->userWithRole('admin');
        $user = $this->userWithRole('warga');

        $this->actingAs($admin)->delete("/users/{$user->id}")->assertRedirect();
        $this->assertSoftDeleted($user);

        $this->actingAs($admin)->post("/users/{$user->id}/restore")->assertRedirect();
        $this->assertNotSoftDeleted($user);

        $this->actingAs($admin)->delete("/users/{$user->id}")->assertRedirect();
        $this->actingAs($admin)->delete("/users/{$user->id}/force")->assertRedirect();

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_bulk_actions_skip_own_account(): void
    {
        $admin = $this->userWithRole('admin');
        $user = $this->userWithRole('warga');

        $this->actingAs($admin)
            ->patch('/users/bulk', [
                'ids' => [$user->id, $admin->id],
                'action' => 'deactivate',
            ])
            ->assertRedirect()
            ->assertSessionHas('warning');

        $this->assertFalse($user->fresh()->is_active);
        $this->assertTrue($admin->fresh()->is_active);
    }

    public function test_inactive_user_is_logged_out_on_next_request(): void
    {
        $user = $this->userWithRole('warga', ['is_active' => false]);

        $this->actingAs($user)
            ->get('/dashboard')
            ->assertRedirect(route('login'));

        $this->assertGuest();
    }

    public function test_admin_can_export_filtered_users_as_csv(): void
    {
        $admin = $this->userWithRole('admin');
        $this->userWithRole('warga', ['name' => 'Warga Ekspor']);

        $response = $this->actingAs($admin)->get('/users/export?status=all&role=warga');

        $response->assertOk();
        $this->assertStringContainsString('text/csv', $response->headers->get('content-type'));

        $csv = $response->streamedContent();

        $this->assertStringContainsString('Name,Email,Roles,NIK,Phone,Status', $csv);
        $this->assertStringContainsString('Warga Ekspor', $csv);
    }
}
