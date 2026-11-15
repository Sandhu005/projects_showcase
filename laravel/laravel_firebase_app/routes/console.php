<?php

use App\Jobs\DownloadGribFileJob;
use Illuminate\Support\Facades\Schedule;

Schedule::command('stations:sync')
    ->everySixHours();

// Schedule::job(new DownloadGribFileJob())->everyMinute();