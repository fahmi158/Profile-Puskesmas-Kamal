@extends('layouts.app')

@section('title', ($query ? 'Pencarian: ' . $query : 'Pencarian') . ' - ' . config('puskesmas.name'))
@section('meta_description', 'Hasil pencarian informasi di ' . config('puskesmas.name'))

@section('content')
    <x-page-header title="Pencarian" :breadcrumbs="['Pencarian' => null]" />

    <div class="mx-auto max-w-4xl px-4 py-12 sm:px-6 lg:px-8">
        <form action="{{ route('search') }}" method="GET" role="search" class="flex gap-2">
            <label for="q" class="sr-only">Kata kunci</label>
            <input id="q" name="q" type="search" value="{{ $query }}" placeholder="Cari berita, layanan, dokumen..."
                class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-200">
            <button type="submit" class="inline-flex shrink-0 items-center gap-2 rounded-lg bg-brand-700 px-5 py-3 text-sm font-semibold text-white transition hover:bg-brand-800">
                <x-heroicon-o-magnifying-glass class="h-4 w-4" />
                Cari
            </button>
        </form>

        @if ($query === '')
            <p class="mt-8 text-sm text-slate-500">Masukkan kata kunci untuk mencari informasi.</p>
        @elseif ($results->isEmpty())
            <div class="mt-8">
                <x-empty-state icon="magnifying-glass">Tidak ada hasil untuk &ldquo;{{ $query }}&rdquo;.</x-empty-state>
            </div>
        @else
            <p class="mt-8 text-sm text-slate-500">Menampilkan hasil pencarian untuk <span class="font-semibold text-slate-700">&ldquo;{{ $query }}&rdquo;</span></p>

            <div class="mt-6 space-y-8">
                @foreach ($results as $category => $items)
                    <section>
                        <h2 class="text-sm font-bold uppercase tracking-wider text-brand-700">{{ $category }}</h2>
                        <ul class="mt-3 divide-y divide-slate-100 rounded-2xl border border-slate-200 bg-white">
                            @foreach ($items as $item)
                                <li class="px-5 py-4">
                                    @php
                                        $url = match ($category) {
                                            'Berita' => route('news.show', $item->slug),
                                            'Agenda' => route('events.show', $item->slug),
                                            'Dokumentasi' => route('albums.show', $item->slug),
                                            'Layanan' => route('services.show', $item->slug),
                                            default => null,
                                        };
                                    @endphp
                                    @if ($url)
                                        <a href="{{ $url }}" class="text-sm font-semibold text-slate-800 transition hover:text-brand-700">
                                            {{ $item->title ?? $item->name ?? $item->question }}
                                        </a>
                                    @else
                                        <span class="text-sm font-semibold text-slate-800">{{ $item->title ?? $item->name ?? $item->question }}</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </section>
                @endforeach
            </div>
        @endif
    </div>
@endsection