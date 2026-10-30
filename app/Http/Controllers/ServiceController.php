<?php

namespace App\Http\Controllers;

use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::published()
            ->orderByDesc('featured')
            ->orderBy('name')
            ->get();

        return view('services.index', compact('services'));
    }

    public function show(string $slug)
    {
        $service = Service::published()->where('slug', $slug)->firstOrFail();

        $schedules = $service->schedules()->where('status', 'active')->get();

        return view('services.show', compact('service', 'schedules'));
    }
}
