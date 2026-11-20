@extends('layouts.app')

@section('title', __('ui.dashboard.title'))

@section('content')
    <x-ui.breadcrumb :items="[['label' => __('ui.dashboard.title')]]" />

    @include('dashboard.'.$role, [
        'stats' => $stats,
        'surats' => $surats,
        'pengaduans' => $pengaduans,
    ])
@endsection
