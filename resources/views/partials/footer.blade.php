<footer class="bg-brand-900 text-slate-300">
    <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
        <div class="grid gap-10 md:grid-cols-2 lg:grid-cols-4">
            <div class="lg:col-span-2">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-3" aria-label="{{ config('puskesmas.name') }}">
                    <img src="{{ asset('image/logo_puskesmas.jpg') }}" alt="Logo {{ config('puskesmas.name') }}" class="h-11 w-11 rounded-xl object-contain bg-white shadow-sm ring-1 ring-white/20">
                    <span class="text-lg font-bold text-white">{{ config('puskesmas.name') }}</span>
                </a>
                <p class="mt-4 max-w-md text-sm leading-relaxed">{{ config('puskesmas.description') }}</p>

                <div class="mt-5 flex items-center gap-2">
                    @foreach (config('puskesmas.social') as $platform => $url)
                        @if ($url)
                            <a href="{{ $url }}" target="_blank" rel="noopener noreferrer"
                                class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-white/10 text-white transition hover:bg-white/20"
                                aria-label="{{ ucfirst($platform) }}">
                                <span class="text-xs font-semibold">{{ strtoupper(substr($platform, 0, 2)) }}</span>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>

            <div>
                <h3 class="text-sm font-semibold uppercase tracking-wider text-white">Tautan</h3>
                <ul class="mt-4 space-y-2 text-sm">
                    <li><a href="{{ route('home') }}" class="transition hover:text-white">Beranda</a></li>
                    <li><a href="{{ route('profil.index') }}" class="transition hover:text-white">Profil</a></li>
                    <li><a href="{{ route('services.index') }}" class="transition hover:text-white">Layanan</a></li>
                    <li><a href="{{ route('news.index') }}" class="transition hover:text-white">Berita</a></li>
                    <li><a href="{{ route('events.index') }}" class="transition hover:text-white">Agenda</a></li>
                    <li><a href="{{ route('albums.index') }}" class="transition hover:text-white">Dokumentasi</a></li>
                    <li><a href="{{ route('documents.index') }}" class="transition hover:text-white">Dokumen</a></li>
                    <li><a href="{{ route('contact.index') }}" class="transition hover:text-white">Kontak</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-sm font-semibold uppercase tracking-wider text-white">Kontak</h3>
                <ul class="mt-4 space-y-3 text-sm">
                    <li class="flex gap-2">
                        <x-heroicon-o-map-pin class="mt-0.5 h-4 w-4 shrink-0 text-emerald-300" />
                        <span>{{ config('puskesmas.address') }}</span>
                    </li>
                    <li class="flex gap-2">
                        <x-heroicon-o-phone class="mt-0.5 h-4 w-4 shrink-0 text-emerald-300" />
                        <span>{{ config('puskesmas.phone') }}</span>
                    </li>
                    <li class="flex gap-2">
                        <x-heroicon-o-envelope class="mt-0.5 h-4 w-4 shrink-0 text-emerald-300" />
                        <span>{{ config('puskesmas.email') }}</span>
                    </li>
                    <li class="flex gap-2">
                        <x-heroicon-o-clock class="mt-0.5 h-4 w-4 shrink-0 text-emerald-300" />
                        <span>{{ config('puskesmas.operational_hours') }}</span>
                    </li>
                    @if (config('puskesmas.whatsapp'))
                        <li>
                            <a href="https://wa.me/{{ config('puskesmas.whatsapp') }}" target="_blank" rel="noopener noreferrer"
                                class="inline-flex items-center gap-2 rounded-lg bg-emerald-600/20 px-3 py-2 text-sm font-medium text-emerald-300 transition hover:bg-emerald-600/30 hover:text-white">
                                <x-heroicon-o-chat-bubble-left-right class="h-4 w-4 shrink-0" />
                                Informasi &amp; Pengaduan via WhatsApp
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>

    <div class="border-t border-white/10">
        <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-2 px-4 py-4 text-xs sm:flex-row sm:px-6 lg:px-8">
            <p>&copy; {{ now()->year }} {{ config('puskesmas.name') }}. Seluruh hak cipta dilindungi.</p>
            <p>Dikembangkan sebagai portal informasi resmi.</p>
        </div>
    </div>
</footer>