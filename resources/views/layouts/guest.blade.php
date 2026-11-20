@php
    $namaDesa = config('desa.nama', 'Desa Digital');
    $inisial = collect(explode(' ', $namaDesa))
        ->filter()
        ->take(2)
        ->map(fn ($kata) => mb_strtoupper(mb_substr($kata, 0, 1)))
        ->implode('');
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.partials.theme-init')

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="@yield('description', 'Portal informasi dan layanan '.$namaDesa.'.')">
        <title>@yield('title', 'Beranda') &middot; {{ config('app.name', 'Portal Desa Digital') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('head')
    </head>
    <body x-data class="flex min-h-screen flex-col bg-background font-sans text-foreground antialiased">
        <a
            href="#main-content"
            class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-50 focus:rounded-lg focus:bg-primary focus:px-4 focus:py-2 focus:text-sm focus:font-semibold focus:text-primary-foreground"
        >
            Lewati ke konten utama
        </a>

        <header class="sticky top-0 z-20 border-b border-border bg-surface/90 backdrop-blur">
            <div class="mx-auto flex h-16 w-full max-w-7xl items-center gap-3 px-4 sm:px-6 lg:px-8">
                <a href="{{ route('home') }}" class="focus-ring flex min-w-0 items-center gap-3 rounded-lg">
                    <span
                        class="grid size-9 shrink-0 place-items-center rounded-lg bg-primary text-sm font-bold text-primary-foreground"
                        aria-hidden="true"
                    >
                        {{ $inisial ?: 'PD' }}
                    </span>

                    <span class="min-w-0">
                        <span class="block truncate text-sm font-semibold text-foreground">{{ config('app.name', 'Portal Desa Digital') }}</span>
                        <span class="block truncate text-xs text-muted-foreground">{{ $namaDesa }}</span>
                    </span>
                </a>

                <nav class="ml-auto flex items-center gap-2" aria-label="Navigasi halaman">
                    <x-ui.accent-picker class="hidden md:flex" />
                    <x-ui.theme-toggle />

                    @auth
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-ui.button type="submit" variant="outline" size="sm">
                                <x-heroicon-o-arrow-right-on-rectangle class="size-4" />
                                <span class="hidden sm:inline">Keluar</span>
                                <span class="sr-only sm:hidden">Keluar</span>
                            </x-ui.button>
                        </form>
                    @elseif (! request()->routeIs('login'))
                        <x-ui.button :href="route('login')" size="sm">
                            <x-heroicon-o-arrow-left-on-rectangle class="size-4" />
                            Masuk
                        </x-ui.button>
                    @endauth
                </nav>
            </div>
        </header>

        <main id="main-content" class="flex-1">
            @yield('content')
        </main>

        <footer class="border-t border-border">
            <div class="mx-auto flex w-full max-w-7xl flex-col gap-2 px-4 py-6 text-xs text-muted-foreground sm:flex-row sm:items-center sm:justify-between sm:px-6 lg:px-8">
                <p>&copy; {{ date('Y') }} {{ $namaDesa }}. Seluruh hak cipta dilindungi.</p>
                <p>{{ config('desa.alamat') }}</p>
            </div>
        </footer>

        <x-feedback.toast-container />
        @stack('modals')
    </body>
</html>
