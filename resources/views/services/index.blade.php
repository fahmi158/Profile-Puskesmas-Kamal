@extends('layouts.app')

@section('title', 'Layanan Puskesmas - ' . config('puskesmas.name'))
@section('meta_description', 'Daftar layanan kesehatan yang tersedia di ' . config('puskesmas.name'))

@section('content')
    <x-page-header title="Layanan Puskesmas" subtitle="Berbagai layanan kesehatan untuk masyarakat."
        :breadcrumbs="['Layanan' => null]" />

    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        @if ($services->isNotEmpty())
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($services as $service)
                    <a href="{{ route('services.show', $service->slug) }}" class="block">
                        <x-service-card :service="$service" />
                    </a>
                @endforeach
            </div>
        @else
            <x-empty-state icon="heart">Belum ada layanan yang tersedia.</x-empty-state>
        @endif
    </div>
@endsection