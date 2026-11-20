@extends('layouts.app')

@section('title', __('ui.dashboard.title'))
@section('description', __('ui.dashboard.subtitle'))

@section('content')
    <x-ui.breadcrumb :items="[['label' => __('ui.dashboard.title')]]" />

    <div class="mt-4">
        <x-ui.page-header
            :eyebrow="__('ui.dashboard.eyebrow')"
            :title="__('ui.dashboard.welcome', ['name' => auth()->user()->name])"
            :description="__('ui.dashboard.subtitle')"
        />
    </div>

    @include('dashboard.'.$role, [
        'stats' => $stats,
        'surats' => $surats,
        'pengaduans' => $pengaduans,
    ])
@endsection
