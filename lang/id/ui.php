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
        'expand_sidebar' => 'Perluas sidebar',
        'collapse_sidebar' => 'Ciutkan sidebar',
    ],

    'footer' => [
        'credit' => 'Ady Shaputra - 17241002 - TI.5B',
    ],

    'common' => [
        'cancel' => 'Batal',
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

    'account' => [
        'menu' => 'Menu pengguna',
        'settings' => 'Pengaturan',
        'change_password' => 'Ubah Password',
        'logout' => 'Keluar',
    ],

    'settings' => [
        'title' => 'Pengaturan',
        'eyebrow' => 'Akun',
        'description' => 'Kelola informasi akun dan preferensi tampilan.',
        'account_info' => 'Informasi akun',
        'account_info_desc' => 'Nama dan email yang dipakai untuk masuk.',
        'name' => 'Nama',
        'email' => 'Email',
        'role' => 'Peran',
        'preferences' => 'Preferensi',
        'preferences_desc' => 'Bahasa dan tema antarmuka.',
        'save' => 'Simpan perubahan',
        'saved' => 'Informasi akun berhasil diperbarui.',
    ],

    'password' => [
        'title' => 'Ubah Password',
        'eyebrow' => 'Keamanan',
        'description' => 'Ganti password akun Anda secara berkala.',
        'current' => 'Password saat ini',
        'new' => 'Password baru',
        'confirm' => 'Konfirmasi password baru',
        'save' => 'Simpan password',
        'saved' => 'Password berhasil diperbarui.',
        'min_hint' => 'Minimal 8 karakter.',
        'google_hint' => 'Akun ini terhubung dengan Google. Isi password lama bila pernah diatur; jika tidak, Anda tetap bisa masuk lewat Google.',
    ],

    'dashboard' => [
        'title' => 'Dashboard',
        'eyebrow' => 'Ringkasan',
        'welcome' => 'Selamat datang, :name',
        'subtitle' => 'Ringkasan aktivitas pelayanan desa.',
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
