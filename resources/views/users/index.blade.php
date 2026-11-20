@extends('layouts.app')

@section('title', __('ui.users.title'))

@section('content')
    <div
        x-data="{
            detail: {},
            deleteTarget: { id: '', name: '' },
            restoreTarget: { id: '', name: '' },
            forceTarget: { id: '', name: '' },
            selected: [],
        }"
    >
        <x-ui.breadcrumb :items="[
            ['label' => __('ui.dashboard.title'), 'url' => route('dashboard')],
            ['label' => __('ui.users.title')],
        ]" />

        @if (session('status'))
            <x-ui.alert variant="success" class="mt-6">{{ session('status') }}</x-ui.alert>
        @endif

        @if (session('warning'))
            <x-ui.alert variant="warning" class="mt-6">{{ session('warning') }}</x-ui.alert>
        @endif

        @if ($errors->any())
            <x-ui.alert variant="danger" class="mt-6">{{ $errors->first() }}</x-ui.alert>
        @endif

        <x-ui.card class="mt-6" padding="p-0 sm:p-0">
            <x-slot:header>
                <div class="flex flex-wrap items-start justify-between gap-3">
                    <div>
                        <h1 class="font-display text-lg font-semibold tracking-tight text-foreground">
                            {{ __('ui.users.title') }}
                        </h1>
                        <p class="mt-0.5 text-sm text-muted-foreground">
                            {{ __('ui.users.count', ['count' => $users->total()]) }}
                        </p>
                    </div>

                    <div class="flex flex-wrap items-center gap-2">
                        <x-ui.button :href="route('users.export', request()->query())" variant="outline" size="sm">
                            <x-heroicon-o-arrow-down-tray class="size-4" />
                            {{ __('ui.users.export') }}
                        </x-ui.button>

                        <x-ui.button :href="route('users.create')" size="sm">
                            <x-heroicon-o-plus class="size-4" />
                            {{ __('ui.users.add') }}
                        </x-ui.button>
                    </div>
                </div>
            </x-slot:header>

            <div class="space-y-4 p-5">
                <form method="GET" action="{{ route('users.index') }}" class="flex flex-col gap-2 xl:flex-row xl:items-end">
                    <div class="min-w-0 flex-1">
                        <x-forms.input
                            name="q"
                            :value="$filters['search']"
                            :placeholder="__('ui.users.search')"
                            icon="heroicon-o-magnifying-glass"
                            aria-label="{{ __('ui.users.search') }}"
                        />
                    </div>

                    <div class="w-full sm:w-44">
                        <x-forms.select
                            name="role"
                            :options="collect($roles)->mapWithKeys(fn ($role) => [$role => __('ui.users.role_options.'.$role)])->all()"
                            :selected="$filters['role']"
                            :placeholder="__('ui.users.all_roles')"
                            aria-label="{{ __('ui.users.role') }}"
                        />
                    </div>

                    <div class="w-full sm:w-44">
                        <x-forms.select
                            name="status"
                            :options="[
                                'active' => __('ui.users.active'),
                                'inactive' => __('ui.users.inactive'),
                                'trashed' => __('ui.users.trashed'),
                                'all' => __('ui.users.all'),
                            ]"
                            :selected="$filters['status']"
                            aria-label="{{ __('ui.users.status') }}"
                        />
                    </div>

                    <div class="w-full sm:w-32">
                        <x-forms.select
                            name="per_page"
                            :options="['10' => '10', '25' => '25', '50' => '50']"
                            :selected="(string) $filters['perPage']"
                            aria-label="{{ __('ui.users.per_page') }}"
                        />
                    </div>

                    <div class="flex items-center gap-2">
                        <x-ui.button type="submit" variant="secondary" size="md">
                            {{ __('ui.users.apply') }}
                        </x-ui.button>

                        <x-ui.button :href="route('users.index')" variant="ghost" size="md">
                            {{ __('ui.users.reset') }}
                        </x-ui.button>
                    </div>
                </form>

                <form id="bulk-form" method="POST" action="{{ route('users.bulk') }}" class="hidden">
                    @csrf
                    @method('patch')
                </form>

                <div class="flex flex-wrap items-center gap-2 rounded-xl border border-card-border bg-surface-muted/50 p-3">
                    <p class="text-sm text-muted-foreground">
                        <span class="font-semibold text-foreground" x-text="selected.length">0</span>
                        {{ __('ui.users.selected') }}
                    </p>

                    <select
                        form="bulk-form"
                        name="action"
                        aria-label="{{ __('ui.users.bulk_action') }}"
                        class="h-9 rounded-lg border border-input-border bg-input px-3 text-sm text-foreground"
                    >
                        <option value="activate">{{ __('ui.users.bulk_activate') }}</option>
                        <option value="deactivate">{{ __('ui.users.bulk_deactivate') }}</option>
                        <option value="delete">{{ __('ui.users.bulk_delete') }}</option>
                    </select>

                    <x-ui.button
                        type="submit"
                        form="bulk-form"
                        variant="secondary"
                        size="sm"
                        x-bind:disabled="selected.length === 0"
                    >
                        {{ __('ui.users.bulk_apply') }}
                    </x-ui.button>
                </div>

                @if ($users->isEmpty())
                    <x-ui.empty-state :title="__('ui.users.empty')" :description="__('ui.users.empty_desc')" />
                @else
                    <x-ui.table
                        :caption="__('ui.users.title')"
                        :headers="[
                            __('ui.users.select'),
                            __('ui.users.name'),
                            __('ui.users.roles'),
                            __('ui.users.status'),
                            __('ui.users.joined'),
                            __('ui.users.actions'),
                        ]"
                    >
                        @foreach ($users as $user)
                            @php
                                $initials = collect(explode(' ', $user->name))
                                    ->filter()
                                    ->take(2)
                                    ->map(fn ($word) => mb_strtoupper(mb_substr($word, 0, 1)))
                                    ->implode('');

                                $detail = [
                                    'name' => $user->name,
                                    'email' => $user->email,
                                    'initials' => $initials ?: '?',
                                    'avatar' => $user->avatar,
                                    'roles' => $user->roles
                                        ->map(fn ($role) => __('ui.users.role_options.'.$role->name))
                                        ->values()
                                        ->all(),
                                    'nik' => $user->nik ?: '—',
                                    'phone' => $user->phone ?: '—',
                                    'status' => $user->trashed()
                                        ? __('ui.users.trashed')
                                        : ($user->is_active ? __('ui.users.active') : __('ui.users.inactive')),
                                    'google' => filled($user->google_id) ? __('ui.users.yes') : __('ui.users.no'),
                                    'verified' => filled($user->email_verified_at) ? __('ui.users.verified') : __('ui.users.unverified'),
                                    'created' => $user->created_at?->format('d/m/Y H:i') ?? '—',
                                    'updated' => $user->updated_at?->format('d/m/Y H:i') ?? '—',
                                ];
                            @endphp

                            <tr class="transition hover:bg-surface-muted/60">
                                <td class="w-10 px-4 py-3">
                                    <input
                                        type="checkbox"
                                        form="bulk-form"
                                        name="ids[]"
                                        value="{{ $user->id }}"
                                        x-model.number="selected"
                                        class="size-4 rounded border-input-border text-primary accent-primary"
                                        aria-label="{{ $user->name }}"
                                    />
                                </td>

                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        @if ($user->avatar)
                <img
                    src="{{ $user->avatar }}"
                    alt=""
                    class="size-9 rounded-full object-cover"
                    width="36"
                    height="36"
                    loading="lazy"
                    decoding="async"
                    referrerpolicy="no-referrer"
                />
                                        @else
                                            <span class="grid size-9 shrink-0 place-items-center rounded-full bg-primary-soft text-xs font-semibold text-primary-soft-foreground">
                                                {{ $initials ?: '?' }}
                                            </span>
                                        @endif

                                        <div class="min-w-0">
                                            <p class="truncate font-medium text-foreground">{{ $user->name }}</p>
                                            <p class="truncate text-xs text-muted-foreground">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-4 py-3">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach ($user->roles as $role)
                                            <x-ui.badge variant="primary">{{ __('ui.users.role_options.'.$role->name) }}</x-ui.badge>
                                        @endforeach
                                    </div>
                                </td>

                                <td class="whitespace-nowrap px-4 py-3">
                                    @if ($user->trashed())
                                        <x-ui.badge variant="danger" dot>{{ __('ui.users.trashed') }}</x-ui.badge>
                                    @elseif ($user->is_active)
                                        <x-ui.badge variant="success" dot>{{ __('ui.users.active') }}</x-ui.badge>
                                    @else
                                        <x-ui.badge variant="warning" dot>{{ __('ui.users.inactive') }}</x-ui.badge>
                                    @endif
                                </td>

                                <td class="whitespace-nowrap px-4 py-3 text-sm text-muted-foreground">
                                    {{ $user->created_at?->format('d/m/Y') ?? '—' }}
                                </td>

                                <td class="whitespace-nowrap px-4 py-3">
                                    <div class="flex items-center gap-1">
                                        <button
                                            type="button"
                                            data-detail="{{ json_encode($detail) }}"
                                            x-on:click="detail = JSON.parse($el.dataset.detail); $dispatch('open-modal', 'user-detail')"
                                            class="focus-ring inline-flex size-8 items-center justify-center rounded-lg text-muted-foreground transition hover:bg-surface-muted hover:text-foreground"
                                            aria-label="{{ __('ui.users.view') }}"
                                            title="{{ __('ui.users.view') }}"
                                        >
                                            <x-heroicon-o-eye class="size-4" />
                                        </button>

                                        @if ($user->trashed())
                                            <button
                                                type="button"
                                                data-id="{{ $user->id }}"
                                                data-name="{{ $user->name }}"
                                                x-on:click="restoreTarget = { id: $el.dataset.id, name: $el.dataset.name }; $dispatch('open-modal', 'user-restore')"
                                                class="focus-ring inline-flex size-8 items-center justify-center rounded-lg text-muted-foreground transition hover:bg-success-soft hover:text-success-soft-foreground"
                                                aria-label="{{ __('ui.users.restore') }}"
                                                title="{{ __('ui.users.restore') }}"
                                            >
                                                <x-heroicon-o-arrow-uturn-left class="size-4" />
                                            </button>

                                            <button
                                                type="button"
                                                data-id="{{ $user->id }}"
                                                data-name="{{ $user->name }}"
                                                x-on:click="forceTarget = { id: $el.dataset.id, name: $el.dataset.name }; $dispatch('open-modal', 'user-force-delete')"
                                                class="focus-ring inline-flex size-8 items-center justify-center rounded-lg text-danger transition hover:bg-danger-soft"
                                                aria-label="{{ __('ui.users.force_delete') }}"
                                                title="{{ __('ui.users.force_delete') }}"
                                            >
                                                <x-heroicon-o-trash class="size-4" />
                                            </button>
                                        @else
                                            <a
                                                href="{{ route('users.edit', $user) }}"
                                                class="focus-ring inline-flex size-8 items-center justify-center rounded-lg text-muted-foreground transition hover:bg-surface-muted hover:text-foreground"
                                                aria-label="{{ __('ui.users.edit') }}"
                                                title="{{ __('ui.users.edit') }}"
                                            >
                                                <x-heroicon-o-pencil-square class="size-4" />
                                            </a>

                                            @if (! $user->is(auth()->user()))
                                                <button
                                                    type="button"
                                                    data-id="{{ $user->id }}"
                                                    data-name="{{ $user->name }}"
                                                    x-on:click="deleteTarget = { id: $el.dataset.id, name: $el.dataset.name }; $dispatch('open-modal', 'user-delete')"
                                                    class="focus-ring inline-flex size-8 items-center justify-center rounded-lg text-danger transition hover:bg-danger-soft"
                                                    aria-label="{{ __('ui.users.delete') }}"
                                                    title="{{ __('ui.users.delete') }}"
                                                >
                                                    <x-heroicon-o-trash class="size-4" />
                                                </button>
                                            @endif
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </x-ui.table>

                    <div class="mt-4">
                        <x-ui.pagination :paginator="$users" />
                    </div>
                @endif
            </div>
        </x-ui.card>

        <x-ui.card class="mt-6">
            <x-slot:header>
                <h2 class="font-display text-base font-semibold tracking-tight text-foreground">
                    {{ __('ui.users.activity') }}
                </h2>
                <p class="mt-0.5 text-sm text-muted-foreground">{{ __('ui.users.activity_desc') }}</p>
            </x-slot:header>

            @if ($activities->isEmpty())
                <p class="text-sm text-muted-foreground">{{ __('ui.users.activity_empty') }}</p>
            @else
                <ul class="divide-y divide-border">
                    @foreach ($activities as $activity)
                        @php
                            $label = __('ui.users.activity_'.$activity->description);

                            if (str_starts_with($label, 'ui.users.activity_')) {
                                $label = $activity->description;
                            }
                        @endphp

                        <li class="flex items-start justify-between gap-3 py-3 first:pt-0 last:pb-0">
                            <p class="text-sm text-muted-foreground">
                                <span class="font-medium text-foreground">{{ $activity->causer?->name ?? __('ui.users.system') }}</span>
                                {{ $label }}
                                @if ($activity->subject)
                                    <span class="font-medium text-foreground">{{ $activity->subject->name }}</span>
                                @endif
                            </p>

                            <time class="shrink-0 text-xs text-muted-foreground">
                                {{ $activity->created_at?->diffForHumans() }}
                            </time>
                        </li>
                    @endforeach
                </ul>
            @endif
        </x-ui.card>

        <x-ui.modal name="user-detail" :title="__('ui.users.detail')" maxWidth="max-w-lg">
            <div class="space-y-5">
                <div class="flex items-center gap-3">
                    <template x-if="detail.avatar">
                        <img :src="detail.avatar" alt="" class="size-12 rounded-full object-cover" referrerpolicy="no-referrer" />
                    </template>
                    <span x-show="! detail.avatar" x-cloak class="grid size-12 shrink-0 place-items-center rounded-full bg-primary-soft text-sm font-semibold text-primary-soft-foreground" x-text="detail.initials"></span>

                    <div class="min-w-0">
                        <p class="truncate font-semibold text-foreground" x-text="detail.name"></p>
                        <p class="truncate text-sm text-muted-foreground" x-text="detail.email"></p>
                    </div>
                </div>

                <div class="flex flex-wrap gap-1">
                    <template x-for="role in detail.roles" :key="role">
                        <x-ui.badge variant="primary"><span x-text="role"></span></x-ui.badge>
                    </template>
                </div>

                <dl class="grid grid-cols-1 gap-3 text-sm sm:grid-cols-2">
                    <div>
                        <dt class="text-muted-foreground">{{ __('ui.users.nik') }}</dt>
                        <dd class="font-medium text-foreground" x-text="detail.nik"></dd>
                    </div>
                    <div>
                        <dt class="text-muted-foreground">{{ __('ui.users.phone') }}</dt>
                        <dd class="font-medium text-foreground" x-text="detail.phone"></dd>
                    </div>
                    <div>
                        <dt class="text-muted-foreground">{{ __('ui.users.status') }}</dt>
                        <dd class="font-medium text-foreground" x-text="detail.status"></dd>
                    </div>
                    <div>
                        <dt class="text-muted-foreground">{{ __('ui.users.google') }}</dt>
                        <dd class="font-medium text-foreground" x-text="detail.google"></dd>
                    </div>
                    <div>
                        <dt class="text-muted-foreground">{{ __('ui.users.verification') }}</dt>
                        <dd class="font-medium text-foreground" x-text="detail.verified"></dd>
                    </div>
                    <div>
                        <dt class="text-muted-foreground">{{ __('ui.users.joined') }}</dt>
                        <dd class="font-medium text-foreground" x-text="detail.created"></dd>
                    </div>
                    <div>
                        <dt class="text-muted-foreground">{{ __('ui.users.updated_at') }}</dt>
                        <dd class="font-medium text-foreground" x-text="detail.updated"></dd>
                    </div>
                </dl>
            </div>
        </x-ui.modal>

        <x-ui.modal name="user-delete" :title="__('ui.users.delete_title')" :description="__('ui.users.delete_desc')" maxWidth="max-w-md">
            <p class="text-sm text-muted-foreground">
                {{ __('ui.users.delete_confirm_named') }}
                <span class="font-semibold text-foreground" x-text="deleteTarget.name"></span>
            </p>

            <x-slot:footer>
                <x-ui.button variant="secondary" type="button" x-on:click="hide()">{{ __('ui.common.cancel') }}</x-ui.button>

                <form method="POST" :action="`{{ url('users') }}/${deleteTarget.id}`">
                    @csrf
                    @method('delete')
                    <x-ui.button type="submit" variant="danger">{{ __('ui.users.delete') }}</x-ui.button>
                </form>
            </x-slot:footer>
        </x-ui.modal>

        <x-ui.modal name="user-restore" :title="__('ui.users.restore_title')" :description="__('ui.users.restore_desc')" maxWidth="max-w-md">
            <p class="text-sm text-muted-foreground">
                {{ __('ui.users.restore_confirm_named') }}
                <span class="font-semibold text-foreground" x-text="restoreTarget.name"></span>
            </p>

            <x-slot:footer>
                <x-ui.button variant="secondary" type="button" x-on:click="hide()">{{ __('ui.common.cancel') }}</x-ui.button>

                <form method="POST" :action="`{{ url('users') }}/${restoreTarget.id}/restore`">
                    @csrf
                    <x-ui.button type="submit">{{ __('ui.users.restore') }}</x-ui.button>
                </form>
            </x-slot:footer>
        </x-ui.modal>

        <x-ui.modal name="user-force-delete" :title="__('ui.users.force_delete_title')" :description="__('ui.users.force_delete_desc')" maxWidth="max-w-md">
            <p class="text-sm text-muted-foreground">
                {{ __('ui.users.force_delete_confirm_named') }}
                <span class="font-semibold text-foreground" x-text="forceTarget.name"></span>
            </p>

            <x-slot:footer>
                <x-ui.button variant="secondary" type="button" x-on:click="hide()">{{ __('ui.common.cancel') }}</x-ui.button>

                <form method="POST" :action="`{{ url('users') }}/${forceTarget.id}/force`">
                    @csrf
                    @method('delete')
                    <x-ui.button type="submit" variant="danger">{{ __('ui.users.force_delete') }}</x-ui.button>
                </form>
            </x-slot:footer>
        </x-ui.modal>
    </div>
@endsection
