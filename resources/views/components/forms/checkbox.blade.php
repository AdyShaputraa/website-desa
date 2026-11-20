@props([
    'name',
    'label' => null,
    'value' => '1',
    'checked' => false,
    'error' => null,
])

@php
    $id = $attributes->get('id', $name.'-'.str_replace(' ', '-', (string) $value));
    $old = old($name);
    $isChecked = $checked || (is_array($old) ? in_array($value, $old) : (string) $old === (string) $value);

    $checkboxAttributes = $attributes->except(['id'])->merge([
        'class' => 'mt-0.5 size-4 shrink-0 rounded border-input-border text-primary accent-primary focus:ring-2 focus:ring-ring/40',
    ]);
@endphp

<div>
    <label for="{{ $id }}" class="flex items-start gap-2.5 text-sm text-foreground">
        <input
            id="{{ $id }}"
            name="{{ $name }}"
            type="checkbox"
            value="{{ $value }}"
            @checked($isChecked)
            {{ $checkboxAttributes }}
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
