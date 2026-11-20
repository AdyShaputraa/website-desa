<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.partials.theme-init')

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="@yield('description', __('ui.app.name'))">
        <title>@yield('title', __('ui.auth.page_title')) &middot; {{ __('ui.app.name') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('head')
    </head>
    <body x-data class="flex min-h-screen flex-col bg-background font-sans text-foreground antialiased">
        <a
            href="#main-content"
            class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-50 focus:rounded-lg focus:bg-primary focus:px-4 focus:py-2 focus:text-sm focus:font-semibold focus:text-primary-foreground"
        >
            {{ __('ui.nav.skip') }}
        </a>

        <main id="main-content" class="flex flex-1 items-center justify-center px-4 py-10 sm:py-16">
            @yield('content')
        </main>

        <footer class="border-t border-border px-4 py-4 text-center text-xs text-muted-foreground">
            <p>{{ __('ui.footer.credit') }} &copy; {{ date('Y') }}</p>
        </footer>

        <x-feedback.toast-container />
        @stack('modals')
    </body>
</html>
