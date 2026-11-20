@props(['title', 'description' => null, 'eyebrow' => null])

<div {{ $attributes->merge(['class' => 'flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between']) }}>
    <div class="min-w-0">
        @if ($eyebrow)
            <p class="text-xs font-semibold uppercase tracking-wide text-primary">{{ $eyebrow }}</p>
        @endif

        <h1 class="font-display text-2xl font-semibold tracking-tight text-foreground sm:text-3xl">{{ $title }}</h1>

        @if ($description)
            <p class="mt-1.5 max-w-2xl text-sm text-muted-foreground">{{ $description }}</p>
        @endif
    </div>

    @isset($actions)
        <div class="flex flex-wrap items-center gap-2">
            {{ $actions }}
        </div>
    @endisset
</div>
