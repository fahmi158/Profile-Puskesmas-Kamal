@props(['news'])

@php
    $image = $news->thumbnail ? \Illuminate\Support\Facades\Storage::url($news->thumbnail) : null;
@endphp

<article class="group flex h-full flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
    <a href="{{ route('news.show', $news->slug) }}" class="relative block aspect-[16/10] overflow-hidden bg-slate-100" tabindex="-1" aria-hidden="true">
        @if ($image)
            <img src="{{ $image }}" alt="" loading="lazy" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
        @else
            <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-brand-100 to-ocean-100 text-brand-600">
                <x-heroicon-o-newspaper class="h-10 w-10" />
            </div>
        @endif
        @if ($news->category)
            <span class="absolute left-3 top-3 rounded-full bg-white/95 px-2.5 py-1 text-[11px] font-semibold uppercase tracking-wide text-brand-700 shadow-sm">
                {{ $news->category }}
            </span>
        @endif
    </a>

    <div class="flex flex-1 flex-col p-5">
        <div class="flex items-center gap-3 text-xs text-slate-400">
            <time datetime="{{ optional($news->published_at)->toDateString() }}">
                {{ optional($news->published_at)->translatedFormat('d F Y') }}
            </time>
        </div>

        <h3 class="mt-2 text-base font-semibold leading-snug text-slate-900">
            <a href="{{ route('news.show', $news->slug) }}" class="transition hover:text-brand-700">{{ $news->title }}</a>
        </h3>

        <p class="mt-2 flex-1 text-sm leading-relaxed text-slate-500">
            {{ $news->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($news->content), 120) }}
        </p>

        <a href="{{ route('news.show', $news->slug) }}" class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-brand-700 transition hover:text-brand-800">
            Baca selengkapnya
            <x-heroicon-m-arrow-right class="h-4 w-4" />
        </a>
    </div>
</article>