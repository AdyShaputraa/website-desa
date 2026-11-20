@extends('layouts.app')

@section('title', __('ui.users.edit'))

@section('content')
    <x-ui.breadcrumb :items="[
        ['label' => __('ui.dashboard.title'), 'url' => route('dashboard')],
        ['label' => __('ui.users.title'), 'url' => route('users.index')],
        ['label' => __('ui.users.edit')],
    ]" />

    @if ($errors->any())
        <x-ui.alert variant="danger" class="mt-6">{{ $errors->first() }}</x-ui.alert>
    @endif

    <x-ui.card class="mt-6">
        <x-slot:header>
            <div class="flex flex-wrap items-center justify-between gap-2">
                <h1 class="font-display text-lg font-semibold tracking-tight text-foreground">{{ __('ui.users.edit') }}</h1>
                <p class="text-sm text-muted-foreground">{{ $user->email }}</p>
            </div>
        </x-slot:header>

        <form id="users-form" method="POST" action="{{ route('users.update', $user) }}" class="grid gap-5 sm:grid-cols-2">
            @csrf
            @method('put')

            @include('users.partials.form', ['user' => $user])
        </form>

        <x-slot:footer>
            <div class="flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">
                <x-ui.button :href="route('users.index')" variant="secondary">
                    {{ __('ui.common.cancel') }}
                </x-ui.button>

                <x-ui.button type="submit" form="users-form">
                    {{ __('ui.users.update') }}
                </x-ui.button>
            </div>
        </x-slot:footer>
    </x-ui.card>
@endsection
