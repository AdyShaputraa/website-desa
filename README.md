# Portal Desa Digital

Portal Desa Digital adalah aplikasi web untuk pengelolaan informasi dan layanan desa.
Project ini dikembangkan sebagai bagian dari mata kuliah **Pemrograman Web** dan
dibangun secara bertahap dari minggu ke minggu.

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
| Font | Plus Jakarta Sans dan Fraunces (Fontsource) |
| Ikon | Heroicons (Blade UI Kit) |
| Build Tool | Vite |
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

Setelah container berjalan, aplikasi dapat diakses di:

| Layanan | Alamat |
|---|---|
| Aplikasi Laravel | http://localhost:8081 |
| Vite dev server | http://localhost:5173 |
| MySQL dari host | 127.0.0.1:3307 |

## Menghentikan Docker

```powershell
docker compose down
```

Data MySQL tetap tersimpan di volume `sail-mysql`. **Jangan** menjalankan
`docker compose down -v` kecuali memang ingin menghapus seluruh data database.

> Dokumentasi pengembangan lengkap (setup, perintah container, database, OAuth,
> design system, dan troubleshooting) tersimpan secara lokal di folder `docs/`.
> Folder tersebut tidak di-commit ke repository.
