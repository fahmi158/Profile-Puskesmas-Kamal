<header x-data="{ mobileOpen: false }" class="sticky top-0 z-40 w-full border-b border-slate-200 bg-white/95 backdrop-blur">
    <div class="hidden bg-brand-800 text-white lg:block">
        <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-1.5 text-xs sm:px-6 lg:px-8">
            <p class="flex items-center gap-2">
                <span class="inline-block h-1.5 w-1.5 rounded-full bg-emerald-300"></span>
                {{ config('puskesmas.tagline') }}
            </p>
            <div class="flex items-center gap-4">
                @if (config('puskesmas.phone'))
                    <span class="inline-flex items-center gap-1.5">
                        <x-heroicon-o-phone class="h-3.5 w-3.5" />
                        {{ config('puskesmas.phone') }}
                    </span>
                @endif
                <span class="inline-flex items-center gap-1.5">
                    <x-heroicon-o-clock class="h-3.5 w-3.5" />
                    {{ config('puskesmas.operational_hours') }}
                </span>
            </div>
        </div>
    </div>

    <div class="mx-auto flex max-w-7xl items-center justify-between gap-3 px-4 py-3 sm:px-6 lg:px-8">
        <a href="{{ route('home') }}" class="flex items-center gap-3" aria-label="{{ config('puskesmas.name') }} - Beranda">
            <img src="{{ asset('image/logo_puskesmas.jpg') }}" alt="Logo {{ config('puskesmas.name') }}" class="h-11 w-11 rounded-xl object-contain bg-white shadow-sm ring-1 ring-slate-200">
            <span class="leading-tight">
                <span class="block text-base font-bold text-brand-800 sm:text-lg">{{ config('puskesmas.name') }}</span>
                <span class="hidden text-xs text-slate-500 sm:block">Portal Informasi Resmi</span>
            </span>
        </a>

        <nav class="hidden items-center gap-1 xl:flex" aria-label="Navigasi utama">
            <x-nav-link :href="route('home')" :active="request()->routeIs('home')">Beranda</x-nav-link>

            <div class="group relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                <button type="button" class="inline-flex items-center gap-1 rounded-lg px-3 py-2 text-sm font-medium {{ request()->routeIs('profil.*') ? 'bg-brand-50 text-brand-700' : 'text-slate-600' }} transition hover:bg-brand-50 hover:text-brand-700" :aria-expanded="open" @click="open = !open">
                    Profil
                    <x-heroicon-m-chevron-down class="h-4 w-4 transition group-hover:rotate-180" />
                </button>
                <div x-show="open" x-cloak x-transition.origin.top.left class="absolute left-0 top-full z-50 w-56 rounded-xl border border-slate-200 bg-white p-2 shadow-lg">
                    <x-dropdown-link :href="route('profil.index')">Tentang Puskesmas</x-dropdown-link>
                    <x-dropdown-link :href="route('profil.sejarah')">Sejarah</x-dropdown-link>
                    <x-dropdown-link :href="route('profil.visi-misi')">Visi &amp; Misi</x-dropdown-link>
                    <x-dropdown-link :href="route('profil.struktur-organisasi')">Struktur Organisasi</x-dropdown-link>
                </div>
            </div>

            <x-nav-link :href="route('services.index')" :active="request()->routeIs('services.*')">Layanan</x-nav-link>

            <div class="group relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                <button type="button" class="inline-flex items-center gap-1 rounded-lg px-3 py-2 text-sm font-medium text-slate-600 transition hover:bg-brand-50 hover:text-brand-700" :aria-expanded="open" @click="open = !open">
                    Informasi
                    <x-heroicon-m-chevron-down class="h-4 w-4 transition group-hover:rotate-180" />
                </button>
                <div x-show="open" x-cloak x-transition.origin.top.left class="absolute left-0 top-full z-50 w-56 rounded-xl border border-slate-200 bg-white p-2 shadow-lg">
                    <x-dropdown-link :href="route('news.index')">Berita</x-dropdown-link>
                    <x-dropdown-link :href="route('news.index', ['kategori' => 'Artikel Kesehatan'])">Artikel Kesehatan</x-dropdown-link>
                    <x-dropdown-link :href="route('news.index', ['kategori' => 'Pengumuman'])">Pengumuman</x-dropdown-link>
                    <x-dropdown-link :href="route('events.index')">Agenda</x-dropdown-link>
                    <x-dropdown-link :href="route('videos.index')">Video</x-dropdown-link>
                    <x-dropdown-link :href="route('faqs.index')">FAQ</x-dropdown-link>
                </div>
            </div>

            <x-nav-link :href="route('albums.index')" :active="request()->routeIs('albums.*')">Dokumentasi</x-nav-link>
            <x-nav-link :href="route('documents.index')" :active="request()->routeIs('documents.*')">Dokumen</x-nav-link>
            <x-nav-link :href="route('contact.index')" :active="request()->routeIs('contact.*')">Kontak</x-nav-link>
        </nav>

        <div class="flex items-center gap-2">
            <form action="{{ route('search') }}" method="GET" class="hidden items-center md:flex" role="search">
                <label for="site-search" class="sr-only">Cari</label>
                <div class="relative">
                    <x-heroicon-o-magnifying-glass class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" />
                    <input id="site-search" type="search" name="q" placeholder="Cari informasi..."
                        class="w-40 rounded-full border border-slate-200 bg-slate-50 py-2 pl-9 pr-4 text-sm text-slate-700 transition focus:w-56 focus:border-brand-400 focus:bg-white focus:outline-none">
                </div>
            </form>

            <button type="button" class="inline-flex h-10 w-10 items-center justify-center rounded-lg text-slate-600 transition hover:bg-brand-50 hover:text-brand-700 xl:hidden"
                @click="mobileOpen = !mobileOpen" :aria-expanded="mobileOpen" aria-controls="mobile-menu" aria-label="Buka menu navigasi">
                <x-heroicon-o-bars-3 x-show="!mobileOpen" class="h-6 w-6" />
                <x-heroicon-o-x-mark x-show="mobileOpen" x-cloak class="h-6 w-6" />
            </button>
        </div>
    </div>

    {{-- Mobile navigation --}}
    <div id="mobile-menu" x-show="mobileOpen" x-cloak x-transition
        class="border-t border-slate-200 bg-white xl:hidden" @keydown.escape.window="mobileOpen = false">
        <div class="mx-auto max-w-7xl space-y-1 px-4 py-4 sm:px-6">
            <form action="{{ route('search') }}" method="GET" class="mb-3" role="search">
                <label for="mobile-search" class="sr-only">Cari</label>
                <div class="relative">
                    <x-heroicon-o-magnifying-glass class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" />
                    <input id="mobile-search" type="search" name="q" placeholder="Cari informasi..."
                        class="w-full rounded-lg border border-slate-200 bg-slate-50 py-2.5 pl-9 pr-4 text-sm focus:border-brand-400 focus:bg-white focus:outline-none">
                </div>
            </form>

            <a href="{{ route('home') }}" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-brand-50 hover:text-brand-700">Beranda</a>

            <div x-data="{ open: false }">
                <button type="button" class="flex w-full items-center justify-between rounded-lg px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-brand-50 hover:text-brand-700" @click="open = !open" :aria-expanded="open">
                    Profil
                    <x-heroicon-m-chevron-down class="h-4 w-4 transition" ::class="open && 'rotate-180'" />
                </button>
                <div x-show="open" x-cloak class="mt-1 space-y-1 border-l border-slate-200 pl-3">
                    <a href="{{ route('profil.index') }}" class="block rounded-lg px-3 py-2 text-sm text-slate-600 hover:bg-brand-50 hover:text-brand-700">Tentang Puskesmas</a>
                    <a href="{{ route('profil.sejarah') }}" class="block rounded-lg px-3 py-2 text-sm text-slate-600 hover:bg-brand-50 hover:text-brand-700">Sejarah</a>
                    <a href="{{ route('profil.visi-misi') }}" class="block rounded-lg px-3 py-2 text-sm text-slate-600 hover:bg-brand-50 hover:text-brand-700">Visi &amp; Misi</a>
                    <a href="{{ route('profil.struktur-organisasi') }}" class="block rounded-lg px-3 py-2 text-sm text-slate-600 hover:bg-brand-50 hover:text-brand-700">Struktur Organisasi</a>
                </div>
            </div>

            <a href="{{ route('services.index') }}" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-brand-50 hover:text-brand-700">Layanan</a>

            <div x-data="{ open: false }">
                <button type="button" class="flex w-full items-center justify-between rounded-lg px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-brand-50 hover:text-brand-700" @click="open = !open" :aria-expanded="open">
                    Informasi
                    <x-heroicon-m-chevron-down class="h-4 w-4 transition" ::class="open && 'rotate-180'" />
                </button>
                <div x-show="open" x-cloak class="mt-1 space-y-1 border-l border-slate-200 pl-3">
                    <a href="{{ route('news.index') }}" class="block rounded-lg px-3 py-2 text-sm text-slate-600 hover:bg-brand-50 hover:text-brand-700">Berita</a>
                    <a href="{{ route('news.index', ['kategori' => 'Artikel Kesehatan']) }}" class="block rounded-lg px-3 py-2 text-sm text-slate-600 hover:bg-brand-50 hover:text-brand-700">Artikel Kesehatan</a>
                    <a href="{{ route('news.index', ['kategori' => 'Pengumuman']) }}" class="block rounded-lg px-3 py-2 text-sm text-slate-600 hover:bg-brand-50 hover:text-brand-700">Pengumuman</a>
                    <a href="{{ route('events.index') }}" class="block rounded-lg px-3 py-2 text-sm text-slate-600 hover:bg-brand-50 hover:text-brand-700">Agenda</a>
                    <a href="{{ route('videos.index') }}" class="block rounded-lg px-3 py-2 text-sm text-slate-600 hover:bg-brand-50 hover:text-brand-700">Video</a>
                    <a href="{{ route('faqs.index') }}" class="block rounded-lg px-3 py-2 text-sm text-slate-600 hover:bg-brand-50 hover:text-brand-700">FAQ</a>
                </div>
            </div>

            <a href="{{ route('albums.index') }}" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-brand-50 hover:text-brand-700">Dokumentasi</a>
            <a href="{{ route('documents.index') }}" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-brand-50 hover:text-brand-700">Dokumen</a>
            <a href="{{ route('contact.index') }}" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-brand-50 hover:text-brand-700">Kontak</a>
        </div>
    </div>
</header>