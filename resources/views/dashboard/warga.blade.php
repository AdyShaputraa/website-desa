<div class="mt-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
    @foreach ($stats as $stat)
        <x-ui.stat :label="$stat['label']" :value="$stat['value']" :icon="$stat['icon']" />
    @endforeach
</div>

@include('dashboard.partials.surat-table', [
    'surats' => $surats,
    'title' => __('ui.table.surat_mine'),
    'description' => __('ui.table.surat_mine_desc'),
    'empty' => __('ui.empty.surat'),
])

@include('dashboard.partials.pengaduan-table', [
    'pengaduans' => $pengaduans,
    'title' => __('ui.table.pengaduan_mine'),
    'description' => __('ui.table.pengaduan_mine_desc'),
    'empty' => __('ui.empty.pengaduan'),
])
