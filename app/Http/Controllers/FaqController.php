<?php

namespace App\Http\Controllers;

use App\Models\Faq;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::published()->orderBy('sort_order')->get()->groupBy('category');

        return view('faqs.index', compact('faqs'));
    }
}
