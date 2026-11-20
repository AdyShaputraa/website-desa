@extends('layouts.app')

@section('title', __('ui.password.title'))
@section('description', __('ui.password.description'))

@section('content')
    <x-ui.breadcrumb :items="[
        ['label' => __('ui.dashboard.title'), 'url' => route('dashboard')],
        ['label' => __('ui.password.title')],
    ]" />

    @if (session('status'))
        <x-ui.alert variant="success" class="mt-6">
            {{ session('status') }}
        </x-ui.alert>
    @endif

    @if (auth()->user()?->google_id)
        <x-ui.alert variant="info" class="mt-6">
            {{ __('ui.password.google_hint') }}
        </x-ui.alert>
    @endif

    <x-ui.card class="mt-6 max-w-xl">
        <form id="password-form" method="POST" action="{{ route('password.update') }}" class="space-y-5">
            @csrf
            @method('put')

            <x-forms.input
                name="current_password"
                type="password"
                :label="__('ui.password.current')"
                :error="$errors->first('current_password')"
                autocomplete="current-password"
                required
            />

            <x-forms.input
                name="password"
                type="password"
                :label="__('ui.password.new')"
                :error="$errors->first('password')"
                :hint="__('ui.password.min_hint')"
                autocomplete="new-password"
                required
            />

            <x-forms.input
                name="password_confirmation"
                type="password"
                :label="__('ui.password.confirm')"
                autocomplete="new-password"
                required
            />
        </form>

        <x-slot:footer>
            <div class="flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">
                <x-ui.button :href="route('settings.edit')" variant="secondary">
                    {{ __('ui.common.cancel') }}
                </x-ui.button>

                <x-ui.button type="submit" form="password-form">
                    <x-heroicon-o-check class="size-4" />
                    {{ __('ui.password.save') }}
                </x-ui.button>
            </div>
        </x-slot:footer>
    </x-ui.card>
@endsection
