<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Settings\UpdateLocationRequest;
use App\Http\Requests\Api\Settings\UpdateSettingsRequest;
use App\Http\Requests\Api\User\UserRegisterRequest;
use App\Services\FarmerService;
use App\Services\WeatherService;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    public function __construct(
        protected FarmerService $farmers,
        protected WeatherService $weatherService,
    ) {}

    // public function store(UserRegisterRequest $request)
    // {
    //     $farmer = $this->farmers->create(
    //         $request->validated()
    //     );

    //     if (!$farmer) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Phone number already registered',
    //         ], 409);
    //     }

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Farmer registered successfully',
    //         'data'    => $farmer,
    //     ], 201);
    // }

    public function me()
    {
        $farmerId = auth('api')->id();

        if (! $farmerId) {
            return response()->json([
                'error' => 'unauthenticated',
                'message' => 'Authentication required.',
            ], 401);
        }

        $farmer = $this->farmers->show($farmerId);

        if (! $farmer) {
            return response()->json([
                'error' => 'user_not_found',
                'message' => 'Farmer profile not found.',
            ], 404);
        }

        if (($farmer['status'] ?? 'active') === 'deleted') {
            return response()->json([
                'error' => 'account_deleted',
                'message' => 'This account has been deleted.',
            ], 403);
        }

        return response()->json([
            'id' => $farmerId,
            'name' => $farmer['name'] ?? null,
            'phone' => $farmer['phone'] ?? null,
            'email' => $farmer['email'] ?? null,
            'location' => [
                'lat' => $farmer['location']['lat'] ?? null,
                'lng' => $farmer['location']['lng'] ?? null,
            ],

            'language' => $farmer['language'] ?? 'en',
        ]);
    }

    public function updateLocation(UpdateLocationRequest $request)
    {

        $farmerId = auth('api')->id();
        $this->farmers->updateLocation(
            $farmerId,
            [
                'lat' => $request->validated('lat'),
                'lng' => $request->validated('lng'),
                'source' => $request->validated('source'),
                'updated_at' => now()->toIso8601String(),
            ]
        );

        return response()->json([
            'message' => 'Location updated successfully.',
        ]);
    }

    public function updateSettings(UpdateSettingsRequest $request)
    {
        $farmerId = auth('api')->id();

        $this->farmers->updateSettings(
            $farmerId,
            [
                'language' => $request->validated('language'),
                'updated_at' => now()->toIso8601String(),
            ]
        );

        return $this->me();
    }

    public function destroy()
    {
        $farmerId = auth('api')->id();

        $this->farmers->softDelete($farmerId);

        JWTAuth::parseToken()->invalidate();

        return response()->noContent();
    }
}
