@props(['status'])

@php
    $map = [
        'Pending' => ['warning', 'pending'],
        'Diproses' => ['info', 'diproses'],
        'Proses' => ['info', 'proses'],
        'Selesai' => ['success', 'selesai'],
        'Ditolak' => ['danger', 'ditolak'],
    ];

    $style = $map[$status] ?? ['neutral', null];
    $variant = $style[0];
    $key = $style[1];
@endphp

<x-ui.badge :variant="$variant" dot>
    {{ $key ? __('ui.status.'.$key) : $status }}
</x-ui.badge>
