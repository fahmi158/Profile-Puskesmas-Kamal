@extends('layouts.app')

@section('title', $video->title . ' - ' . config('puskesmas.name'))
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($video->description), 150))

@section('content')
    <x-page-header :title="$video->title" :breadcrumbs="['Video' => route('videos.index'), \Illuminate\Support\Str::limit($video->title, 40) => null]" />

    <div class="mx-auto max-w-4xl px-4 py-12 sm:px-6 lg:px-8">
        @if ($video->youtube_id)
            <div class="aspect-video overflow-hidden rounded-2xl border border-slate-200 bg-slate-900">
                <iframe src="https://www.youtube.com/embed/{{ $video->youtube_id }}" class="h-full w-full" title="{{ $video->title }}"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        @else
            <div class="flex aspect-video items-center justify-center rounded-2xl border border-slate-200 bg-slate-100 text-slate-400">
                <x-heroicon-o-video-camera class="h-12 w-12" />
            </div>
        @endif

        <div class="mt-8">
            @if ($video->published_at)
                <p class="text-sm text-slate-400">{{ $video->published_at->translatedFormat('d F Y') }}</p>
            @endif
            <h1 class="mt-2 text-2xl font-bold text-slate-900">{{ $video->title }}</h1>
            @if ($video->description)
                <div class="prose prose-slate mt-4 max-w-none">{!! $video->description !!}</div>
            @endif
        </div>

        @if ($related->isNotEmpty())
            <div class="mt-12">
                <h2 class="text-lg font-bold text-slate-900">Video Lainnya</h2>
                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                    @foreach ($related as $item)
                        <a href="{{ route('videos.show', $item->slug) }}" class="flex gap-3 rounded-xl border border-slate-200 bg-white p-3 transition hover:border-brand-200 hover:shadow-sm">
                            <div class="relative h-16 w-24 shrink-0 overflow-hidden rounded-lg bg-slate-900">
                                @if ($item->youtube_id)
                                    <img src="https://img.youtube.com/vi/{{ $item->youtube_id }}/mqdefault.jpg" alt="" loading="lazy" class="h-full w-full object-cover">
                                @endif
                            </div>
                            <p class="text-sm font-medium text-slate-700">{{ \Illuminate\Support\Str::limit($item->title, 50) }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection