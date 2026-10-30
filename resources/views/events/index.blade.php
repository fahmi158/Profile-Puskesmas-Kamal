@extends('layouts.app')

@section('title', 'Agenda Kegiatan - ' . config('puskesmas.name'))
@section('meta_description', 'Jadwal dan agenda kegiatan ' . config('puskesmas.name'))

@section('content')
    <x-page-header title="Agenda Kegiatan" subtitle="Informasi jadwal kegiatan pelayanan dan promosi kesehatan."
        :breadcrumbs="['Agenda' => null]" />

    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Kegiatan Mendatang</h2>
            @if ($upcoming->isNotEmpty())
                <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($upcoming as $event)
                        <x-event-card :event="$event" />
                    @endforeach
                </div>
            @else
                <div class="mt-6">
                    <x-empty-state icon="calendar-days">Belum ada agenda.</x-empty-state>
                </div>
            @endif
        </div>

        @if ($past->isNotEmpty())
            <div class="mt-14">
                <h2 class="text-xl font-bold text-slate-900">Kegiatan Sebelumnya</h2>
                <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($past as $event)
                        <x-event-card :event="$event" />
                    @endforeach
                </div>
                <div class="mt-8">
                    {{ $past->links() }}
                </div>
            </div>
        @endif
    </div>
@endsection