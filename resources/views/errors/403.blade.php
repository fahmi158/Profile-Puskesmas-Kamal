@extends('layouts.app')

@section('title', 'Akses Ditolak - ' . config('puskesmas.name'))

@section('content')
    <section class="mx-auto flex max-w-3xl flex-col items-center px-4 py-24 text-center sm:px-6 lg:px-8">
        <span class="flex h-20 w-20 items-center justify-center rounded-full bg-amber-50 text-amber-600">
            <x-heroicon-o-lock-closed class="h-10 w-10" />
        </span>
        <p class="mt-6 text-5xl font-bold text-brand-800">403</p>
        <h1 class="mt-2 text-2xl font-bold text-slate-900">Akses Ditolak</h1>
        <p class="mt-3 max-w-md text-sm leading-relaxed text-slate-500">
            Anda tidak memiliki izin untuk mengakses halaman ini.
        </p>
        <a href="{{ route('home') }}" class="mt-8 inline-flex items-center gap-2 rounded-full bg-brand-700 px-6 py-3 text-sm font-semibold text-white transition hover:bg-brand-800">
            <x-heroicon-m-home class="h-4 w-4" />
            Kembali ke Beranda
        </a>
    </section>
@endsection