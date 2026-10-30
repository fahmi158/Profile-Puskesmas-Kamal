@props(['album'])

@php
    $cover = $album->cover_image ? \Illuminate\Support\Facades\Storage::url($album->cover_image) : null;
@endphp

<article class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:shadow-md">
    <a href="{{ route('albums.show', $album->slug) }}" class="block">
        <div class="relative aspect-[4/3] overflow-hidden bg-slate-100">
            @if ($cover)
                <img src="{{ $cover }}" alt="{{ $album->title }}" loading="lazy" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
            @else
                <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-ocean-100 to-brand-100 text-ocean-600">
                    <x-heroicon-o-photo class="h-10 w-10" />
                </div>
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-slate-900/20 to-transparent"></div>

            @if ($album->category)
                <span class="absolute left-3 top-3 rounded-full bg-white/95 px-2.5 py-1 text-[11px] font-semibold uppercase tracking-wide text-brand-700">
                    {{ $album->category }}
                </span>
            @endif

            <div class="absolute inset-x-0 bottom-0 p-4">
                <h3 class="text-sm font-semibold text-white sm:text-base">{{ $album->title }}</h3>
                @if ($album->event_date)
                    <p class="mt-1 text-xs text-slate-200">{{ $album->event_date->translatedFormat('d F Y') }}</p>
                @endif
            </div>
        </div>
    </a>
</article>