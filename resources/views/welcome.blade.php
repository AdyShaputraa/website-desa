@extends('layouts.guest')

@section('title', 'Beranda')
@section('description', 'Halaman verifikasi instalasi Portal Desa Digital: Laravel, Tailwind CSS, Alpine.js, dan Fontsource.')

@section('content')
    <div class="mx-auto w-full max-w-3xl px-4 py-10 sm:px-6 lg:py-16">
        <x-ui.page-header
            eyebrow="Verifikasi instalasi"
            title="Selamat datang di Portal Desa Digital"
            description="Halaman ini memastikan seluruh lapisan aplikasi — backend, stylesheet, dan interaktivitas — sudah terpasang dengan benar."
        >
            <x-slot:actions>
                <x-ui.badge variant="success" dot>Lingkungan lokal</x-ui.badge>
            </x-slot:actions>
        </x-ui.page-header>

        <x-ui.card class="mt-8">
            <x-slot:header>
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <h2 class="font-display text-base font-semibold tracking-tight">Ringkasan versi</h2>
                        <p class="mt-0.5 text-sm text-muted-foreground">Komponen utama yang berjalan saat ini.</p>
                    </div>

                    <x-heroicon-o-cpu-chip class="size-5 text-muted-foreground" />
                </div>
            </x-slot:header>

            <dl class="divide-y divide-border text-sm">
                @foreach ([
                    ['label' => 'Laravel', 'value' => app()->version()],
                    ['label' => 'PHP', 'value' => PHP_VERSION],
                    ['label' => 'Tailwind CSS', 'value' => 'v4'],
                    ['label' => 'Font', 'value' => 'Plus Jakarta Sans & Fraunces'],
                ] as $row)
                    <div class="flex items-center justify-between gap-4 py-3 first:pt-0 last:pb-0">
                        <dt class="text-muted-foreground">{{ $row['label'] }}</dt>
                        <dd class="text-right font-semibold text-foreground">{{ $row['value'] }}</dd>
                    </div>
                @endforeach

                <div class="flex items-center justify-between gap-4 py-3 last:pb-0">
                    <dt class="text-muted-foreground">Alpine.js</dt>
                    <dd class="text-right font-semibold text-foreground" x-text="window.Alpine ? 'v' + window.Alpine.version : 'memuat…'">
                        memuat…
                    </dd>
                </div>
            </dl>
        </x-ui.card>

        <x-ui.alert variant="success" title="Aset frontend termuat" class="mt-6">
            Jika halaman ini tampil rapi dan versi di atas terisi, berarti Tailwind CSS, Alpine.js, dan
            Fontsource sudah berjalan dengan benar.
        </x-ui.alert>

        <x-ui.card class="mt-6" x-data="{ tampil: true }">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h2 class="font-display text-base font-semibold tracking-tight">Uji interaksi Alpine.js</h2>
                    <p class="mt-0.5 text-sm text-muted-foreground">Tombol di samping memakai state lokal Alpine.</p>
                </div>

                <x-ui.button type="button" variant="outline" size="sm" x-on:click="tampil = !tampil">
                    <x-heroicon-o-eye class="size-4" x-show="! tampil" />
                    <x-heroicon-o-eye-slash class="size-4" x-show="tampil" />
                    <span x-text="tampil ? 'Sembunyikan' : 'Tampilkan'">Sembunyikan</span>
                </x-ui.button>
            </div>

            <p x-show="tampil" x-cloak class="mt-4 flex items-center gap-2 text-sm text-success-soft-foreground">
                <x-heroicon-o-check-circle class="size-4 shrink-0 text-success" />
                Alpine.js aktif dan reaktif.
            </p>
        </x-ui.card>

        @if (app()->isLocal())
            <div class="mt-6 flex flex-col gap-3 rounded-xl border border-dashed border-border bg-surface-muted/40 p-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm font-semibold text-foreground">Jelajahi design system</p>
                    <p class="mt-0.5 text-sm text-muted-foreground">
                        Seluruh token warna, komponen, dan pola layout tersedia di halaman showcase.
                    </p>
                </div>

                <x-ui.button :href="route('design-system')" variant="outline" size="sm">
                    Buka showcase
                    <x-heroicon-o-arrow-right class="size-4" />
                </x-ui.button>
            </div>
        @endif
    </div>
@endsection
