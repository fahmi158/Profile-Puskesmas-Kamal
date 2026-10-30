<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $query = Document::published()->latest('published_at');

        if ($request->filled('kategori')) {
            $query->where('category', $request->input('kategori'));
        }

        $documents = $query->paginate(12)->withQueryString();

        $categories = Document::published()
            ->whereNotNull('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('documents.index', compact('documents', 'categories'));
    }
}
