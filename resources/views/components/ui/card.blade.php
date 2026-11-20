@props(['padding' => 'p-5 sm:p-6', 'overflow' => 'visible'])

<div {{ $attributes->merge(['class' => 'rounded-xl border border-card-border bg-card text-card-foreground shadow-sm '.($overflow === 'hidden' ? 'overflow-hidden' : '')]) }}>
    @isset($header)
        <div class="rounded-t-xl border-b border-card-border px-5 py-4 sm:px-6">
            {{ $header }}
        </div>
    @endisset

    <div class="{{ $padding }}">
        {{ $slot }}
    </div>

    @isset($footer)
        <div class="rounded-b-xl border-t border-card-border bg-surface-muted/60 px-5 py-4 sm:px-6">
            {{ $footer }}
        </div>
    @endisset
</div>
