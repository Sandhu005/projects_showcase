<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WeatherService
{
    private string $stationsUrl = '';

    private string $predictionBaseUrl = '';

    private string $gddUrl = '';


    /**
     * Get weather data for a latitude/longitude.
     */
    public function getWeatherData(
        float $latitude,
        float $longitude
    ): ?array {

        // Find nearest station within 50 KM
        $nearest = $this->getNearestStation(
            $latitude,
            $longitude
        );

        if (!$nearest) {
            return null;
        }

        $station = $nearest['station'];

        // Station ID
        $stationID = strtolower($station['id']);

        // Prediction URL
        $url = $this->predictionBaseUrl . $stationID . '.json';

        $response = Http::timeout(10)->get($url);

        if (!$response->successful()) {
            return null;
        }

        return [
            'station' => $station,
            'station_id' => $stationID,
            'distance_km' => $nearest['distance_km'],
            'weather' => $response->json(),
        ];
    }


    /**
     * Get GDD data for a particular station.
     */
    public function getGddData(string $stationId): ?array
    {
        $response = Http::timeout(10)->get($this->gddUrl);

        if (!$response->successful()) {
            return null;
        }

        $data = $response->json();

        if (!is_array($data)) {
            return null;
        }

        return $data[$stationId] ?? null;
    }


    /**
     * Find nearest station within 50 KM.
     */
    public function getNearestStation(
        float $latitude,
        float $longitude
    ): ?array {

        $response = Http::timeout(10)->get(
            $this->stationsUrl
        );

        if (!$response->successful()) {
            return null;
        }

        $stations = $response->json();

        if (!is_array($stations)) {
            return null;
        }

        $nearestStation = null;
        $nearestDistance = PHP_FLOAT_MAX;

        foreach ($stations as $station) {

            if (
                !isset($station['latitude']) ||
                !isset($station['longitude'])
            ) {
                continue;
            }

            $stationLatitude = (float) $station['latitude'];
            $stationLongitude = (float) $station['longitude'];

            $distance = $this->calculateDistance(
                $latitude,
                $longitude,
                $stationLatitude,
                $stationLongitude
            );

            if ($distance < $nearestDistance) {
                $nearestDistance = $distance;
                $nearestStation = $station;
            }
        }

        if (!$nearestStation) {
            return null;
        }

        // More than 50 KM
        if ($nearestDistance > 50) {
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
}
