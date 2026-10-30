@extends('layouts.app')

@section('title', 'Dokumen Publik - ' . config('puskesmas.name'))
@section('meta_description', 'Dokumen dan informasi publik ' . config('puskesmas.name'))

@section('content')
    <x-page-header title="Dokumen Publik" subtitle="Unduh dokumen, standar pelayanan, dan informasi publik."
        :breadcrumbs="['Dokumen' => null]" />

    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        @if ($categories->isNotEmpty())
            <div class="mb-8 flex flex-wrap gap-2">
                <a href="{{ route('documents.index') }}"
                    class="rounded-full border px-4 py-1.5 text-sm font-medium transition {{ request('kategori') ? 'border-slate-200 bg-white text-slate-600 hover:border-brand-300' : 'border-brand-600 bg-brand-600 text-white' }}">
                    Semua
                </a>
                @foreach ($categories as $category)
                    <a href="{{ route('documents.index', ['kategori' => $category]) }}"
                        class="rounded-full border px-4 py-1.5 text-sm font-medium transition {{ request('kategori') === $category ? 'border-brand-600 bg-brand-600 text-white' : 'border-slate-200 bg-white text-slate-600 hover:border-brand-300' }}">
                        {{ $category }}
                    </a>
                @endforeach
            </div>
        @endif

        @if ($documents->isNotEmpty())
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($documents as $document)
                    <article class="flex h-full flex-col rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:shadow-md">
                        <div class="flex items-start gap-4">
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-brand-50 text-brand-700">
                                <x-heroicon-o-document-text class="h-6 w-6" />
                            </span>
                            <div class="min-w-0">
                                @if ($document->category)
                                    <span class="text-xs font-semibold uppercase tracking-wide text-brand-600">{{ $document->category }}</span>
                                @endif
                                <h2 class="mt-1 text-sm font-semibold text-slate-900">{{ $document->title }}</h2>
                            </div>
                        </div>

                        @if ($document->description)
                            <p class="mt-3 flex-1 text-sm text-slate-500">{{ \Illuminate\Support\Str::limit(strip_tags($document->description), 120) }}</p>
                        @endif

                        <div class="mt-4 flex items-center justify-between">
                            <span class="text-xs text-slate-400">{{ strtoupper($document->file_type ?: 'FILE') }} &middot; {{ $document->file_size_for_humans }}</span>
                            <a href="{{ \Illuminate\Support\Facades\Storage::url($document->file) }}" target="_blank" rel="noopener noreferrer"
                                class="inline-flex items-center gap-1.5 text-sm font-semibold text-brand-700 transition hover:text-brand-800">
                                <x-heroicon-o-arrow-down-tray class="h-4 w-4" />
                                Unduh
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
            <div class="mt-10">
                {{ $documents->links() }}
            </div>
        @else
            <x-empty-state icon="document-text">Belum ada dokumen.</x-empty-state>
        @endif
    </div>
@endsection