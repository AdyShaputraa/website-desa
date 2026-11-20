# Portal Desa Digital

Portal Desa Digital adalah aplikasi web untuk pengelolaan informasi dan layanan desa.
Project ini dikembangkan sebagai bagian dari mata kuliah **Pemrograman Web** dan
dibangun secara bertahap dari minggu ke minggu.

README ini berisi panduan umum untuk menyiapkan lingkungan pengembangan, menjalankan
aplikasi, dan menjalankan perintah di dalam container Docker.

## Technology Stack

| Komponen | Teknologi |
|---|---|
| Backend | Laravel 13 |
| PHP | PHP 8.4 (Docker) |
| Database | MySQL 8.4 |
| Web Server | Laravel Sail |
| Container | Docker Desktop |
| Template | Blade |
| CSS Framework | Tailwind CSS 4 |
| JavaScript | Alpine.js 3 |
| Font | Plus Jakarta Sans (Fontsource) |
| Ikon | Heroicons (Blade UI Kit) |
| Build Tool | Vite + PostCSS |
| Package Manager | Composer dan NPM |

## Persyaratan

- Docker Desktop (Docker Compose v2)
- Git (opsional)
- Browser modern

PHP, Composer, dan Node.js **tidak perlu** dipasang di Windows. Semua perintah
Composer, Artisan, dan PHP dijalankan di dalam container melalui Laravel Sail.

## Menjalankan Docker

Jalankan dari folder project `website-desa`:

```powershell
docker compose up -d
```

Perintah tersebut menjalankan container aplikasi dari image Sail `sail-8.4/app`
(PHP 8.4) serta MySQL 8.4. Jika image belum tersedia, Docker akan membangunnya
dari `vendor/laravel/sail/runtimes/8.4`.

Cek status container:

```powershell
docker compose ps
```

## Menghentikan Docker

```powershell
docker compose down
```

Data MySQL tetap tersimpan di volume `sail-mysql`. **Jangan** menjalankan
`docker compose down -v` kecuali memang ingin menghapus seluruh data database.

## Menjalankan Perintah di Dalam Container

Semua perintah PHP, Composer, Artisan, dan NPM dijalankan melalui container
`laravel.test`.

### Artisan

```powershell
docker compose exec laravel.test php artisan <perintah>
```

Contoh:

```powershell
docker compose exec laravel.test php artisan migrate
docker compose exec laravel.test php artisan db:seed
docker compose exec laravel.test php artisan route:list
```

### Composer

```powershell
docker compose exec laravel.test composer <perintah>
```

Contoh:

```powershell
docker compose exec laravel.test composer install
docker compose exec laravel.test composer require <nama-package>
```

### NPM dan Vite

```powershell
docker compose exec laravel.test npm install
docker compose exec laravel.test npm run build
docker compose exec laravel.test npm run dev
```

### MySQL

```powershell
docker compose exec mysql mysql -usail -p website_desa
```

### Shell Interaktif

```powershell
docker compose exec laravel.test bash
```

### Sail (WSL, Git Bash, macOS, Linux)

Jika memakai WSL, Git Bash, macOS, atau Linux, Sail dapat dipanggil langsung:

```bash
./vendor/bin/sail artisan migrate
./vendor/bin/sail composer install
./vendor/bin/sail npm run dev
```

## Konfigurasi `.env`

Identitas aplikasi:

```env
APP_NAME="Portal Desa Digital"
APP_URL=http://localhost:8081
APP_PORT=8081
APP_LOCALE=id
APP_FALLBACK_LOCALE=id
APP_FAKER_LOCALE=id_ID
```

Koneksi database:

```env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=website_desa
DB_USERNAME=sail
DB_PASSWORD=password
FORWARD_DB_PORT=3307
```

`DB_HOST=mysql` adalah nama service Docker, bukan `127.0.0.1`. Dari komputer host,
MySQL dapat diakses di `127.0.0.1:3307` (port eksternal diatur `FORWARD_DB_PORT`
agar tidak bentrok dengan MySQL lokal di port 3306).

Konfigurasi Google OAuth (opsional, credential boleh kosong):

```env
GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT_URI=http://localhost:8081/auth/google/callback
```

`.env.example` memuat struktur yang sama tanpa secret. Jangan commit file `.env`.

## Timezone

Timezone aplikasi diatur di `config/app.php`:

```php
'timezone' => 'Asia/Jakarta',
```

Tujuannya agar waktu pencatatan berita, pengajuan surat, dan aktivitas aplikasi
menggunakan WIB.

## Alamat Akses dan Port

| Layanan | Alamat |
|---|---|
| Aplikasi Laravel | http://localhost:8081 |
| Vite dev server | http://localhost:5173 |
| MySQL dari host | 127.0.0.1:3307 |

| Port | Kegunaan | Diatur oleh |
|---|---|---|
| 8081 | Aplikasi Laravel | `APP_PORT` |
| 5173 | Vite dev server | `VITE_PORT` |
| 3307 | MySQL dari host | `FORWARD_DB_PORT` |

Port di dalam container tetap 80 untuk aplikasi dan 3306 untuk MySQL.

## Database

### Daftar Tabel

| Tabel | Fungsi |
|---|---|
| `users` | Akun pengguna (termasuk kolom OAuth, NIK, dan telepon) |
| `penduduks` | Identitas dan alamat penduduk |
| `surats` | Pengajuan layanan surat |
| `pengaduans` | Laporan atau pengaduan warga |
| `beritas` | Konten berita CMS desa |
| `roles`, `permissions`, `model_has_roles`, `model_has_permissions`, `role_has_permissions` | Role dan permission Spatie |

Tabel `users` bawaan Laravel dan tabel milik Spatie tidak dibuat ulang.

### Model dan Relasi

| Model | Isi |
|---|---|
| `User` | Trait `HasRoles`, kolom tambahan, `surats()` hasMany, `pengaduans()` hasMany |
| `Penduduk` | `$guarded = []`, cast `tanggal_lahir` ke date |
| `Surat` | `$guarded = []`, konstanta `JENIS`, `user()` belongsTo, accessor `label_jenis` |
| `Berita` | `$guarded = []`, cast `is_published` boolean, route key `slug`, `author()` belongsTo, scope `published()`, accessor `ringkasan` |
| `Pengaduan` | `$guarded = []`, konstanta `KATEGORI`, `user()` belongsTo |

Relasi:

- `User` **hasMany** `Surat` dan `Pengaduan`
- `Surat` **belongsTo** `User`
- `Pengaduan` **belongsTo** `User` (opsional)
- `Berita` **belongsTo** `User` melalui `author_id`

### Menjalankan Migration

```powershell
docker compose exec laravel.test php artisan migrate
```

**Jangan** langsung menjalankan `migrate:fresh --seed`. Perintah tersebut menghapus
seluruh tabel pada database aktif. Gunakan hanya jika database dipastikan boleh
dikosongkan.

### Menjalankan Seeder

```powershell
docker compose exec laravel.test php artisan db:seed
```

Seeder bersifat idempoten dan aman dijalankan berulang tanpa duplicate entry.

### Memeriksa Status Migration

```powershell
docker compose exec laravel.test php artisan migrate:status
```

Pastikan seluruh migration berstatus `Ran`.

### Verifikasi Data

```powershell
docker compose exec laravel.test php artisan tinker --execute="echo 'users='.\App\Models\User::count().' penduduk='.\App\Models\Penduduk::count().' berita='.\App\Models\Berita::count().' surat='.\App\Models\Surat::count().' pengaduan='.\App\Models\Pengaduan::count();"
```

Cek role:

```powershell
docker compose exec laravel.test php artisan tinker --execute="echo \Spatie\Permission\Models\Role::pluck('name')->implode(', ');"
```

Cek foreign key dari MySQL:

```powershell
docker compose exec mysql mysql -usail -ppassword website_desa -e "SELECT TABLE_NAME, COLUMN_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA='website_desa' AND REFERENCED_TABLE_NAME IS NOT NULL;"
```

## Akun Demo

| Role | Email | Password |
|---|---|---|
| admin | `admin@desa.id` | `password123` |
| staff | `staff@desa.id` | `password123` |
| warga | `warga@desa.id` | `password123` |

> Password ini hanya untuk pengembangan lokal. Jangan digunakan di lingkungan publik
> atau production.

## Package yang Digunakan

| Package | Fungsi |
|---|---|
| `laravel/framework` | Framework Laravel 13 |
| `laravel/tinker` | REPL untuk verifikasi data |
| `laravel/sail` | Lingkungan Docker (PHP 8.4, MySQL 8.4) |
| `laravel/socialite` | Login Google OAuth |
| `spatie/laravel-permission` | Role dan permission |
| `barryvdh/laravel-dompdf` | Pembuatan PDF (surat) |
| `blade-ui-kit/blade-heroicons` | Komponen ikon Heroicons untuk Blade |

Instalasi package (dijalankan sekali saat setup):

```powershell
docker compose exec laravel.test composer require laravel/socialite spatie/laravel-permission barryvdh/laravel-dompdf blade-ui-kit/blade-heroicons
```

Publish konfigurasi dan migration Spatie:

```powershell
docker compose exec laravel.test php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
```

Publish konfigurasi DomPDF:

```powershell
docker compose exec laravel.test php artisan vendor:publish --provider="Barryvdh\DomPDF\ServiceProvider"
```

Membuat symbolic link storage:

```powershell
docker compose exec laravel.test php artisan storage:link
```

## Identitas Desa

Konfigurasi identitas desa ada di `config/desa.php` dan dapat diakses dengan
helper `config()`, misalnya `config('desa.nama')`.

```php
<?php

return [
    'nama' => 'Desa Maju Bersama',
    'kecamatan' => 'Makmur Jaya',
    'kabupaten' => 'Kabupaten Digital',
    'alamat' => 'Jl. Raya Desa Digital No. 01, Kode Pos 40123',
    'kepala_desa' => 'H. Ahmad Sumantri',
    'telepon' => '(022) 1234567',
    'email' => 'info@desamajubersama.id',
];
```

Nilai di atas adalah data contoh, bukan identitas desa sebenarnya.

## Middleware Spatie

Alias middleware didaftarkan di `bootstrap/app.php`:

```php
$middleware->alias([
    'role' => RoleMiddleware::class,
    'permission' => PermissionMiddleware::class,
    'role_or_permission' => RoleOrPermissionMiddleware::class,
]);
```

## Frontend

Aset frontend dikelola dengan Vite, Tailwind CSS 4, dan PostCSS. Semua aset dimuat
lewat `@vite` di Blade, tanpa CDN.

- `resources/css/app.css` mengimpor `tailwindcss`, mendefinisikan font default lewat
  `@theme`, dan menambahkan aturan `[x-cloak]`.
- `resources/js/app.js` mengimpor font Fontsource dan menjalankan Alpine.js.
- `postcss.config.js` mendaftarkan plugin `@tailwindcss/postcss` dan `autoprefixer`.
- `vite.config.js` mengelola input `resources/css/app.css` dan `resources/js/app.js`.

Tailwind CSS 4 tidak memakai `tailwind.config.js`. Kustomisasi tema dilakukan di CSS:

```css
@import 'tailwindcss';

@theme {
    --font-sans: 'Plus Jakarta Sans Variable', ui-sans-serif, system-ui, sans-serif;
}

[x-cloak] {
    display: none !important;
}
```

Font Plus Jakarta Sans berasal dari package Fontsource dan diimpor di `app.js`:

```js
import '@fontsource-variable/plus-jakarta-sans';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();
```

Interaktivitas halaman memakai Alpine.js, misalnya:

```blade
<div x-data="{ tampil: true }">
    <button type="button" @click="tampil = !tampil">Toggle</button>
    <p x-show="tampil" x-cloak>Konten</p>
</div>
```

Ikon memakai komponen Heroicons:

```blade
<x-heroicon-o-check-circle class="size-5 text-emerald-600" />
```

Komponen Heroicons membutuhkan manifest ikon di `bootstrap/cache/blade-icons.php`.
Manifest tersebut dibuat otomatis oleh `scripts/cache-blade-icons.php` setiap kali
`composer install`, `composer update`, atau `composer dump-autoload` dijalankan.

> Di Docker Desktop untuk Windows, `php artisan icons:cache` dapat menghasilkan
> manifest yang tidak lengkap karena `DirectoryIterator` PHP melewatkan sebagian file
> pada bind mount. Jika muncul error `Unable to locate a class or view for component
> [heroicon-...]`, jalankan `composer dump-autoload` di dalam container.

Halaman verifikasi di `/` menampilkan versi Laravel, PHP, Tailwind, Alpine, dan font,
sehingga dapat dipakai untuk memastikan seluruh aset frontend termuat.

## Login Google OAuth

Login memakai `laravel/socialite` dengan driver Google. Credential dibaca dari `.env`
melalui `config/services.php`.

### Konfigurasi Google Cloud Console

1. Buat OAuth Client ID bertipe **Web application**.
2. Tambahkan **Authorized redirect URI** persis seperti nilai `GOOGLE_REDIRECT_URI`:
   `http://localhost:8081/auth/google/callback`.
3. Salin Client ID dan Client Secret ke `.env`:

```env
GOOGLE_CLIENT_ID=...
GOOGLE_CLIENT_SECRET=...
GOOGLE_REDIRECT_URI=http://localhost:8081/auth/google/callback
```

Redirect URI harus sama persis, termasuk skema, host, port, dan path. Jika berbeda,
Google akan menolak proses login.

### Route

| Method | URI | Nama | Fungsi |
|---|---|---|---|
| GET | `/login` | `login` | Halaman login |
| GET | `/auth/google/redirect` | `auth.google` | Mengarahkan ke halaman persetujuan Google |
| GET | `/auth/google/callback` | `auth.google.callback` | Menerima callback dari Google |
| POST | `/logout` | `logout` | Keluar dari sesi |

### Alur Callback

`app/Http/Controllers/Auth/GoogleController.php` menangani proses login:

1. Mengambil data pengguna dari Google.
2. Mencari user berdasarkan `google_id`, lalu berdasarkan `email`.
3. Jika user sudah ada, `google_id` dan `avatar` diperbarui.
4. Jika belum ada, user baru dibuat dengan role `warga` dan `email_verified_at` diisi.
5. User diarahkan ke halaman utama.

Karena kolom `users.password` bersifat `NOT NULL`, akun yang dibuat lewat Google diberi
password acak. Akun tersebut tetap bisa login ulang lewat Google.

Perintah terkait:

```powershell
docker compose exec laravel.test php artisan route:list --except-vendor
docker compose exec laravel.test php artisan package:discover
```

`package:discover` perlu dijalankan setelah menambah package Composer baru agar
komponen Heroicons dan service provider lain terdaftar.

## Setup Pertama Kali

Jika `.env` belum ada:

```powershell
Copy-Item .env.example .env
```

Generate application key:

```powershell
docker compose exec laravel.test php artisan key:generate
```

Jalankan migration dan seeder:

```powershell
docker compose exec laravel.test php artisan migrate
docker compose exec laravel.test php artisan db:seed
```

Install dependency frontend dan build:

```powershell
docker compose exec laravel.test npm install
docker compose exec laravel.test npm run build
```

## Troubleshooting

### HTTP 500 `tempnam(): file created in the system's temporary directory`

Di Windows, folder `storage` dan `bootstrap/cache` bisa ter-mount sebagai milik
`root`, sehingga web server yang berjalan sebagai user `sail` tidak dapat menulis
file kompilasi. Perbaiki sekali dengan:

```powershell
docker compose exec laravel.test chmod -R 777 storage bootstrap/cache
```

Setelah itu muat ulang halaman. Perintah ini hanya mengubah permission folder
runtime, bukan data aplikasi.

### Container MySQL belum siap

Container aplikasi menunggu MySQL sehat sebelum dijalankan. Jika perlu melihat log:

```powershell
docker compose logs mysql
docker compose logs laravel.test
```
