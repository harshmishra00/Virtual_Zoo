<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use App\Models\FeedingSchedule;
use App\Http\Resources\AnimalResource;
use Illuminate\Http\Request;

class AnimalApiController extends Controller
{
    public function index(Request $request)
    {
        $animals = Animal::with(['species', 'enclosure.habitat'])
            ->when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%"))
            ->when($request->status, fn($q) => $q->where('conservation_status', $request->status))
            ->paginate(20);

        return AnimalResource::collection($animals);
    }

    public function show(Animal $animal)
    {
        $animal->load(['species', 'enclosure.habitat', 'feedingSchedules']);
        return new AnimalResource($animal);
    }

    public function schedules()
    {
        $schedules = FeedingSchedule::with('animal')
            ->orderBy('feed_time')
            ->get()
            ->map(fn($s) => [
                'id'          => $s->id,
                'animal'      => $s->animal->name,
                'feed_time'   => $s->feed_time,
                'food_type'   => $s->food_type,
                'quantity_kg' => $s->quantity_kg,
                'period'      => $s->period,
            ]);

        return response()->json(['data' => $schedules]);
    }
}
