<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$file = __DIR__ . '/storage/app/data/fishes.json';
$json = json_decode(file_get_contents($file), true);

$apiKey = env('PEXELS_API_KEY');

foreach($json as &$fish) {
    echo "Fetching for {$fish['name']}...\n";
    $searchName = $fish['name'] . ' fish underwater';
    
    $url = 'https://api.pexels.com/v1/search?query=' . urlencode($searchName) . '&per_page=1&orientation=landscape';
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: ' . $apiKey
    ]);
    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    if($httpcode == 200) {
        $data = json_decode($response, true);
        if(isset($data['photos'][0]['src']['large'])) {
            $fish['image'] = $data['photos'][0]['src']['large'];
            echo "Found image!\n";
        } else {
            $fish['image'] = 'https://images.unsplash.com/photo-1524704796725-9fc3044a58b2?q=80&w=800&auto=format&fit=crop';
            echo "No thumbnail found.\n";
        }
    } else {
        $fish['image'] = 'https://images.unsplash.com/photo-1524704796725-9fc3044a58b2?q=80&w=800&auto=format&fit=crop';
        echo "HTTP error $httpcode\n";
    }
    
    usleep(500000); 
}

file_put_contents($file, json_encode($json, JSON_PRETTY_PRINT));
echo "Done.\n";
