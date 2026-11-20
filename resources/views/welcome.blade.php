<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-50 font-sans text-slate-900 antialiased">
        <main class="mx-auto w-full max-w-3xl px-4 py-12 sm:px-6 lg:py-16">
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="flex items-start justify-between gap-4 border-b border-slate-200 px-6 py-6 sm:px-8">
                    <div>
                        <h1 class="text-xl font-semibold tracking-tight sm:text-2xl">{{ config('app.name') }}</h1>
                        <p class="mt-1 text-sm text-slate-500">Halaman verifikasi instalasi</p>
                    </div>

                    @auth
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button
                                type="submit"
                                class="inline-flex items-center gap-2 rounded-lg border border-slate-300 px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-100"
                            >
                                <x-heroicon-o-arrow-right-on-rectangle class="size-4" />
                                Keluar
                            </button>
                        </form>
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="inline-flex items-center gap-2 rounded-lg bg-slate-900 px-3 py-2 text-sm font-medium text-white transition hover:bg-slate-700"
                        >
                            <x-heroicon-o-arrow-left-on-rectangle class="size-4" />
                            Masuk
                        </a>
                    @endauth
                </div>

                <div class="px-6 py-6 sm:px-8" x-data="{ tampil: true }">
                    <dl class="divide-y divide-slate-200">
                        <div class="flex items-center justify-between gap-4 py-3">
                            <dt class="text-sm text-slate-500">Laravel</dt>
                            <dd class="text-sm font-semibold">{{ app()->version() }}</dd>
                        </div>
                        <div class="flex items-center justify-between gap-4 py-3">
                            <dt class="text-sm text-slate-500">PHP</dt>
                            <dd class="text-sm font-semibold">{{ PHP_VERSION }}</dd>
                        </div>
                        <div class="flex items-center justify-between gap-4 py-3">
                            <dt class="text-sm text-slate-500">Tailwind CSS</dt>
                            <dd class="text-sm font-semibold">v4</dd>
                        </div>
                        <div class="flex items-center justify-between gap-4 py-3">
                            <dt class="text-sm text-slate-500">Alpine.js</dt>
                            <dd class="text-sm font-semibold" x-text="window.Alpine ? window.Alpine.version : 'not loaded'">memuat...</dd>
                        </div>
                        <div class="flex items-center justify-between gap-4 py-3">
                            <dt class="text-sm text-slate-500">Font</dt>
                            <dd class="text-sm font-semibold">Plus Jakarta Sans</dd>
                        </div>
                    </dl>

                    <div class="mt-6 rounded-xl border border-emerald-200 bg-emerald-50 p-4">
                        <p class="flex items-start gap-2 text-sm text-emerald-800">
                            <x-heroicon-o-check-circle class="mt-0.5 size-5 shrink-0 text-emerald-600" />
                            <span>
                                Jika halaman ini tampil rapi dan versi di atas terisi, berarti Tailwind CSS,
                                Alpine.js, dan Fontsource sudah berjalan.
                            </span>
                        </p>
                    </div>

                    <div class="mt-6 rounded-xl border border-slate-200 p-4">
                        <div class="flex items-center justify-between gap-4">
                            <p class="text-sm font-medium text-slate-700">Uji interaksi Alpine.js</p>
                            <button
                                type="button"
                                @click="tampil = !tampil"
                                class="inline-flex items-center gap-2 rounded-lg border border-slate-300 px-3 py-1.5 text-sm font-medium text-slate-700 transition hover:bg-slate-100"
                            >
                                <span x-text="tampil ? 'Sembunyikan' : 'Tampilkan'">Sembunyikan</span>
                            </button>
                        </div>
                        <p
                            x-show="tampil"
                            x-cloak
                            class="mt-3 flex items-center gap-2 text-sm text-slate-600"
                        >
                            <x-heroicon-o-check-circle class="size-4 text-emerald-600" />
                            Alpine.js aktif dan reaktif.
                        </p>
                    </div>
                </div>
            </div>
        </main>
    </body>
</html>
