@props([
    'name' => 'confirm',
    'title' => 'Konfirmasi tindakan',
    'description' => null,
    'confirmLabel' => 'Ya, lanjutkan',
    'cancelLabel' => 'Batal',
    'variant' => 'danger',
])

<x-ui.modal :name="$name" :title="$title" :description="$description" maxWidth="max-w-md">
    {{ $slot }}

    <x-slot:footer>
        <x-ui.button variant="secondary" type="button" x-on:click="hide()">
            {{ $cancelLabel }}
        </x-ui.button>

        <x-ui.button
            :variant="$variant"
            type="button"
            x-on:click="$dispatch('confirmed', { name: '{{ $name }}' }); hide()"
        >
            {{ $confirmLabel }}
        </x-ui.button>
    </x-slot:footer>
</x-ui.modal>
