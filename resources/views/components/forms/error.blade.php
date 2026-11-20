@props([])

<p {{ $attributes->merge(['class' => 'mt-1.5 flex items-center gap-1 text-xs text-danger']) }}>
    <x-heroicon-o-exclamation-circle class="size-3.5 shrink-0" />
    <span>{{ $slot }}</span>
</p>
