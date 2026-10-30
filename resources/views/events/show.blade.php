@extends('layouts.app')

@section('title', $event->title . ' - ' . config('puskesmas.name'))
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($event->description), 150))

@php
    $image = $event->featured_image ? \Illuminate\Support\Facades\Storage::url($event->featured_image) : null;
@endphp

@if ($image)
    @section('og_image', $image)
@endif

@push('structured_data')
    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'Event',
            'name' => $event->title,
            'startDate' => $event->event_date?->toDateString(),
            'location' => ['@type' => 'Place', 'name' => $event->location ?: config('puskesmas.name')],
            'description' => strip_tags($event->description),
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>
@endpush

@section('content')
    <x-page-header :title="$event->title" :breadcrumbs="['Agenda' => route('events.index'), \Illuminate\Support\Str::limit($event->title, 40) => null]" />

    <article class="mx-auto max-w-3xl px-4 py-12 sm:px-6 lg:px-8">
        <dl class="grid gap-4 rounded-2xl border border-slate-200 bg-white p-6 sm:grid-cols-3">
            <div>
                <dt class="text-xs font-semibold uppercase tracking-wider text-slate-500">Tanggal</dt>
                <dd class="mt-1 text-sm font-semibold text-slate-900">{{ $event->event_date?->translatedFormat('d F Y') }}</dd>
            </div>
            <div>
                <dt class="text-xs font-semibold uppercase tracking-wider text-slate-500">Waktu</dt>
                <dd class="mt-1 text-sm font-semibold text-slate-900">
                    @if ($event->start_time)
                        {{ \Illuminate\Support\Str::of($event->start_time)->substr(0, 5) }}{{ $event->end_time ? ' - ' . \Illuminate\Support\Str::of($event->end_time)->substr(0, 5) : '' }} WIB
                    @else
                        -
                    @endif
                </dd>
            </div>
            <div>
                <dt class="text-xs font-semibold uppercase tracking-wider text-slate-500">Lokasi</dt>
                <dd class="mt-1 text-sm font-semibold text-slate-900">{{ $event->location ?: '-' }}</dd>
            </div>
        </dl>

        @if ($image)
            <img src="{{ $image }}" alt="{{ $event->title }}" class="mt-6 w-full rounded-2xl border border-slate-200 object-cover">
        @endif

        <div class="prose prose-slate mt-8 max-w-none">
            {!! $event->description !!}
        </div>
    </article>

    @if ($related->isNotEmpty())
        <section class="bg-white py-14">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <h2 class="text-xl font-bold text-slate-900">Agenda Lainnya</h2>
                <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($related as $item)
                        <x-event-card :event="$item" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection