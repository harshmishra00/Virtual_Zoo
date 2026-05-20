<?php

namespace App\Http\Controllers;

use App\Models\FeedingSchedule;
use App\Models\Habitat;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $query = FeedingSchedule::with(['animal.enclosure.habitat'])
            ->orderBy('feed_time');

        if ($request->filled('habitat')) {
            $query->whereHas('animal.enclosure.habitat', fn($q) => $q->where('id', $request->habitat));
        }

        $schedules = $query->get()->groupBy(function ($s) {
            $hour = (int) substr($s->feed_time, 0, 2);
            if ($hour < 12) return 'Morning';
            if ($hour < 17) return 'Afternoon';
            return 'Evening';
        });

        $habitats = Habitat::all();
        $nextFeed = FeedingSchedule::with('animal')
            ->where('feed_time', '>=', now()->format('H:i:s'))
            ->orderBy('feed_time')
            ->first();

        return view('schedule.index', compact('schedules', 'habitats', 'nextFeed'));
    }
}
