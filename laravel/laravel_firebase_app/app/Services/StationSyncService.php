<?php

namespace App\Services;

use App\Models\Station;
use Illuminate\Support\Facades\Http;

class StationSyncService
{
    private string $stationsUrl =
        'https://lotusinfotech.co.in/uhfnew/data/stations.json';

    public function sync(): int
    {
        // Get stations from API
        $response = Http::timeout(10)->get($this->stationsUrl);

        if (! $response->successful()) {
            throw new \Exception('Unable to fetch stations.');
        }

        $stations = $response->json();

        if (! is_array($stations)) {
            throw new \Exception('Invalid station API response.');
        }

        // If no stations are received, stop the sync
        if (empty($stations)) {
            throw new \Exception('No stations received.');
        }

        // Step 1: Mark all old stations as inactive
        Station::query()->update(['status' => false]);

        $synced = 0;

        // Step 2: Add new stations or update existing ones
        foreach ($stations as $station) {

            if (
                ! isset($station['id']) ||
                ! isset($station['name']) ||
                ! isset($station['latitude']) ||
                ! isset($station['longitude'])
            ) {
                continue;
            }

            Station::updateOrCreate(
                [
                    'station_id' => strtolower(trim($station['id'])),
                ],
                [
                    'name' => $station['name'],
                    'state' => $station['state'] ?? null,
                    'latitude' => (float) $station['latitude'],
                    'longitude' => (float) $station['longitude'],
                    'status' => true,
                ]
            );

            $synced++;
        }

        return $synced;
    }
}
