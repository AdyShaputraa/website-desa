@props(['name', 'title' => null, 'description' => null, 'maxWidth' => 'max-w-lg'])

<div
    x-data="modal"
    x-on:open-modal.window="if ($event.detail === '{{ $name }}') show()"
    x-on:close-modal.window="if ($event.detail === '{{ $name }}') hide()"
    x-on:keydown.escape.window="open && hide()"
    x-show="open"
    x-cloak
    class="fixed inset-0 z-50 flex items-end justify-center p-4 sm:items-center"
    role="dialog"
    aria-modal="true"
    @if ($title) aria-labelledby="{{ $name }}-title" @endif
>
    <div
        x-show="open"
        x-transition.opacity
        class="absolute inset-0 bg-overlay"
        @click="hide()"
        aria-hidden="true"
    ></div>

    <div
        x-ref="panel"
        x-show="open"
        x-transition
        class="relative z-10 max-h-[calc(100vh-2rem)] w-full {{ $maxWidth }} overflow-y-auto rounded-2xl border border-card-border bg-card text-card-foreground shadow-xl"
    >
        <div class="flex items-start justify-between gap-4 border-b border-card-border px-5 py-4 sm:px-6">
            <div>
                @if ($title)
                    <h2 id="{{ $name }}-title" class="font-display text-lg font-semibold tracking-tight">{{ $title }}</h2>
                @endif

                @if ($description)
                    <p class="mt-1 text-sm text-muted-foreground">{{ $description }}</p>
                @endif
            </div>

            <button
                type="button"
                @click="hide()"
                class="focus-ring -mr-1 shrink-0 rounded-lg p-1.5 text-muted-foreground transition hover:bg-surface-muted hover:text-foreground"
                aria-label="Tutup dialog"
            >
                <x-heroicon-o-x-mark class="size-5" />
            </button>
        </div>

        <div class="px-5 py-5 sm:px-6">
            {{ $slot }}
        </div>

        @isset($footer)
            <div class="flex flex-col-reverse gap-2 border-t border-card-border bg-surface-muted/60 px-5 py-4 sm:flex-row sm:justify-end sm:px-6">
                {{ $footer }}
            </div>
        @endisset
    </div>
</div>
