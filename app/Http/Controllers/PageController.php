<?php

namespace App\Http\Controllers;

use App\Models\Page;

class PageController extends Controller
{
    public function profil()
    {
        $pages = Page::published()->get()->keyBy('slug');

        return view('pages.profil', compact('pages'));
    }

    public function show(string $slug)
    {
        $page = Page::published()->where('slug', $slug)->firstOrFail();

        return view('pages.show', compact('page'));
    }
}
