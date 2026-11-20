<?php

return [
    'app' => [
        'name' => 'Portal Desa Digital',
    ],

    'nav' => [
        'dashboard' => 'Dashboard',
        'language' => 'Bahasa',
        'theme' => 'Tema',
        'theme_light' => 'Terang',
        'theme_dark' => 'Gelap',
        'theme_system' => 'Sistem',
        'logout' => 'Keluar',
        'open_menu' => 'Buka menu navigasi',
        'close_menu' => 'Tutup menu navigasi',
        'main_navigation' => 'Navigasi utama',
        'skip' => 'Lewati ke konten utama',
    ],

    'footer' => [
        'credit' => 'Made by Ady Shaputra - 17241002 - TI.5B',
    ],

    'auth' => [
        'page_title' => 'Masuk',
        'brand_subtitle' => 'Portal layanan desa',
        'title' => 'Masuk ke akun Anda',
        'subtitle' => 'Gunakan email dan password, atau lanjutkan dengan akun Google.',
        'email' => 'Email',
        'email_placeholder' => 'nama@email.com',
        'password' => 'Password',
        'password_placeholder' => 'Masukkan password',
        'remember' => 'Ingat saya',
        'submit' => 'Masuk',
        'or' => 'atau',
        'google' => 'Masuk dengan Google',
        'failed' => 'Email atau password tidak sesuai.',
        'google_failed' => 'Login dengan Google gagal. Silakan coba lagi.',
        'secure_note' => 'Dengan masuk, Anda menyetujui penggunaan data untuk keperluan layanan desa.',
    ],

    'dashboard' => [
        'title' => 'Dashboard',
        'eyebrow' => 'Ringkasan',
        'welcome' => 'Selamat datang, :name',
        'subtitle' => 'Ringkasan aktivitas pelayanan desa.',
        'role' => 'Peran: :role',
        'roles' => [
            'admin' => 'Administrator',
            'staff' => 'Staff',
            'warga' => 'Warga',
        ],
    ],

    'stats' => [
        'population' => 'Total penduduk',
        'surat_total' => 'Total surat',
        'pengaduan_total' => 'Total pengaduan',
        'berita_published' => 'Berita terbit',
        'surat_pending' => 'Surat pending',
        'surat_processing' => 'Surat diproses',
        'pengaduan_pending' => 'Pengaduan baru',
        'pengaduan_processing' => 'Pengaduan diproses',
        'surat_mine' => 'Surat saya',
        'surat_done' => 'Surat selesai',
        'pengaduan_mine' => 'Pengaduan saya',
        'pengaduan_done' => 'Pengaduan selesai',
    ],

    'table' => [
        'surat_latest' => 'Surat terbaru',
        'surat_latest_desc' => 'Pengajuan surat terakhir dari seluruh warga.',
        'pengaduan_latest' => 'Pengaduan terbaru',
        'pengaduan_latest_desc' => 'Laporan terakhir yang masuk ke portal.',
        'surat_queue' => 'Antrean surat',
        'surat_queue_desc' => 'Pengajuan yang menunggu diproses.',
        'pengaduan_queue' => 'Antrean pengaduan',
        'pengaduan_queue_desc' => 'Pengaduan yang belum selesai ditangani.',
        'surat_mine' => 'Surat saya',
        'surat_mine_desc' => 'Riwayat pengajuan surat Anda.',
        'pengaduan_mine' => 'Pengaduan saya',
        'pengaduan_mine_desc' => 'Riwayat laporan yang Anda kirim.',
        'rows' => 'data',
    ],

    'fields' => [
        'ticket' => 'Nomor tiket',
        'applicant' => 'Pemohon',
        'type' => 'Jenis surat',
        'status' => 'Status',
        'date' => 'Tanggal',
        'code' => 'Kode',
        'title' => 'Judul',
        'category' => 'Kategori',
        'reporter' => 'Pelapor',
    ],

    'empty' => [
        'surat' => 'Belum ada data surat',
        'pengaduan' => 'Belum ada data pengaduan',
        'desc' => 'Data akan muncul di sini setelah ada pengajuan atau laporan baru.',
    ],

    'status' => [
        'pending' => 'Pending',
        'diproses' => 'Diproses',
        'proses' => 'Proses',
        'selesai' => 'Selesai',
        'ditolak' => 'Ditolak',
    ],
];
