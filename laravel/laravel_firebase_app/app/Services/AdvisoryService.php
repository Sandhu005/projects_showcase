<?php

namespace App\Services;

use App\Models\Advisory;

class AdvisoryService
{
    public function __construct(
        protected FarmerService $farmerService
    ) {}

    public function getForFarmer(string $farmerId)
    {
        // Get farmer location from Firebase
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

        // Get active and currently valid advisories
        $advisories = Advisory::query()
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

                // Global advisory
                $query->whereNull('state')

                    // State-specific advisory
                    ->orWhereRaw(
                        'LOWER(TRIM(state)) = ?',
                        [strtolower($farmerState)]
                    );
            })

            ->latest()
            ->get();

        // Return advisory content according to farmer's language
        return $advisories->map(function ($advisory) use ($language) {

            return [
                'id' => $advisory->id,

                'title' => $language === 'hi'
                    ? $advisory->title_hi
                    : $advisory->title_en,

                'description' => $language === 'hi'
                    ? $advisory->description_hi
                    : $advisory->description_en,

                'valid_from' => $advisory->valid_from,
                'valid_until' => $advisory->valid_until,
            ];
        });
    }
}
