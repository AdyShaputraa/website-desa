@props(['items' => [], 'label' => null])

<div class="flex h-full flex-col border-r border-sidebar-border bg-sidebar">
    <div class="flex h-16 shrink-0 items-center gap-3 border-b border-sidebar-border px-4">
        <a href="{{ route('dashboard') }}" class="focus-ring flex min-w-0 items-center gap-3 rounded-lg">
            <span
                class="grid size-9 shrink-0 place-items-center rounded-lg bg-primary text-xs font-bold text-primary-foreground"
                aria-hidden="true"
            >
                PD
            </span>

            <span class="min-w-0">
                <span class="block truncate text-sm font-semibold text-foreground">{{ __('ui.app.name') }}</span>
            </span>
        </a>

        <button
            type="button"
            data-sidebar-close
            x-on:click="$store.sidebar.close()"
            class="focus-ring ml-auto inline-flex size-9 items-center justify-center rounded-lg text-muted-foreground transition hover:bg-surface-muted hover:text-foreground lg:hidden"
            aria-label="{{ __('ui.nav.close_menu') }}"
        >
            <x-heroicon-o-x-mark class="size-5" />
        </button>
    </div>

    <nav class="surface-scrollbar flex-1 space-y-1 overflow-y-auto px-3 py-4" aria-label="{{ $label ?? __('ui.nav.main_navigation') }}">
        @foreach ($items as $item)
            <x-navigation.nav-link
                :href="$item['href'] ?? '#'"
                :active="$item['active'] ?? false"
                :icon="$item['icon'] ?? null"
                :badge="$item['badge'] ?? null"
            >
                {{ $item['label'] ?? '' }}
            </x-navigation.nav-link>
        @endforeach
    </nav>

    @isset($footer)
        <div class="shrink-0 border-t border-sidebar-border p-3">
            {{ $footer }}
        </div>
    @endisset
</div>
