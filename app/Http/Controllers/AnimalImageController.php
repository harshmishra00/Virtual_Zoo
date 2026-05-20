<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AnimalImageController extends Controller
{
    public function index()
    {
        $query = request('animal');

        if (empty($query)) {
            // Pick a random animal if no search query is provided
            $randomAnimals = ['wildlife', 'safari', 'zoo animals', 'tiger', 'elephant', 'fox', 'panda', 'zebra', 'giraffe', 'penguin', 'koala', 'sloth', 'cheetah'];
            $query = $randomAnimals[array_rand($randomAnimals)];
        }

        $response = Http::withHeaders([
            'Authorization' => config('services.pexels.key'),
        ])->get('https://api.pexels.com/v1/search', [
            'query' => $query,
            'per_page' => 12,
            // Add a random page number (1-10) to get different results even for the same random keyword
            'page' => rand(1, 10),
        ]);

        $images = $response->json()['photos'] ?? [];
        $displayQuery = request('animal');

        return view('animals', compact('images', 'query', 'displayQuery'));
    }
}
