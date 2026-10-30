@extends('layouts.app')

@section('title', $album->title . ' - ' . config('puskesmas.name'))
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($album->description), 150))

@php
    $cover = $album->cover_image ? \Illuminate\Support\Facades\Storage::url($album->cover_image) : null;
@endphp

@if ($cover)
    @section('og_image', $cover)
@endif

@section('content')
    <x-page-header :title="$album->title" :subtitle="$album->description"
        :breadcrumbs="['Dokumentasi' => route('albums.index'), \Illuminate\Support\Str::limit($album->title, 40) => null]" />

    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8" x-data="{ lightbox: null }">
        <div class="mb-6 flex flex-wrap items-center gap-3 text-sm text-slate-500">
            @if ($album->category)
                <span class="rounded-full bg-brand-50 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-brand-700">{{ $album->category }}</span>
            @endif
            @if ($album->event_date)
                <span>{{ $album->event_date->translatedFormat('d F Y') }}</span>
            @endif
            <span>&middot;</span>
            <span>{{ $album->photos->count() }} Foto</span>
        </div>

        @if ($album->photos->isNotEmpty())
            <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
                @foreach ($album->photos as $photo)
                    @php $photoUrl = \Illuminate\Support\Facades\Storage::url($photo->image); @endphp
                    <button type="button" @click="lightbox = { src: '{{ $photoUrl }}', caption: {{ \Illuminate\Support\Js::from($photo->caption) }} }"
                        class="group relative aspect-square overflow-hidden rounded-xl border border-slate-200 bg-slate-100">
                        <img src="{{ $photoUrl }}" alt="{{ $photo->caption ?: $album->title }}" loading="lazy"
                            class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                    </button>
                @endforeach
            </div>

            <div x-show="lightbox" x-cloak @keydown.escape.window="lightbox = null"
                class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/90 p-4" @click.self="lightbox = null">
                <button type="button" class="absolute right-4 top-4 rounded-full bg-white/10 p-2 text-white hover:bg-white/20" @click="lightbox = null" aria-label="Tutup">
                    <x-heroicon-o-x-mark class="h-6 w-6" />
                </button>
                <figure class="max-h-full max-w-4xl">
                    <img :src="lightbox?.src" :alt="lightbox?.caption" class="max-h-[80vh] w-full rounded-lg object-contain">
                    <figcaption class="mt-3 text-center text-sm text-slate-200" x-text="lightbox?.caption"></figcaption>
                </figure>
            </div>
        @else
            <x-empty-state icon="photo">Belum ada foto pada album ini.</x-empty-state>
        @endif
    </div>
@endsection