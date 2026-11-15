<?php

namespace App\Services;

use App\Models\Station;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class WeatherService
{
    private string $predictionBaseUrl =
        'https://lotusinfotech.co.in/uhfnew/data/predictions/';

    private string $gddUrl =
        'https://lotusinfotech.co.in/uhfnew/data/daily_gdd_data.json';

    /**
     * Get weather data for latitude/longitude.
     * Used by mobile API.
     */
    public function getWeatherData(
        float $latitude,
        float $longitude
    ): ?array {

        $latitude = round($latitude, 2);
        $longitude = round($longitude, 2);

        $cacheKey = 'weather:'.$latitude.':'.$longitude;

        $cachedWeather = Cache::get($cacheKey);

        if ($cachedWeather !== null) {
            return $cachedWeather;
        }

        $nearest = $this->getNearestStation(
            $latitude,
            $longitude
        );

        if (! $nearest) {
            return null;
        }

        $station = $nearest['station'];

        $stationId = strtolower($station->station_id);

        $weather = $this->getWeatherByStation($stationId);

        if (! $weather) {
            return null;
        }

        $image = $this->getWeatherImage($weather);

        $data = [
            'station' => $station->name,
            'station_id' => $stationId,
            'distance_km' => $nearest['distance_km'],
            'image' => $image,
            'weather_data' => $weather,
        ];

        Cache::put(
            $cacheKey,
            $data,
            now()->addMinutes(30)
        );

        return $data;
    }

    /**
     * Get weather data by station/location.
     * Used by admin panel.
     */
    public function getWeatherByLocation(string $location): ?array
    {
        $location = strtolower($location);

        $cacheKey = 'weather:location:'.$location;

        $cachedWeather = Cache::get($cacheKey);

        if ($cachedWeather !== null) {
            return $cachedWeather;
        }

        $weather = $this->getWeatherByStation($location);

        if (! $weather) {
            return null;
        }

        Cache::put(
            $cacheKey,
            $weather,
            now()->addMinutes(30)
        );

        return $weather;
    }

    /**
     * Get weather prediction from external API.
     */
    private function getWeatherByStation(string $stationId): ?array
    {
        $stationId = strtolower($stationId);

        $url = $this->predictionBaseUrl.$stationId.'.json';

        $response = Http::timeout(10)->get($url);

        if (! $response->successful()) {
            return null;
        }

        $data = $response->json();

        return $data['predictions'] ?? null;
    }

    /**
     * Get GDD data for a station.
     */
    public function getGddData(string $stationId): ?array
    {
        $stationId = strtolower($stationId);

        // Cache the entire GDD dataset.
        $cacheKey = 'gdd:all';

        $data = Cache::get($cacheKey);

        if ($data === null) {
            $response = Http::timeout(10)->get($this->gddUrl);

            if (! $response->successful()) {
                return null;
            }

            $data = $response->json();

            if (! is_array($data)) {
                return null;
            }

            Cache::put(
                $cacheKey,
                $data,
                now()->addMinutes(30)
            );
        }

        $stationData = $data[$stationId] ?? null;

        if (! is_array($stationData)) {
            return null;
        }

        // Sort records by date: today -> future dates
        $stationData['records'] = array_reverse($stationData['records']);

        return $stationData;
    }

    /**
     * Find nearest station within 50 KM.
     */
    public function getNearestStation(
        float $latitude,
        float $longitude
    ): ?array {

        $stations = Station::where([
            ['status', true],
            ['state', 'Himachal Pradesh'],
        ])->get();

        if ($stations->isEmpty()) {
            return null;
        }

        $nearestStation = null;
        $nearestDistance = PHP_FLOAT_MAX;

        foreach ($stations as $station) {

            $distance = $this->calculateDistance(
                $latitude,
                $longitude,
                (float) $station->latitude,
                (float) $station->longitude
            );

            if ($distance < $nearestDistance) {
                $nearestDistance = $distance;
                $nearestStation = $station;
            }
        }

        if (! $nearestStation || $nearestDistance > 50) {
            return null;
        }

        return [
            'station' => $nearestStation,
            'distance_km' => round($nearestDistance, 2),
        ];
    }

    /**
     * Calculate distance between two coordinates.
     */
    private function calculateDistance(
        float $lat1,
        float $lon1,
        float $lat2,
        float $lon2
    ): float {

        $earthRadius = 6371;

        $latDifference = deg2rad($lat2 - $lat1);
        $lonDifference = deg2rad($lon2 - $lon1);

        $a =
            sin($latDifference / 2) ** 2 +
            cos(deg2rad($lat1)) *
            cos(deg2rad($lat2)) *
            sin($lonDifference / 2) ** 2;

        $c = 2 * atan2(
            sqrt($a),
            sqrt(1 - $a)
        );

        return $earthRadius * $c;
    }

    public function getWeatherImage(array $weather): string
    {
        $tp = $weather['variables']['tp'] ?? 0;
        $tcc = $weather['variables']['tcc'] ?? 0;

        if ($tp > 0.1) {
            return 'images/weather/rainy.jpg';
        } elseif ($tcc >= 0.75) {
            return 'images/weather/cloudy.jpg';
        } elseif ($tcc >= 0.5) {
            return 'images/weather/partial-cloudy.jpg';
        } else {
            return 'images/weather/sunny.jpg';
        }
    }
}
