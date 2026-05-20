<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\FeedingSchedule;
use App\Models\Habitat;
use App\Models\Species;

class HomeController extends Controller
{
    public function index()
    {
        $featuredAnimals = Animal::with(['species', 'enclosure'])
            ->where('is_featured', true)
            ->take(6)
            ->get();

        $habitats = Habitat::withCount('animals')->get();

        $nextFeedings = FeedingSchedule::with('animal')
            ->orderBy('feed_time')
            ->take(3)
            ->get();

        $stats = [
            'animals'  => Animal::count(),
            'species'  => Species::count(),
        ];

        return view('home', compact('featuredAnimals', 'habitats', 'nextFeedings', 'stats'));
    }
}
