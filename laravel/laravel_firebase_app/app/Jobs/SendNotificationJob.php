<?php

namespace App\Jobs;

use App\Services\NotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendNotificationJob implements ShouldQueue
{
    use Queueable;

    // public int $tries = 3;

    // public int $backoff = 10;

    // public int $timeout = 30;

    /**
     * Create a new job instance.
     */
    public function __construct(
        // public string $title_en,
        // public string $description_en,
        // public string $title_hi,
        // public string $description_hi
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(NotificationService $notificationService): void
    {
        // $notificationService->sendToAll(
        //     $this->title_en,
        //     $this->description_en,
        //     $this->title_hi,
        //     $this->description_hi
        //     );
    }
}
