@props(['items' => [], 'label' => 'Navigasi utama'])

@php
    $namaDesa = config('desa.nama', 'Desa Digital');
    $inisial = collect(explode(' ', $namaDesa))
        ->filter()
        ->take(2)
        ->map(fn ($kata) => mb_strtoupper(mb_substr($kata, 0, 1)))
        ->implode('');
@endphp

<div class="flex h-full flex-col border-r border-sidebar-border bg-sidebar">
    <div class="flex h-16 shrink-0 items-center gap-3 border-b border-sidebar-border px-4">
        <a href="{{ route('home') }}" class="focus-ring flex min-w-0 items-center gap-3 rounded-lg">
            <span
                class="grid size-9 shrink-0 place-items-center rounded-lg bg-primary text-sm font-bold text-primary-foreground"
                aria-hidden="true"
            >
                {{ $inisial ?: 'PD' }}
            </span>

            <span class="min-w-0">
                <span class="block truncate text-sm font-semibold text-foreground">Portal Desa</span>
                <span class="block truncate text-xs text-muted-foreground">{{ $namaDesa }}</span>
            </span>
        </a>

        <button
            type="button"
            data-sidebar-close
            x-on:click="$store.sidebar.close()"
            class="focus-ring ml-auto inline-flex size-9 items-center justify-center rounded-lg text-muted-foreground transition hover:bg-surface-muted hover:text-foreground lg:hidden"
            aria-label="Tutup menu navigasi"
        >
            <x-heroicon-o-x-mark class="size-5" />
        </button>
    </div>

    <nav class="surface-scrollbar flex-1 space-y-1 overflow-y-auto px-3 py-4" aria-label="{{ $label }}">
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
