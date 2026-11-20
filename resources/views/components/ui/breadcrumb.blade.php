@props(['items' => []])

<nav aria-label="Breadcrumb">
    <ol class="flex flex-wrap items-center gap-1.5 text-sm">
        @foreach ($items as $item)
            @if (! $loop->last && ! empty($item['url']))
                <li class="flex items-center gap-1.5">
                    <a href="{{ $item['url'] }}" class="focus-ring rounded text-muted-foreground transition hover:text-foreground">
                        {{ $item['label'] }}
                    </a>
                    <x-heroicon-o-chevron-right class="size-3.5 text-muted-foreground/70" aria-hidden="true" />
                </li>
            @else
                <li class="flex items-center gap-1.5">
                    <span @if ($loop->last) aria-current="page" @endif class="font-medium text-foreground">
                        {{ $item['label'] }}
                    </span>
                </li>
            @endif
        @endforeach
    </ol>
</nav>
