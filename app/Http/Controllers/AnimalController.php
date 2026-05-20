<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Habitat;
use App\Models\Species;
use Illuminate\Http\Request;

class AnimalController extends Controller
{
    public function index(Request $request)
    {
        return view('animals.index');
    }

    public function show(Animal $animal)
    {
        $animal->load(['species', 'enclosure.habitat', 'images', 'feedingSchedules', 'reviews.user']);

        $relatedAnimals = Animal::where('species_id', $animal->species_id)
            ->where('id', '!=', $animal->id)
            ->take(3)
            ->get();

        return view('animals.show', compact('animal', 'relatedAnimals'));
    }
}
