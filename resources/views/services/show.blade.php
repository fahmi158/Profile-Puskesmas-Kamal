@extends('layouts.app')

@section('title', $service->name . ' - ' . config('puskesmas.name'))
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($service->description), 150))

@section('content')
    <x-page-header :title="$service->name" :breadcrumbs="['Layanan' => route('services.index'), \Illuminate\Support\Str::limit($service->name, 40) => null]" />

    <div class="mx-auto grid max-w-7xl gap-10 px-4 py-12 sm:px-6 lg:grid-cols-3 lg:px-8">
        <div class="lg:col-span-2">
            <div class="prose prose-slate max-w-none">
                {!! $service->description !!}
            </div>

            @if ($service->requirements)
                <div class="mt-8 rounded-2xl border border-slate-200 bg-white p-6">
                    <h2 class="text-base font-semibold text-slate-900">Persyaratan</h2>
                    <div class="prose prose-sm mt-3 max-w-none text-slate-600">{!! $service->requirements !!}</div>
                </div>
            @endif
        </div>

        <aside class="space-y-4">
            <div class="rounded-2xl border border-slate-200 bg-white p-6">
                <h2 class="text-sm font-semibold uppercase tracking-wider text-slate-500">Jadwal</h2>
                <p class="mt-2 text-sm font-semibold text-slate-900">{{ $service->schedule ?: 'Informasi jadwal belum tersedia.' }}</p>

                @if ($schedules->isNotEmpty())
                    <ul class="mt-4 space-y-2 text-sm text-slate-600">
                        @foreach ($schedules as $schedule)
                            <li class="flex items-center justify-between border-b border-slate-100 pb-2 last:border-0">
                                <span class="capitalize">{{ $schedule->day }}</span>
                                <span>{{ \Illuminate\Support\Str::of($schedule->start_time)->substr(0, 5) }} - {{ \Illuminate\Support\Str::of($schedule->end_time)->substr(0, 5) }}</span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            @if ($service->location)
                <div class="rounded-2xl border border-slate-200 bg-white p-6">
                    <h2 class="text-sm font-semibold uppercase tracking-wider text-slate-500">Lokasi</h2>
                    <p class="mt-2 text-sm font-semibold text-slate-900">{{ $service->location }}</p>
                </div>
            @endif

            <div class="rounded-2xl border border-brand-200 bg-brand-50 p-6">
                <h2 class="text-sm font-semibold text-brand-800">Butuh bantuan?</h2>
                <p class="mt-2 text-sm text-slate-600">Hubungi kami untuk informasi lebih lanjut.</p>
                <a href="{{ route('contact.index') }}" class="mt-4 inline-flex items-center gap-1.5 rounded-full bg-brand-700 px-4 py-2 text-xs font-semibold text-white transition hover:bg-brand-800">
                    Hubungi Kami
                    <x-heroicon-m-arrow-right class="h-4 w-4" />
                </a>
            </div>
        </aside>
    </div>
@endsection