@extends('layouts.guest')

@section('title', __('ui.auth.page_title'))
@section('description', __('ui.auth.subtitle'))

@section('content')
    <div class="w-full max-w-md">
        <x-ui.card padding="p-6 sm:p-8">
            <div class="flex items-start justify-between gap-3">
                <div class="flex min-w-0 items-center gap-3">
                    <span
                        class="grid size-10 shrink-0 place-items-center rounded-xl bg-primary text-xs font-bold text-primary-foreground"
                        aria-hidden="true"
                    >
                        PD
                    </span>

                    <div class="min-w-0">
                        <p class="truncate text-xs font-semibold text-foreground sm:text-sm">{{ __('ui.app.name') }}</p>
                        <p class="mt-0.5 hidden truncate text-xs text-muted-foreground sm:block">{{ __('ui.auth.brand_subtitle') }}</p>
                    </div>
                </div>

                <x-ui.language-switcher :label="false" />
            </div>

            <h1 class="mt-6 font-display text-2xl font-semibold tracking-tight text-foreground">
                {{ __('ui.auth.title') }}
            </h1>
            <p class="mt-1.5 text-sm text-muted-foreground">{{ __('ui.auth.subtitle') }}</p>

            @if ($errors->has('google'))
                <x-ui.alert variant="danger" class="mt-5">
                    {{ $errors->first('google') }}
                </x-ui.alert>
            @endif

            <form method="POST" action="{{ route('auth.login') }}" class="mt-6 space-y-4">
                @csrf

                <x-forms.input
                    name="email"
                    type="email"
                    :label="__('ui.auth.email')"
                    :placeholder="__('ui.auth.email_placeholder')"
                    :error="$errors->first('email')"
                    autocomplete="username"
                    autofocus
                    required
                />

                <x-forms.input
                    name="password"
                    type="password"
                    :label="__('ui.auth.password')"
                    :placeholder="__('ui.auth.password_placeholder')"
                    :error="$errors->first('password')"
                    autocomplete="current-password"
                    required
                />

                <x-forms.checkbox name="remember" value="1" :label="__('ui.auth.remember')" />

                <x-ui.button type="submit" size="lg" full>
                    {{ __('ui.auth.submit') }}
                </x-ui.button>
            </form>

            <x-ui.divider :label="__('ui.auth.or')" class="my-6" />

            <x-ui.button :href="route('auth.google')" variant="outline" size="lg" full>
                <svg class="size-5" viewBox="0 0 24 24" aria-hidden="true">
                    <path fill="#4285F4" d="M23.52 12.27c0-.85-.08-1.67-.22-2.45H12v4.64h6.46a5.52 5.52 0 0 1-2.4 3.62v3h3.88c2.27-2.09 3.58-5.17 3.58-8.81Z" />
                    <path fill="#34A853" d="M12 24c3.24 0 5.96-1.08 7.94-2.92l-3.88-3c-1.08.72-2.45 1.15-4.06 1.15-3.12 0-5.77-2.11-6.71-4.95H1.28v3.09A12 12 0 0 0 12 24Z" />
                    <path fill="#FBBC05" d="M5.29 14.28a7.2 7.2 0 0 1 0-4.56V6.63H1.28a12 12 0 0 0 0 10.74l4.01-3.09Z" />
                    <path fill="#EA4335" d="M12 4.77c1.76 0 3.34.61 4.58 1.79l3.44-3.44A11.96 11.96 0 0 0 12 0 12 12 0 0 0 1.28 6.63l4.01 3.09C6.23 6.88 8.88 4.77 12 4.77Z" />
                </svg>
                {{ __('ui.auth.google') }}
            </x-ui.button>

            <p class="mt-6 text-center text-xs text-muted-foreground">{{ __('ui.auth.secure_note') }}</p>
        </x-ui.card>
    </div>
@endsection
