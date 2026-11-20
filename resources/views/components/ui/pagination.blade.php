@props(['paginator'])

@if ($paginator->hasPages())
    @php
        $current = $paginator->currentPage();
        $last = $paginator->lastPage();
        $start = max(1, $current - 2);
        $end = min($last, $current + 2);
    @endphp

    <nav class="flex flex-col items-center justify-between gap-3 sm:flex-row" aria-label="Navigasi halaman">
        <p class="text-sm text-muted-foreground">
            Menampilkan
            <span class="font-medium text-foreground">{{ $paginator->firstItem() }}</span>
            &ndash;
            <span class="font-medium text-foreground">{{ $paginator->lastItem() }}</span>
            dari
            <span class="font-medium text-foreground">{{ $paginator->total() }}</span>
            data
        </p>

        <div class="flex items-center gap-1">
            @if ($paginator->onFirstPage())
                <span class="focus-ring inline-flex size-9 items-center justify-center rounded-lg border border-card-border text-muted-foreground opacity-50" aria-disabled="true">
                    <x-heroicon-o-chevron-left class="size-4" />
                    <span class="sr-only">Halaman sebelumnya</span>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="focus-ring inline-flex size-9 items-center justify-center rounded-lg border border-card-border text-foreground transition hover:bg-surface-muted">
                    <x-heroicon-o-chevron-left class="size-4" />
                    <span class="sr-only">Halaman sebelumnya</span>
                </a>
            @endif

            @foreach ($paginator->getUrlRange($start, $end) as $page => $url)
                @if ($page === $current)
                    <span aria-current="page" class="inline-flex size-9 items-center justify-center rounded-lg bg-primary text-sm font-semibold text-primary-foreground">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="focus-ring inline-flex size-9 items-center justify-center rounded-lg border border-card-border text-sm font-medium text-foreground transition hover:bg-surface-muted">{{ $page }}</a>
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="focus-ring inline-flex size-9 items-center justify-center rounded-lg border border-card-border text-foreground transition hover:bg-surface-muted">
                    <x-heroicon-o-chevron-right class="size-4" />
                    <span class="sr-only">Halaman berikutnya</span>
                </a>
            @else
                <span class="focus-ring inline-flex size-9 items-center justify-center rounded-lg border border-card-border text-muted-foreground opacity-50" aria-disabled="true">
                    <x-heroicon-o-chevron-right class="size-4" />
                    <span class="sr-only">Halaman berikutnya</span>
                </span>
            @endif
        </div>
    </nav>
@endif
