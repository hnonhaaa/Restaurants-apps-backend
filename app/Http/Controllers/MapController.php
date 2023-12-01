<?php

namespace App\Http\Controllers;

use App\Services\MapService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class MapController extends Controller
{
    private $mapService;
    public function __construct(
        MapService $mapService
    ) {
        $this->mapService = $mapService;
    }


    public function searchRestaurants($location)
    {
        if (Cache::has('historySearch')) {
            $arrayHistorySearch = Cache::get('historySearch');
        } else {
            $arrayHistorySearch = [];
        }

        if (!in_array(strtolower($location), array_map('strtolower', $arrayHistorySearch))) {
            $arrayHistorySearch[] = $location;
        }

        Cache::put('historySearch', $arrayHistorySearch);
        $results = $this->mapService->searchRestaurants($location);
        return response()->json([
            'success' => true,
            'result' => $results,
            'history' => Cache::get('historySearch')
        ]);
    }
}
