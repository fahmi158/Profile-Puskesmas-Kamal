<?php

namespace App\Http\Controllers;

use App\Models\Album;

class AlbumController extends Controller
{
    public function index()
    {
        $albums = Album::published()
            ->withCount('photos')
            ->orderByDesc('event_date')
            ->latest()
            ->paginate(12);

        $categories = Album::published()
            ->whereNotNull('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('albums.index', compact('albums', 'categories'));
    }

    public function show(string $slug)
    {
        $album = Album::published()
            ->with(['photos' => fn ($query) => $query->orderBy('sort_order')])
            ->where('slug', $slug)
            ->firstOrFail();

        return view('albums.show', compact('album'));
    }
}
