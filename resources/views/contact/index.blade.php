@extends('layouts.app')

@section('title', 'Kontak - ' . config('puskesmas.name'))
@section('meta_description', 'Hubungi ' . config('puskesmas.name') . ' untuk informasi layanan dan kesehatan.')

@push('structured_data')
    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'MedicalClinic',
            'name' => config('puskesmas.name'),
            'telephone' => config('puskesmas.phone'),
            'email' => config('puskesmas.email'),
            'address' => ['@type' => 'PostalAddress', 'streetAddress' => config('puskesmas.address')],
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>
@endpush

@section('content')
    <x-page-header title="Hubungi Kami" subtitle="Sampaikan pertanyaan, saran, atau masukan Anda kepada kami."
        :breadcrumbs="['Kontak' => null]" />

    <div class="mx-auto grid max-w-7xl gap-10 px-4 py-12 sm:px-6 lg:grid-cols-2 lg:px-8">
        <div>
            <h2 class="text-lg font-bold text-slate-900">Informasi Kontak</h2>
            <ul class="mt-6 space-y-4 text-sm">
                <li class="flex gap-3">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-brand-50 text-brand-700">
                        <x-heroicon-o-map-pin class="h-5 w-5" />
                    </span>
                    <div>
                        <p class="font-semibold text-slate-900">Alamat</p>
                        <p class="text-slate-500">{{ config('puskesmas.address') }}</p>
                    </div>
                </li>
                <li class="flex gap-3">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-brand-50 text-brand-700">
                        <x-heroicon-o-phone class="h-5 w-5" />
                    </span>
                    <div>
                        <p class="font-semibold text-slate-900">Telepon</p>
                        <p class="text-slate-500">{{ config('puskesmas.phone') }}</p>
                    </div>
                </li>
                <li class="flex gap-3">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-brand-50 text-brand-700">
                        <x-heroicon-o-envelope class="h-5 w-5" />
                    </span>
                    <div>
                        <p class="font-semibold text-slate-900">Email</p>
                        <p class="text-slate-500">{{ config('puskesmas.email') }}</p>
                    </div>
                </li>
                <li class="flex gap-3">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-brand-50 text-brand-700">
                        <x-heroicon-o-clock class="h-5 w-5" />
                    </span>
                    <div>
                        <p class="font-semibold text-slate-900">Jam Pelayanan</p>
                        <p class="text-slate-500">{{ config('puskesmas.operational_hours') }}</p>
                    </div>
                </li>
                @if (config('puskesmas.whatsapp'))
                    <li class="flex gap-3">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700">
                            <x-heroicon-o-chat-bubble-left-right class="h-5 w-5" />
                        </span>
                        <div>
                            <p class="font-semibold text-slate-900">Informasi &amp; Pengaduan</p>
                            <a href="https://wa.me/{{ config('puskesmas.whatsapp') }}" target="_blank" rel="noopener noreferrer"
                                class="mt-1 inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-700">
                                <x-heroicon-o-chat-bubble-left-right class="h-4 w-4" />
                                Chat WhatsApp
                            </a>
                        </div>
                    </li>
                @endif
            </ul>

            @if (config('puskesmas.maps_embed'))
                <div class="mt-8 overflow-hidden rounded-2xl border border-slate-200">
                    <iframe src="{{ config('puskesmas.maps_embed') }}" class="h-64 w-full" loading="lazy" title="Lokasi {{ config('puskesmas.name') }}"></iframe>
                    @if (config('puskesmas.maps_link'))
                        <a href="{{ config('puskesmas.maps_link') }}" target="_blank" rel="noopener noreferrer"
                            class="flex items-center justify-center gap-2 border-t border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-brand-700 transition hover:bg-brand-50">
                            <x-heroicon-o-map-pin class="h-4 w-4" />
                            Buka di Google Maps
                        </a>
                    @endif
                </div>
            @endif
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <h2 class="text-lg font-bold text-slate-900">Kirim Pesan</h2>

            @if (session('success'))
                <div class="mt-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800" role="status">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('contact.store') }}" method="POST" class="mt-6 space-y-4">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700">Nama <span class="text-red-500">*</span></label>
                    <input id="name" name="name" type="text" required value="{{ old('name') }}"
                        class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-200">
                    @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700">Email <span class="text-red-500">*</span></label>
                        <input id="email" name="email" type="email" required value="{{ old('email') }}"
                            class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-200">
                        @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-slate-700">Telepon</label>
                        <input id="phone" name="phone" type="text" value="{{ old('phone') }}"
                            class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-200">
                        @error('phone') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="subject" class="block text-sm font-medium text-slate-700">Subjek</label>
                    <input id="subject" name="subject" type="text" value="{{ old('subject') }}"
                        class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-200">
                    @error('subject') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="message" class="block text-sm font-medium text-slate-700">Pesan <span class="text-red-500">*</span></label>
                    <textarea id="message" name="message" rows="4" required
                        class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-200">{{ old('message') }}</textarea>
                    @error('message') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-brand-700 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-brand-800">
                    <x-heroicon-o-paper-airplane class="h-4 w-4" />
                    Kirim Pesan
                </button>
            </form>
        </div>
    </div>
@endsection