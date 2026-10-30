@props(['href', 'active' => false])

<a href="{{ $href }}"
    @if ($active) aria-current="page" @endif
    {{ $attributes->merge(['class' => 'rounded-lg px-3 py-2 text-sm font-medium transition ' . ($active ? 'bg-brand-50 text-brand-700' : 'text-slate-600 hover:bg-brand-50 hover:text-brand-700')]) }}>
    {{ $slot }}
</a>