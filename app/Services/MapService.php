<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class MapService
{
    public function searchRestaurants($search)
    {
        $apiKey = env('GOOGLE_MAPS_API_KEY');
        $baseUrl = 'https://maps.googleapis.com/maps/api/place';

        $searchResponse = Http::get("$baseUrl/textsearch/json", [
            'query' => 'restaurants in ' . $search,
            'key' => $apiKey,
        ]);

        return $searchResponse->json()['results'];
    }
}
