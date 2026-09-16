<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Process;

class DownloadGribFileJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    // public function handle(): void
    // {
    //     $process = Process::timeout(7200)->run([
    //         'python',
    //         base_path('python/IMD_read_parameter.py'),
    //     ]);

    //     if($process->failed()) {
    //         logger()->error('Failed to download GRIB file: ' . $process->errorOutput());

    //         throw new \Exception('Failed to download GRIB file: ' . $process->errorOutput());
    //     }

    //     logger()->info('Successfully downloaded GRIB file: ' . $process->output());

    // }
}
