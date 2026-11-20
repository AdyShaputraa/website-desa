@props([])

<p {{ $attributes->merge(['class' => 'mt-1.5 text-xs text-muted-foreground']) }}>
    {{ $slot }}
</p>
