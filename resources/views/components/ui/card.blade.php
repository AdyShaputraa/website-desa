@props(['padding' => 'p-5 sm:p-6'])

<div {{ $attributes->merge(['class' => 'overflow-hidden rounded-xl border border-card-border bg-card text-card-foreground shadow-sm']) }}>
    @isset($header)
        <div class="border-b border-card-border px-5 py-4 sm:px-6">
            {{ $header }}
        </div>
    @endisset

    <div class="{{ $padding }}">
        {{ $slot }}
    </div>

    @isset($footer)
        <div class="border-t border-card-border bg-surface-muted/60 px-5 py-4 sm:px-6">
            {{ $footer }}
        </div>
    @endisset
</div>
