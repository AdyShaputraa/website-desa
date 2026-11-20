@props(['title' => null, 'description' => null, 'id' => null])

<section @if ($id) id="{{ $id }}" @endif {{ $attributes->merge(['class' => 'scroll-mt-24']) }}>
    @if ($title || $description)
        <div class="mb-4">
            @if ($title)
                <h2 class="font-display text-lg font-semibold tracking-tight text-foreground sm:text-xl">{{ $title }}</h2>
            @endif

            @if ($description)
                <p class="mt-1 text-sm text-muted-foreground">{{ $description }}</p>
            @endif
        </div>
    @endif

    {{ $slot }}
</section>
