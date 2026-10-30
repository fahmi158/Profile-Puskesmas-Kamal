@props(['title', 'subtitle' => null, 'breadcrumbs' => []])

<section class="border-b border-slate-200 bg-gradient-to-br from-brand-800 to-ocean-800">
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 lg:py-16">
        <nav aria-label="Breadcrumb" class="mb-4">
            <ol class="flex flex-wrap items-center gap-2 text-xs text-slate-200">
                <li>
                    <a href="{{ route('home') }}" class="transition hover:text-white">Beranda</a>
                </li>
                @foreach ($breadcrumbs as $label => $url)
                    <li class="flex items-center gap-2">
                        <x-heroicon-m-chevron-right class="h-3.5 w-3.5 text-slate-400" />
                        @if ($url)
                            <a href="{{ $url }}" class="transition hover:text-white">{{ $label }}</a>
                        @else
                            <span class="font-medium text-white" aria-current="page">{{ $label }}</span>
                        @endif
                    </li>
                @endforeach
            </ol>
        </nav>

        <h1 class="text-2xl font-bold text-white sm:text-3xl lg:text-4xl">{{ $title }}</h1>

        @if ($subtitle)
            <p class="mt-3 max-w-2xl text-sm leading-relaxed text-slate-200 sm:text-base">{{ $subtitle }}</p>
        @endif
    </div>
</section>