@props([
    'name',
    'label' => null,
    'error' => null,
    'hint' => null,
    'rows' => 4,
])

@php
    $id = $attributes->get('id', $name);
    $hasError = filled($error);

    $classes = 'block w-full rounded-lg border bg-input px-3 py-2 text-sm text-foreground placeholder:text-placeholder transition focus:outline-none focus:ring-2 focus:ring-ring/40 disabled:cursor-not-allowed disabled:opacity-60 '
        .($hasError ? 'border-danger focus:border-danger' : 'border-input-border focus:border-primary');

    $textareaAttributes = $attributes->except(['id'])->merge(['class' => $classes, 'rows' => $rows]);
@endphp

<div>
    @if ($label)
        <x-forms.label :for="$id" :required="$attributes->has('required')">{{ $label }}</x-forms.label>
    @endif

    <div @class(['mt-1.5' => $label])>
        <textarea
            id="{{ $id }}"
            name="{{ $name }}"
            @if ($hasError) aria-invalid="true" aria-describedby="{{ $id }}-error" @elseif ($hint) aria-describedby="{{ $id }}-hint" @endif
            {{ $textareaAttributes }}
        >{{ $attributes->get('value', old($name)) }}</textarea>
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
