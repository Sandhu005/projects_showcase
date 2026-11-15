<?php

namespace App\Http\Controllers;

use App\Models\Station;
use App\Services\WeatherService;

class WeatherController extends Controller
{
    public function __construct(
        private WeatherService $weatherService
    ) {}

    public function index()
    {
        $stations = Station::where([['status', true], ['state', 'Himachal Pradesh']])->get();

        return view('weather.index', compact('stations'));
    }

    public function getWeather(string $location)
    {
        try {
            $weather = $this->weatherService->getWeatherByLocation($location);

            if (! $weather) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unable to get weather data.',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $weather,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function getGddData(string $location)
    {
        try {
            $gddData = $this->weatherService->getGddData($location);

            if (! $gddData) {
                return response()->json([
                    'success' => false,
                    'message' => 'GDD data not found for this location.',
                ], 404);
            }

            $today = now()->format('Y-m-d');

            $todayRecord = collect($gddData['records'] ?? [])
                ->firstWhere('date', $today);

            if (! $todayRecord) {
                return response()->json([
                    'success' => false,
                    'message' => "Today's GDD data is not available.",
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'station_name' => $gddData['station_name'] ?? null,
                    'records' => [$todayRecord],
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
