<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class ExplorerController extends Controller
{
    public function animals(Request $request)
    {
        return $this->exploreJson($request, 'animals.json', 'Virtual Zoo', 'Explore our incredible wildlife.');
    }

    public function flowers(Request $request)
    {
        return $this->exploreJson($request, 'flowers.json', 'Virtual Botanical Garden', 'Discover beautiful and exotic flowers from around the world.');
    }

    public function showAnimal($slug)
    {
        return $this->showJsonItem('animals.json', $slug, 'animals.index');
    }

    public function showFlower($slug)
    {
        return $this->showJsonItem('flowers.json', $slug, 'flowers.index');
    }

    public function aquarium(Request $request)
    {
        $path = storage_path('app/data/fishes.json');
        $fishes = File::exists($path) ? json_decode(File::get($path), true) : [];
        
        // Use pre-fetched images
        foreach ($fishes as &$fish) {
            $fish['pexels_image'] = $fish['image'] ?? $this->getPexelsImage($fish);
        }

        return view('aquarium', compact('fishes'));
    }

    public function showFish($slug)
    {
        return $this->showJsonItem('fishes.json', $slug, 'aquarium');
    }

    public function tour()
    {
        $tourItems = $this->getRandomTourBatch(10, []);
        return view('tour', compact('tourItems'));
    }

    /**
     * AJAX endpoint for infinite scroll.
     * GET /tour/more?exclude=slug1,slug2,...&count=8
     * Returns JSON array of rendered HTML slide strings.
     */
    public function tourMore(Request $request)
    {
        $exclude = array_filter(explode(',', $request->input('exclude', '')));
        $count   = min((int) $request->input('count', 8), 15);

        $items = $this->getRandomTourBatch($count, $exclude);

        // Return only the data needed to build slides on the client
        $slides = array_map(fn($item) => [
            'slug'                => $item['slug'],
            'name'                => $item['name'],
            '_type'               => $item['_type'],
            'scientific_name'     => $item['scientific_name'] ?? ($item['species']['name'] ?? null),
            'description'         => $item['description'] ?? '',
            'conservation_status' => $item['conservation_status'] ?? null,
            'pexels_image'        => $item['pexels_image'],
            'wiki'                => $item['wiki'],
            'continent'           => $item['continent'] ?? null,
            'bloom_season'        => $item['bloom_season'] ?? null,
            'native_to'           => $item['native_to'] ?? null,
            'weight_kg'           => $item['animal_facts']['weight_kg'] ?? null,
            'lifespan_years'      => $item['animal_facts']['lifespan_years'] ?? null,
        ], $items);

        return response()->json($slides);
    }

    /**
     * Shared helper: load all items, tag them, exclude already-seen slugs,
     * shuffle, and enrich with Pexels + Wikipedia.
     * Reads fresh from disk each time — so adding new JSON entries is instant.
     */
    private function getRandomTourBatch(int $count, array $exclude): array
    {
        $animalsPath = storage_path('app/data/animals.json');
        $flowersPath = storage_path('app/data/flowers.json');

        $animals = File::exists($animalsPath) ? json_decode(File::get($animalsPath), true) : [];
        $flowers = File::exists($flowersPath) ? json_decode(File::get($flowersPath), true) : [];

        foreach ($animals as &$a) { $a['_type'] = 'animal'; }
        foreach ($flowers as &$f) { $f['_type'] = 'flower'; }

        $all = array_merge($animals, $flowers);

        // Filter out already-seen slugs
        if (!empty($exclude)) {
            $all = array_filter($all, fn($i) => !in_array($i['slug'], $exclude));
        }

        // If we've seen everything, reset (loop back over all items)
        if (count($all) === 0) {
            foreach ($animals as &$a) { $a['_type'] = 'animal'; }
            foreach ($flowers as &$f) { $f['_type'] = 'flower'; }
            $all = array_merge($animals, $flowers);
        }

        shuffle($all);
        $batch = array_slice($all, 0, $count);

        foreach ($batch as &$item) {
            $item['pexels_image'] = $item['image'] ?? $this->getPexelsImage($item);
            $item['wiki']         = $this->getWikipediaData($item['name']);
        }

        return $batch;
    }

    private function getWikipediaData(string $name): array
    {
        return [
            'extract' => "This is a detailed description of the {$name}. It is a fascinating species found in various habitats around the world.",
            'thumbnail' => null,
            'url' => '#',
            'title' => $name
        ];
    }

    private function showJsonItem($filename, $slug, $backRoute)
    {
        $path = storage_path('app/data/' . $filename);
        if (!File::exists($path)) {
            abort(404, "Data file not found.");
        }

        $data = json_decode(File::get($path), true);
        if (!is_array($data)) {
            abort(404, "Data file corrupted.");
        }

        $item = collect($data)->firstWhere('slug', $slug);
        
        if (!$item) {
            abort(404, "Item not found.");
        }
        
        $item['pexels_image'] = $item['image'] ?? $this->getPexelsImage($item);
        $item['wiki']         = $this->getWikipediaData($item['name']);

        return view('explore-show', compact('item', 'backRoute'));
    }

    private function exploreJson(Request $request, $filename, $title, $description)
    {
        $path = storage_path('app/data/' . $filename);
        if (!File::exists($path)) {
            abort(404, "Data file not found.");
        }

        $data = json_decode(File::get($path), true);
        if (!is_array($data)) {
            $data = [];
        }
        
        // Handle search
        $query = $request->input('search');
        if ($query) {
            $data = array_filter($data, function($item) use ($query) {
                return stripos($item['name'], $query) !== false || stripos($item['description'], $query) !== false;
            });
        }

        // Pagination
        $page = (int) $request->input('page', 1);
        $perPage = 12;
        $offset = ($page - 1) * $perPage;
        
        $items = array_slice($data, $offset, $perPage);
        
        // Use pre-fetched images or fallback
        foreach ($items as &$item) {
            $item['pexels_image'] = $item['image'] ?? $this->getPexelsImage($item);
        }

        $paginator = new LengthAwarePaginator(
            $items,
            count($data),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );
        $paginator->fragment('explore-grid');

        return view('explore', compact('paginator', 'title', 'description', 'query'));
    }

    private function getPexelsImage($item)
    {
        $images = [
            'fish' => [
                'https://images.unsplash.com/photo-1524704796725-9fc3044a58b2?q=80&w=800&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1544551763-46a013bb70d5?q=80&w=800&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1513475143360-1594917f2231?q=80&w=800&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1522069169874-c58ec4b76be5?q=80&w=800&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1524704654690-b56c05c78a00?q=80&w=800&auto=format&fit=crop',
            ],
            'animal' => [
                'https://images.unsplash.com/photo-1543946207-39fdc172bc13?q=80&w=800&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1474511320723-9a56873867b5?q=80&w=800&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1456926631375-92c8ce872def?q=80&w=800&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1503066211613-c17ebc9daef0?q=80&w=800&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1534567153574-2b12153a87f0?q=80&w=800&auto=format&fit=crop',
            ],
            'flower' => [
                'https://images.unsplash.com/photo-1490750967868-88cb4ecb0701?q=80&w=800&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1462275646964-a0e3386b89fa?q=80&w=800&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1465146344425-f00d5f3c8f07?q=80&w=800&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1457089328109-e5d9bd499191?q=80&w=800&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1470509037663-253afd7f0f51?q=80&w=800&auto=format&fit=crop',
            ]
        ];

        $category = isset($item['category']) ? strtolower($item['category']) : 'animal';
        $type = str_contains($category, 'flower') ? 'flower' : (str_contains($category, 'fish') ? 'fish' : 'animal');
        
        $index = abs(crc32($item['name'])) % count($images[$type]);
        return $images[$type][$index];
    }
}
