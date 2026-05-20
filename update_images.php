<?php
$file = __DIR__ . '/storage/app/data/fishes.json';
$json = json_decode(file_get_contents($file), true);

foreach($json as &$fish) {
    echo "Fetching for {$fish['name']}...\n";
    $searchName = $fish['name'];
    if ($searchName === 'Betta') $searchName = 'Siamese fighting fish';
    if ($searchName === 'Grouper') $searchName = 'Epinephelinae'; // more specific
    
    $url = 'https://en.wikipedia.org/api/rest_v1/page/summary/' . urlencode($searchName);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, 'ZootopiaBot/1.0');
    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if($httpcode == 200) {
        $data = json_decode($response, true);
        if(isset($data['thumbnail']['source'])) {
            $fish['image'] = $data['thumbnail']['source'];
            echo "Found image!\n";
        } else {
            $fish['image'] = 'https://images.unsplash.com/photo-1524704796725-9fc3044a58b2?q=80&w=800&auto=format&fit=crop';
            echo "No thumbnail found.\n";
        }
    } else {
        $fish['image'] = 'https://images.unsplash.com/photo-1524704796725-9fc3044a58b2?q=80&w=800&auto=format&fit=crop';
        echo "HTTP error $httpcode\n";
    }
    
    // be nice to Wikipedia
    usleep(100000); 
}

file_put_contents($file, json_encode($json, JSON_PRETTY_PRINT));
echo "Done.\n";
