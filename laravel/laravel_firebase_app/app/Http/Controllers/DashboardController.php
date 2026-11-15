<?php

namespace App\Http\Controllers;

use App\Models\Advisory;
use App\Models\Alert;
use App\Models\Crops;
use App\Services\FarmerService;

class DashboardController extends Controller
{
    public function __construct(
        protected FarmerService $farmers
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalActiveFarmers = $this->farmers->getFarmerCount();
        $totalActiveAdvisories = Advisory::where('valid_until', '>', now())->count();
        $totalActiveAlerts = Alert::where('valid_until', '>', now())->count();
        $totalActiveCrops = Crops::whereNull('deleted_at')->count();
        $alerts = Alert::latest()->take(4)->get();
        $advisories = Advisory::latest()->take(4)->get();

        return view('dashboard', compact('totalActiveFarmers', 'totalActiveAdvisories', 'totalActiveAlerts', 'totalActiveCrops', 'alerts', 'advisories'));
    }
}
