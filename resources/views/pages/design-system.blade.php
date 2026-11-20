@extends('layouts.app')

@section('title', 'Design System')
@section('description', 'Showcase token warna, komponen, dan pola layout Portal Desa Digital.')

@section('content')
    <div
        x-data
        x-on:confirmed.window="if ($event.detail.name === 'demo-confirm') $store.toasts.push('Tindakan dikonfirmasi.', 'success')"
    >
        <x-ui.page-header
            eyebrow="Referensi internal"
            title="Design System"
            description="Kumpulan token, komponen, dan pola layout yang dipakai seluruh halaman portal. Halaman ini hanya tersedia di lingkungan lokal."
        >
            <x-slot:actions>
                <x-ui.badge variant="warning" dot>Hanya lokal</x-ui.badge>
                <x-ui.button :href="route('home')" variant="outline" size="sm">
                    <x-heroicon-o-arrow-left class="size-4" />
                    Beranda
                </x-ui.button>
            </x-slot:actions>
        </x-ui.page-header>

        <x-ui.card class="mt-8" padding="p-4 sm:p-5">
            <nav aria-label="Daftar isi design system">
                <ul class="flex flex-wrap gap-2">
                    @foreach ([
                        ['warna', 'Warna'],
                        ['tipografi', 'Tipografi'],
                        ['tombol', 'Tombol'],
                        ['form', 'Form'],
                        ['feedback', 'Feedback'],
                        ['data', 'Data'],
                        ['overlay', 'Overlay'],
                        ['navigasi', 'Navigasi'],
                    ] as [$anchor, $label])
                        <li>
                            <a
                                href="#{{ $anchor }}"
                                class="focus-ring inline-flex rounded-full border border-card-border bg-card px-3 py-1 text-sm font-medium text-foreground transition hover:bg-surface-muted"
                            >
                                {{ $label }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>
        </x-ui.card>

        <div class="mt-10 space-y-12">
            <x-ui.section id="warna" title="Warna & token" description="Token semantik yang otomatis menyesuaikan mode terang dan gelap.">
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ([
                        ['Primary', 'bg-primary', '--color-primary'],
                        ['Success', 'bg-success', '--color-success'],
                        ['Warning', 'bg-warning', '--color-warning'],
                        ['Danger', 'bg-danger', '--color-danger'],
                        ['Info', 'bg-info', '--color-info'],
                        ['Border', 'bg-border', '--color-border'],
                    ] as [$label, $swatch, $token])
                        <div class="overflow-hidden rounded-xl border border-card-border bg-card">
                            <div class="h-16 {{ $swatch }}" aria-hidden="true"></div>
                            <div class="px-4 py-3">
                                <p class="text-sm font-semibold text-foreground">{{ $label }}</p>
                                <p class="mt-0.5 font-mono text-xs text-muted-foreground">{{ $token }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <x-ui.card class="mt-4">
                    <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">
                        <div>
                            <h3 class="text-sm font-semibold text-foreground">Warna accent</h3>
                            <p class="mt-0.5 text-sm text-muted-foreground">
                                Pilihan accent disimpan di <code class="rounded bg-surface-muted px-1 py-0.5 font-mono text-xs">localStorage</code>
                                dan langsung mengubah token primary.
                            </p>

                            <x-ui.accent-picker class="mt-3" />
                        </div>

                        <div>
                            <h3 class="text-sm font-semibold text-foreground">Mode tema</h3>
                            <p class="mt-0.5 text-sm text-muted-foreground">Light, Dark, atau mengikuti sistem.</p>

                            <div class="mt-3 flex items-center gap-2">
                                <x-ui.theme-toggle />

                                <span class="text-sm text-muted-foreground">
                                    Aktif:
                                    <span class="font-semibold text-foreground" x-text="$store.theme.mode"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </x-ui.card>
            </x-ui.section>

            <x-ui.section id="tipografi" title="Tipografi" description="Fraunces untuk judul, Plus Jakarta Sans untuk teks antarmuka.">
                <x-ui.card class="space-y-6">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-muted-foreground">Display / Fraunces</p>
                        <p class="mt-2 font-display text-4xl font-semibold tracking-tight text-foreground sm:text-5xl">
                            Desa yang terhubung
                        </p>
                    </div>

                    <x-ui.divider />

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <p class="font-display text-2xl font-semibold tracking-tight">Judul halaman</p>
                            <p class="mt-1 text-sm text-muted-foreground">text-2xl / font-display / semibold</p>
                        </div>
                        <div>
                            <p class="font-display text-lg font-semibold tracking-tight">Judul kartu</p>
                            <p class="mt-1 text-sm text-muted-foreground">text-lg / font-display / semibold</p>
                        </div>
                        <div>
                            <p class="text-base font-medium">Teks tebal antarmuka</p>
                            <p class="mt-1 text-sm text-muted-foreground">text-base / font-medium</p>
                        </div>
                        <div>
                            <p class="text-sm text-muted-foreground">Teks sekunder untuk keterangan dan bantuan.</p>
                            <p class="mt-1 text-xs text-muted-foreground">text-sm / text-muted-foreground</p>
                        </div>
                    </div>
                </x-ui.card>
            </x-ui.section>

            <x-ui.section id="tombol" title="Tombol" description="Varian, ukuran, dan status tombol.">
                <x-ui.card>
                    <h3 class="text-sm font-semibold text-foreground">Varian</h3>
                    <div class="mt-3 flex flex-wrap items-center gap-2">
                        <x-ui.button>Primary</x-ui.button>
                        <x-ui.button variant="secondary">Secondary</x-ui.button>
                        <x-ui.button variant="outline">Outline</x-ui.button>
                        <x-ui.button variant="ghost">Ghost</x-ui.button>
                        <x-ui.button variant="danger">Danger</x-ui.button>
                        <x-ui.button variant="link">Link</x-ui.button>
                    </div>

                    <x-ui.divider class="my-6" />

                    <h3 class="text-sm font-semibold text-foreground">Ukuran & status</h3>
                    <div class="mt-3 flex flex-wrap items-center gap-2">
                        <x-ui.button size="sm">Small</x-ui.button>
                        <x-ui.button size="md">Medium</x-ui.button>
                        <x-ui.button size="lg">Large</x-ui.button>
                        <x-ui.button size="icon" aria-label="Tombol ikon">
                            <x-heroicon-o-plus class="size-5" />
                        </x-ui.button>
                        <x-ui.button disabled>Disabled</x-ui.button>
                        <x-ui.button loading>Memproses</x-ui.button>
                    </div>

                    <x-ui.divider class="my-6" />

                    <h3 class="text-sm font-semibold text-foreground">Dengan ikon</h3>
                    <div class="mt-3 flex flex-wrap items-center gap-2">
                        <x-ui.button>
                            <x-heroicon-o-plus class="size-4" />
                            Tambah data
                        </x-ui.button>
                        <x-ui.button variant="outline">
                            <x-heroicon-o-arrow-down-tray class="size-4" />
                            Unduh laporan
                        </x-ui.button>
                    </div>
                </x-ui.card>
            </x-ui.section>

            <x-ui.section id="form" title="Form" description="Kontrol input dengan label, hint, dan pesan kesalahan.">
                <x-ui.card>
                    <form class="grid gap-5 sm:grid-cols-2" x-on:submit.prevent>
                        <x-forms.input name="demo_nama" label="Nama lengkap" placeholder="Masukkan nama lengkap" required hint="Sesuai KTP." />
                        <x-forms.input name="demo_email" type="email" label="Email" placeholder="nama@email.com" icon="heroicon-o-envelope" />
                        <x-forms.select
                            name="demo_jenis"
                            label="Jenis surat"
                            placeholder="Pilih jenis surat"
                            :options="['domisili' => 'Surat domisili', 'usaha' => 'Surat keterangan usaha', 'pindah' => 'Surat pindah']"
                        />
                        <x-forms.input name="demo_error" label="Contoh validasi" value="Data tidak valid" error="Nilai ini tidak sesuai format." />

                        <div class="sm:col-span-2">
                            <x-forms.textarea name="demo_pesan" label="Pesan" placeholder="Tulis pesan Anda" />
                        </div>

                        <div class="space-y-3 sm:col-span-2">
                            <x-forms.checkbox name="demo_setuju" value="1" label="Saya menyetujui syarat dan ketentuan." />
                            <x-forms.switch name="demo_notifikasi" value="1" label="Kirim notifikasi lewat email" />
                        </div>

                        <fieldset class="sm:col-span-2">
                            <legend class="text-sm font-medium text-foreground">Kanal pengaduan</legend>
                            <div class="mt-2 flex flex-wrap gap-4">
                                <x-forms.radio name="demo_kanal" value="online" label="Online" checked />
                                <x-forms.radio name="demo_kanal" value="datang" label="Datang ke kantor" />
                            </div>
                        </fieldset>

                        <div class="flex flex-wrap gap-2 sm:col-span-2">
                            <x-ui.button type="submit">Simpan</x-ui.button>
                            <x-ui.button type="reset" variant="secondary">Reset</x-ui.button>
                        </div>
                    </form>
                </x-ui.card>
            </x-ui.section>

            <x-ui.section id="feedback" title="Feedback" description="Alert, badge, toast, dan indikator proses.">
                <div class="grid gap-3 lg:grid-cols-2">
                    <x-ui.alert variant="info" title="Informasi">Pengajuan surat diproses maksimal 3 hari kerja.</x-ui.alert>
                    <x-ui.alert variant="success" title="Berhasil">Data penduduk berhasil disimpan.</x-ui.alert>
                    <x-ui.alert variant="warning" title="Perhatian">Berkas yang diunggah harus berformat PDF.</x-ui.alert>
                    <x-ui.alert variant="danger" title="Gagal" dismissible>Koneksi ke server terputus. Coba lagi.</x-ui.alert>
                </div>

                <x-ui.card class="mt-4">
                    <div class="flex flex-col gap-5 sm:flex-row sm:items-start sm:justify-between">
                        <div>
                            <h3 class="text-sm font-semibold text-foreground">Badge</h3>
                            <div class="mt-3 flex flex-wrap items-center gap-2">
                                <x-ui.badge>Netral</x-ui.badge>
                                <x-ui.badge variant="primary" dot>Diproses</x-ui.badge>
                                <x-ui.badge variant="success" dot>Selesai</x-ui.badge>
                                <x-ui.badge variant="warning" dot>Menunggu</x-ui.badge>
                                <x-ui.badge variant="danger" dot>Ditolak</x-ui.badge>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-sm font-semibold text-foreground">Toast</h3>
                            <div class="mt-3 flex flex-wrap gap-2">
                                <x-ui.button size="sm" variant="outline" x-on:click="$store.toasts.push('Data berhasil disimpan.', 'success')">
                                    Success
                                </x-ui.button>
                                <x-ui.button size="sm" variant="outline" x-on:click="$store.toasts.push('Terjadi kesalahan saat menyimpan.', 'danger')">
                                    Danger
                                </x-ui.button>
                                <x-ui.button size="sm" variant="outline" x-on:click="$store.toasts.push('Periksa kembali data Anda.', 'warning')">
                                    Warning
                                </x-ui.button>
                                <x-ui.button size="sm" variant="outline" x-on:click="$store.toasts.push('Pengajuan sedang diproses.', 'info')">
                                    Info
                                </x-ui.button>
                            </div>
                        </div>
                    </div>

                    <x-ui.divider class="my-6" />

                    <h3 class="text-sm font-semibold text-foreground">Loading</h3>
                    <div class="mt-3 flex flex-wrap items-center gap-6">
                        <x-feedback.loading label="Memuat data penduduk" />
                        <x-feedback.loading label="Menyimpan" size="size-4" />
                    </div>
                </x-ui.card>
            </x-ui.section>

            <x-ui.section id="data" title="Data display" description="Statistik, tabel responsif, pagination, dan empty state.">
                <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                    <x-ui.stat label="Total penduduk" value="4.286" icon="heroicon-o-users" trend="+2,4%" description="dari bulan lalu" />
                    <x-ui.stat label="Surat diproses" value="38" icon="heroicon-o-document-text" trend="+6" description="minggu ini" />
                    <x-ui.stat label="Pengaduan masuk" value="12" icon="heroicon-o-chat-bubble-left-right" trend="-3" trendDirection="down" description="minggu ini" />
                    <x-ui.stat label="Berita terbit" value="24" icon="heroicon-o-newspaper" />
                </div>

                <x-ui.card class="mt-4" padding="p-0 sm:p-0">
                    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-card-border px-5 py-4">
                        <div>
                            <h3 class="font-display text-base font-semibold tracking-tight">Pengajuan surat terbaru</h3>
                            <p class="mt-0.5 text-sm text-muted-foreground">Tabel dapat digeser horizontal pada layar kecil.</p>
                        </div>

                        <x-ui.button size="sm" variant="outline">
                            <x-heroicon-o-funnel class="size-4" />
                            Filter
                        </x-ui.button>
                    </div>

                    <div class="p-5">
                        <x-ui.table :headers="['Pemohon', 'Jenis surat', 'Status', 'Tanggal']" caption="Contoh daftar pengajuan surat">
                            @foreach ([
                                ['Siti Aminah', 'Surat domisili', 'success', 'Selesai', '12 Nov 2026'],
                                ['Budi Santoso', 'Surat usaha', 'warning', 'Menunggu', '13 Nov 2026'],
                                ['Rina Wulandari', 'Surat pindah', 'info', 'Diproses', '14 Nov 2026'],
                                ['Agus Setiawan', 'Surat domisili', 'danger', 'Ditolak', '15 Nov 2026'],
                            ] as [$nama, $jenis, $variant, $status, $tanggal])
                                <tr class="transition hover:bg-surface-muted/60">
                                    <td class="whitespace-nowrap px-4 py-3 font-medium text-foreground">{{ $nama }}</td>
                                    <td class="whitespace-nowrap px-4 py-3 text-muted-foreground">{{ $jenis }}</td>
                                    <td class="whitespace-nowrap px-4 py-3">
                                        <x-ui.badge :variant="$variant" dot>{{ $status }}</x-ui.badge>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 text-muted-foreground">{{ $tanggal }}</td>
                                </tr>
                            @endforeach
                        </x-ui.table>
                    </div>
                </x-ui.card>

                <div class="mt-4 grid gap-4 lg:grid-cols-2">
                    <x-ui.card>
                        <h3 class="text-sm font-semibold text-foreground">Pagination</h3>
                        <div class="mt-4">
                            @php
                                $demoPaginator = new \Illuminate\Pagination\LengthAwarePaginator(
                                    collect(range(1, 5)),
                                    24,
                                    5,
                                    2,
                                    ['path' => url()->current()],
                                );
                            @endphp

                            <x-ui.pagination :paginator="$demoPaginator" />
                        </div>
                    </x-ui.card>

                    <x-ui.empty-state
                        title="Belum ada pengaduan"
                        description="Pengaduan warga akan muncul di sini setelah dikirim melalui formulir."
                    >
                        <x-slot:action>
                            <x-ui.button size="sm" variant="outline">
                                <x-heroicon-o-plus class="size-4" />
                                Tambah pengaduan
                            </x-ui.button>
                        </x-slot:action>
                    </x-ui.empty-state>
                </div>
            </x-ui.section>

            <x-ui.section id="overlay" title="Overlay & interaksi" description="Dropdown, modal, konfirmasi, tab, dan accordion.">
                <div class="grid gap-4 lg:grid-cols-2">
                    <x-ui.card>
                        <h3 class="text-sm font-semibold text-foreground">Dropdown</h3>
                        <p class="mt-0.5 text-sm text-muted-foreground">Tutup otomatis saat klik di luar atau tombol Escape.</p>

                        <div class="mt-4">
                            <x-ui.dropdown align="left" width="w-52">
                                <x-slot:trigger>
                                    <x-ui.button variant="outline" x-bind:aria-expanded="open">
                                        <x-heroicon-o-ellipsis-horizontal class="size-4" />
                                        Aksi
                                    </x-ui.button>
                                </x-slot:trigger>

                                <button type="button" role="menuitem" class="focus-ring flex w-full items-center gap-2 rounded-lg px-3 py-2 text-sm text-foreground transition hover:bg-surface-muted">
                                    <x-heroicon-o-pencil-square class="size-4" />
                                    Ubah
                                </button>
                                <button type="button" role="menuitem" class="focus-ring flex w-full items-center gap-2 rounded-lg px-3 py-2 text-sm text-foreground transition hover:bg-surface-muted">
                                    <x-heroicon-o-document-arrow-down class="size-4" />
                                    Unduh
                                </button>
                                <button type="button" role="menuitem" class="focus-ring flex w-full items-center gap-2 rounded-lg px-3 py-2 text-sm text-danger transition hover:bg-danger-soft">
                                    <x-heroicon-o-trash class="size-4" />
                                    Hapus
                                </button>
                            </x-ui.dropdown>
                        </div>
                    </x-ui.card>

                    <x-ui.card>
                        <h3 class="text-sm font-semibold text-foreground">Modal & konfirmasi</h3>
                        <p class="mt-0.5 text-sm text-muted-foreground">Fokus berpindah ke panel, Escape menutup dialog.</p>

                        <div class="mt-4 flex flex-wrap gap-2">
                            <x-ui.button variant="outline" x-on:click="$dispatch('open-modal', 'demo-modal')">
                                <x-heroicon-o-window class="size-4" />
                                Buka modal
                            </x-ui.button>

                            <x-ui.button variant="danger" x-on:click="$dispatch('open-modal', 'demo-confirm')">
                                <x-heroicon-o-trash class="size-4" />
                                Hapus data
                            </x-ui.button>
                        </div>
                    </x-ui.card>
                </div>

                <x-ui.card class="mt-4">
                    <h3 class="text-sm font-semibold text-foreground">Tab</h3>

                    <div x-data="tabs(0)" class="mt-4">
                        <div role="tablist" aria-label="Contoh tab" class="flex gap-1 overflow-x-auto border-b border-border">
                            @foreach (['Profil', 'Layanan', 'Riwayat'] as $index => $label)
                                <button
                                    type="button"
                                    role="tab"
                                    id="demo-tab-{{ $index }}"
                                    aria-controls="demo-panel-{{ $index }}"
                                    x-bind:aria-selected="isActive({{ $index }}).toString()"
                                    x-bind:tabindex="isActive({{ $index }}) ? 0 : -1"
                                    x-on:click="select({{ $index }})"
                                    x-bind:class="isActive({{ $index }}) ? 'border-primary text-primary' : 'border-transparent text-muted-foreground hover:text-foreground'"
                                    class="focus-ring -mb-px whitespace-nowrap border-b-2 px-3 py-2 text-sm font-medium transition"
                                >
                                    {{ $label }}
                                </button>
                            @endforeach
                        </div>

                        @foreach ([
                            'Data diri dan alamat sesuai KTP.',
                            'Daftar layanan surat yang tersedia untuk warga.',
                            'Riwayat pengajuan dan status terakhir.',
                        ] as $index => $panel)
                            <div
                                id="demo-panel-{{ $index }}"
                                role="tabpanel"
                                aria-labelledby="demo-tab-{{ $index }}"
                                x-show="isActive({{ $index }})"
                                x-cloak
                                class="pt-4 text-sm text-muted-foreground"
                            >
                                {{ $panel }}
                            </div>
                        @endforeach
                    </div>
                </x-ui.card>

                <x-ui.card class="mt-4">
                    <h3 class="text-sm font-semibold text-foreground">Accordion</h3>

                    <div x-data="accordion" class="mt-4 divide-y divide-border">
                        @foreach ([
                            ['Apa saja syarat pengajuan surat?', 'KTP, Kartu Keluarga, dan dokumen pendukung sesuai jenis surat.'],
                            ['Berapa lama prosesnya?', 'Maksimal tiga hari kerja setelah berkas dinyatakan lengkap.'],
                            ['Apakah bisa diwakilkan?', 'Bisa, dengan surat kuasa dan fotokopi KTP penerima kuasa.'],
                        ] as $index => [$question, $answer])
                            <div>
                                <h4>
                                    <button
                                        type="button"
                                        x-on:click="toggle({{ $index }})"
                                        x-bind:aria-expanded="isOpen({{ $index }}).toString()"
                                        aria-controls="demo-accordion-{{ $index }}"
                                        class="focus-ring flex w-full items-center justify-between gap-3 rounded-lg py-3 text-left text-sm font-medium text-foreground"
                                    >
                                        {{ $question }}
                                        <x-heroicon-o-chevron-down
                                            class="size-4 shrink-0 text-muted-foreground transition"
                                            x-bind:class="isOpen({{ $index }}) ? 'rotate-180' : ''"
                                        />
                                    </button>
                                </h4>

                                <div id="demo-accordion-{{ $index }}" x-show="isOpen({{ $index }})" x-cloak>
                                    <p class="pb-3 text-sm text-muted-foreground">{{ $answer }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </x-ui.card>
            </x-ui.section>

            <x-ui.section id="navigasi" title="Navigasi" description="Breadcrumb, nav link sidebar, dan header halaman.">
                <x-ui.card>
                    <x-ui.breadcrumb :items="[
                        ['label' => 'Beranda', 'url' => route('home')],
                        ['label' => 'Layanan', 'url' => '#'],
                        ['label' => 'Pengajuan surat'],
                    ]" />

                    <x-ui.divider class="my-5" />

                    <nav class="max-w-xs space-y-1" aria-label="Contoh navigasi sidebar">
                        <x-navigation.nav-link :href="route('home')" icon="heroicon-o-home">Beranda</x-navigation.nav-link>
                        <x-navigation.nav-link href="#" icon="heroicon-o-document-text" :active="true">Pengajuan surat</x-navigation.nav-link>
                        <x-navigation.nav-link href="#" icon="heroicon-o-chat-bubble-left-right" badge="3">Pengaduan</x-navigation.nav-link>
                        <x-navigation.nav-link href="#" icon="heroicon-o-newspaper">Berita</x-navigation.nav-link>
                    </nav>
                </x-ui.card>
            </x-ui.section>
        </div>

        <x-ui.modal name="demo-modal" title="Tambah penduduk" description="Contoh formulir di dalam dialog." maxWidth="max-w-lg">
            <div class="grid gap-4">
                <x-forms.input name="modal_nama" label="Nama lengkap" placeholder="Masukkan nama" />
                <x-forms.input name="modal_nik" label="NIK" placeholder="16 digit" hint="Harus terdiri dari 16 angka." />
            </div>

            <x-slot:footer>
                <x-ui.button variant="secondary" type="button" x-on:click="hide()">Batal</x-ui.button>
                <x-ui.button type="button" x-on:click="hide(); $store.toasts.push('Data penduduk ditambahkan.', 'success')">
                    Simpan
                </x-ui.button>
            </x-slot:footer>
        </x-ui.modal>

        <x-feedback.confirmation
            name="demo-confirm"
            title="Hapus data penduduk?"
            description="Tindakan ini tidak dapat dibatalkan."
            confirm-label="Ya, hapus"
        >
            Data yang dihapus akan hilang dari daftar penduduk desa.
        </x-feedback.confirmation>
    </div>
@endsection
