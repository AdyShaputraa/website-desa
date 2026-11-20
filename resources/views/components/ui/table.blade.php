@props(['headers' => [], 'caption' => null])

<div class="surface-scrollbar w-full overflow-x-auto rounded-xl border border-card-border">
    <table class="w-full min-w-[40rem] border-collapse text-left text-sm">
        @if ($caption)
            <caption class="sr-only">{{ $caption }}</caption>
        @endif

        @if (count($headers) > 0)
            <thead class="bg-surface-muted">
                <tr>
                    @foreach ($headers as $header)
                        <th scope="col" class="whitespace-nowrap px-4 py-3 text-xs font-semibold uppercase tracking-wide text-muted-foreground">
                            {{ $header }}
                        </th>
                    @endforeach
                </tr>
            </thead>
        @endif

        <tbody class="divide-y divide-border">
            {{ $slot }}
        </tbody>
    </table>
</div>
