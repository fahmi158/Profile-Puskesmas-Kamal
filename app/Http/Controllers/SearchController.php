<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Document;
use App\Models\Event;
use App\Models\Faq;
use App\Models\News;
use App\Models\Service;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = trim((string) $request->input('q', ''));

        $results = collect();

        if ($query !== '') {
            $results = collect([
                'Berita' => News::published()
                    ->where(fn ($builder) => $builder
                        ->where('title', 'like', "%{$query}%")
                        ->orWhere('content', 'like', "%{$query}%"))
                    ->latest('published_at')->take(5)->get(),
                'Agenda' => Event::published()
                    ->where(fn ($builder) => $builder
                        ->where('title', 'like', "%{$query}%")
                        ->orWhere('description', 'like', "%{$query}%"))
                    ->orderBy('event_date')->take(5)->get(),
                'Dokumentasi' => Album::published()
                    ->where('title', 'like', "%{$query}%")
                    ->latest()->take(5)->get(),
                'Dokumen' => Document::published()
                    ->where('title', 'like', "%{$query}%")
                    ->latest()->take(5)->get(),
                'Layanan' => Service::published()
                    ->where(fn ($builder) => $builder
                        ->where('name', 'like', "%{$query}%")
                        ->orWhere('description', 'like', "%{$query}%"))
                    ->take(5)->get(),
                'FAQ' => Faq::published()
                    ->where(fn ($builder) => $builder
                        ->where('question', 'like', "%{$query}%")
                        ->orWhere('answer', 'like', "%{$query}%"))
                    ->take(5)->get(),
            ])->filter(fn ($items) => $items->isNotEmpty());
        }

        return view('search.index', compact('query', 'results'));
    }
}
