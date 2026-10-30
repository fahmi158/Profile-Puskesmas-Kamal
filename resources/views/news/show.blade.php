@extends('layouts.app')

@section('title', $article->title . ' - ' . config('puskesmas.name'))
@section('meta_description', $article->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($article->content), 150))

@php
    $image = $article->thumbnail ? \Illuminate\Support\Facades\Storage::url($article->thumbnail) : null;
@endphp

@if ($image)
    @section('og_image', $image)
    @section('og_type', 'article')
@endif

@push('structured_data')
    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $article->title,
            'datePublished' => optional($article->published_at)->toIso8601String(),
            'author' => ['@type' => 'Organization', 'name' => config('puskesmas.name')],
            'publisher' => ['@type' => 'Organization', 'name' => config('puskesmas.name')],
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>
@endpush

@section('content')
    <x-page-header :title="$article->title" :breadcrumbs="['Berita' => route('news.index'), \Illuminate\Support\Str::limit($article->title, 40) => null]" />

    <article class="mx-auto max-w-3xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="flex flex-wrap items-center gap-3 text-sm text-slate-500">
            @if ($article->category)
                <span class="rounded-full bg-brand-50 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-brand-700">{{ $article->category }}</span>
            @endif
            <time datetime="{{ optional($article->published_at)->toDateString() }}">
                {{ optional($article->published_at)->translatedFormat('d F Y') }}
            </time>
            @if ($article->user)
                <span>&middot;</span>
                <span>{{ $article->user->name }}</span>
            @endif
        </div>

        @if ($image)
            <img src="{{ $image }}" alt="{{ $article->title }}" class="mt-6 w-full rounded-2xl border border-slate-200 object-cover">
        @endif

        <div class="prose prose-slate mt-8 max-w-none prose-headings:text-slate-900 prose-a:text-brand-700">
            {!! $article->content !!}
        </div>

        <div class="mt-10 flex items-center gap-3 border-t border-slate-200 pt-6">
            <span class="text-sm font-semibold text-slate-600">Bagikan:</span>
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" rel="noopener noreferrer"
                class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-medium text-slate-600 transition hover:border-brand-300 hover:text-brand-700">Facebook</a>
            <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($article->title) }}" target="_blank" rel="noopener noreferrer"
                class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-medium text-slate-600 transition hover:border-brand-300 hover:text-brand-700">Twitter</a>
            <a href="https://wa.me/?text={{ urlencode($article->title . ' ' . url()->current()) }}" target="_blank" rel="noopener noreferrer"
                class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-medium text-slate-600 transition hover:border-brand-300 hover:text-brand-700">WhatsApp</a>
        </div>
    </article>

    @if ($related->isNotEmpty())
        <section class="bg-white py-14">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <h2 class="text-xl font-bold text-slate-900 sm:text-2xl">Berita Terkait</h2>
                <div class="mt-6 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($related as $item)
                        <x-news-card :news="$item" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection