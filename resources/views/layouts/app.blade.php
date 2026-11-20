@php
    $sidebarItems = [
        [
            'label' => __('ui.nav.dashboard'),
            'href' => route('dashboard'),
            'icon' => 'heroicon-o-squares-2x2',
            'active' => request()->routeIs('dashboard'),
        ],
    ];

    if (auth()->user()?->hasRole('admin')) {
        $sidebarItems[] = [
            'label' => __('ui.users.title'),
            'href' => route('users.index'),
            'icon' => 'heroicon-o-users',
            'active' => request()->routeIs('users.*'),
        ];
    }
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.partials.theme-init')

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="@yield('description', __('ui.app.name'))">
        <title>@yield('title', __('ui.nav.dashboard')) &middot; {{ __('ui.app.name') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('head')
    </head>
    <body x-data class="min-h-screen bg-background font-sans text-foreground antialiased">
        <a
            href="#main-content"
            class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-50 focus:rounded-lg focus:bg-primary focus:px-4 focus:py-2 focus:text-sm focus:font-semibold focus:text-primary-foreground"
        >
            {{ __('ui.nav.skip') }}
        </a>

        <div class="app-shell lg:grid lg:min-h-screen lg:grid-cols-[16rem_minmax(0,1fr)]">
            <x-navigation.mobile-drawer>
                <x-navigation.sidebar :items="$sidebarItems" />
            </x-navigation.mobile-drawer>

            <div class="flex min-h-screen min-w-0 flex-col">
                <x-navigation.navbar :title="View::yieldContent('title')">
                    <x-ui.language-switcher />
                    <x-ui.theme-toggle />
                    <span class="h-6 w-px shrink-0 bg-border" aria-hidden="true"></span>
                    <x-ui.user-menu />
                </x-navigation.navbar>

                <main id="main-content" class="flex-1">
                    <div class="w-full px-4 py-6 sm:px-6 sm:py-8 lg:px-8 2xl:px-10">
                        @yield('content')
                    </div>
                </main>

                <footer class="border-t border-border px-4 py-4 text-left text-xs text-muted-foreground sm:px-6 lg:px-8">
                    <p>{{ __('ui.footer.credit') }} &copy; {{ date('Y') }}</p>
                </footer>
            </div>
        </div>

        <x-feedback.toast-container />
        @stack('modals')
    </body>
</html>
