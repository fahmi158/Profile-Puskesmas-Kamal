@props(['href' => null, 'linkLabel' => 'Lihat Semua'])

<div {{ $attributes->merge(['class' => 'flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between']) }}>
    <div class="max-w-2xl">
        @isset($eyebrow)
            <span class="inline-flex items-center gap-1.5 text-xs font-semibold uppercase tracking-wider text-brand-600">
                {{ $eyebrow }}
            </span>
        @endisset

        <h2 class="mt-1 text-2xl font-bold text-slate-900 sm:text-3xl">{{ $title ?? '' }}</h2>

        @isset($description)
            <p class="mt-2 text-sm leading-relaxed text-slate-500 sm:text-base">{{ $description }}</p>
        @endisset
    </div>

    @if ($href)
        <a href="{{ $href }}" class="group inline-flex shrink-0 items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-brand-700 shadow-sm transition hover:border-brand-300 hover:bg-brand-50">
            {{ $linkLabel }}
            <x-heroicon-m-arrow-right class="h-4 w-4 transition group-hover:translate-x-0.5" />
        </a>
    @endif
</div>