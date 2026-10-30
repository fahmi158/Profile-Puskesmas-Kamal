@props(['service'])

<article class="group flex h-full flex-col rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:border-brand-200 hover:shadow-md">
    <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-brand-50 text-brand-700 transition group-hover:bg-brand-600 group-hover:text-white">
        <x-dynamic-component :component="'heroicon-o-' . ($service->icon ?: 'heart')" class="h-6 w-6" />
    </span>

    <h3 class="mt-4 text-base font-semibold text-slate-900">{{ $service->name }}</h3>

    <p class="mt-2 flex-1 text-sm leading-relaxed text-slate-500">
        {{ $service->description ? \Illuminate\Support\Str::limit(strip_tags($service->description), 120) : 'Informasi layanan belum tersedia.' }}
    </p>

    <a href="{{ route('services.show', $service->slug) }}" class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-brand-700 transition hover:text-brand-800">
        Selengkapnya
        <x-heroicon-m-arrow-right class="h-4 w-4" />
    </a>
</article>