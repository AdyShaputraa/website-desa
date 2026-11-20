@props(['href', 'active' => false, 'icon' => null, 'badge' => null])

<a
    href="{{ $href }}"
    @if ($active) aria-current="page" @endif
    {{ $attributes->merge([
        'class' => 'focus-ring group flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition '
            .($active
                ? 'bg-sidebar-active text-sidebar-active-foreground'
                : 'text-sidebar-foreground hover:bg-surface-muted hover:text-foreground'),
    ]) }}
>
    @if ($icon)
        <x-dynamic-component :component="$icon" class="size-5 shrink-0" />
    @endif

    <span class="min-w-0 flex-1 truncate">{{ $slot }}</span>

    @if ($badge)
        <x-ui.badge variant="primary" class="shrink-0">{{ $badge }}</x-ui.badge>
    @endif
</a>
