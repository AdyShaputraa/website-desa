@props([
    'name',
    'label' => null,
    'error' => null,
    'hint' => null,
    'type' => 'text',
    'icon' => null,
])

@php
    $id = $attributes->get('id', $name);
    $value = $attributes->get('value', old($name));
    $hasError = filled($error);

    $classes = 'block h-10 w-full rounded-lg border bg-input px-3 text-sm text-foreground placeholder:text-placeholder transition focus:outline-none focus:ring-2 focus:ring-ring/40 disabled:cursor-not-allowed disabled:opacity-60 '
        .($icon ? 'pl-10 ' : '')
        .($hasError ? 'border-danger focus:border-danger' : 'border-input-border focus:border-primary');

    $inputAttributes = $attributes->except(['id', 'value'])->merge(['class' => $classes]);
@endphp

<div>
    @if ($label)
        <x-forms.label :for="$id" :required="$attributes->has('required')">{{ $label }}</x-forms.label>
    @endif

    <div @class(['relative', 'mt-1.5' => $label])>
        @if ($icon)
            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-muted-foreground">
                <x-dynamic-component :component="$icon" class="size-5" />
            </span>
        @endif

        <input
            id="{{ $id }}"
            name="{{ $name }}"
            type="{{ $type }}"
            value="{{ $value }}"
            @if ($hasError) aria-invalid="true" aria-describedby="{{ $id }}-error" @elseif ($hint) aria-describedby="{{ $id }}-hint" @endif
            {{ $inputAttributes }}
        />
    </div>

    @if ($hint && ! $hasError)
        <p id="{{ $id }}-hint" class="mt-1.5 text-xs text-muted-foreground">{{ $hint }}</p>
    @endif

    @if ($hasError)
        <p id="{{ $id }}-error" class="mt-1.5 flex items-center gap-1 text-xs text-danger">
            <x-heroicon-o-exclamation-circle class="size-3.5" />
            {{ $error }}
        </p>
    @endif
</div>
