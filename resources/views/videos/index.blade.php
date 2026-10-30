@extends('layouts.app')

@section('title', 'Video - ' . config('puskesmas.name'))
@section('meta_description', 'Kumpulan video edukasi dan kegiatan ' . config('puskesmas.name'))

@section('content')
    <x-page-header title="Video" subtitle="Kumpulan video edukasi kesehatan dan dokumentasi kegiatan."
        :breadcrumbs="['Video' => null]" />

    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        @if ($videos->isNotEmpty())
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($videos as $video)
                    @php $youtubeId = $video->youtube_id; @endphp
                    <article class="group overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:shadow-md">
                        <a href="{{ route('videos.show', $video->slug) }}" class="block">
                            <div class="relative aspect-video overflow-hidden bg-slate-900">
                                @if ($video->thumbnail)
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($video->thumbnail) }}" alt="{{ $video->title }}" loading="lazy" class="h-full w-full object-cover">
                                @elseif ($video->youtube_id)
                                    <img src="https://img.youtube.com/vi/{{ $video->youtube_id }}/hqdefault.jpg" alt="{{ $video->title }}" loading="lazy" class="h-full w-full object-cover">
                                @endif
                                <span class="absolute inset-0 flex items-center justify-center">
                                    <span class="flex h-14 w-14 items-center justify-center rounded-full bg-white/90 text-brand-700 shadow-lg transition group-hover:scale-105">
                                        <x-heroicon-s-play class="h-6 w-6" />
                                    </span>
                                </span>
                            </div>
                        </a>
                        <div class="p-5">
                            <h3 class="text-sm font-semibold text-slate-900">{{ $video->title }}</h3>
                            @if ($video->published_at)
                                <p class="mt-1 text-xs text-slate-400">{{ $video->published_at->translatedFormat('d F Y') }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-10">
                {{ $videos->links() }}
            </div>
        @else
            <x-empty-state icon="video-camera">Belum ada video.</x-empty-state>
        @endif
    </div>
@endsection