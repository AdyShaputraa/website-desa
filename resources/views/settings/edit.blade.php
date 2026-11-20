@extends('layouts.app')

@section('title', __('ui.settings.title'))
@section('description', __('ui.settings.description'))

@section('content')
    <x-ui.breadcrumb :items="[
        ['label' => __('ui.dashboard.title'), 'url' => route('dashboard')],
        ['label' => __('ui.settings.title')],
    ]" />

    @if (session('status'))
        <x-ui.alert variant="success" class="mt-6">
            {{ session('status') }}
        </x-ui.alert>
    @endif

    <div class="mt-6 grid gap-6 xl:grid-cols-3">
        <x-ui.card class="xl:col-span-2">
            <x-slot:header>
                <h2 class="font-display text-base font-semibold tracking-tight text-foreground">
                    {{ __('ui.settings.account_info') }}
                </h2>
                <p class="mt-0.5 text-sm text-muted-foreground">{{ __('ui.settings.account_info_desc') }}</p>
            </x-slot:header>

            <form id="settings-form" method="POST" action="{{ route('settings.update') }}" class="grid gap-5 sm:grid-cols-2">
                @csrf
                @method('patch')

                <x-forms.input
                    name="name"
                    :label="__('ui.settings.name')"
                    :value="$user->name"
                    :error="$errors->first('name')"
                    required
                />

                <x-forms.input
                    name="email"
                    type="email"
                    :label="__('ui.settings.email')"
                    :value="$user->email"
                    :error="$errors->first('email')"
                    required
                />

                <div class="sm:col-span-2">
                    <p class="text-sm font-medium text-foreground">{{ __('ui.settings.role') }}</p>

                    <div class="mt-2 flex flex-wrap gap-2">
                        @forelse ($user->getRoleNames() as $role)
                            <x-ui.badge variant="primary">{{ ucfirst($role) }}</x-ui.badge>
                        @empty
                            <span class="text-sm text-muted-foreground">&mdash;</span>
                        @endforelse
                    </div>
                </div>
            </form>

            <x-slot:footer>
                <div class="flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">
                    <x-ui.button :href="route('dashboard')" variant="secondary">
                        {{ __('ui.common.cancel') }}
                    </x-ui.button>

                    <x-ui.button type="submit" form="settings-form">
                        {{ __('ui.settings.save') }}
                    </x-ui.button>
                </div>
            </x-slot:footer>
        </x-ui.card>

        <div class="space-y-6">
            <x-ui.card>
                <h2 class="font-display text-base font-semibold tracking-tight text-foreground">
                    {{ __('ui.settings.preferences') }}
                </h2>
                <p class="mt-0.5 text-sm text-muted-foreground">{{ __('ui.settings.preferences_desc') }}</p>

                <div class="mt-5 space-y-5">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-muted-foreground">
                            {{ __('ui.nav.language') }}
                        </p>
                        <div class="mt-2">
                            <x-ui.language-switcher />
                        </div>
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-muted-foreground">
                            {{ __('ui.nav.theme') }}
                        </p>
                        <div class="mt-2">
                            <x-ui.theme-toggle />
                        </div>
                    </div>
                </div>
            </x-ui.card>

            <x-ui.card>
                <h2 class="font-display text-base font-semibold tracking-tight text-foreground">
                    {{ __('ui.account.change_password') }}
                </h2>
                <p class="mt-0.5 text-sm text-muted-foreground">{{ __('ui.password.description') }}</p>

                <x-ui.button :href="route('password.edit')" variant="outline" size="sm" class="mt-4">
                    <x-heroicon-o-key class="size-4" />
                    {{ __('ui.account.change_password') }}
                </x-ui.button>
            </x-ui.card>
        </div>
    </div>
@endsection
