@php
    $activeValue = old('is_active', $user?->is_active ?? true);
    $isActive = in_array((string) $activeValue, ['1', 'true', 'on'], true);
@endphp

<x-forms.input
    name="name"
    :label="__('ui.users.name')"
    :value="$user?->name"
    :error="$errors->first('name')"
    required
/>

<x-forms.input
    name="email"
    type="email"
    :label="__('ui.users.email')"
    :value="$user?->email"
    :error="$errors->first('email')"
    required
/>

<x-forms.input
    name="nik"
    :label="__('ui.users.nik')"
    :value="$user?->nik"
    :error="$errors->first('nik')"
    hint="16 digit."
/>

<x-forms.input
    name="phone"
    :label="__('ui.users.phone')"
    :value="$user?->phone"
    :error="$errors->first('phone')"
/>

<div class="grid gap-5 sm:col-span-2 sm:grid-cols-2">
    <x-forms.input
        name="password"
        type="password"
        :label="__('ui.users.password')"
        :error="$errors->first('password')"
        :hint="$user ? __('ui.users.password_optional') : __('ui.users.password_hint')"
        autocomplete="new-password"
        :required="$user === null"
    />

    <x-forms.input
        name="password_confirmation"
        type="password"
        :label="__('ui.users.password_confirm')"
        autocomplete="new-password"
        :required="$user === null"
    />
</div>

<fieldset class="sm:col-span-2">
    <legend class="text-sm font-medium text-foreground">{{ __('ui.users.roles') }}</legend>
    <p class="mt-0.5 text-xs text-muted-foreground">{{ __('ui.users.roles_hint') }}</p>

    <div class="mt-3 flex flex-wrap gap-x-5 gap-y-3">
        @foreach ($roles as $role)
            <x-forms.checkbox
                :id="'role-'.$role"
                name="roles[]"
                :value="$role"
                :label="__('ui.users.role_options.'.$role)"
                :checked="in_array($role, old('roles', $user?->roles->pluck('name')->all() ?? ['warga']), true)"
            />
        @endforeach
    </div>

    @error('roles')
        <x-forms.error>{{ $message }}</x-forms.error>
    @enderror
</fieldset>

<div class="sm:col-span-2">
    <input type="hidden" name="is_active" value="0" />

    <x-forms.switch
        name="is_active"
        value="1"
        :label="__('ui.users.is_active')"
        :checked="$isActive"
    />

    <p class="mt-1.5 text-xs text-muted-foreground">{{ __('ui.users.is_active_hint') }}</p>

    @error('is_active')
        <x-forms.error>{{ $message }}</x-forms.error>
    @enderror

    @if ($user?->google_id)
        <p class="mt-3 text-xs text-muted-foreground">
            {{ __('ui.users.google') }}: {{ $user->email }}
        </p>
    @endif
</div>
