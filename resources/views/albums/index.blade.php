@extends('layouts.app')

@section('title', 'Dokumentasi Kegiatan - ' . config('puskesmas.name'))
@section('meta_description', 'Galeri dokumentasi kegiatan ' . config('puskesmas.name'))

@section('content')
    <x-page-header title="Dokumentasi Kegiatan" subtitle="Galeri foto dan dokumentasi kegiatan Puskesmas Kamal."
        :breadcrumbs="['Dokumentasi' => null]" />

    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        @if ($categories->isNotEmpty())
            <div class="mb-8 flex flex-wrap gap-2">
                <a href="{{ route('albums.index') }}"
                    class="rounded-full border px-4 py-1.5 text-sm font-medium transition {{ request('kategori') ? 'border-slate-200 bg-white text-slate-600 hover:border-brand-300' : 'border-brand-600 bg-brand-600 text-white' }}">
                    Semua
                </a>
                @foreach ($categories as $category)
                    <a href="{{ route('albums.index', ['kategori' => $category]) }}"
                        class="rounded-full border px-4 py-1.5 text-sm font-medium transition {{ request('kategori') === $category ? 'border-brand-600 bg-brand-600 text-white' : 'border-slate-200 bg-white text-slate-600 hover:border-brand-300' }}">
                        {{ $category }}
                    </a>
                @endforeach
            </div>
        @endif

        @if ($albums->isNotEmpty())
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($albums as $album)
                    <x-album-card :album="$album" />
                @endforeach
            </div>
            <div class="mt-10">
                {{ $albums->links() }}
            </div>
        @else
            <x-empty-state icon="photo">Belum ada dokumentasi kegiatan.</x-empty-state>
        @endif
    </div>
@endsection