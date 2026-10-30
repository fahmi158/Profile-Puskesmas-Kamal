@extends('layouts.app')

@section('title', $page->title . ' - ' . config('puskesmas.name'))
@section('meta_description', $page->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($page->content), 150))

@section('content')
    <x-page-header :title="$page->title" :subtitle="$page->excerpt"
        :breadcrumbs="['Profil' => route('profil.index'), $page->title => null]" />

    <div class="mx-auto grid max-w-7xl gap-10 px-4 py-12 sm:px-6 lg:grid-cols-4 lg:px-8">
        <aside class="lg:col-span-1">
            <div class="rounded-2xl border border-slate-200 bg-white p-4">
                <x-profil-nav :active="$page->slug" />
            </div>
        </aside>

        <div class="lg:col-span-3">
            <div class="prose prose-slate max-w-none">
                {!! $page->content !!}
            </div>
        </div>
    </div>
@endsection