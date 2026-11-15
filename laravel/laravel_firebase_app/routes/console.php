<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('stations:sync')
    ->everySixHours();