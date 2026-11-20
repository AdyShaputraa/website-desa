@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
    'href' => null,
    'disabled' => false,
    'loading' => false,
    'full' => false,
])

@php
    $variants = [
        'primary' => 'bg-primary text-primary-foreground shadow-sm hover:bg-primary-hover',
        'secondary' => 'bg-secondary text-secondary-foreground hover:bg-secondary-hover',
        'outline' => 'border border-input-border bg-transparent text-foreground hover:bg-surface-muted',
        'ghost' => 'bg-transparent text-foreground hover:bg-surface-muted',
        'danger' => 'bg-danger text-white shadow-sm hover:brightness-110',
        'link' => 'bg-transparent text-primary underline-offset-4 hover:underline',
    ];

    $sizes = [
        'sm' => 'h-9 gap-1.5 px-3 text-sm',
        'md' => 'h-10 gap-2 px-4 text-sm',
        'lg' => 'h-11 gap-2 px-5 text-base',
        'icon' => 'size-10 justify-center',
    ];

    $base = 'focus-ring inline-flex items-center justify-center whitespace-nowrap rounded-lg font-semibold transition disabled:pointer-events-none disabled:opacity-50';
    $classes = trim($base.' '.($variants[$variant] ?? $variants['primary']).' '.($sizes[$size] ?? $sizes['md']).($full ? ' w-full' : ''));
    $isDisabled = $disabled || $loading;
@endphp

@if ($href && ! $isDisabled)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if ($loading)
            <x-ui.spinner class="size-4" />
        @endif

        {{ $slot }}
    </a>
@elseif ($href)
    <span aria-disabled="true" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </span>
@else
    <button type="{{ $type }}" @disabled($isDisabled) @if ($loading) aria-busy="true" @endif {{ $attributes->merge(['class' => $classes]) }}>
        @if ($loading)
            <x-ui.spinner class="size-4" />
        @endif

        {{ $slot }}
    </button>
@endif
