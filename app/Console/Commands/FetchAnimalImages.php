<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Animal;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FetchAnimalImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zoo:fetch-images {--key=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch animal images from Pexels API and attach them as thumbnails';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $apiKey = $this->option('key');
        
        if (!$apiKey) {
            $apiKey = env('PEXELS_API_KEY');
        }

        if (!$apiKey) {
            $this->error('Please provide a Pexels API key using --key=... or set PEXELS_API_KEY in .env');
            return;
        }

        $animals = Animal::with('species')->get();
        
        // Ensure directory exists
        if (!Storage::disk('public')->exists('animals')) {
            Storage::disk('public')->makeDirectory('animals');
        }

        foreach ($animals as $animal) {
            $query = $animal->name;
            $this->info("Fetching image for: {$animal->name} (Query: {$query})");

            $response = Http::withHeaders([
                'Authorization' => $apiKey
            ])->get('https://api.pexels.com/v1/search', [
                'query' => $query,
                'per_page' => 1,
                'orientation' => 'landscape'
            ]);

            if ($response->successful() && !empty($response->json('photos'))) {
                $photo = $response->json('photos')[0];
                // Prefer large format for thumbnails/hero images
                $imageUrl = $photo['src']['large'] ?? $photo['src']['original'];
                
                $imageContent = Http::get($imageUrl)->body();
                
                $filename = 'animals/' . Str::slug($animal->name . '-' . uniqid()) . '.jpg';
                
                Storage::disk('public')->put($filename, $imageContent);
                
                $animal->thumbnail = $filename;
                $animal->save();
                
                $this->info("✓ Saved image: {$filename}");
            } else {
                $this->warn("! No image found for: {$query}");
            }
            
            // Respect rate limits (Pexels is 200 req / hour)
            sleep(1);
        }
        
        $this->info('Done fetching all images!');
    }
}
