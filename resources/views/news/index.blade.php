@extends('layouts.app')

@section('title', 'Berita - ' . config('puskesmas.name'))
@section('meta_description', 'Berita, kegiatan, dan pengumuman terbaru dari ' . config('puskesmas.name'))

@section('content')
    <x-page-header title="Berita & Informasi" subtitle="Ikuti perkembangan berita, kegiatan, dan pengumuman terbaru."
        :breadcrumbs="['Berita' => null]" />

    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        @if ($categories->isNotEmpty())
            <div class="mb-8 flex flex-wrap gap-2">
                <a href="{{ route('news.index') }}"
                    class="rounded-full border px-4 py-1.5 text-sm font-medium transition {{ request('kategori') ? 'border-slate-200 bg-white text-slate-600 hover:border-brand-300' : 'border-brand-600 bg-brand-600 text-white' }}">
                    Semua
                </a>
                @foreach ($categories as $category)
                    <a href="{{ route('news.index', ['kategori' => $category]) }}"
                        class="rounded-full border px-4 py-1.5 text-sm font-medium transition {{ request('kategori') === $category ? 'border-brand-600 bg-brand-600 text-white' : 'border-slate-200 bg-white text-slate-600 hover:border-brand-300' }}">
                        {{ $category }}
                    </a>
                @endforeach
            </div>
        @endif

        @if ($news->isNotEmpty())
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($news as $item)
                    <x-news-card :news="$item" />
                @endforeach
            </div>

            <div class="mt-10">
                {{ $news->links() }}
            </div>
        @else
            <x-empty-state icon="newspaper">Belum ada berita tersedia.</x-empty-state>
        @endif
    </div>
@endsection