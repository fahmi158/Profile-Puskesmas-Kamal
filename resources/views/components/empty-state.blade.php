@props(['icon' => 'inbox'])

<div {{ $attributes->merge(['class' => 'flex flex-col items-center justify-center rounded-2xl border border-dashed border-slate-200 bg-white px-6 py-14 text-center']) }}>
    <span class="flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-400">
        <x-dynamic-component :component="'heroicon-o-' . $icon" class="h-6 w-6" />
    </span>
    <p class="mt-4 text-sm text-slate-500">{{ $slot }}</p>
</div>