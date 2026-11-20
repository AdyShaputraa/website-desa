<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Masuk — {{ config('app.name', 'Laravel') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="grid min-h-screen place-items-center bg-slate-50 font-sans text-slate-900 antialiased">
        <main class="w-full max-w-md px-4 py-12">
            <div class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">
                <div class="text-center">
                    <h1 class="text-xl font-semibold tracking-tight">{{ config('app.name') }}</h1>
                    <p class="mt-1 text-sm text-slate-500">Masuk untuk melanjutkan</p>
                </div>

                @if ($errors->any())
                    <div class="mt-6 flex items-start gap-2 rounded-xl border border-rose-200 bg-rose-50 p-3 text-sm text-rose-800">
                        <x-heroicon-o-exclamation-triangle class="mt-0.5 size-5 shrink-0 text-rose-600" />
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <a
                    href="{{ route('auth.google') }}"
                    class="mt-8 flex w-full items-center justify-center gap-3 rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-slate-900 focus-visible:ring-offset-2"
                >
                    <svg class="size-5" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill="#4285F4" d="M23.52 12.27c0-.85-.08-1.67-.22-2.45H12v4.64h6.46a5.52 5.52 0 0 1-2.4 3.62v3h3.88c2.27-2.09 3.58-5.17 3.58-8.81Z" />
                        <path fill="#34A853" d="M12 24c3.24 0 5.96-1.08 7.94-2.92l-3.88-3c-1.08.72-2.45 1.15-4.06 1.15-3.12 0-5.77-2.11-6.71-4.95H1.28v3.09A12 12 0 0 0 12 24Z" />
                        <path fill="#FBBC05" d="M5.29 14.28a7.2 7.2 0 0 1 0-4.56V6.63H1.28a12 12 0 0 0 0 10.74l4.01-3.09Z" />
                        <path fill="#EA4335" d="M12 4.77c1.76 0 3.34.61 4.58 1.79l3.44-3.44A11.96 11.96 0 0 0 12 0 12 12 0 0 0 1.28 6.63l4.01 3.09C6.23 6.88 8.88 4.77 12 4.77Z" />
                    </svg>
                    Masuk dengan Google
                </a>

                <p class="mt-6 text-center text-xs text-slate-500">
                    Dengan masuk, akun Google Anda akan ditautkan ke akun portal desa.
                </p>
            </div>

            <p class="mt-6 text-center text-sm">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 font-medium text-slate-600 hover:text-slate-900">
                    <x-heroicon-o-arrow-left class="size-4" />
                    Kembali ke halaman verifikasi
                </a>
            </p>
        </main>
    </body>
</html>
