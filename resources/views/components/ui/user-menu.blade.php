@props([])

@php
    $user = auth()->user();
    $name = $user?->name ?? '';
    $initials = collect(explode(' ', $name))
        ->filter()
        ->take(2)
        ->map(fn ($word) => mb_strtoupper(mb_substr($word, 0, 1)))
        ->implode('');
@endphp

<x-ui.dropdown align="right" width="w-64">
    <x-slot:trigger>
        <button
            type="button"
            x-data="{ avatarFailed: false }"
            class="focus-ring inline-flex size-10 items-center justify-center overflow-hidden rounded-full border border-card-border bg-surface-muted text-sm font-semibold text-foreground transition hover:ring-2 hover:ring-ring/30"
            :aria-expanded="open"
            aria-haspopup="menu"
            aria-label="{{ __('ui.account.menu') }} {{ $initials }}"
        >
            @if ($user?->avatar)
                <img
                    src="{{ $user->avatar }}"
                    alt=""
                    class="size-full object-cover"
                    width="40"
                    height="40"
                    decoding="async"
                    referrerpolicy="no-referrer"
                    x-show="! avatarFailed"
                    x-on:error="avatarFailed = true"
                />
                <span x-show="avatarFailed" x-cloak>{{ $initials ?: '?' }}</span>
            @else
                <span>{{ $initials ?: '?' }}</span>
            @endif
        </button>
    </x-slot:trigger>

    <div class="border-b border-card-border px-3 py-2.5">
        <p class="truncate text-sm font-semibold text-foreground">{{ $user?->name }}</p>
        <p class="truncate text-xs text-muted-foreground">{{ $user?->email }}</p>
    </div>

    <div class="py-1">
        <a
            href="{{ route('settings.edit') }}"
            role="menuitem"
            class="focus-ring flex items-center gap-2 rounded-lg px-3 py-2 text-sm text-foreground transition hover:bg-surface-muted"
        >
            <x-heroicon-o-cog-6-tooth class="size-4" />
            {{ __('ui.account.settings') }}
        </a>

        <a
            href="{{ route('password.edit') }}"
            role="menuitem"
            class="focus-ring flex items-center gap-2 rounded-lg px-3 py-2 text-sm text-foreground transition hover:bg-surface-muted"
        >
            <x-heroicon-o-key class="size-4" />
            {{ __('ui.account.change_password') }}
        </a>
    </div>

    <div class="border-t border-card-border pt-1">
        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button
                type="submit"
                role="menuitem"
                class="focus-ring flex w-full items-center gap-2 rounded-lg px-3 py-2 text-left text-sm text-danger transition hover:bg-danger-soft"
            >
                <x-heroicon-o-arrow-right-on-rectangle class="size-4" />
                {{ __('ui.account.logout') }}
            </button>
        </form>
    </div>
</x-ui.dropdown>
