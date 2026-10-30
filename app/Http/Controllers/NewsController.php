<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $query = News::published()->with('user')->latest('published_at');

        if ($request->filled('kategori')) {
            $query->where('category', $request->input('kategori'));
        }

        $news = $query->paginate(9)->withQueryString();

        $featured = News::published()
            ->with('user')
            ->orderByDesc('is_featured')
            ->latest('published_at')
            ->first();

        $categories = News::published()
            ->whereNotNull('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('news.index', compact('news', 'featured', 'categories'));
    }

    public function show(string $slug)
    {
        $article = News::published()->with('user')->where('slug', $slug)->firstOrFail();

        $related = News::published()
            ->where('id', '!=', $article->id)
            ->where('category', $article->category)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('news.show', compact('article', 'related'));
    }
}
