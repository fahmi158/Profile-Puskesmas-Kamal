@props(['active' => null])

@php
    $items = [
        'tentang' => ['label' => 'Tentang Puskesmas', 'route' => 'profil.index'],
        'sejarah' => ['label' => 'Sejarah', 'route' => 'profil.sejarah'],
        'visi-misi' => ['label' => 'Visi & Misi', 'route' => 'profil.visi-misi'],
        'struktur-organisasi' => ['label' => 'Struktur Organisasi', 'route' => 'profil.struktur-organisasi'],
    ];
@endphp

<nav class="space-y-1" aria-label="Navigasi profil">
    @foreach ($items as $slug => $item)
        <a href="{{ route($item['route']) }}"
            @if ($active === $slug) aria-current="page" @endif
            class="block rounded-lg px-4 py-2.5 text-sm font-medium transition {{ $active === $slug ? 'bg-brand-600 text-white' : 'text-slate-600 hover:bg-brand-50 hover:text-brand-700' }}">
            {{ $item['label'] }}
        </a>
    @endforeach
</nav>