@props(['title' => null, 'subtitle' => null])

<header class="sticky top-0 z-20 border-b border-border bg-surface/90 backdrop-blur">
    <div class="flex h-16 items-center gap-3 px-4 sm:px-6 lg:px-8">
        <button
            type="button"
            x-on:click="$store.sidebar.toggle()"
            :aria-expanded="$store.sidebar.open.toString()"
            aria-controls="app-sidebar"
            class="focus-ring inline-flex size-10 shrink-0 items-center justify-center rounded-lg border border-card-border bg-card text-foreground transition hover:bg-surface-muted lg:hidden"
            aria-label="{{ __('ui.nav.open_menu') }}"
        >
            <x-heroicon-o-bars-3 class="size-5" />
        </button>

        <div class="min-w-0 flex-1">
            @if ($title)
                <p class="hidden truncate text-sm font-semibold text-foreground sm:block sm:text-base">{{ $title }}</p>
            @endif

            @if ($subtitle)
                <p class="hidden truncate text-xs text-muted-foreground sm:block">{{ $subtitle }}</p>
            @endif
        </div>

        <div class="flex shrink-0 items-center gap-2">
            {{ $slot }}
        </div>
    </div>
</header>
