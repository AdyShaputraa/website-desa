@props(['for' => null, 'required' => false])

<label @if ($for) for="{{ $for }}" @endif {{ $attributes->merge(['class' => 'block text-sm font-medium text-foreground']) }}>
    {{ $slot }}@if ($required)<span class="ml-0.5 text-danger" aria-hidden="true">*</span>@endif
</label>
