@props([])

@php
    $accents = [
        ['value' => 'indigo', 'label' => 'Indigo', 'class' => 'bg-indigo-500'],
        ['value' => 'emerald', 'label' => 'Emerald', 'class' => 'bg-emerald-500'],
        ['value' => 'violet', 'label' => 'Violet', 'class' => 'bg-violet-500'],
        ['value' => 'rose', 'label' => 'Rose', 'class' => 'bg-rose-500'],
    ];
@endphp

<div {{ $attributes->merge(['class' => 'flex flex-wrap items-center gap-2']) }} role="group" aria-label="Warna accent">
    @foreach ($accents as $accent)
        <button
            type="button"
            x-on:click="$store.accent.set('{{ $accent['value'] }}')"
            :aria-pressed="$store.accent.value === '{{ $accent['value'] }}'"
            :class="$store.accent.value === '{{ $accent['value'] }}' ? 'border-primary ring-2 ring-ring/30' : 'border-card-border hover:bg-surface-muted'"
            class="focus-ring inline-flex items-center gap-2 rounded-lg border bg-card px-3 py-1.5 text-sm font-medium text-foreground transition"
        >
            <span class="size-4 rounded-full {{ $accent['class'] }}" aria-hidden="true"></span>
            {{ $accent['label'] }}
        </button>
    @endforeach
</div>
