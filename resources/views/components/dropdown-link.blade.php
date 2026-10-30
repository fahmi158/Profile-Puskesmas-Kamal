@props(['href'])

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'block rounded-lg px-3 py-2 text-sm text-slate-600 transition hover:bg-brand-50 hover:text-brand-700']) }}>
    {{ $slot }}
</a>