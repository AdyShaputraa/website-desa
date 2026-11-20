@props([
    'name',
    'label' => null,
    'value' => '1',
    'checked' => false,
    'disabled' => false,
])

@php
    $id = $attributes->get('id', $name);
    $isChecked = $checked || (string) old($name) === (string) $value;

    $switchAttributes = $attributes->except(['id'])->merge(['class' => 'peer sr-only']);
@endphp

<label for="{{ $id }}" class="inline-flex cursor-pointer items-center gap-3">
    <span class="relative inline-flex">
        <input
            id="{{ $id }}"
            name="{{ $name }}"
            type="checkbox"
            value="{{ $value }}"
            @checked($isChecked)
            @disabled($disabled)
            {{ $switchAttributes }}
        />

        <span class="h-6 w-11 rounded-full bg-muted transition peer-checked:bg-primary peer-focus-visible:ring-2 peer-focus-visible:ring-ring peer-focus-visible:ring-offset-2 peer-focus-visible:ring-offset-background peer-disabled:opacity-50"></span>
        <span class="pointer-events-none absolute left-0.5 top-0.5 size-5 rounded-full bg-white shadow transition peer-checked:translate-x-5"></span>
    </span>

    @if ($label || ! $slot->isEmpty())
        <span class="text-sm text-foreground">{{ $label ?? $slot }}</span>
    @endif
</label>
