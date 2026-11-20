@props(['label' => true])

@php
    $current = app()->getLocale();
    $locales = [
        'id' => 'Indonesia',
        'en' => 'English',
    ];
@endphp

<x-ui.dropdown align="right" width="w-44">
    <x-slot:trigger>
        <button
            type="button"
            class="focus-ring inline-flex h-10 items-center gap-1.5 rounded-lg border border-card-border bg-card px-2.5 text-foreground transition hover:bg-surface-muted"
            :aria-expanded="open"
            aria-haspopup="menu"
            aria-label="{{ __('ui.nav.language') }}"
        >
            <x-heroicon-o-language class="size-5" />
            <span @class(['text-xs font-semibold uppercase', 'hidden sm:inline' => ! $label])>{{ $current }}</span>
        </button>
    </x-slot:trigger>

    @foreach ($locales as $code => $label)
        <a
            href="{{ route('language.switch', $code) }}"
            hreflang="{{ $code }}"
            role="menuitemradio"
            aria-checked="{{ $current === $code ? 'true' : 'false' }}"
            @class([
                'focus-ring flex items-center gap-2 rounded-lg px-3 py-2 text-sm transition hover:bg-surface-muted',
                'font-semibold text-primary' => $current === $code,
                'text-foreground' => $current !== $code,
            ])
        >
            {{ $label }}

            @if ($current === $code)
                <x-heroicon-o-check class="ml-auto size-4" />
            @endif
        </a>
    @endforeach
</x-ui.dropdown>
