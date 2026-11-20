@props(['label' => null])

<div class="flex items-center gap-3" role="separator">
    <span class="h-px flex-1 bg-border"></span>

    @if ($label)
        <span class="text-xs font-medium uppercase tracking-wide text-muted-foreground">{{ $label }}</span>
        <span class="h-px flex-1 bg-border"></span>
    @endif
</div>
