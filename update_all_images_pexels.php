<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$files = [
    [
        'path' => __DIR__ . '/storage/app/data/animals.json',
        'suffix' => ' animal wildlife'
    ],
    [
        'path' => __DIR__ . '/storage/app/data/flowers.json',
        'suffix' => ' flower close up'
    ]
];

$apiKey = env('PEXELS_API_KEY');

foreach($files as $fileInfo) {
    if (!file_exists($fileInfo['path'])) {
        echo "File {$fileInfo['path']} not found.\n";
        continue;
    }
    
    $json = json_decode(file_get_contents($fileInfo['path']), true);
    if (!is_array($json)) continue;

    echo "\nProcessing {$fileInfo['path']}...\n";

    foreach($json as &$item) {
        if (!empty($item['image'])) {
            echo "Skipping {$item['name']} (already has image)\n";
            // We can re-fetch if we want, but it's faster to skip if already accurate.
            // Wait, to be safe and ensure accuracy as requested, let's just fetch it anyway!
        }
        
        echo "Fetching for {$item['name']}...\n";
        $searchName = $item['name'] . $fileInfo['suffix'];
        
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
                $item['image'] = $data['photos'][0]['src']['large'];
                echo "Found image!\n";
            } else {
                echo "No thumbnail found.\n";
            }
        } else {
            echo "HTTP error $httpcode\n";
        }
        
        usleep(500000); // 500ms to stay within limits
    }

    file_put_contents($fileInfo['path'], json_encode($json, JSON_PRETTY_PRINT));
    echo "Saved {$fileInfo['path']}\n";
}

echo "Done.\n";
