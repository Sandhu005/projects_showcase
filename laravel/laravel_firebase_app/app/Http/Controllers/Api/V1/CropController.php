<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Crops\CropSearchRequest;
use App\Models\Crops;
use Illuminate\Http\Request;

class CropController extends Controller
{
    public function index(CropSearchRequest $request)
    {
        $query = Crops::query()->where('status', 'active');

        //Search by crop name
        if (!empty($request->validated('q'))) {
            $query->where('crop_name', 'like', '%' . $request->validated('q') . '%');
        }

        //Search by season
        if (!empty($request->validated('season'))) {
            $query->where('crop_season', $request->validated('season'));
        }

        //Search by type
        if (!empty($request->validated('type'))) {
            $query->where('crop_type', $request->validated('type'));
        }

        $crops = $query->orderBy('id')
            ->cursorPaginate(
                10,
                [
                    'id',
                    'crop_name',
                    'crop_season',
                    'crop_type',
                    'crop_image',
                ],
                'cursor',
                $request->input('cursor')
            );

        return response()->json([
            'items' => $crops->items(),
            'next_cursor' => $crops->nextCursor()?->encode(),
        ], 200);
    }

    public function show(string $id)
    {
        $crop = Crops::query()->where('status', 'active')->find($id);

        if (!$crop) {
            return response()->json([
                'error' => 'No record found!',
                'message' => 'No such crop found in the database!',
            ], 404);
        }

        return response()->json([
            'crop' => $crop,
        ], 200);
    }
}
