@extends('layouts.app')

@section('title', 'FAQ - ' . config('puskesmas.name'))
@section('meta_description', 'Pertanyaan yang sering diajukan tentang layanan ' . config('puskesmas.name'))

@section('content')
    <x-page-header title="Pertanyaan yang Sering Diajukan" subtitle="Temukan jawaban atas pertanyaan umum seputar layanan kami."
        :breadcrumbs="['FAQ' => null]" />

    <div class="mx-auto max-w-3xl px-4 py-12 sm:px-6 lg:px-8">
        @if ($faqs->isNotEmpty())
            @foreach ($faqs as $category => $items)
                <div class="mb-10">
                    @if ($category)
                        <h2 class="mb-4 text-lg font-bold text-slate-900">{{ $category }}</h2>
                    @endif

                    <div class="space-y-3" x-data="{ open: null }">
                        @foreach ($items as $faq)
                            <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">
                                <button type="button"
                                    class="flex w-full items-center justify-between gap-4 px-5 py-4 text-left text-sm font-semibold text-slate-800 transition hover:bg-slate-50"
                                    @click="open = open === {{ $faq->id }} ? null : {{ $faq->id }}" :aria-expanded="open === {{ $faq->id }}">
                                    {{ $faq->question }}
                                    <x-heroicon-m-chevron-down class="h-5 w-5 shrink-0 text-brand-600 transition" ::class="open === {{ $faq->id }} && 'rotate-180'" />
                                </button>
                                <div x-show="open === {{ $faq->id }}" x-cloak x-transition class="border-t border-slate-100 px-5 py-4">
                                    <div class="prose prose-sm max-w-none text-slate-600">{!! $faq->answer !!}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @else
            <x-empty-state icon="question-mark-circle">Belum ada FAQ.</x-empty-state>
        @endif
    </div>
@endsection