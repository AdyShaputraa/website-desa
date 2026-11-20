@props(['align' => 'right', 'width' => 'w-56'])

@php
    $alignment = $align === 'left' ? 'left-0' : 'right-0';
@endphp

<div
    x-data="dropdown"
    @click.outside="close()"
    @keydown.escape="close()"
    class="relative inline-flex"
>
    <div class="inline-flex" @click="toggle()">
        {{ $trigger }}
    </div>

    <div
        x-show="open"
        x-cloak
        x-transition
        class="absolute {{ $alignment }} z-40 mt-2 {{ $width }} overflow-hidden rounded-xl border border-card-border bg-card p-1 shadow-lg"
        role="menu"
    >
        {{ $slot }}
    </div>
</div>
