<?php

namespace App\Http\Controllers;

use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        $upcoming = Event::published()
            ->upcoming()
            ->orderBy('event_date')
            ->get();

        $past = Event::published()
            ->where('event_date', '<', now()->toDateString())
            ->orderByDesc('event_date')
            ->paginate(9);

        return view('events.index', compact('upcoming', 'past'));
    }

    public function show(string $slug)
    {
        $event = Event::published()->where('slug', $slug)->firstOrFail();

        $related = Event::published()
            ->where('id', '!=', $event->id)
            ->orderBy('event_date')
            ->take(3)
            ->get();

        return view('events.show', compact('event', 'related'));
    }
}
