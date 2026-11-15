<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Station;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function popular()
    {
        return response()->json(
            Station::where([['status', true], ['state', 'Himachal Pradesh']])->get()
        );
    }

    public function search(Request $request)
    {
        $city = trim($request->query('city', ''));

        if ($city === '') {
            return response()->json([
                'items' => [],
            ]);
        }

        $results = Station::where([['status', true], ['state', 'Himachal Pradesh']])
            ->where('name', 'like', '%'.$city.'%')
            ->get();

        return response()->json([
            'items' => $results,
        ]);
    }
}
