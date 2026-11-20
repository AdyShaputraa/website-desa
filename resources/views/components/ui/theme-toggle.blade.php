@props([])

<x-ui.dropdown align="right" width="w-48">
    <x-slot:trigger>
        <button
            type="button"
            class="focus-ring inline-flex size-10 items-center justify-center rounded-lg border border-card-border bg-card text-foreground transition hover:bg-surface-muted"
            :aria-expanded="open"
            aria-label="Ganti tema"
        >
            <x-heroicon-o-sun class="size-5 dark:hidden" />
            <x-heroicon-o-moon class="hidden size-5 dark:block" />
        </button>
    </x-slot:trigger>

    @foreach ([
        ['value' => 'light', 'label' => 'Light', 'icon' => 'heroicon-o-sun'],
        ['value' => 'dark', 'label' => 'Dark', 'icon' => 'heroicon-o-moon'],
        ['value' => 'system', 'label' => 'System', 'icon' => 'heroicon-o-computer-desktop'],
    ] as $option)
        <button
            type="button"
            role="menuitemradio"
            x-on:click="$store.theme.set('{{ $option['value'] }}'); close()"
            :aria-checked="$store.theme.mode === '{{ $option['value'] }}'"
            :class="{ 'text-primary': $store.theme.mode === '{{ $option['value'] }}' }"
            class="focus-ring flex w-full items-center gap-2 rounded-lg px-3 py-2 text-sm text-foreground transition hover:bg-surface-muted"
        >
            <x-dynamic-component :component="$option['icon']" class="size-4" />
            {{ $option['label'] }}
            <x-heroicon-o-check class="ml-auto size-4" x-show="$store.theme.mode === '{{ $option['value'] }}'" />
        </button>
    @endforeach
</x-ui.dropdown>
