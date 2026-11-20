<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Penduduk;
use App\Models\Pengaduan;
use App\Models\Surat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $role = $user->getRoleNames()->first();

        if (! in_array($role, ['admin', 'staff', 'warga'], true)) {
            $role = 'warga';
        }

        [$stats, $surats, $pengaduans] = match ($role) {
            'admin' => $this->adminData(),
            'staff' => $this->staffData(),
            default => $this->wargaData($user),
        };

        return view('dashboard', [
            'role' => $role,
            'stats' => $stats,
            'surats' => $surats,
            'pengaduans' => $pengaduans,
        ]);
    }

    /**
     * @return array{0: array<int, array<string, string>>, 1: \Illuminate\Database\Eloquent\Collection<int, Surat>, 2: \Illuminate\Database\Eloquent\Collection<int, Pengaduan>}
     */
    private function adminData(): array
    {
        return [
            [
                ['label' => __('ui.stats.population'), 'value' => number_format(Penduduk::count()), 'icon' => 'heroicon-o-users'],
                ['label' => __('ui.stats.surat_total'), 'value' => number_format(Surat::count()), 'icon' => 'heroicon-o-document-text'],
                ['label' => __('ui.stats.pengaduan_total'), 'value' => number_format(Pengaduan::count()), 'icon' => 'heroicon-o-chat-bubble-left-right'],
                ['label' => __('ui.stats.berita_published'), 'value' => number_format(Berita::published()->count()), 'icon' => 'heroicon-o-newspaper'],
            ],
            Surat::with('user')->latest()->take(5)->get(),
            Pengaduan::with('user')->latest()->take(5)->get(),
        ];
    }

    /**
     * @return array{0: array<int, array<string, string>>, 1: \Illuminate\Database\Eloquent\Collection<int, Surat>, 2: \Illuminate\Database\Eloquent\Collection<int, Pengaduan>}
     */
    private function staffData(): array
    {
        return [
            [
                ['label' => __('ui.stats.surat_pending'), 'value' => number_format(Surat::where('status', 'Pending')->count()), 'icon' => 'heroicon-o-clock'],
                ['label' => __('ui.stats.surat_processing'), 'value' => number_format(Surat::where('status', 'Diproses')->count()), 'icon' => 'heroicon-o-document-text'],
                ['label' => __('ui.stats.pengaduan_pending'), 'value' => number_format(Pengaduan::where('status', 'Pending')->count()), 'icon' => 'heroicon-o-exclamation-circle'],
                ['label' => __('ui.stats.pengaduan_processing'), 'value' => number_format(Pengaduan::where('status', 'Proses')->count()), 'icon' => 'heroicon-o-chat-bubble-left-right'],
            ],
            Surat::with('user')->whereIn('status', ['Pending', 'Diproses'])->latest()->take(5)->get(),
            Pengaduan::with('user')->whereIn('status', ['Pending', 'Proses'])->latest()->take(5)->get(),
        ];
    }

    /**
     * @return array{0: array<int, array<string, string>>, 1: \Illuminate\Database\Eloquent\Collection<int, Surat>, 2: \Illuminate\Database\Eloquent\Collection<int, Pengaduan>}
     */
    private function wargaData(User $user): array
    {
        return [
            [
                ['label' => __('ui.stats.surat_mine'), 'value' => number_format($user->surats()->count()), 'icon' => 'heroicon-o-document-text'],
                ['label' => __('ui.stats.surat_done'), 'value' => number_format($user->surats()->where('status', 'Selesai')->count()), 'icon' => 'heroicon-o-check-circle'],
                ['label' => __('ui.stats.pengaduan_mine'), 'value' => number_format($user->pengaduans()->count()), 'icon' => 'heroicon-o-chat-bubble-left-right'],
                ['label' => __('ui.stats.pengaduan_done'), 'value' => number_format($user->pengaduans()->where('status', 'Selesai')->count()), 'icon' => 'heroicon-o-check-badge'],
            ],
            $user->surats()->latest()->take(5)->get(),
            $user->pengaduans()->latest()->take(5)->get(),
        ];
    }
}
