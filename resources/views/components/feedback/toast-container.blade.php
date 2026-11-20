@props([])

<div
    class="pointer-events-none fixed inset-x-0 bottom-0 z-[60] flex flex-col items-center gap-2 p-4 sm:inset-x-auto sm:right-4 sm:bottom-4 sm:items-end"
    aria-live="polite"
    aria-atomic="false"
>
    <template x-for="toast in $store.toasts.items" :key="toast.id">
        <div
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="translate-y-2 opacity-0"
            x-transition:enter-end="translate-y-0 opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="pointer-events-auto flex w-full max-w-sm items-start gap-3 rounded-xl border p-4 text-sm shadow-lg"
            :class="{
                'border-success/30 bg-success-soft text-success-soft-foreground': toast.type === 'success',
                'border-danger/30 bg-danger-soft text-danger-soft-foreground': toast.type === 'danger',
                'border-warning/30 bg-warning-soft text-warning-soft-foreground': toast.type === 'warning',
                'border-info/30 bg-info-soft text-info-soft-foreground': toast.type === 'info',
            }"
            role="status"
        >
            <x-heroicon-o-check-circle class="mt-0.5 size-5 shrink-0" x-show="toast.type === 'success'" />
            <x-heroicon-o-x-circle class="mt-0.5 size-5 shrink-0" x-show="toast.type === 'danger'" />
            <x-heroicon-o-exclamation-triangle class="mt-0.5 size-5 shrink-0" x-show="toast.type === 'warning'" />
            <x-heroicon-o-information-circle class="mt-0.5 size-5 shrink-0" x-show="toast.type === 'info'" />

            <p class="min-w-0 flex-1" x-text="toast.message"></p>

            <button
                type="button"
                x-on:click="$store.toasts.remove(toast.id)"
                class="focus-ring shrink-0 rounded-md p-1 transition hover:bg-black/5 dark:hover:bg-white/10"
                aria-label="Tutup notifikasi"
            >
                <x-heroicon-o-x-mark class="size-4" />
            </button>
        </div>
    </template>
</div>
