@extends('layouts.app')

@section('title', 'Jadwal Pelayanan - ' . config('puskesmas.name'))
@section('meta_description', 'Jadwal pelayanan ' . config('puskesmas.name'))

@php
    $dayLabels = [
        'monday' => 'Senin', 'tuesday' => 'Selasa', 'wednesday' => 'Rabu',
        'thursday' => 'Kamis', 'friday' => 'Jumat', 'saturday' => 'Sabtu', 'sunday' => 'Minggu',
    ];
@endphp

@section('content')
    <x-page-header title="Jadwal Pelayanan" subtitle="Informasi jadwal pelayanan berdasarkan hari dan layanan."
        :breadcrumbs="['Jadwal' => null]" />

    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <form method="GET" action="{{ route('schedules.index') }}" class="mb-8 flex flex-wrap items-end gap-4 rounded-2xl border border-slate-200 bg-white p-5">
            <div>
                <label for="hari" class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Hari</label>
                <select id="hari" name="hari" class="mt-1 rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-brand-500 focus:outline-none">
                    <option value="">Semua Hari</option>
                    @foreach ($dayLabels as $value => $label)
                        <option value="{{ $value }}" @selected(request('hari') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="layanan" class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Layanan</label>
                <select id="layanan" name="layanan" class="mt-1 rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-brand-500 focus:outline-none">
                    <option value="">Semua Layanan</option>
                    @foreach ($services as $service)
                        <option value="{{ $service->id }}" @selected((string) request('layanan') === (string) $service->id)>{{ $service->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="rounded-lg bg-brand-700 px-5 py-2 text-sm font-semibold text-white transition hover:bg-brand-800">Filter</button>
            @if (request()->hasAny(['hari', 'layanan']))
                <a href="{{ route('schedules.index') }}" class="text-sm font-medium text-slate-500 transition hover:text-brand-700">Reset</a>
            @endif
        </form>

        @if ($schedules->isNotEmpty())
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50">
                        <tr>
                            <th scope="col" class="px-5 py-3 text-left font-semibold text-slate-600">Layanan</th>
                            <th scope="col" class="px-5 py-3 text-left font-semibold text-slate-600">Hari</th>
                            <th scope="col" class="px-5 py-3 text-left font-semibold text-slate-600">Jam</th>
                            <th scope="col" class="px-5 py-3 text-left font-semibold text-slate-600">Lokasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($schedules as $schedule)
                            <tr class="hover:bg-slate-50">
                                <td class="px-5 py-3 font-medium text-slate-800">{{ $schedule->service?->name ?? $schedule->service_name ?? '-' }}</td>
                                <td class="px-5 py-3 text-slate-600">{{ $dayLabels[$schedule->day] ?? $schedule->day }}</td>
                                <td class="px-5 py-3 text-slate-600">
                                    {{ \Illuminate\Support\Str::of($schedule->start_time)->substr(0, 5) }} - {{ \Illuminate\Support\Str::of($schedule->end_time)->substr(0, 5) }}
                                </td>
                                <td class="px-5 py-3 text-slate-600">{{ $schedule->location ?: '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <x-empty-state icon="calendar-days">Belum ada jadwal.</x-empty-state>
        @endif
    </div>
@endsection