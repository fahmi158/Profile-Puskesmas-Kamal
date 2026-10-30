<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Announcement;
use App\Models\Event;
use App\Models\News;
use App\Models\Service;

class HomeController extends Controller
{
    public function index()
    {
        $announcements = Announcement::query()
            ->where('is_active', true)
            ->where('status', 'published')
            ->where(function ($query) {
                $query->whereNull('starts_at')->orWhere('starts_at', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('ends_at')->orWhere('ends_at', '>=', now());
            })
            ->orderByDesc('priority')
            ->latest()
            ->take(5)
            ->get();

        $news = News::query()
            ->where('status', 'published')
            ->with('user')
            ->orderByDesc('is_featured')
            ->latest('published_at')
            ->take(6)
            ->get();

        $events = Event::query()
            ->where('status', 'published')
            ->orderBy('event_date')
            ->take(6)
            ->get();

        $albums = Album::query()
            ->where('status', 'published')
            ->latest()
            ->take(4)
            ->get();

        $services = Service::query()
            ->where('status', 'published')
            ->where('featured', true)
            ->take(6)
            ->get();

        return view('home', compact('announcements', 'news', 'events', 'albums', 'services'));
    }
}
