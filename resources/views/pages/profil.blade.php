@extends('layouts.app')

@php
    $page = $pages->get('tentang') ?? $pages->first();
@endphp

@section('title', 'Profil - ' . config('puskesmas.name'))
@section('meta_description', 'Profil, sejarah, visi misi, dan struktur organisasi ' . config('puskesmas.name'))

@section('content')
    <x-page-header title="Profil Puskesmas" subtitle="Kenali lebih dekat {{ config('puskesmas.name') }}."
        :breadcrumbs="['Profil' => null]" />

    <div class="mx-auto grid max-w-7xl gap-10 px-4 py-12 sm:px-6 lg:grid-cols-4 lg:px-8">
        <aside class="lg:col-span-1">
            <div class="rounded-2xl border border-slate-200 bg-white p-4">
                <x-profil-nav active="tentang" />
            </div>
        </aside>

        <div class="lg:col-span-3">
            @if ($page)
                <h2 class="text-2xl font-bold text-slate-900">{{ $page->title }}</h2>
                <div class="prose prose-slate mt-6 max-w-none">
                    {!! $page->content !!}
                </div>
            @else
                <x-empty-state icon="document-text">Informasi profil belum tersedia. Silakan diisi oleh admin.</x-empty-state>
            @endif
        </div>
    </div>
@endsection