@props(['event'])

<article class="group flex gap-4 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:border-brand-200 hover:shadow-md">
    <div class="flex h-16 w-16 shrink-0 flex-col items-center justify-center rounded-xl bg-brand-50 text-brand-700">
        <span class="text-xl font-bold leading-none">{{ $event->event_date?->format('d') }}</span>
        <span class="mt-1 text-[11px] font-semibold uppercase tracking-wide">{{ $event->event_date?->translatedFormat('M') }}</span>
    </div>

    <div class="min-w-0 flex-1">
        <h3 class="truncate text-sm font-semibold text-slate-900">
            <a href="{{ route('events.show', $event->slug) }}" class="transition hover:text-brand-700">{{ $event->title }}</a>
        </h3>

        <ul class="mt-2 space-y-1 text-xs text-slate-500">
            @if ($event->start_time)
                <li class="flex items-center gap-1.5">
                    <x-heroicon-o-clock class="h-3.5 w-3.5 text-brand-500" />
                    <span>
                        {{ \Illuminate\Support\Str::of($event->start_time)->substr(0, 5) }}
                        @if ($event->end_time)
                            &ndash; {{ \Illuminate\Support\Str::of($event->end_time)->substr(0, 5) }} WIB
                        @endif
                    </span>
                </li>
            @endif

            @if ($event->location)
                <li class="flex items-center gap-1.5">
                    <x-heroicon-o-map-pin class="h-3.5 w-3.5 shrink-0 text-brand-500" />
                    <span class="truncate">{{ $event->location }}</span>
                </li>
            @endif
        </ul>
    </div>
</article>