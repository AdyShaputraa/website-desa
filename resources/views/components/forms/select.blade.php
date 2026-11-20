@props([
    'name',
    'label' => null,
    'error' => null,
    'hint' => null,
    'options' => [],
    'placeholder' => null,
])

@php
    $id = $attributes->get('id', $name);
    $hasError = filled($error);
    $selected = (string) $attributes->get('selected', old($name, ''));

    $normalized = [];

    foreach ($options as $key => $option) {
        if (is_array($option)) {
            $normalized[] = [
                'value' => (string) ($option['value'] ?? ''),
                'label' => $option['label'] ?? '',
            ];
        } elseif (is_int($key)) {
            $normalized[] = ['value' => (string) $option, 'label' => $option];
        } else {
            $normalized[] = ['value' => (string) $key, 'label' => $option];
        }
    }

    $classes = 'block h-10 w-full rounded-lg border bg-input px-3 text-sm text-foreground transition focus:outline-none focus:ring-2 focus:ring-ring/40 disabled:cursor-not-allowed disabled:opacity-60 '
        .($hasError ? 'border-danger focus:border-danger' : 'border-input-border focus:border-primary');

    $selectAttributes = $attributes->except(['id', 'selected'])->merge(['class' => $classes]);
@endphp

<div>
    @if ($label)
        <x-forms.label :for="$id" :required="$attributes->has('required')">{{ $label }}</x-forms.label>
    @endif

    <div @class(['mt-1.5' => $label])>
        <select
            id="{{ $id }}"
            name="{{ $name }}"
            @if ($hasError) aria-invalid="true" aria-describedby="{{ $id }}-error" @elseif ($hint) aria-describedby="{{ $id }}-hint" @endif
            {{ $selectAttributes }}
        >
            @if ($placeholder)
                <option value="" @selected($selected === '')>{{ $placeholder }}</option>
            @endif

            @foreach ($normalized as $option)
                <option value="{{ $option['value'] }}" @selected($selected === $option['value'])>{{ $option['label'] }}</option>
            @endforeach
        </select>
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
