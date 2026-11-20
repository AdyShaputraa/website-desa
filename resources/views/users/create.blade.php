@extends('layouts.app')

@section('title', __('ui.users.add'))

@section('content')
    <x-ui.breadcrumb :items="[
        ['label' => __('ui.dashboard.title'), 'url' => route('dashboard')],
        ['label' => __('ui.users.title'), 'url' => route('users.index')],
        ['label' => __('ui.users.add')],
    ]" />

    @if ($errors->any())
        <x-ui.alert variant="danger" class="mt-6">{{ $errors->first() }}</x-ui.alert>
    @endif

    <x-ui.card class="mt-6">
        <x-slot:header>
            <h1 class="font-display text-lg font-semibold tracking-tight text-foreground">{{ __('ui.users.add') }}</h1>
        </x-slot:header>

        <form id="users-form" method="POST" action="{{ route('users.store') }}" class="grid gap-5 sm:grid-cols-2">
            @csrf

            @include('users.partials.form', ['user' => null])
        </form>

        <x-slot:footer>
            <div class="flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">
                <x-ui.button :href="route('users.index')" variant="secondary">
                    {{ __('ui.common.cancel') }}
                </x-ui.button>

                <x-ui.button type="submit" form="users-form">
                    {{ __('ui.users.save') }}
                </x-ui.button>
            </div>
        </x-slot:footer>
    </x-ui.card>
@endsection
