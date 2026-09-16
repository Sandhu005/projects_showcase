<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\FarmerService;
use App\Services\WeatherService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{

    public function __construct(
        protected WeatherService $weatherService,
        protected FarmerService $farmers,
    ) {}

    public function index(){
       //
    }

    public function weatherByLocation(string $location){
        $url = 'location_url'.$location.'.json';
        $response = Http::get($url);

        if ($response->successful()) {
            return response()->json($response->json());
        } else {
            return response()->json(['error' => 'Weather data not found for the specified location.'], 404);
        }
    }

    public function userWeatherData()
    {
        $farmerId = auth('api')->id();
        $location = $this->farmers->getLocation($farmerId);

        if(!$location || !isset($location['lat']) || !isset($location['lng'])) {
            return response()->json([
                'error' => 'location_not_set',
                'message' => 'Location not set for the authenticated user.',
            ], 404);
        }

        $weather = $this->weatherService->getWeatherData(
            (float) $location['lat'],
            (float) $location['lng']
        );

        if (!$weather) {
            return response()->json([
                'error' => 'weather_data_not_found',
                'message' => 'Weather data not found for the specified location.',
            ], 404);
        }

        $stationId = $weather['station_id'] ?? null;

        $gdd = $this->weatherService->getGddData($stationId);

        return response()->json([
            'weather' => $weather,
            'gdd' => $gdd,
        ]);
    }
}
