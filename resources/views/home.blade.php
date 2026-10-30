@extends('layouts.app')

@section('title', config('puskesmas.name') . ' - ' . config('puskesmas.tagline'))
@section('meta_description', config('puskesmas.description'))

@section('content')
    {{-- HERO --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-brand-800 via-brand-700 to-ocean-800">
        <div class="absolute inset-0 opacity-20">
            <div class="absolute -left-24 -top-24 h-72 w-72 rounded-full bg-emerald-400 blur-3xl"></div>
            <div class="absolute -bottom-32 right-0 h-80 w-80 rounded-full bg-ocean-400 blur-3xl"></div>
        </div>

        <div class="relative mx-auto grid max-w-7xl gap-10 px-4 py-16 sm:px-6 lg:grid-cols-2 lg:items-center lg:py-24 lg:px-8">
            <div>
                <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-emerald-200 ring-1 ring-white/20">
                    <x-heroicon-o-shield-check class="h-3.5 w-3.5" />
                    Portal Informasi Resmi
                </span>

                <h1 class="mt-5 text-3xl font-bold leading-tight text-white sm:text-4xl lg:text-5xl">
                    Selamat Datang di {{ config('puskesmas.name') }}
                </h1>

                <p class="mt-5 max-w-xl text-sm leading-relaxed text-slate-200 sm:text-base">
                    {{ config('puskesmas.description') }}
                </p>

                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('services.index') }}" class="inline-flex items-center gap-2 rounded-full bg-white px-6 py-3 text-sm font-semibold text-brand-800 shadow-sm transition hover:bg-brand-50">
                        <x-heroicon-o-clipboard-document-list class="h-5 w-5" />
                        Lihat Layanan
                    </a>
                    <a href="{{ route('news.index') }}" class="inline-flex items-center gap-2 rounded-full border border-white/30 bg-white/5 px-6 py-3 text-sm font-semibold text-white transition hover:bg-white/10">
                        <x-heroicon-o-newspaper class="h-5 w-5" />
                        Berita Terbaru
                    </a>
                </div>
            </div>

            <div class="relative hidden lg:block">
                <div class="aspect-[4/3] overflow-hidden rounded-3xl border border-white/20 shadow-2xl">
                    <img src="{{ asset('image/hero_puskemas.jpg') }}" alt="Gedung {{ config('puskesmas.name') }}" class="h-full w-full object-cover">
                </div>
            </div>
        </div>
    </section>

    {{-- INFORMASI PENTING --}}
    @if ($announcements->isNotEmpty())
        <section class="mx-auto -mt-6 max-w-7xl px-4 sm:px-6 lg:px-8" aria-labelledby="pengumuman-heading">
            <div class="rounded-2xl border border-amber-200 bg-amber-50 p-5 shadow-sm sm:p-6">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-start gap-3">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-amber-100 text-amber-700">
                            <x-heroicon-o-megaphone class="h-5 w-5" />
                        </span>
                        <div>
                            <h2 id="pengumuman-heading" class="text-xs font-bold uppercase tracking-wider text-amber-700">Informasi Penting</h2>
                            <p class="mt-1 text-sm font-semibold text-slate-800">{{ $announcements->first()->title }}</p>
                        </div>
                    </div>
                    <a href="#" class="inline-flex shrink-0 items-center gap-1.5 rounded-full bg-amber-600 px-4 py-2 text-xs font-semibold text-white transition hover:bg-amber-700">
                        Lihat Selengkapnya
                        <x-heroicon-m-arrow-right class="h-4 w-4" />
                    </a>
                </div>
            </div>
        </section>
    @endif

    {{-- BERITA TERBARU --}}
    <section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
        <x-section-header eyebrow="Publikasi" title="Berita Terbaru" description="Ikuti perkembangan informasi dan kegiatan terbaru dari Puskesmas Kamal." href="#" />

        @if ($news->isNotEmpty())
            <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($news as $item)
                    <x-news-card :news="$item" />
                @endforeach
            </div>
        @else
            <div class="mt-8">
                <x-empty-state icon="newspaper">Belum ada berita tersedia.</x-empty-state>
            </div>
        @endif
    </section>

    {{-- AGENDA & DOKUMENTASI --}}
    <section class="bg-white py-14">
        <div class="mx-auto grid max-w-7xl gap-12 px-4 sm:px-6 lg:grid-cols-2 lg:px-8">
            <div>
                <x-section-header eyebrow="Jadwal Kegiatan" title="Agenda Kegiatan" href="#" />
                @if ($events->isNotEmpty())
                    <div class="mt-8 space-y-3">
                        @foreach ($events as $event)
                            <x-event-card :event="$event" />
                        @endforeach
                    </div>
                @else
                    <div class="mt-8">
                        <x-empty-state>Belum ada agenda.</x-empty-state>
                    </div>
                @endif
            </div>

            <div>
                <x-section-header eyebrow="Galeri" title="Dokumentasi Kegiatan" href="#" />
                @if ($albums->isNotEmpty())
                    <div class="mt-8 grid gap-4 sm:grid-cols-2">
                        @foreach ($albums->take(4) as $album)
                            <x-album-card :album="$album" />
                        @endforeach
                    </div>
                @else
                    <div class="mt-8">
                        <x-empty-state>Belum ada dokumentasi kegiatan.</x-empty-state>
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- LAYANAN --}}
    <section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
        <x-section-header eyebrow="Pelayanan Kesehatan" title="Layanan Puskesmas" description="Berbagai layanan kesehatan yang tersedia untuk masyarakat." href="#" />

        @if ($services->isNotEmpty())
            <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($services as $service)
                    <x-service-card :service="$service" />
                @endforeach
            </div>
        @else
            <div class="mt-8">
                <x-empty-state>Belum ada layanan yang tersedia.</x-empty-state>
            </div>
        @endif
    </section>

    {{-- KONTAK / MAPS --}}
    <section class="bg-brand-900 py-16 text-white">
        <div class="mx-auto grid max-w-7xl gap-10 px-4 sm:px-6 lg:grid-cols-2 lg:items-center lg:px-8">
            <div>
                <h2 class="text-2xl font-bold sm:text-3xl">Kunjungi {{ config('puskesmas.name') }}</h2>
                <p class="mt-3 text-sm leading-relaxed text-slate-200">{{ config('puskesmas.address') }}</p>

                <dl class="mt-6 space-y-4 text-sm">
                    <div class="flex gap-3">
                        <x-heroicon-o-phone class="h-5 w-5 shrink-0 text-emerald-300" />
                        <div>
                            <dt class="text-slate-300">Telepon</dt>
                            <dd class="font-semibold text-white">{{ config('puskesmas.phone') }}</dd>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <x-heroicon-o-envelope class="h-5 w-5 shrink-0 text-emerald-300" />
                        <div>
                            <dt class="text-slate-300">Email</dt>
                            <dd class="font-semibold text-white">{{ config('puskesmas.email') }}</dd>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <x-heroicon-o-clock class="h-5 w-5 shrink-0 text-emerald-300" />
                        <div>
                            <dt class="text-slate-300">Jam Pelayanan</dt>
                            <dd class="font-semibold text-white">{{ config('puskesmas.operational_hours') }}</dd>
                        </div>
                    </div>
                </dl>
            </div>

            <div class="overflow-hidden rounded-2xl border border-white/15 bg-white/5">
                @if (config('puskesmas.maps_embed'))
                    <iframe src="{{ config('puskesmas.maps_embed') }}" class="h-72 w-full" loading="lazy" title="Lokasi Puskesmas Kamal"></iframe>
                    @if (config('puskesmas.maps_link'))
                        <a href="{{ config('puskesmas.maps_link') }}" target="_blank" rel="noopener noreferrer"
                            class="flex items-center justify-center gap-2 border-t border-white/15 px-4 py-3 text-sm font-semibold text-emerald-300 transition hover:text-white">
                            <x-heroicon-o-map-pin class="h-4 w-4" />
                            Buka di Google Maps
                        </a>
                    @endif
                @else
                    <div class="flex h-72 w-full flex-col items-center justify-center text-center text-slate-300">
                        <x-heroicon-o-map class="h-12 w-12" />
                        <p class="mt-3 text-sm">Peta lokasi dapat dipasang oleh admin.</p>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection