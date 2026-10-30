<?php

namespace App\Http\Controllers;

use App\Models\Video;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::published()
            ->orderByDesc('published_at')
            ->paginate(12);

        return view('videos.index', compact('videos'));
    }

    public function show(string $slug)
    {
        $video = Video::published()->where('slug', $slug)->firstOrFail();

        $related = Video::published()
            ->where('id', '!=', $video->id)
            ->latest('published_at')
            ->take(4)
            ->get();

        return view('videos.show', compact('video', 'related'));
    }
}
