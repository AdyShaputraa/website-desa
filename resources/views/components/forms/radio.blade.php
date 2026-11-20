@props([
    'name',
    'label' => null,
    'value',
    'checked' => false,
    'error' => null,
])

@php
    $id = $attributes->get('id', $name.'-'.str_replace(' ', '-', (string) $value));
    $isChecked = $checked || (string) old($name) === (string) $value;

    $radioAttributes = $attributes->except(['id'])->merge([
        'class' => 'mt-0.5 size-4 shrink-0 border-input-border text-primary accent-primary focus:ring-2 focus:ring-ring/40',
    ]);
@endphp

<div>
    <label for="{{ $id }}" class="flex items-start gap-2.5 text-sm text-foreground">
        <input
            id="{{ $id }}"
            name="{{ $name }}"
            type="radio"
            value="{{ $value }}"
            @checked($isChecked)
            {{ $radioAttributes }}
        />

        <span>{{ $label ?? $slot }}</span>
    </label>

    @if (filled($error))
        <p class="mt-1.5 flex items-center gap-1 text-xs text-danger">
            <x-heroicon-o-exclamation-circle class="size-3.5" />
            {{ $error }}
        </p>
    @endif
</div>
