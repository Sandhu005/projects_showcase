<?php

namespace App\Console\Commands;

use App\Services\StationSyncService;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('stations:sync')]
#[Description('Sync stations from external API')]
class SyncStations extends Command
{
    public function handle(StationSyncService $stationSyncService): int
    {
        try {

            $count = $stationSyncService->sync();

            $this->info(
                "Stations synced successfully: {$count}"
            );

            return self::SUCCESS;
        } catch (\Throwable $e) {

            $this->error(
                'Station sync failed: '.$e->getMessage()
            );

            return self::FAILURE;
        }
    }
}
