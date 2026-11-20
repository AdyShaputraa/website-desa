@extends('layouts.guest')

@section('title', 'Masuk')
@section('description', 'Masuk ke Portal Desa Digital menggunakan akun Google Anda.')

@section('content')
    <div class="mx-auto flex w-full max-w-md flex-col justify-center px-4 py-12 sm:py-16">
        <x-ui.card padding="p-6 sm:p-8">
            <div class="text-center">
                <span class="mx-auto grid size-12 place-items-center rounded-xl bg-primary-soft text-primary-soft-foreground">
                    <x-heroicon-o-shield-check class="size-6" />
                </span>

                <h1 class="mt-4 font-display text-2xl font-semibold tracking-tight text-foreground">Masuk ke portal</h1>
                <p class="mt-1.5 text-sm text-muted-foreground">
                    Gunakan akun Google Anda untuk melanjutkan ke layanan desa.
                </p>
            </div>

            @if ($errors->any())
                <x-ui.alert variant="danger" class="mt-6">
                    {{ $errors->first() }}
                </x-ui.alert>
            @endif

            <x-ui.button :href="route('auth.google')" variant="outline" size="lg" full class="mt-8">
                <svg class="size-5" viewBox="0 0 24 24" aria-hidden="true">
                    <path fill="#4285F4" d="M23.52 12.27c0-.85-.08-1.67-.22-2.45H12v4.64h6.46a5.52 5.52 0 0 1-2.4 3.62v3h3.88c2.27-2.09 3.58-5.17 3.58-8.81Z" />
                    <path fill="#34A853" d="M12 24c3.24 0 5.96-1.08 7.94-2.92l-3.88-3c-1.08.72-2.45 1.15-4.06 1.15-3.12 0-5.77-2.11-6.71-4.95H1.28v3.09A12 12 0 0 0 12 24Z" />
                    <path fill="#FBBC05" d="M5.29 14.28a7.2 7.2 0 0 1 0-4.56V6.63H1.28a12 12 0 0 0 0 10.74l4.01-3.09Z" />
                    <path fill="#EA4335" d="M12 4.77c1.76 0 3.34.61 4.58 1.79l3.44-3.44A11.96 11.96 0 0 0 12 0 12 12 0 0 0 1.28 6.63l4.01 3.09C6.23 6.88 8.88 4.77 12 4.77Z" />
                </svg>
                Masuk dengan Google
            </x-ui.button>

            <x-ui.divider label="atau" class="mt-6" />

            <p class="mt-6 text-center text-xs text-muted-foreground">
                Dengan masuk, akun Google Anda akan ditautkan ke akun portal desa. Data hanya digunakan
                untuk keperluan layanan.
            </p>
        </x-ui.card>

        <p class="mt-6 text-center text-sm">
            <a href="{{ route('home') }}" class="focus-ring inline-flex items-center gap-1.5 rounded font-medium text-muted-foreground transition hover:text-foreground">
                <x-heroicon-o-arrow-left class="size-4" />
                Kembali ke halaman verifikasi
            </a>
        </p>
    </div>
@endsection
