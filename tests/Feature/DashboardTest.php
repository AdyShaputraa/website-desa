<?php

namespace Tests\Feature;

use App\Models\Surat;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    private function userWithRole(string $role): User
    {
        Role::findOrCreate($role, 'web');
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $user = User::factory()->create();
        $user->assignRole($role);

        return $user;
    }

    private function suratFor(User $user, string $ticket): Surat
    {
        return Surat::create([
            'nomor_tiket' => $ticket,
            'user_id' => $user->id,
            'jenis_surat' => 'Domisili',
            'nik_pemohon' => '3201000000000099',
            'nama_pemohon' => $user->name,
            'keperluan' => 'Pengujian dashboard',
            'status' => 'Pending',
        ]);
    }

    public function test_admin_sees_global_stats_and_latest_requests(): void
    {
        $admin = $this->userWithRole('admin');
        $warga = $this->userWithRole('warga');
        $this->suratFor($warga, 'SRT-ADMIN-0001');

        $this->actingAs($admin)
            ->get('/dashboard')
            ->assertOk()
            ->assertSee(__('ui.stats.population'))
            ->assertSee(__('ui.table.surat_latest'))
            ->assertSee('SRT-ADMIN-0001');
    }

    public function test_staff_sees_operational_queue(): void
    {
        $staff = $this->userWithRole('staff');

        $this->actingAs($staff)
            ->get('/dashboard')
            ->assertOk()
            ->assertSee(__('ui.table.surat_queue'))
            ->assertSee(__('ui.table.pengaduan_queue'));
    }

    public function test_warga_only_sees_their_own_requests(): void
    {
        $warga = $this->userWithRole('warga');
        $other = $this->userWithRole('warga');

        $this->suratFor($warga, 'SRT-MINE-0001');
        $this->suratFor($other, 'SRT-OTHER-0001');

        $this->actingAs($warga)
            ->get('/dashboard')
            ->assertOk()
            ->assertSee(__('ui.table.surat_mine'))
            ->assertSee('SRT-MINE-0001')
            ->assertDontSee('SRT-OTHER-0001');
    }
}
