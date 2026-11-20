@props(['title' => 'Belum ada data', 'description' => null, 'icon' => 'heroicon-o-inbox'])

<div {{ $attributes->merge(['class' => 'flex flex-col items-center justify-center rounded-xl border border-dashed border-border bg-surface-muted/40 px-6 py-12 text-center']) }}>
    <span class="rounded-full bg-primary-soft p-3 text-primary-soft-foreground">
        <x-dynamic-component :component="$icon" class="size-6" />
    </span>

    <p class="mt-4 font-semibold text-foreground">{{ $title }}</p>

    @if ($description)
        <p class="mt-1 max-w-sm text-sm text-muted-foreground">{{ $description }}</p>
    @endif

    @isset($action)
        <div class="mt-5">
            {{ $action }}
        </div>
    @endisset
</div>
