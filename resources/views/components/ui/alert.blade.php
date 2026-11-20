@props(['variant' => 'info', 'title' => null, 'dismissible' => false])

@php
    $variants = [
        'info' => ['container' => 'border-info/30 bg-info-soft text-info-soft-foreground', 'icon' => 'heroicon-o-information-circle'],
        'success' => ['container' => 'border-success/30 bg-success-soft text-success-soft-foreground', 'icon' => 'heroicon-o-check-circle'],
        'warning' => ['container' => 'border-warning/30 bg-warning-soft text-warning-soft-foreground', 'icon' => 'heroicon-o-exclamation-triangle'],
        'danger' => ['container' => 'border-danger/30 bg-danger-soft text-danger-soft-foreground', 'icon' => 'heroicon-o-x-circle'],
    ];

    $style = $variants[$variant] ?? $variants['info'];
@endphp

<div
    @if ($dismissible) x-data="{ visible: true }" x-show="visible" @endif
    role="alert"
    {{ $attributes->merge(['class' => 'flex items-start gap-3 rounded-xl border p-4 text-sm '.$style['container']]) }}
>
    <x-dynamic-component :component="$style['icon']" class="mt-0.5 size-5 shrink-0" />

    <div class="min-w-0 flex-1">
        @if ($title)
            <p class="font-semibold">{{ $title }}</p>
        @endif

        <div @class(['mt-1' => $title])>{{ $slot }}</div>
    </div>

    @if ($dismissible)
        <button
            type="button"
            @click="visible = false"
            class="focus-ring shrink-0 rounded-md p-1 transition hover:bg-black/5 dark:hover:bg-white/10"
            aria-label="Tutup notifikasi"
        >
            <x-heroicon-o-x-mark class="size-4" />
        </button>
    @endif
</div>
