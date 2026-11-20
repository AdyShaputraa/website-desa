@props(['variant' => 'neutral', 'dot' => false])

@php
    $variants = [
        'neutral' => 'bg-muted text-muted-foreground',
        'primary' => 'bg-primary-soft text-primary-soft-foreground',
        'success' => 'bg-success-soft text-success-soft-foreground',
        'warning' => 'bg-warning-soft text-warning-soft-foreground',
        'danger' => 'bg-danger-soft text-danger-soft-foreground',
        'info' => 'bg-info-soft text-info-soft-foreground',
    ];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-1.5 whitespace-nowrap rounded-full px-2.5 py-0.5 text-xs font-semibold '.($variants[$variant] ?? $variants['neutral'])]) }}>
    @if ($dot)
        <span class="size-1.5 rounded-full bg-current" aria-hidden="true"></span>
    @endif

    {{ $slot }}
</span>
