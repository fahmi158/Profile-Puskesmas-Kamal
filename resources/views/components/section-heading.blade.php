@props(['eyebrow' => null, 'title', 'description' => null, 'href' => null, 'linkLabel' => 'Lihat Semua'])

<div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
    <div class="max-w-2xl">
        @if ($eyebrow)
            <span class="inline-block rounded-full bg-brand-50 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-brand-700">
                {{ $eyebrow }}
            </span>
        @endif
        <h2 class="mt-3 text-2xl font-bold text-slate-900 sm:text-3xl">{{ $title }}</h2>
        @if ($description)
            <p class="mt-2 text-sm leading-relaxed text-slate-500 sm:text-base">{{ $description }}</p>
        @endif
    </div>

    @if ($href)
        <a href="{{ $href }}" class="group inline-flex shrink-0 items-center gap-1.5 text-sm font-semibold text-brand-700 transition hover:text-brand-800">
            Lihat Semua
            <x-heroicon-m-arrow-right class="h-4 w-4 transition group-hover:translate-x-0.5" />
        </a>
    @endif
</footer>