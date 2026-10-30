@extends('layouts.app')

@section('title', 'Terjadi Kesalahan - ' . config('puskesmas.name'))

@section('content')
    <section class="mx-auto flex max-w-3xl flex-col items-center px-4 py-24 text-center sm:px-6 lg:px-8">
        <span class="flex h-20 w-20 items-center justify-center rounded-full bg-red-50 text-red-600">
            <x-heroicon-o-exclamation-triangle class="h-10 w-10" />
        </span>
        <p class="mt-6 text-5xl font-bold text-brand-800">500</p>
        <h1 class="mt-2 text-2xl font-bold text-slate-900">Terjadi Kesalahan</h1>
        <p class="mt-3 max-w-md text-sm leading-relaxed text-slate-500">
            Maaf, sedang terjadi kendala pada sistem. Silakan coba beberapa saat lagi.
        </p>
        <a href="{{ route('home') }}" class="mt-8 inline-flex items-center gap-2 rounded-full bg-brand-700 px-6 py-3 text-sm font-semibold text-white transition hover:bg-brand-800">
            <x-heroicon-m-home class="h-4 w-4" />
            Kembali ke Beranda
        </a>
    </section>
@endsection