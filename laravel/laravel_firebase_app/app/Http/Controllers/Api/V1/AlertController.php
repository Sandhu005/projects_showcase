<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\AlertService;
use Illuminate\Http\JsonResponse;

class AlertController extends Controller
{
    public function __construct(
        protected AlertService $alertService
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

        $alerts = $this->alertService->getForFarmer($farmerId);

        if ($alerts->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No alerts found for the farmer.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $alerts,
        ]);
    }
}
