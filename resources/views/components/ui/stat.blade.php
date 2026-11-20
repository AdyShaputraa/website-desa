@props(['label', 'value', 'icon' => null, 'trend' => null, 'trendDirection' => 'up', 'description' => null])

<div {{ $attributes->merge(['class' => 'rounded-xl border border-card-border bg-card p-5 text-card-foreground shadow-sm']) }}>
    <div class="flex items-start justify-between gap-3">
        <div class="min-w-0">
            <p class="text-sm text-muted-foreground">{{ $label }}</p>
            <p class="mt-1 font-display text-2xl font-semibold tracking-tight">{{ $value }}</p>
        </div>

        @if ($icon)
            <span class="rounded-lg bg-primary-soft p-2 text-primary-soft-foreground">
                <x-dynamic-component :component="$icon" class="size-5" />
            </span>
        @endif
    </div>

    @if ($trend || $description)
        <div class="mt-3 flex items-center gap-1.5 text-xs">
            @if ($trend)
                @if ($trendDirection === 'down')
                    <x-heroicon-o-arrow-trending-down class="size-4 text-danger" />
                    <span class="font-semibold text-danger">{{ $trend }}</span>
                @else
                    <x-heroicon-o-arrow-trending-up class="size-4 text-success" />
                    <span class="font-semibold text-success">{{ $trend }}</span>
                @endif
            @endif

            @if ($description)
                <span class="text-muted-foreground">{{ $description }}</span>
            @endif
        </div>
    @endif
</div>
