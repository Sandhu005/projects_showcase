<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class WeatherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stations = Http::get('location_url');
        $stationResponse = $stations->json();

        return view('weather.index', compact('stationResponse'));
    }


    public function getWeather($location)
    {
        try {

            $url = "url/{$location}.json";

            // Check cache first
            $data = Cache::get("weather_{$location}");

            // If not in cache, get it from the URL
            if (!$data) {

                $response = Http::get($url);

                if (!$response->successful()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Unable to get weather data.'
                    ], 500);
                }

                $data = $response->json();

                // Save data in cache for 10 minutes
                Cache::put(
                    "weather_{$location}",
                    $data,
                    now()->addMinutes(10)
                );
            }

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function getGddData($location)
    {
        try {

            $url = "gdd_url.json";

            // Check cache first
            $data = Cache::get('daily_gdd_data');

            // If not in cache, get it from the URL
            if (!$data) {

                $response = Http::get($url);

                if (!$response->successful()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Unable to get GDD data.'
                    ], 500);
                }

                $data = $response->json();

                // Save data in cache for 10 minutes
                Cache::put(
                    'daily_gdd_data',
                    $data,
                    now()->addMinutes(10)
                );
            }

            // Get selected location
            $gddData = $data[$location] ?? null;

            if (!$gddData) {
                return response()->json([
                    'success' => false,
                    'message' => 'GDD data not found for this location.'
                ], 404);
            }

            // Get today's date
            $today = now()->format('Y-m-d');

            // Find today's record
            $todayRecord = collect($gddData['records'] ?? [])
                ->firstWhere('date', $today);

            if (!$todayRecord) {
                return response()->json([
                    'success' => false,
                    'message' => "Today's GDD data is not available."
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'station_name' => $gddData['station_name'] ?? null,
                    'records' => [$todayRecord]
                ]
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
