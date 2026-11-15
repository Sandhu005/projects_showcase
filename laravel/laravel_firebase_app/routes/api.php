<?php

use App\Http\Controllers\Api\V1\AdvisoryController;
use App\Http\Controllers\Api\V1\AlertController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CropController;
use App\Http\Controllers\Api\V1\LocationController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\WeatherController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::prefix('auth')->group(function () {
        Route::post('/otp/send', [AuthController::class, 'sendOtp']);
        Route::post('/otp/verify', [AuthController::class, 'verifyOtp']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::get('/google', [AuthController::class, 'googleRedirect']);
        Route::get('/google/callback', [AuthController::class, 'googleCallback']);
    });

    Route::middleware('auth:api')->group(function () {
        Route::post('/auth/logout', [AuthController::class, 'logout']);

        Route::prefix('user')->group(function () {
            Route::get('/me', [UserController::class, 'me']);
            Route::delete('/me', [UserController::class, 'destroy']);
            Route::patch('/settings', [UserController::class, 'updateSettings']);
            Route::get('/weather', [WeatherController::class, 'userWeatherData']);
            Route::get('/weatherbylocation/{location}', [WeatherController::class, 'weatherByLocation']);
            Route::get('/advisories', [AdvisoryController::class, 'index']);
            Route::get('/alerts', [AlertController::class, 'index']);

            Route::prefix('locations')->group(function () {
                Route::patch('/update', [UserController::class, 'updateLocation']);
                Route::get('/popular', [LocationController::class, 'popular']);
                Route::get('/search', [LocationController::class, 'search']);
            });

            Route::prefix('crops')->group(function () {
                Route::post('/', [CropController::class, 'index']);
                Route::get('/{id}', [CropController::class, 'show']);
            });
        });
    });
});
