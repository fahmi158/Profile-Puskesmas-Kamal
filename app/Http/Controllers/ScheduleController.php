<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Service;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $query = Schedule::query()->where('status', 'active')->with('service');

        if ($request->filled('hari')) {
            $query->where('day', $request->input('hari'));
        }

        if ($request->filled('layanan')) {
            $query->where('service_id', $request->integer('layanan'));
        }

        $dayOrder = ['monday' => 1, 'tuesday' => 2, 'wednesday' => 3, 'thursday' => 4, 'friday' => 5, 'saturday' => 6, 'sunday' => 7];

        $schedules = $query->get()->sortBy(fn ($schedule) => $dayOrder[$schedule->day] ?? 99);

        $services = Service::published()->orderBy('name')->get();

        return view('schedules.index', compact('schedules', 'services'));
    }
}
