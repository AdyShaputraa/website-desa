@props(['label' => 'Memuat data', 'overlay' => false, 'size' => 'size-5'])

@if ($overlay)
    <div
        class="fixed inset-0 z-50 grid place-items-center bg-overlay p-4"
        role="status"
        aria-live="polite"
        {{ $attributes }}
    >
        <div class="flex items-center gap-3 rounded-xl border border-card-border bg-card px-4 py-3 text-sm text-card-foreground shadow-lg">
            <x-ui.spinner :size="$size" class="text-primary" />
            <span>{{ $label }}</span>
        </div>
    </div>
@else
    <div
        class="inline-flex items-center gap-2 text-sm text-muted-foreground"
        role="status"
        aria-live="polite"
        {{ $attributes }}
    >
        <x-ui.spinner :size="$size" class="text-primary" />
        <span>{{ $label }}</span>
    </div>
@endif
