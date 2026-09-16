<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LocationController extends Controller
{
    public function popular()
    {
        $response = Http::get('https://lotusinfotech.co.in/uhfnew/data/stations.json');
        return $response->json();
    }

    public function search(Request $request)
    {
        $city = $request->query('city');

        $response = Http::get('https://lotusinfotech.co.in/uhfnew/data/stations.json');
        $locations = $response->json();

        $results = collect($locations)->filter(function ($location) use ($city) {
            $name = strtolower(trim($location['name'] ?? ''));
            $city = strtolower($city);
            return str_contains($name, $city);
        })->values();

        return response()->json([
            'items' => $results,
        ]);
    }
}
