<x-ui.card padding="p-0 sm:p-0" class="mt-6">
    <div class="flex flex-wrap items-start justify-between gap-3 border-b border-card-border px-5 py-4">
        <div>
            <h2 class="font-display text-base font-semibold tracking-tight text-foreground">{{ $title }}</h2>
            <p class="mt-0.5 text-sm text-muted-foreground">{{ $description }}</p>
        </div>

        <x-ui.badge variant="primary">{{ $surats->count() }} {{ __('ui.table.rows') }}</x-ui.badge>
    </div>

    <div class="p-5">
        @if ($surats->isEmpty())
            <x-ui.empty-state :title="$empty" :description="__('ui.empty.desc')" />
        @else
            <x-ui.table
                :caption="$title"
                :headers="[
                    __('ui.fields.ticket'),
                    __('ui.fields.applicant'),
                    __('ui.fields.type'),
                    __('ui.fields.status'),
                    __('ui.fields.date'),
                ]"
            >
                @foreach ($surats as $surat)
                    <tr class="transition hover:bg-surface-muted/60">
                        <td class="whitespace-nowrap px-4 py-3 font-mono text-xs font-medium text-foreground">
                            {{ $surat->nomor_tiket }}
                        </td>
                        <td class="whitespace-nowrap px-4 py-3 text-foreground">{{ $surat->nama_pemohon }}</td>
                        <td class="whitespace-nowrap px-4 py-3 text-muted-foreground">{{ $surat->label_jenis }}</td>
                        <td class="whitespace-nowrap px-4 py-3">
                            <x-ui.status-badge :status="$surat->status" />
                        </td>
                        <td class="whitespace-nowrap px-4 py-3 text-muted-foreground">
                            {{ $surat->created_at?->format('d/m/Y') }}
                        </td>
                    </tr>
                @endforeach
            </x-ui.table>
        @endif
    </div>
</x-ui.card>
