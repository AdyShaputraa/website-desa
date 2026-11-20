@php
    $namaDesa = config('desa.nama', 'Desa Digital');

    $sidebarItems = [
        [
            'label' => 'Beranda',
            'href' => route('home'),
            'icon' => 'heroicon-o-home',
            'active' => request()->routeIs('home'),
        ],
    ];

    if (app()->isLocal()) {
        $sidebarItems[] = [
            'label' => 'Design System',
            'href' => route('design-system'),
            'icon' => 'heroicon-o-swatch',
            'active' => request()->routeIs('design-system'),
        ];
    }

    if (auth()->guest()) {
        $sidebarItems[] = [
            'label' => 'Masuk',
            'href' => route('login'),
            'icon' => 'heroicon-o-arrow-left-on-rectangle',
            'active' => request()->routeIs('login'),
        ];
    }
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
    <body x-data class="min-h-screen bg-background font-sans text-foreground antialiased">
        <a
            href="#main-content"
            class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-50 focus:rounded-lg focus:bg-primary focus:px-4 focus:py-2 focus:text-sm focus:font-semibold focus:text-primary-foreground"
        >
            Lewati ke konten utama
        </a>

        <div class="lg:grid lg:min-h-screen lg:grid-cols-[16rem_minmax(0,1fr)]">
            <x-navigation.mobile-drawer>
                <x-navigation.sidebar :items="$sidebarItems">
                    <x-slot:footer>
                        <p class="px-1 pb-2 text-xs font-semibold uppercase tracking-wide text-muted-foreground">Warna accent</p>
                        <x-ui.accent-picker />

                        <div class="mt-3 border-t border-sidebar-border pt-3">
                            @auth
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-ui.button type="submit" variant="ghost" size="sm" full>
                                        <x-heroicon-o-arrow-right-on-rectangle class="size-4" />
                                        Keluar
                                    </x-ui.button>
                                </form>
                            @else
                                <x-ui.button :href="route('login')" size="sm" full>
                                    <x-heroicon-o-arrow-left-on-rectangle class="size-4" />
                                    Masuk
                                </x-ui.button>
                            @endauth
                        </div>
                    </x-slot:footer>
                </x-navigation.sidebar>
            </x-navigation.mobile-drawer>

            <div class="flex min-h-screen min-w-0 flex-col">
                <x-navigation.navbar :title="View::yieldContent('title')">
                    <x-ui.accent-picker class="hidden xl:flex" />
                    <x-ui.theme-toggle />
                </x-navigation.navbar>

                <main id="main-content" class="flex-1">
                    <div class="mx-auto w-full max-w-7xl px-4 py-6 sm:px-6 sm:py-8 lg:px-8">
                        @yield('content')
                    </div>
                </main>

                <footer class="border-t border-border px-4 py-4 text-xs text-muted-foreground sm:px-6 lg:px-8">
                    <div class="mx-auto flex w-full max-w-7xl flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
                        <p>&copy; {{ date('Y') }} {{ $namaDesa }}</p>
                        <p>{{ config('desa.alamat') }}</p>
                    </div>
                </footer>
            </div>
        </div>

        <x-feedback.toast-container />
        @stack('modals')
    </body>
</html>
