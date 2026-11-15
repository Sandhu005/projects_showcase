<?php

namespace App\Services;

use App\Models\Alert;
use Illuminate\Support\Collection;

class AlertService
{
    public function __construct(
        protected FarmerService $farmerService
    ) {}

    public function getForFarmer(string $farmerId): Collection
    {
        $location = $this->farmerService->getLocation($farmerId);

        if (! $location) {
            return collect();
        }

        $farmerState = trim($location['state'] ?? '');

        // if ($farmerState === '') {
        //     return collect();
        // }

        // Get farmer's preferred language
        // Default is English
        $language = $this->farmerService->getFarmerLanguage($farmerId);

        $alerts = Alert::query()
            ->where('status', true)
            ->where(function ($query) {
                $query
                    ->whereNull('valid_from')
                    ->orWhere('valid_from', '<=', now());
            })
            ->where(function ($query) {
                $query
                    ->whereNull('valid_until')
                    ->orWhere('valid_until', '>=', now());
            })
            ->where(function ($query) use ($farmerState) {
                $query->whereNull('state')
                    ->orWhereRaw('LOWER(TRIM(state)) = ?', [strtolower($farmerState)]);
            })
            ->latest()
            ->get();

        // Return advisory content according to farmer's language
        return $alerts->map(function ($alert) use ($language) {

            return [
                'id' => $alert->id,

                'title' => $language === 'hi'
                    ? $alert->title_hi
                    : $alert->title_en,

                'description' => $language === 'hi'
                    ? $alert->description_hi
                    : $alert->description_en,

                'valid_from' => $alert->valid_from,
                'valid_until' => $alert->valid_until,
            ];
        });
    }
}
