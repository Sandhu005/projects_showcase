<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\AdvisoryService;
use App\Services\FarmerService;
use Illuminate\Http\JsonResponse;

class AdvisoryController extends Controller
{
    public function __construct(
        protected AdvisoryService $advisoryService,
        protected FarmerService $farmerService
    ) {}

    public function index(): JsonResponse
    {
        $farmerId = auth('api')->id();

        if (! $farmerId) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 401);
        }

        $advisories = $this->advisoryService
            ->getForFarmer($farmerId);

        if ($advisories->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No advisories found for the farmer.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $advisories,
        ]);
    }
}
