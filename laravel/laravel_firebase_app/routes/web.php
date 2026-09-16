<?php

use App\Http\Controllers\CropsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FarmerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SeedsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WeatherController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('users', UserController::class)->except('index', 'show');
    Route::patch('/users/{user}/restore', [UserController::class, 'restore'])->name('users.restore');
    Route::resource('crops', CropsController::class)->except('index', 'show');
    Route::patch('/crops/{crop}/restore', [CropsController::class, 'restore'])->name('crops.restore');
    // Route::resource('seeds', SeedsController::class)->except('index', 'show');
    // Route::patch('/seeds/{seed}/restore', [SeedsController::class, 'restore'])->name('seeds.restore');
});

Route::middleware(['auth', 'role:admin|editor'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('farmers', FarmerController::class);
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/weather', [WeatherController::class, 'index'])->name('weather.index');
    Route::get('/crops', [CropsController::class, 'index'])->name('crops.index');
    Route::get('/crops/{crop}', [CropsController::class, 'show'])->name('crops.show');
    // Route::get('/seeds', [SeedsController::class, 'index'])->name('seeds.index');
    // Route::get('/seeds/{seed}', [SeedsController::class, 'show'])->name('seeds.show');
    Route::get('/weather-data/{location}', [WeatherController::class, 'getWeather'])->name('weather.data');
    Route::get('/gdd-data/{location}', [WeatherController::class, 'getGddData'])->name('gdd.data');
});

require __DIR__ . '/auth.php';
