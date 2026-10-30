<!DOCTYPE html>
<html lang="id" class="scroll-pt-24">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('puskesmas.name'))</title>
    <meta name="description" content="@yield('meta_description', config('puskesmas.description'))">
    <link rel="canonical" href="{{ url()->current() }}">

    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:site_name" content="{{ config('puskesmas.name') }}">
    <meta property="og:title" content="@yield('title', config('puskesmas.name'))">
    <meta property="og:description" content="@yield('meta_description', config('puskesmas.description'))">
    <meta property="og:url" content="{{ url()->current() }}">
    @hasSection('og_image')
        <meta property="og:image" content="@yield('og_image')">
    @endif

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', config('puskesmas.name'))">
    <meta name="twitter:description" content="@yield('meta_description', config('puskesmas.description'))">

    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">

    @stack('structured_data')

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 font-sans text-slate-700 antialiased">
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-50 focus:rounded-lg focus:bg-brand-700 focus:px-4 focus:py-2 focus:text-white">
        Lewati ke konten utama
    </a>

    @include('partials.header')

    <main id="main-content">
        @yield('content')
    </main>

    @include('partials.footer')
</body>
</html>